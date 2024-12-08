<?php

require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';
$database = new db();  // Instantiate the db class

if ($_POST) {
    $data = $_POST;

    // Check required fields
    $requiredFields = [
        'resume_title', 'full_name', 'email', 'objective', 'mobile_no', 'dob', 
        'gender', 'religion', 'nationality', 'marital_status', 
        'hobbies', 'languages', 'address'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            $missingFields[] = ucfirst(str_replace('_', ' ', $field)); // Human-readable format
        }
    }

    if (!empty($missingFields)) {
        $fn->setError("The following fields are required: " . implode(', ', $missingFields));
        $fn->redirect('../createresume.php');
        exit;
    }

    // Prepare data for insertion
    $columns = '';
    $values = '';
    foreach ($data as $index => $value) {
        $$index = $database->connect()->real_escape_string($value);
        $columns .= $index . ",";
        $values .= "'$value',";
    }
$authid = $fn->auth()['id'];
$slug=$fn->randomstr();
    // Add additional columns
    $columns .= 'slug,updated_at,user_id';
    $values .= "'" . $slug . "'," . time() . ",". $authid ;

    try {
        // Construct query
        $query = "INSERT INTO resumes ($columns) VALUES ($values)";

        // Execute query
        if (!$database->connect()->query($query)) {
            throw new Exception('Database query failed: ' . $database->connect()->error);
        }

        // Success
        $fn->setAlert('Resume added successfully');
        $fn->redirect('../myresumes.php');
    } catch (Exception $error) {
        // Handle exceptions and log the error
        error_log($error->getMessage());
        $fn->setError("Something went wrong. Please try again.");
        $fn->redirect('../createresume.php');
    }
} else {
    $fn->redirect('../createresume.php');
}
