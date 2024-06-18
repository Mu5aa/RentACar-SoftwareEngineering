<?php

require_once __DIR__ . '/../services/AuthService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::set('auth_service', new AuthService());
// Start output buffering
ob_start();

// Clean (erase) the output buffer
ob_clean();

// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Check for OPTIONS request and return 200 response
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

Flight::group('/auth', function() {

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system using email and password",
     *      @OA\Response(
     *           response=200,
     *           description="User data and JWT"
     *      ),
     *      @OA\RequestBody(
     *          description="Credentials",
     *          @OA\JsonContent(
     *              required={"email","pwd"},
     *              @OA\Property(property="email", type="string", example="example@example.com", description="User email address"),
     *              @OA\Property(property="pwd", type="string", example="some_password", description="User password")
     *          )
     *      )
     * )
     */
    Flight::route('POST /login', function() {
        $payload = Flight::request()->data->getData();

        $user = Flight::get('auth_service')->get_user_by_email($payload['email']);

        if(!$user || !password_verify($payload['pwd'], $user['pwd']))
            Flight::halt(500, "Invalid username or password");

        unset($user['pwd']);

        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            // If this parameter is not set, JWT will be valid for life. This is not a good approach
            'exp' => time() + (60 * 60 * 24) // valid for day
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        Flight::json(
            array_merge($user, ['token' => $token])
        );
    });

    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      tags={"auth"},
     *      summary="Logout from the system",
     *      security={
     *          {"ApiKey": {}}   
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success response or exception if unable to verify jwt token"
     *      ),
     * )
     */
    Flight::route('POST /logout', function() {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(!$token)
                Flight::halt(401, "Missing authentication header");

            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

            Flight::json([
                'jwt_decoded' => $decoded_token,
                'user' => $decoded_token->user
            ]);
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    });

    /**
     * @OA\Post(
     *      path="/auth/register",
     *      tags={"auth"},
     *      summary="Register a new user",
     *      @OA\Response(
     *           response=200,
     *           description="User registration successful"
     *      ),
     *      @OA\RequestBody(
     *          description="User details",
     *          @OA\JsonContent(
     *              required={"first_name","last_name","email","pwd"},
     *              @OA\Property(property="first_name", type="string", example="John", description="User first name"),
     *              @OA\Property(property="last_name", type="string", example="Doe", description="User last name"),
     *              @OA\Property(property="email", type="string", example="example@example.com", description="User email address"),
     *              @OA\Property(property="pwd", type="string", example="some_password", description="User password")
     *          )
     *      )
     * )
     */
    Flight::route('POST /register', function() {
        $payload = Flight::request()->data->getData();

        // Validate required fields
        if (!isset($payload['first_name']) || !isset($payload['last_name']) || !isset($payload['email']) || !isset($payload['pwd'])) {
            Flight::halt(400, "All fields are required");
        }

        // Hash the password before storing
        $hashed_password = password_hash($payload['pwd'], PASSWORD_BCRYPT);

        // Store user in the database
        $user = [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'email' => $payload['email'],
            'pwd' => $hashed_password
        ];

        try {
            Flight::get('auth_service')->register_user($user);
            Flight::json(['message' => 'User registration successful']);
        } catch (Exception $e) {
            Flight::halt(500, $e->getMessage());
        }
    });

});
ob_end_clean();

