<?php
require "db.php";




?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Book Publishers</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Book Publishers</li>
        </ol>
        <div class="d-grid  justify-content-end pb-2">
            <a href="book-publisher-add.php" class="btn btn-dark">Add New Publisher</a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
<?php require_once('footer.php'); ?>


