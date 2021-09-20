<?php
require("db.php");
$error;

$sql = "SELECT * FROM book_category WHERE is_delete = '0'";
$categories = $conn->query($sql);
$sql = "SELECT * FROM book_author WHERE is_delete = '0'";
$authors = $conn->query($sql);
$sql = "SELECT * FROM book_sub_category WHERE is_delete = '0'";
$sub_categories = $conn->query($sql);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $author_id=$_POST['author_id'];
    $isbn = $_POST['isbn'];
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $description = $_POST['description'];

    if (empty($name)) {
        $error = "Please enter Name";
    } elseif (empty($price)) {
        $error = "Please enter Price";

    } elseif (empty($isbn)) {
        $error = "Please enter ISBN";

    } else {
        // To check whether the ISBN exists.
        $sql = "SELECT id FROM book WHERE ISBN = '{$isbn}'";
        $res = $conn->query($sql);
        if ($res->num_rows) {
            $error = "This ISBN already exists";
        } else {
            $sql = "INSERT INTO book(name,price,auther_id,isbn,category_id,sub_category_id,description) 
                VALUES('{$name}','{$price}',{$author_id},'{$isbn}',{$category_id},{$sub_category_id},'{$description}')";
            $res = $conn->query($sql);
            if ($res) {
                header("location:book-add.php");
                die();
            } else {
                $error = "Database error";
            }
        }

    }
}


?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add New Books</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add New Book</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                     class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                     role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    <?= $error ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="row row-cols-2 g-3">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Select Image File to Upload:</label>
                                    <input type="file" class="form-control-file" id="file">
                                </div><br>
                                <div class="col">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="col">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price">
                                </div>
                                <div class="col">
                                    <label class="form-label">Author</label>
                                    <select class="form-select" name="author_id">
                                        <?php while ($author = $authors->fetch_array()): ?>
                                            <option value="<?= $author['id'] ?>"><?= $author['fname']," ",$author['lname'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" class="form-control" name="isbn">
                                </div>
                                <div class="col">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="category_id">
                                        <?php while ($category = $categories->fetch_array()): ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Sub Category</label>
                                    <select class="form-select" name="sub_category_id">
                                        <?php while ($sub_category = $sub_categories->fetch_array()): ?>
                                            <option value="<?= $sub_category['id'] ?>"><?= $sub_category['sub_category'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-lable">Description</label>
                                    <textarea class="form-control" name="description" rows="4"></textarea>
                                </div>
                                
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success float-end" name="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<?php require_once('footer.php'); ?>
