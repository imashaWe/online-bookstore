<?php
require "db.php";

$sql = "SELECT system_user.id,fname,lname,email,name AS role 
            FROM system_user 
            INNER JOIN system_user_role ON system_user_role.id = system_user.role_id
            WHERE is_delete = 0";
$users = $conn->query($sql);

if (isset($_POST['delete_submit'])) {
    $uid = $_POST['uid'];
    $sql = "UPDATE system_user SET is_delete = 1 WHERE id = {$uid}";
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
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <input type="hidden" id="uid" name="uid">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="delete_submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">System Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">System Users</li>
            </ol>
            <div class="d-grid  justify-content-end pb-2">
                <a href="system-user-add.php" class="btn btn-dark">Add New User</a>
            </div>
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($user = $users->fetch_array()): ?>
                            <tr>
                                <td><?= $user['fname'] ?></td>
                                <td><?= $user['lname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td>
                                    <button type="button"
                                            class="btn btn-danger btn-user-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            onclick="setDelete(<?= $user['id'] ?>)"
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
            const uid = document.getElementById('uid');
            uid.value = id;
        }
    </script>
<?php require_once('footer.php'); ?>