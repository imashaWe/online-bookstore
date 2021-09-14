<?php
require "db.php";

$sql = "SELECT fname,lname,email,name AS role 
            FROM system_user 
            INNER JOIN system_user_role ON system_user_role.id = system_user.role_id";
$users = $conn->query($sql);

?>
<?php require_once('header.php'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">System Users</li>
                <li class="breadcrumb-item active">Users</li>
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
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($user = $users->fetch_array()): ?>
                            <tr>
                                <td><?= $user['fname'] ?></td>
                                <td><?= $user['lname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>


        </div>
    </main>
<?php require_once('footer.php'); ?>