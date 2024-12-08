<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';

require '../assets/packages/phpmailer/src/Exception.php';
require '../assets/packages/phpmailer/src/PHPMailer.php';
require '../assets/packages/phpmailer/src/SMTP.php';

// Create a new instance of the db class
$database = new db(); // Instantiate the db class

if ($_POST) {
    $data = $_POST;

    if (!empty($data['email_id'])) {
        $email_id = filter_var($data['email_id'], FILTER_SANITIZE_EMAIL); // Sanitize email

        if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
            $fn->setError("Invalid email format.");
            $fn->redirect('../forgot-password.php');
            
        }

        // Fetch user data from the database
        $result = $database->connect()->query("SELECT id, full_name FROM users WHERE email_id='$email_id'");
         $user = $result->fetch_assoc();

        if ($user) {
            $otp = rand(100000, 999999); // Generate OTP
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'anasfaiz0811@gmail.com'; // Use environment variable
                $mail->Password   = 'uabufbvrfxisyrrv'; // Use environment variable
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                //Recipients
                $mail->setFrom('verify@gmail.com', 'Resume Builder');
                $mail->addAddress($email_id);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification';
                $mail->Body    = 'Your OTP is <b>' . $otp . '</b>';

                $mail->send();

                $fn->setSession('otp', $otp);
                $fn->setSession('email', $email_id);
                $fn->redirect('../verification.php');

            } catch (Exception $e) {
                $fn->setError("Unable to send email. Please try again later.");
                $fn->redirect('../forgot-password.php');
            }
        } else {
            $fn->setAlert("If this email is registered, an OTP has been sent.");
            $fn->redirect('../forgot-password.php');
        }
    } else {
        $fn->setError("Please enter your email.");
        $fn->redirect('../forgot-password.php');
    }
} else {
    $fn->setError("here");
    $fn->redirect('../forgot-password.php');
}
?>
