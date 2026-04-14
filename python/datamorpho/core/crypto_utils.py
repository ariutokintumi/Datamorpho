from __future__ import annotations

import base64
import json
import secrets
from dataclasses import dataclass
from typing import Any

from cryptography.hazmat.primitives import hashes, hmac, serialization
from cryptography.hazmat.primitives.asymmetric import padding, rsa
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.primitives.ciphers.aead import AESGCM

from .constants import (
    AES_CTR_COUNTER_BYTES,
    AES_GCM_IV_BYTES,
    AES_KEY_SIZE_BYTES,
    HARDENED_FRAGMENT_SUITES,
    HARDENED_SUITE,
    HMAC_SHA256_KEY_SIZE_BYTES,
    RSA_BITS,
    SIMPLE_FRAGMENT_SUITES,
    SIMPLE_SUITE,
)
from .exceptions import ReconstructionError, ValidationError
from .utils import b64url_decode, b64url_encode


@dataclass(slots=True)
class EncryptedFragment:
    cipher_suite: str
    ciphertext: bytes
    iv_b64url: str
    key_material: dict[str, Any]


def _pack_suite_defined(payload: dict[str, Any]) -> dict[str, Any]:
    raw = json.dumps(payload, sort_keys=True, separators=(",", ":")).encode("utf-8")
    return {
        "format": "suite-defined",
        "encoding": "base64url",
        "value": b64url_encode(raw),
    }


def _unpack_suite_defined(key_material: dict[str, Any]) -> dict[str, Any]:
    return json.loads(b64url_decode(key_material["value"]).decode("utf-8"))


def _encrypt_aes_gcm(key: bytes, plaintext: bytes) -> tuple[bytes, str]:
    iv = secrets.token_bytes(AES_GCM_IV_BYTES)
    aes = AESGCM(key)
    ciphertext = aes.encrypt(iv, plaintext, associated_data=None)
    return ciphertext, b64url_encode(iv)


def _decrypt_aes_gcm(key: bytes, ciphertext: bytes, iv_b64url: str) -> bytes:
    aes = AESGCM(key)
    return aes.decrypt(b64url_decode(iv_b64url), ciphertext, associated_data=None)


def _encrypt_aes_ctr_hmac(enc_key: bytes, mac_key: bytes, plaintext: bytes) -> tuple[bytes, str, str]:
    iv = secrets.token_bytes(AES_CTR_COUNTER_BYTES)
    encryptor = Cipher(algorithms.AES(enc_key), modes.CTR(iv)).encryptor()
    ciphertext = encryptor.update(plaintext) + encryptor.finalize()
    mac = hmac.HMAC(mac_key, hashes.SHA256())
    mac.update(iv)
    mac.update(ciphertext)
    tag = mac.finalize()
    return ciphertext, b64url_encode(iv), b64url_encode(tag)


def _decrypt_aes_ctr_hmac(enc_key: bytes, mac_key: bytes, ciphertext: bytes, iv_b64url: str, tag_b64url: str) -> bytes:
    iv = b64url_decode(iv_b64url)
    tag = b64url_decode(tag_b64url)
    mac = hmac.HMAC(mac_key, hashes.SHA256())
    mac.update(iv)
    mac.update(ciphertext)
    mac.verify(tag)
    decryptor = Cipher(algorithms.AES(enc_key), modes.CTR(iv)).decryptor()
    return decryptor.update(ciphertext) + decryptor.finalize()


def generate_rsa_keypair() -> tuple[bytes, bytes, rsa.RSAPrivateKey]:
    private_key = rsa.generate_private_key(public_exponent=65537, key_size=RSA_BITS)
    public_key = private_key.public_key()
    private_pem = private_key.private_bytes(
        encoding=serialization.Encoding.PEM,
        format=serialization.PrivateFormat.PKCS8,
        encryption_algorithm=serialization.NoEncryption(),
    )
    public_pem = public_key.public_bytes(
        encoding=serialization.Encoding.PEM,
        format=serialization.PublicFormat.SubjectPublicKeyInfo,
    )
    return private_pem, public_pem, private_key


