<?php
require "core/db.php";
$name = "";
$price = "";
$description = "";
$isbn = "";
$author_id = 0;
$category_id = 0;
$sub_category_id = 0;
$publisher_id = 0;
$language_id = 1;

$sql = "SELECT * FROM book_category WHERE is_delete = '0'";
$categories = $conn->query($sql);

$sql = "SELECT * FROM book_author WHERE is_delete = '0'";
$authors = $conn->query($sql);

$sql = "SELECT * FROM book_publisher WHERE is_delete = '0'";
$publishers = $conn->query($sql);


$sql = "SELECT * FROM book_language";
$languages = $conn->query($sql);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM book WHERE id = {$id}";
    $row = $conn->query($sql)->fetch_array();
    $name = $row['name'];
    $price = $row['price'];
    $description = $row['description'];
    $isbn = $row['isbn'];
    $author_id = $row['author_id'];
    $category_id = $row['category_id'];
    $sub_category_id = $row['sub_category_id'];
    $publisher_id = $row['publisher_id'];
    $language_id = $row['language_id'];


    $sql = "SELECT * FROM book_sub_category WHERE is_delete = '0' AND category_id= {$category_id}";
    $sub_categories = $conn->query($sql);
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $author_id = $_POST['author_id'];
    $publisher_id = $_POST['publisher_id'];
    $isbn = $_POST['isbn'];
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $language_id = $_POST['language_id'];
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = "Please enter Name";
    } elseif (empty($price)) {
        $error = "Please enter Price";
    } elseif (empty($isbn)) {
        $error = "Please enter ISBN";
    } elseif (empty($description)) {
        $error = "Please enter Description";
    } elseif (!$author_id) {
        $error = "Please select Author";
    } elseif (!$publisher_id) {
        $error = "Please select Publisher";
    } elseif (!$category_id) {
        $error = "Please select Category";
    } else {
        // To check whether the ISBN exists.
        $sql = "SELECT id FROM book WHERE ISBN = '{$isbn}'";
        $res = $conn->query($sql);
        if ($res->num_rows && !isset($_POST['id'])) {
            $error = "This ISBN already exists";
        } else {
            if (isset($_POST['id'])) {
                $sql = "UPDATE book SET 
                        name = '{$name}',
                        price = {$price},
                        isbn = '{$isbn}',
                        description = '{$description}',
                        category_id = {$category_id},
                        sub_category_id = {$sub_category_id},
                        author_id = {$author_id},
                        publisher_id = {$publisher_id},
                        language_id = {$language_id}
                        WHERE id = {$id}";
            } else {
                $sql = "INSERT 
                        INTO book(name,price,author_id,publisher_id,isbn,category_id,sub_category_id,language_id,description) 
                        VALUES('{$name}','{$price}',{$author_id},{$publisher_id},'{$isbn}',{$category_id},{$sub_category_id},{$language_id}'{$description}')";
            }
            echo $sql;
            $res = $conn->query($sql);
            if ($res) {
                header("location:book.php");
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
        <h1 class="mt-4"><?= isset($_POST['id']) ? 'Add New' : 'Edit' ?> Book</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Book</li>
            <li class="breadcrumb-item active"><?= isset($_POST['id']) ? 'Add New' : 'Edit' ?> Book</li>
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
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Select Image File to Upload:</label>
                                        <input type="file" class="form-control-file" id="file">
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cols-2 g-3 pt-2">
                                <div class="col">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $name ?>">
                                </div>
                                <div class="col">
                                    <label class="form-label">Language</label>
                                    <select class="form-select" name="language_id" value="<?= $language_id ?>">
                                        <?php while ($row = $languages->fetch_array()): ?>
                                            <option value="<?= $row['id'] ?>"
                                                <?php if ($language_id == $row['id']) echo "selected"; ?>>
                                                <?= $row['language']?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" class="form-control" name="isbn" value="<?= $isbn ?>">
                                </div>
                                <div class="col">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price" value="<?= $price ?>">
                                </div>
                                <div class="col">
                                    <label class="form-label">Author</label>
                                    <select class="form-select" name="author_id" value="<?= $author_id ?>">
                                        <option value=0>Choose</option>
                                        <?php while ($author = $authors->fetch_array()): ?>
                                            <option value="<?= $author['id'] ?>"
                                                <?php if ($author_id == $author['id']) echo "selected"; ?>>
                                                <?= $author['fname'], " ", $author['lname'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Publisher</label>
                                    <select class="form-select" name="publisher_id" value="<?= $publisher_id ?>">
                                        <option value=0>Choose</option>
                                        <?php while ($row = $publishers->fetch_array()): ?>
                                            <option value="<?= $row['id'] ?>"
                                                <?php if ($publisher_id == $row['id']) echo "selected"; ?>>
                                                <?= $row['name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Category</label>
                                    <select class="form-select"
                                            name="category_id"
                                            onchange="getSubCategory(this.value)"
                                    >
                                        <option value=0>Choose</option>
                                        <?php while ($category = $categories->fetch_array()): ?>
                                            <option value="<?= $category['id'] ?>"
                                                <?php if ($category_id == $category['id']) echo "selected"; ?>>
                                                <?= $category['category'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Sub Category</label>
                                    <select class="form-select"
                                            name="sub_category_id"
                                            id="subCategorySelect"
                                            value="<?= $sub_category_id ?>">
                                        <option value=0>N/A</option>
                                        <?php if (isset($sub_categories)): ?>
                                            <?php while ($row = $sub_categories->fetch_array()): ?>
                                                <option value="<?= $row['id'] ?>"
                                                    <?php if ($sub_category_id == $row['id']) echo "selected"; ?>>
                                                    <?= $row['sub_category'] ?></option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 pt-2">
                                <div class="col">
                                    <label class="form-lable">Description</label>
                                    <textarea class="form-control"
                                              name="description"
                                              rows="4"><?= $description ?>
                                    </textarea>
                                </div>
                            </div>
                            <br>
                            <?php if (isset($_GET['id'])): ?>
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?php endif; ?>
                            <div class="row justify-content-end pb-2">
                                <div class="col-1">
                                    <a href="book.php" class="btn btn-outline-secondary btn-lg float-end"
                                       name="submit">Cancel</a>
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<script>
    function getSubCategory(id) {
        const subCategorySelect = document.getElementById("subCategorySelect");
        if (id == 0) {
            subCategorySelect.innerHTML = '<option value=0>N/A</option>';
            return;
        }
        ;
        fetch(`core/api.php?func=get_sub_categories&category_id=${id}`)
            .then(response => response.json())
            .then(data => {
                let rows = data['data'];
                if (!rows.length) {
                    subCategorySelect.innerHTML = '<option value=0>N/A</option>';
                    return;
                }
                let html = '<option value=0>Choose</option>';
                for (let r of rows)
                    html += '<option value=' + r['id'] + '>' + r['sub_category'] + '</option>';
                subCategorySelect.innerHTML = html;
            });
    }

</script>
<?php require_once('footer.php'); ?>
