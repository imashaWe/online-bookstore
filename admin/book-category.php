<?php
require("db.php");

$sql = "SELECT * FROM book_category WHERE is_delete = '0'";
$categories = $conn->query($sql);

if (isset($_POST['delete_submit'])) {
    $id = $_POST['id'];
    $sql = "UPDATE book_category SET is_delete = 1 WHERE id = '{$id}'";
    $res = $conn->query($sql);
    if ($res) {
        header("location:{$_SERVER['REQUEST_URI']}");
    }
}


?>

<?php require_once('header.php'); ?>
<div class="modal" tabindex="-1" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this category?</p>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <input type="hidden" id="delete_id" name="id">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete_submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Book Categories</h1>
        <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Book Categories</li>
        </ol>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CATEGORY</th>
                        </tr><br>
                    </thead>
                    <tbody>
                    <?php while ($category = $categories->fetch_array()): ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= $category['category'] ?></td>
                            <td>
                                <button type="button"
                                        class="btn btn-danger btn-user-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        onclick="setDelete(<?= $category['id'] ?>)">
                                    Delete
                                </button>
                            </td>
                        </tr><br>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<script>
    function setDelete(id) {
        const delete_id = document.getElementById('delete_id');
        delete_id.value = id;
    }
</script>

<?php require_once('footer.php'); ?>