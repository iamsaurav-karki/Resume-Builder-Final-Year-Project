<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if (
        !empty($post['full_name']) &&
        !empty($post['email_id']) &&
        !empty($post['objective']) &&
        !empty($post['mobile_no']) &&
        !empty($post['dob']) &&
        !empty($post['religion']) &&
        !empty($post['nationality']) &&
        !empty($post['marital_status']) &&
        !empty($post['hobbies']) &&
        !empty($post['languages']) &&
        !empty($post['address'])
    ) {
        $columns = '';
        $values = '';
        $slug = $fn->randomstring(); // Generate unique slug
        $authid = $fn->Auth()['id'];

        // Check for duplicate resume title for the user
        $resumeTitle = $db->real_escape_string($post['resume_title']);
        $checkQuery = "SELECT id FROM resumes WHERE resume_title = '$resumeTitle' AND user_id = $authid";
        $result = $db->query($checkQuery);

        if ($result->num_rows > 0) {
            $fn->setError('A resume with this title already exists. Please use a different title.');
            $fn->redirect('../createresume.php');
            exit;
        }

        // Prepare columns and values for insertion
        foreach ($post as $index => $value) {
            $value = $db->real_escape_string($value);
            $columns .= $index . ',';
            $values .= "'$value',";
        }

        // Add slug, updated_at, and user_id to the columns and values
        $columns .= 'slug, updated_at, user_id';
        $values .= "'$slug', NOW(), $authid";

        try {
            // Insert resume into database
            $query = "INSERT INTO resumes ($columns) VALUES ($values)";
            if ($db->query($query)) {
                $fn->setAlert('Resume Added!');
                $fn->redirect('../myresumes.php');
                exit;
            } else {
                throw new Exception('Database insertion failed: ' . $db->error);
            }
        } catch (Exception $error) {
            // Log and display error
            error_log($error->getMessage()); // Log to server error log
            $fn->setError('Error adding resume: ' . $error->getMessage());
            $fn->redirect('../createresume.php');
            exit;
        }
    } else {
        $fn->setError('Please fill all required fields!');
        $fn->redirect('../createresume.php');
        exit;
    }
} else {
    $fn->redirect('../createresume.php');
    exit;
}
?>
