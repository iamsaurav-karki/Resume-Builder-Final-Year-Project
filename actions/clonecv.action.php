<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

$slug = $_GET['resume'] ?? '';

// Fetch the original resume
$resumes = $db->query("SELECT * FROM resumes WHERE (slug='$slug' AND user_id=" . $fn->Auth()['id'] . ")");
$resume = $resumes->fetch_assoc();

if (!$resume) {
    $fn->redirect('myresumes.php');
}

// Fetch experiences, educations, and skills for the original resume
$exps = $db->query("SELECT * FROM experiences WHERE (resume_id=" . $resume['id'] . ")");
$exps = $exps->fetch_all(1);

$edus = $db->query("SELECT * FROM educations WHERE (resume_id=" . $resume['id'] . ")");
$edus = $edus->fetch_all(1);

$skills = $db->query("SELECT * FROM skills WHERE (resume_id=" . $resume['id'] . ")");
$skills = $skills->fetch_all(1);

// Prepare the cloned resume data
$columns = '';
$values = '';

unset($resume['id']);
unset($resume['slug']);
unset($resume['updated_at']);

$resume['resume_title'] .= ' clone_' . time();

foreach ($resume as $index => $value) {
    $value = $db->real_escape_string($value);
    $columns .= $index . ',';
    $values .= "'$value',";
}

$authid = $fn->Auth()['id'];
$columns .= 'slug, updated_at';
$values .= "'" . $fn->randomstring() . "', NOW()";

try {
    // Insert the cloned resume
    $query = "INSERT INTO resumes ($columns) VALUES ($values)";
    $db->query($query);

    $new_resume_id = $db->insert_id;

    // Clone experiences
    foreach ($exps as $exp) {
        foreach ($exp as $index => $value) {
            $exp[$index] = $db->real_escape_string($value);
        }
        $query2 = "INSERT INTO experiences (resume_id, position, company, job_desc, started, ended, currently_working) 
                   VALUES ($new_resume_id, '{$exp['position']}', '{$exp['company']}', '{$exp['job_desc']}', '{$exp['started']}', " . ($exp['currently_working'] ? "NULL" : "'{$exp['ended']}'") . ", {$exp['currently_working']})";
        $db->query($query2);
    }

    // Clone educations
    foreach ($edus as $edu) {
        foreach ($edu as $index => $value) {
            $edu[$index] = $db->real_escape_string($value);
        }
        $query3 = "INSERT INTO educations (resume_id, course, institute, started, ended, currently_studying) 
                   VALUES ($new_resume_id, '{$edu['course']}', '{$edu['institute']}', '{$edu['started']}', " . ($edu['currently_studying'] ? "NULL" : "'{$edu['ended']}'") . ", {$edu['currently_studying']})";
        $db->query($query3);
    }

    // Clone skills
    foreach ($skills as $skill) {
        foreach ($skill as $index => $value) {
            $skill[$index] = $db->real_escape_string($value);
        }
        $query4 = "INSERT INTO skills (resume_id, skill) 
                   VALUES ($new_resume_id, '{$skill['skill']}')";
        $db->query($query4);
    }

    $fn->setAlert('Resume Cloned!');
    $fn->redirect('../myresumes.php');
} catch (Exception $error) {
    $fn->setError($error->getMessage());
    $fn->redirect('../myresumes.php');
}
?>