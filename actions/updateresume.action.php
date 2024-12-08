<?php

require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';
$database = new db(); // Instantiate the db class

if ($_POST) {
    $data = $_POST;

    // Check required fields
    $requiredFields = [
        'resume_title', 'full_name', 'email', 'objective', 'mobile_no', 'dob',
        'gender', 'religion', 'nationality', 'marital_status',
        'hobbies', 'languages', 'address', 'id', 'slug'
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

    // Prepare data for update
    $setClause = '';
    $data2 = $data;
    unset($data2['id'], $data2['slug']); // Remove `id` and `slug` from the update fields

    foreach ($data2 as $column => $value) {
        $escapedValue = $database->connect()->real_escape_string($value);
        $setClause .= "$column = '$escapedValue', ";
    }

    // Add `updated_at` column
    $setClause .= "updated_at = " . time();

    try {
        // Construct query
        $query = "UPDATE resumes SET $setClause WHERE id = '{$data['id']}' AND slug = '{$data['slug']}'";

        // Debugging (optional)
        // echo "<pre>$query</pre>";
        // die();

        // Execute query
        if (!$database->connect()->query($query)) {
            throw new Exception('Database query failed: ' . $database->connect()->error);
        }

        // Success
        $fn->setAlert('Resume updated successfully');
        $fn->redirect("../updateresume.php?resume={$data['slug']}");
    } catch (Exception $error) {
        // Handle exceptions and log the error
        error_log($error->getMessage());
        $fn->setError("Something went wrong. Please try again.");
        $fn->redirect("../updateresume.php?resume={$data['slug']}");
    }
} else {
    $fn->redirect('../updateresume.php');
}
