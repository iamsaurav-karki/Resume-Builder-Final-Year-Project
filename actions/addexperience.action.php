<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if (!empty($post['resume_id']) && !empty($post['position']) && !empty($post['company']) && !empty($post['started']) && !empty($post['ended']) && !empty($post['job_desc'])) {
        $resumeid = $db->real_escape_string($post['resume_id']);
        $position = $db->real_escape_string($post['position']);
        $company = $db->real_escape_string($post['company']);
        $started = $db->real_escape_string($post['started']);
        $ended = $db->real_escape_string($post['ended']);
        $job_desc = $db->real_escape_string($post['job_desc']);
        $slug = $db->real_escape_string($post['slug']); // Retrieve slug for redirection

        // Check for duplicate experience for the given resume
        $checkQuery = "SELECT id FROM experiences WHERE resume_id = $resumeid AND position = '$position' AND company = '$company'";
        $result = $db->query($checkQuery);

        if ($result->num_rows > 0) {
            $fn->setError('This experience is already added to the resume.');
            $fn->redirect("../updateresume.php?resume=$slug");
            exit;
        }

        try {
            // Insert experience into the database
            $query = "INSERT INTO experiences (resume_id, position, company, started, ended, job_desc) VALUES ($resumeid, '$position', '$company', '$started', '$ended', '$job_desc')";
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
