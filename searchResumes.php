<?php
// Include necessary files
require $_SERVER['DOCUMENT_ROOT'] . '/resumebuilder/assets/class/database.class.php';
require $_SERVER['DOCUMENT_ROOT'] . '/resumebuilder/assets/class/function.class.php';

// Get the search query from the POST request
$searchQuery = isset($_POST['searchQuery']) ? $_POST['searchQuery'] : '';

// SQL query to search for resumes
$query = "
    SELECT DISTINCT resumes.*, 
        CASE 
            WHEN resumes.resume_title LIKE '$searchQuery%' THEN 1
            WHEN resumes.resume_title LIKE '%$searchQuery%' THEN 2
            WHEN skills.skill LIKE '%$searchQuery%' THEN 3
            ELSE 4
        END AS priority
    FROM resumes
    LEFT JOIN skills ON resumes.id = skills.resume_id
    WHERE resumes.user_id = " . $fn->Auth()['id'] . " AND (
        resumes.resume_title LIKE '%$searchQuery%' OR 
        skills.skill LIKE '%$searchQuery%'
    )
    ORDER BY priority ASC, resumes.resume_title ASC
";

$resumes = $db->query($query);
$resumes = $resumes->fetch_all(MYSQLI_ASSOC);

// Output search results dynamically as HTML
if ($resumes) {
    foreach ($resumes as $resume) {
        ?>
        <div class="col-12 col-md-6 p-2">
            <div class="p-2 border rounded">
                <h5><?= htmlspecialchars($resume['resume_title']) ?></h5>
                <p class="small text-secondary m-0" style="font-size:12px"><i class="bi bi-clock-history"></i>
                    Last Updated <?= date('d M, Y ', strtotime($resume['updated_at'])) ?>
                </p>
                <div class="d-flex gap-2 mt-1">
                    <a href="resume.php?resume=<?= $resume['slug'] ?>" target="_blank" class="text-decoration-none small"><i class="bi bi-file-text"></i> Open</a>
                    <a href="updateresume.php?resume=<?= $resume['slug'] ?>" class="text-decoration-none small"><i class="bi bi-pencil-square"></i> Edit</a>
                    <a href="actions/deleteresume.action.php?id=<?= $resume['id'] ?>" class="text-decoration-none small"><i class="bi bi-trash2"></i> Delete</a>
                    <a href="actions/clonecv.action.php?resume=<?= $resume['slug'] ?>" class="text-decoration-none small"><i class="bi bi-copy"></i> Clone</a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div class="text-center py-3 border rounded mt-3" style="background-color: rgba(236, 236, 236, 0.56);"><i class="bi bi-file-text"></i> No Resumes Found</div>';
}
?>
