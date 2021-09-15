
<?php require_once('header.php'); ?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Book Author</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Book Author</li>
            </ol>
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
                        <?php while ($user = $users->fetch_array()): ?>
                            <tr>
                                <td><?= $user['fname'] ?></td>
                                <td><?= $user['lname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['phone'] ?></td>
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
    </main>

<?php require_once('footer.php'); ?>