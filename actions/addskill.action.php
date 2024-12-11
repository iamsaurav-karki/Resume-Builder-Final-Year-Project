<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if ($post['resume_id'] && $post['skill']) {
        $resumeid = $db->real_escape_string($post['resume_id']);
        $skill = $db->real_escape_string($post['skill']);
        $slug = $db->real_escape_string($post['slug']); // Retrieve slug for redirection

        // Check for duplicate skill for the given resume
        $checkQuery = "SELECT id FROM skills WHERE skill = '$skill' AND resume_id = $resumeid";
        $result = $db->query($checkQuery);

        if ($result->num_rows > 0) {
            $fn->setError('This skill is already added to the resume.');
            $fn->redirect("../updateresume.php?resume=$slug");
            exit;
        }

        try {
            // Insert skill into the database
            $query = "INSERT INTO skills (skill, resume_id) VALUES ('$skill', $resumeid)";
            $db->query($query);

            $fn->setAlert('Skill Added!');
            $fn->redirect("../updateresume.php?resume=$slug");
        } catch (Exception $error) {
            $fn->setError($error->getMessage());
            $fn->redirect("../updateresume.php?resume=$slug");
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../updateresume.php');
    }
} else {
    $fn->redirect('../updateresume.php');
}
?>
