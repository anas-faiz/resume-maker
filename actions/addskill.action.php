<?php

require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';

$database = new db();  // Instantiate the db class

if ($_POST) {
    $data = $_POST;
    // Check required fields
    $requiredFields = ['resume_id', 'slug', 'skill'];
    $missingFields = array_filter($requiredFields, fn($field) => empty($data[$field]));
    
    if (!empty($missingFields)) {
        $fn->setError("The following fields are required: " . implode(', ', array_map('ucfirst', $missingFields)));
        $fn->redirect('../updateresume.php');
        exit;
    }
    
    // Prepare sanitized input
    $resume_id = $database->connect()->real_escape_string($data['resume_id']);
    $slug = $data['slug'] ?? '';
    unset($data['resume_id'], $data['slug']); // Exclude unnecessary fields
    
    $columns = implode(',', array_keys($data));
    $placeholders = implode(',', array_fill(0, count($data), '?'));
    $values = array_values($data);
    $values[] = $resume_id; // Add resume_id at the end for SQL binding
    
    try {
        // Construct and execute query with prepared statements
        $stmt = $database->connect()->prepare("INSERT INTO skills ($columns, resume_id) VALUES ($placeholders, ?)");
        //print_r($stmt);
        //die();
        
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);

        if (!$stmt->execute()) {
            throw new Exception('Database query failed: ' . $stmt->error);
        }

        // Success
        $fn->setAlert('Resume added successfully');
        $fn->redirect("../updateresume.php?resume=$slug");
    } catch (Exception $error) {
        // Handle exceptions and log the error
        error_log($error->getMessage());
        $fn->setError("Something went wrong. Please try again.");
        $fn->redirect("../updateresume.php?resume=$slug");
    }
} else {
    $fn->redirect('../updateresume.php');
}
