<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed.']);
    exit;
}

$honeypot = trim((string)($_POST['website_field'] ?? ''));
if ($honeypot !== '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid input data.']);
    exit;
}

$payloadJson = (string)($_POST['payload_json'] ?? '');
if ($payloadJson === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing payload_json.']);
    exit;
}

$payload = json_decode($payloadJson, true);
if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid payload_json.']);
    exit;
}

$logDir = __DIR__ . '/creation_tool/logs';
if (!is_dir($logDir) && !mkdir($logDir, 0775, true) && !is_dir($logDir)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Could not initialize log directory.']);
    exit;
}

$timestamp = gmdate('Ymd_His');
$random = bin2hex(random_bytes(8));
$filename = $logDir . '/' . $timestamp . '_' . $random . '.json';

$record = [
    'logged_at_utc' => gmdate('c'),
    'original_files_hashes' => $payload['original_files_hashes'] ?? [],
    'result_file_hash' => $payload['result_file_hash'] ?? null,
    'reconstruction_object' => $payload['reconstruction_object'] ?? null,
];

file_put_contents($filename, json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

echo json_encode(['ok' => true]);