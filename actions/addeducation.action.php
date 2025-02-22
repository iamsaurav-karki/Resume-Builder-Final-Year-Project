<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    // Debug log
    file_put_contents('debug.log', 'POST data: ' . print_r($_POST, true) . "\n", FILE_APPEND);

    if (!empty($_POST['resume_id']) && !empty($_POST['course']) && !empty($_POST['institute']) && !empty($_POST['started'])) {
        $resumeid = $db->real_escape_string($_POST['resume_id']);
        $course = $db->real_escape_string($_POST['course']);
        $institute = $db->real_escape_string($_POST['institute']);
        $started = $db->real_escape_string($_POST['started']);
        $slug = $db->real_escape_string($_POST['slug']);

        // Handle currently studying status
        $currentlyStudying = isset($_POST['currently_studying']) ? 1 : 0;
        
        // Handle end date based on currently studying status
        if ($currentlyStudying) {
            $ended = "NULL"; // Use NULL if currently studying
        } else {
            // If not currently studying, require end date
            if (empty($_POST['ended'])) {
                $fn->setError('Please provide an end date or select "Currently Studying".');
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }
            $ended = "'" . $db->real_escape_string($_POST['ended']) . "'";
        }

        // Build the query
        $query = "INSERT INTO educations (
            resume_id, 
            course, 
            institute, 
            started, 
            ended, 
            currently_studying
        ) VALUES (
            $resumeid,
            '$course',
            '$institute',
            '$started',
            $ended,
            $currentlyStudying
        )";

        // Debug log
        file_put_contents('debug.log', 'SQL Query: ' . $query . "\n", FILE_APPEND);

        try {
            if ($db->query($query)) {
                $fn->setAlert('Education Added Successfully!');
            } else {
                $fn->setError('Database Error: ' . $db->error);
                file_put_contents('debug.log', 'DB Error: ' . $db->error . "\n", FILE_APPEND);
            }
        } catch (Exception $e) {
            $fn->setError('Error: ' . $e->getMessage());
            file_put_contents('debug.log', 'Exception: ' . $e->getMessage() . "\n", FILE_APPEND);
        }

        $fn->redirect("../updateresume.php?resume=$slug");
        exit;
    } else {
        $fn->setError('Please fill in all required fields.');
        $fn->redirect("../updateresume.php?resume=$slug");
        exit;
    }
} else {
    $fn->redirect('../updateresume.php');
}
?>