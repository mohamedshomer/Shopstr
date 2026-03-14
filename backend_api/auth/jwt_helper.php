<?php
require_once __DIR__ . "/../../vendor/autoload.php"; // مسار صحيح من auth إلى vendor
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$jwt_secret_key = "SHOPSTR_SECRET_KEY_2026";

function generateJWT($payload, $exp = 3600) {
    global $jwt_secret_key;
    $issuedAt = time();
    $expire = $issuedAt + $exp;
    $payload['iat'] = $issuedAt;
    $payload['exp'] = $expire;
    return JWT::encode($payload, $jwt_secret_key, 'HS256');
}

function validateJWT($token) {
    global $jwt_secret_key;
    try {
        $decoded = JWT::decode($token, new Key($jwt_secret_key, 'HS256'));
        return (array)$decoded;
    } catch (Exception $e) {
        return false;
    }
}
?>
