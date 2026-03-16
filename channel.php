<?php
require 'db.php';

$token = $_GET['token'] ?? '';
$decoded = base64_decode(urldecode($token));
$parts = explode(':', $decoded, 3);

if (count($parts) !== 3) { http_response_code(403); exit('Geçersiz token'); }

[$email, $expires, $sig] = $parts;

$valid = time() < (int)$expires
      && hash_equals(hash_hmac('sha256', $email . ':' . $expires, SECRET_KEY), $sig)
      && isActive($email);

if (!$valid) { http_response_code(403); exit('Geçersiz veya süresi dolmuş token'); }

// Direkt Viloud'a yönlendir
header('Location: https://app.viloud.tv/hls/channel/09368cef97b0a015a45970bea736e8e0.m3u8');
exit;