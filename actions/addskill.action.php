<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    // Check if required fields are filled
    if (!empty($post['resume_id']) && !empty($post['skill'])) {
        $resumeid = $db->real_escape_string($post['resume_id']);
        $skill = $db->real_escape_string($post['skill']);
        $slug = $db->real_escape_string($post['slug']);

        // Validate skill format (only strings separated by commas)
        if (!preg_match('/^[a-zA-Z,\s]+$/', $skill)) {
            $fn->setError('Skills must be strings separated by commas (e.g., "Java, Python, Selenium").');
            $fn->redirect("../updateresume.php?resume=$slug");
            exit;
        }

        // Split skills by commas and trim whitespace
        $skills = array_map('trim', explode(',', $skill));

        // Check for duplicate skills for the given resume
        foreach ($skills as $singleSkill) {
            $checkQuery = "SELECT id FROM skills WHERE skill = '$singleSkill' AND resume_id = $resumeid";
            $result = $db->query($checkQuery);

            if ($result->num_rows > 0) {
                $fn->setError("The skill '$singleSkill' is already added to the resume.");
                $fn->redirect("../updateresume.php?resume=$slug");
                exit;
            }
        }

        try {
            // Insert each skill into the database
            foreach ($skills as $singleSkill) {
                $query = "INSERT INTO skills (skill, resume_id) VALUES ('$singleSkill', $resumeid)";
                $db->query($query);
            }

            $fn->setAlert('Skills Added!');
            $fn->redirect("../updateresume.php?resume=$slug");
        } catch (Exception $error) {
            $fn->setError('Error adding skills: ' . $error->getMessage());
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