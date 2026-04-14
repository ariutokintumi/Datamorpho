from __future__ import annotations

import secrets
from dataclasses import dataclass

from .constants import MAX_FRAGMENTS_PER_STATE, MIN_FRAGMENT_SIZE


@dataclass(slots=True)
class PlainFragment:
    order: int
    data: bytes


def choose_fragment_count(data_len: int) -> int:
    if data_len <= MIN_FRAGMENT_SIZE * 2:
        return 1

    max_by_size = max(1, data_len // MIN_FRAGMENT_SIZE)
    upper = min(MAX_FRAGMENTS_PER_STATE, max_by_size)

    if upper <= 1:
        return 1

    return secrets.randbelow(upper) + 1


def split_plaintext(data: bytes) -> list[PlainFragment]:
    data_len = len(data)
    if data_len == 0:
        return [PlainFragment(order=1, data=b"")]

    fragment_count = choose_fragment_count(data_len)
    if fragment_count == 1:
        return [PlainFragment(order=1, data=data)]

    # Keep every fragment at least MIN_FRAGMENT_SIZE where possible
    remaining = data_len
    fragments: list[PlainFragment] = []
    cursor = 0

    for order in range(1, fragment_count):
        remaining_fragments_after_this = fragment_count - order
        min_reserved = remaining_fragments_after_this * MIN_FRAGMENT_SIZE

        max_this = remaining - min_reserved
        min_this = MIN_FRAGMENT_SIZE

        if max_this <= min_this:
            size = min_this
        else:
            size = secrets.randbelow(max_this - min_this + 1) + min_this

        end = cursor + size
        fragments.append(PlainFragment(order=order, data=data[cursor:end]))
        cursor = end
        remaining = data_len - cursor

    fragments.append(PlainFragment(order=fragment_count, data=data[cursor:]))
    return fragments