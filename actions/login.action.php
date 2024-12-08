<?php
require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';

// Create a new instance of the db class
$database = new db(); // Instantiate the db class

if ($_POST) {
    $data = $_POST;

    if (!empty($_POST['email_id']) && !empty($_POST['password'])) {
        $email_id = $database->connect()->real_escape_string($_POST['email_id']);
        $password = $_POST['password']; // Keep plain text password for verification

        // Fetch user data from the database
        $result = $database->connect()->query("SELECT id, full_name, password FROM users WHERE email_id='$email_id'");
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // User authenticated
            $fn->setAuth($user); // Assuming setAuth is a method to manage user sessions
            $fn->setAlert('Logged in successfully!');
            $fn->redirect('../myresumes.php');
        } else {
            // Invalid credentials
            $fn->setError("Invalid credentials.");
            $fn->redirect('../login.php');
        }
    } else {
        $fn->setError("Please fill in all fields.");
        $fn->redirect('../login.php');
    }
} else {
    $fn->redirect('../login.php');
}

?>