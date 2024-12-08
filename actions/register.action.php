<?php
session_start();
require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';

// Create a new instance of the db class
$database = new db();  // Make sure to instantiate the db class

if ($_POST) {
    $data = $_POST;

    if ($_POST['full_name'] && $_POST['email_id'] && $_POST['password']) {
        $full_name = $database->connect()->real_escape_string($_POST['full_name']);
        $email_id = $database->connect()->real_escape_string($_POST['email_id']);
        $password = password_hash($database->connect()->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Use password_hash instead of md5
        
        // Check if the email is already registered
        $result = $database->connect()->query("SELECT COUNT(*) AS user FROM users WHERE email_id='$email_id'");
        $result = $result->fetch_assoc();

        if ($result['user'] > 0) { // If user exists
            $fn->setError($email_id . " is already registered!");
            $fn->redirect('../index.php');
            die();
        }
        
        try {
            // Insert new user into the database
            $database->connect()->query("INSERT INTO users(full_name, email_id, password) VALUES('$full_name', '$email_id', '$password')");
            $fn->setAlert('Registered successfully');
            $fn->redirect('../login.php');
        } catch (Exception $error) {
            // Log error or handle as needed
            error_log($error->getMessage()); // Log error for debugging
            $fn->setError("Something went wrong, please try again.");
            $fn->redirect('../index.php');
        }

    } else {
        $fn->setError("Please fill in all fields.");
        $fn->redirect('../index.php');
    }
} else {
    $fn->redirect('../index.php');
}
?>
