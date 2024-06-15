<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Middleware to check JWT on all routes except login and register
Flight::route('/*', function () {
    $path = Flight::request()->url;
    if ($path == '/auth/login' || strpos($path, '/auth/register') !== false) {
        return true;
    }

    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        Flight::json(["error" => "Unauthorized access"], 403);
        return false;
    } else {
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            $token = $matches[1];
        }
        try {
            $decoded = (array)JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('verifiedUser', $decoded);
            return true;
        } catch (Exception $e) {
            Flight::json(["error" => "Token authorization invalid"], 403);
            return false;
        }
    }
});

// Error handling
Flight::map('error', function (Throwable $e) {
    // Log the error message and code
    file_put_contents('logs.txt', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . ' - Code: ' . $e->getCode() . PHP_EOL, FILE_APPEND | LOCK_EX);

    // Halt with an appropriate HTTP status code and message
    $code = $e->getCode();
    if ($code < 100 || $code >= 600) {
        $code = 500; // Ensure the code is a valid HTTP status code
    }
    Flight::json(["error" => $e->getMessage()], $code);
    Flight::stop();
});
