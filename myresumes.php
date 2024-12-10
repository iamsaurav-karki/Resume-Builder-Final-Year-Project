<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$title = "My Resumes | Resume Builder";
require './assets/includes/header.php';
require './assets/includes/navbar.php';
$fn->authPage();

// Fetch all resumes for the user
$resumes = $db->query('SELECT * FROM resumes WHERE user_id=' . $fn->Auth()['id']);
$resumes = $resumes->fetch_all(MYSQLI_ASSOC);

// Bubble Sort function to sort resumes by title
function bubbleSort($array, $key) {
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if (strcasecmp($array[$j][$key], $array[$j + 1][$key]) > 0) {
                $temp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $temp;
            }
        }
    }
    return $array;
}

// Sort the resumes by title
$resumes = bubbleSort($resumes, 'resume_title');

?>
<div class="container">
    <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
        <div class="d-flex justify-content-between border-bottom">
            <h5>Resumes</h5>
            <div>
                <a href="createresume.php" class="text-decoration-none"><i class="bi bi-file-earmark-plus"></i> Add New</a>
            </div>
        </div>

        <!-- Search Form -->
        <form id="searchForm" class="d-flex my-3">
            <input type="text" name="searchQuery" class="form-control" id="searchQuery" placeholder="Search by Title..." />
        </form>

        <!-- Resume Results -->
        <div id="resumeResults">
            <div class="d-flex flex-wrap">
                <?php
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
                    echo '<div class="text-center py-3 border rounded mt-3 w-100" style="background-color: rgba(236, 236, 236, 0.56);"><i class="bi bi-file-text"></i> No Resumes Found</div>';
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php require './assets/includes/footer.php'; ?>

<!-- jQuery and AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Trigger search on input
    $('#searchQuery').on('input', function () {
        var searchQuery = $(this).val();

        // AJAX request to fetch search results
        $.ajax({
            url: 'searchResumes.php', // Dedicated endpoint for search logic
            type: 'POST',
            data: { searchQuery: searchQuery },
            success: function (response) {
                // Inject only the resumes (without nav/header) into the container
                $('#resumeResults').html(response);
            },
        });
    });
});
</script>
