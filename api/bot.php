<?php
$config = require __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');

$botId = $config['discord']['bot_id'] ?? '';
$botToken = $config['discord']['bot_token'] ?? '';

if ($botId === '') {
  http_response_code(400);
  echo json_encode(['error' => 'bot_id manquant']);
  exit;
}

if ($botToken === '') {
  http_response_code(400);
  echo json_encode(['error' => 'bot_token manquant']);
  exit;
}

$url = 'https://discord.com/api/v10/users/' . rawurlencode($botId);

$ch = curl_init($url);
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    'Authorization: Bot ' . $botToken,
    'User-Agent: DiscordBotWebsite (https://example.com, 1.0)'
  ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

if ($response === false || $httpCode >= 400) {
  http_response_code(502);
  echo json_encode(['error' => 'Discord API indisponible', 'details' => $err]);
  exit;
}

echo $response;
