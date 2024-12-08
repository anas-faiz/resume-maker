<?php

require '../assets/class/db.class.php';
require '../assets/class/functions.class.php';

$database = new db(); // Instantiate the db class

if ($_GET) {
    $data = $_GET;

    // Check required fields
    $requiredFields = ['resume_id', 'id'];
    $missingFields = array_filter($requiredFields, fn($field) => empty($data[$field]));

    if (!empty($missingFields)) {
        $fn->setError("The following fields are required: " . implode(', ', array_map('ucfirst', $missingFields)));
        $fn->redirect('../updateresume.php');
        exit;
    }

    // Retrieve necessary data
    $resume_id = $data['resume_id'];
    $id = $data['id'];

    try {
        // Construct and execute delete query using prepared statements
        $stmt = $database->connect()->prepare("DELETE FROM experience WHERE resume_id = ? AND id = ?");
        $stmt->bind_param('ss', $resume_id, $id);

        if (!$stmt->execute()) {
            throw new Exception('Database query failed: ' . $stmt->error);
        }

        // Success
        $fn->setAlert('Experience deleted successfully');
        $fn->redirect("../updateresume.php?resume=$resume_id");
    } catch (Exception $error) {
        // Handle exceptions and log the error
        error_log($error->getMessage());
        $fn->setError("Something went wrong. Please try again.");
        $fn->redirect("../updateresume.php?resume=$resume_id");
    }
} else {
    $fn->redirect('../updateresume.php');
}
