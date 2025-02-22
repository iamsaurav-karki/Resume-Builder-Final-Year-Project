<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    // Check if required fields are filled
    if (!empty($post['resume_id']) && !empty($post['position']) && !empty($post['company']) && !empty($post['started']) && !empty($post['job_desc'])) {
        $resumeid = $db->real_escape_string($post['resume_id']);
        $position = $db->real_escape_string($post['position']);
        $company = $db->real_escape_string($post['company']);
        $started = $db->real_escape_string($post['started']);
        $job_desc = $db->real_escape_string($post['job_desc']);
        $slug = $db->real_escape_string($post['slug']);

        // Handle "Currently Working" checkbox
        $currentlyWorking = isset($post['currently_working']) ? 1 : 0;
        $ended = $currentlyWorking ? null : $db->real_escape_string($post['ended']);

        // Validate Start Date
        $today = date('Y-m-d'); // Get today's date
        if ($started > $today) {
            $fn->setError('Start date cannot be beyond today\'s date.');
            $fn->redirect("../updateresume.php?resume=$slug");
            exit;
        }

        // Validate End Date if not currently working
        if (!$currentlyWorking) {
            if (empty($ended)) {
                $fn->setError('Please provide an end date or select "Currently Working".');
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }

            // Validate End Date is not beyond today's date
            if ($ended > $today) {
                $fn->setError('End date cannot be beyond today\'s date.');
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }

            // Validate End Date is not before Start Date
            if ($ended < $started) {
                $fn->setError('End date cannot be before the start date.');
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }
        } else {
            // If currently working, ensure end date is empty
            if (!empty($post['ended'])) {
                $fn->setError('End date must be empty if "Currently Working" is selected.');
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }
        }

        // Check for duplicate experience for the given resume
        $checkQuery = "SELECT id FROM experiences WHERE resume_id = $resumeid AND position = '$position' AND company = '$company'";
        $result = $db->query($checkQuery);

        if ($result->num_rows > 0) {
            $fn->setError('This experience is already added to the resume.');
            $fn->redirect("../updateresume.php?resume=$slug");
            exit;
        }

        try {
            // Insert experience into the database including currently_working field
            $query = "INSERT INTO experiences (resume_id, position, company, job_desc, started, ended, currently_working) VALUES ($resumeid, '$position', '$company', '$job_desc', '$started', " . ($ended ? "'$ended'" : "NULL") . ", $currentlyWorking)";
            $db->query($query);

            $fn->setAlert('Experience Added!');
            $fn->redirect("../updateresume.php?resume=$slug");
        } catch (Exception $error) {
            $fn->setError('Error adding experience: ' . $error->getMessage());
            $fn->redirect("../updateresume.php?resume=$slug");
        }
    } else {
        $fn->setError('Please fill in all required fields!');
        $fn->redirect('../updateresume.php');
    }
} else {
    $fn->redirect('../updateresume.php');
}
?>