def _wrap_with_rsa(public_key: rsa.RSAPublicKey, secret_blob: bytes) -> str:
    wrapped = public_key.encrypt(
        secret_blob,
        padding.OAEP(mgf=padding.MGF1(algorithm=hashes.SHA256()), algorithm=hashes.SHA256(), label=None),
    )
    return b64url_encode(wrapped)


def _unwrap_with_rsa(private_key_pem_b64: str, wrapped_b64url: str) -> bytes:
    private_pem = base64.b64decode(private_key_pem_b64)
    private_key = serialization.load_pem_private_key(private_pem, password=None)
    return private_key.decrypt(
        b64url_decode(wrapped_b64url),
        padding.OAEP(mgf=padding.MGF1(algorithm=hashes.SHA256()), algorithm=hashes.SHA256(), label=None),
    )


def _choose_fragment_suite(suite_profile: str) -> str:
    if suite_profile == SIMPLE_SUITE:
        return secrets.choice(SIMPLE_FRAGMENT_SUITES)
    if suite_profile == HARDENED_SUITE:
        return secrets.choice(HARDENED_FRAGMENT_SUITES)
    raise ValidationError(f"Unsupported suite profile: {suite_profile}")


def encrypt_fragment(plaintext: bytes, suite_profile: str, shared_state_keys: dict[str, Any] | None = None) -> tuple[EncryptedFragment, dict[str, Any] | None]:
    cipher_suite = _choose_fragment_suite(suite_profile)

    if suite_profile == SIMPLE_SUITE:
        if cipher_suite == "AES-256-GCM":
            key = secrets.token_bytes(AES_KEY_SIZE_BYTES)
            ciphertext, iv_b64url = _encrypt_aes_gcm(key, plaintext)
            fragment = EncryptedFragment(
                cipher_suite=cipher_suite,
                ciphertext=ciphertext,
                iv_b64url=iv_b64url,
                key_material={
                    "format": "raw",
                    "encoding": "base64url",
                    "value": b64url_encode(key),
                },
            )
            return fragment, None

        if cipher_suite == "AES-256-CTR+HMAC-SHA-256":
            enc_key = secrets.token_bytes(AES_KEY_SIZE_BYTES)
            mac_key = secrets.token_bytes(HMAC_SHA256_KEY_SIZE_BYTES)
            ciphertext, iv_b64url, tag_b64url = _encrypt_aes_ctr_hmac(enc_key, mac_key, plaintext)
            fragment = EncryptedFragment(
                cipher_suite=cipher_suite,
                ciphertext=ciphertext,
                iv_b64url=iv_b64url,
                key_material=_pack_suite_defined({
                    "enc_key": b64url_encode(enc_key),
                    "mac_key": b64url_encode(mac_key),
                    "tag": tag_b64url,
                }),
            )
            return fragment, None

    if suite_profile == HARDENED_SUITE:
        if shared_state_keys is None:
            private_pem, public_pem, private_key = generate_rsa_keypair()
            shared_state_keys = {
                "format": "suite-defined",
                "encoding": "base64url",
                "value": b64url_encode(
                    json.dumps(
                        {
                            "rsa_private_key_pkcs8_pem_base64": base64.b64encode(private_pem).decode("ascii"),
                            "rsa_public_key_spki_pem_base64": base64.b64encode(public_pem).decode("ascii"),
                            "wrap_algorithm": "RSA-OAEP-4096",
                        },
                        sort_keys=True,
                        separators=(",", ":"),
                    ).encode("utf-8")
                ),
                "_private_key_object": private_key,
            }
        private_key = shared_state_keys.get("_private_key_object")
        if private_key is None:
            raise ValidationError("Internal error: hardened shared state key object is missing.")
        public_key = private_key.public_key()

        if cipher_suite == "RSA-OAEP-4096+AES-256-GCM":
            cek = secrets.token_bytes(AES_KEY_SIZE_BYTES)
            ciphertext, iv_b64url = _encrypt_aes_gcm(cek, plaintext)
            wrapped = _wrap_with_rsa(public_key, cek)
            fragment = EncryptedFragment(
                cipher_suite=cipher_suite,
                ciphertext=ciphertext,
                iv_b64url=iv_b64url,
                key_material=_pack_suite_defined({"wrapped_key": wrapped}),
            )
            return fragment, shared_state_keys

        if cipher_suite == "RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256":
            enc_key = secrets.token_bytes(AES_KEY_SIZE_BYTES)
            mac_key = secrets.token_bytes(HMAC_SHA256_KEY_SIZE_BYTES)
            ciphertext, iv_b64url, tag_b64url = _encrypt_aes_ctr_hmac(enc_key, mac_key, plaintext)
            secret_blob = json.dumps(
                {
                    "enc_key": b64url_encode(enc_key),
                    "mac_key": b64url_encode(mac_key),
                    "tag": tag_b64url,
                },
                sort_keys=True,
                separators=(",", ":"),
            ).encode("utf-8")
            wrapped = _wrap_with_rsa(public_key, secret_blob)
            fragment = EncryptedFragment(
                cipher_suite=cipher_suite,
                ciphertext=ciphertext,
                iv_b64url=iv_b64url,
                key_material=_pack_suite_defined({"wrapped_key": wrapped}),
            )
            return fragment, shared_state_keys

    raise ValidationError(f"Unsupported suite profile: {suite_profile}")


