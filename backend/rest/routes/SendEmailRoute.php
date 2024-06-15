<?php

require_once 'SendEmailService.php';

// Configuration array or object, depending on what your BaseDao expects
$config = [
    'db_host' => 'your_db_host',
    'db_user' => 'your_db_user',
    'db_password' => 'your_db_password',
    'db_name' => 'your_db_name'
];

$sendEmailService = new SendEmailService($config);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uri = $_SERVER['REQUEST_URI'];

    if ($uri == '/auth/login') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['email'], $data['pwd'])) {
            $email = $data['email'];
            $pwd = $data['pwd'];
            
            // Assume login is successful (perform actual login validation here)
            $name = "User"; // Replace with actual user name

            // Generate a random verification code
            $verificationCode = rand(100000, 999999);

            // Store the verification code in the session (or database)
            session_start();
            $_SESSION['2fa_code'] = $verificationCode;
            $_SESSION['2fa_email'] = $email;

            // Send verification email
            $emailSubject = "Your Verification Code";
            $emailBody = "Dear $name,<br><br>Your verification code is: $verificationCode<br><br>Thank you.";
            $sendEmailService->sendVerificationEmail($email, $name, $emailSubject, $emailBody);

            echo json_encode(['message' => 'Verification code sent successfully.']);
        } else {
            echo json_encode(['error' => 'Invalid input.']);
        }
    } elseif ($uri == '/auth/verify-2fa') {
        session_start();
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['2fa-code'])) {
            $enteredCode = $data['2fa-code'];

            if ($enteredCode == $_SESSION['2fa_code']) {
                // 2FA validation successful, create user session
                $user = ['email' => $_SESSION['2fa_email']];
                echo json_encode($user);
            } else {
                echo json_encode(['error' => 'Invalid 2FA code.']);
            }
        } else {
            echo json_encode(['error' => 'Invalid input.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method.']);
    }
}

?>
