<?php
require "db.php";

$sql = "SELECT id,fname,lname,email,phone
            FROM book_author
            WHERE is_delete = 0";
        $authors = $conn->query($sql);

if (isset($_POST['delete_submit'])) {
    $id = $_POST['id'];
    $sql = "UPDATE book_author SET is_delete = 1 WHERE id = {$id}";
    echo $sql;
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
                    <p>Are you sure want to delete this author?</p>
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
            <h1 class="mt-4">Book Author</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Book Author</li>
            </ol>
            <div class="d-grid  justify-content-end pb-2">
                <a href="book-author-add.php" class="btn btn-dark">Add New Author</a>
            </div>
            <div class="card">

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Telephone Number</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($author = $authors -> fetch_array()): ?>
                            <tr>
                                <td><?= $author['fname'] ?></td>
                                <td><?= $author['lname'] ?></td>
                                <td><?= $author['email'] ?></td>
                                <td><?= $author['phone'] ?></td>
                                <td>
                                    <button type="button"
                                            class="btn btn-danger btn-user-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            onclick="setDelete(<?= $author['id'] ?>)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
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