def finalize_state_key_material(state_key_material: dict[str, Any] | None) -> dict[str, Any] | None:
    if not state_key_material:
        return None
    return {key: value for key, value in state_key_material.items() if not key.startswith("_")}


def _state_key_package(state_key_material: dict[str, Any]) -> dict[str, Any]:
    return json.loads(b64url_decode(state_key_material["value"]).decode("utf-8"))


def decrypt_fragment(ciphertext: bytes, cipher_suite: str, iv_b64url: str, key_material: dict[str, Any], state_key_material: dict[str, Any] | None = None) -> bytes:
    if cipher_suite == "AES-256-GCM":
        raw_key = b64url_decode(key_material["value"])
        return _decrypt_aes_gcm(raw_key, ciphertext, iv_b64url)

    if cipher_suite == "AES-256-CTR+HMAC-SHA-256":
        package = _unpack_suite_defined(key_material)
        enc_key = b64url_decode(package["enc_key"])
        mac_key = b64url_decode(package["mac_key"])
        return _decrypt_aes_ctr_hmac(enc_key, mac_key, ciphertext, iv_b64url, package["tag"])

    if cipher_suite == "RSA-OAEP-4096+AES-256-GCM":
        if not state_key_material:
            raise ReconstructionError("Missing state-level RSA key material.")
        state_package = _state_key_package(state_key_material)
        wrapped_package = _unpack_suite_defined(key_material)
        cek = _unwrap_with_rsa(state_package["rsa_private_key_pkcs8_pem_base64"], wrapped_package["wrapped_key"])
        return _decrypt_aes_gcm(cek, ciphertext, iv_b64url)

    if cipher_suite == "RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256":
        if not state_key_material:
            raise ReconstructionError("Missing state-level RSA key material.")
        state_package = _state_key_package(state_key_material)
        wrapped_package = _unpack_suite_defined(key_material)
        secret_blob = _unwrap_with_rsa(state_package["rsa_private_key_pkcs8_pem_base64"], wrapped_package["wrapped_key"])
        payload = json.loads(secret_blob.decode("utf-8"))
        enc_key = b64url_decode(payload["enc_key"])
        mac_key = b64url_decode(payload["mac_key"])
        return _decrypt_aes_ctr_hmac(enc_key, mac_key, ciphertext, iv_b64url, payload["tag"])

    raise ReconstructionError(f"Unsupported cipher suite in reconstruction object: {cipher_suite}")