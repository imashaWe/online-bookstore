<?php
require("db.php");

$error;

$sql = "SELECT * FROM book_category";

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $scategory = $_POST['SubCategory'];

    if (empty($category)) {
        $error = "Please enter Category";
    
    }else {
        $sql = "SELECT * FROM `online-bookstore`.book_category WHERE category = '{$category}' AND is_delete = '0'";
        $res = $conn->query($sql);

        $raw=$result->fetch_array();
        $category_id = $raw['id'];

        if ($res->num_rows) {
            //$error = "This category already exists";
            $sql = "INSERT INTO `online-bookstore`.`book_sub_category` (`category_id`, `name`) VALUES ('{$category_id}','{$scategory}')";
        } else {
            $sql = "INSERT INTO `online-bookstore`.`book_category` (`category`) VALUES ('{$category}')";
            $res = $conn->query($sql);
            echo $res;
            if ($res) {
                header("location:book-category-add.php");
                die();
            } else {
                $error = "Database error";
            }
            //$sql = "INSERT INTO book_sub_category(category_id, name) VALUES('{$category_id}','{$scategory}')";

        }

    }
}


?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add New Categories</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Add Sub category</li>
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
                                <div class="col">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category">

                                    <label class="form-label">Sub Category</label>
                                    <input type="text" class="form-control" name="SubCategory"><br>
                                    <button type="button" class="btn btn-primary float-end" name="add">Add</button>

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
