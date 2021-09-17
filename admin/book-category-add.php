<?php
require("db.php");

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    if (empty($category)) {
        $error = "Please enter Category";
    } else {
        $sql = "INSERT INTO book_category (category) VALUES('{$category}')";
        $res = $conn->query($sql);
        if ($res) {
            if (isset($_POST['sub_categories'])) {
                $insert_id = $conn->insert_id;
                $sql = "INSERT INTO book_sub_category (category_id,sub_category) VALUES (?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $insert_id, $sub_category);
                foreach ($_POST['sub_categories'] as $sub_category) {
                    $stmt->execute();
                }
                $stmt->close();
            }
            header("location:book-category.php");
        } else {
            $error = "Database error";
        }

    }
}


?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add New Category</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Book Category</li>
            <li class="breadcrumb-item active">Add New Category</li>
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

                                <div class="col-2">
                                    <label class="form-label">Category Name:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="category">
                                </div>

                            </div>
                            <br>
                            <div class="row">

                                <div class="col-2">
                                    <label class="form-label">Sub Categories:</label>
                                </div>

                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control"
                                               placeholder="Type sub category name and press add"
                                               aria-label="Subcategory name"
                                               aria-describedby="btnAdd"
                                               id="subCategoryNameField"
                                        >
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                id="btnAdd">
                                            <icon class="fas fa-plus"></icon>&nbsp;Add
                                        </button>
                                    </div>
                                    <ul class="list-group" id="subCategoriesList">

                                    </ul>
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
<script>
    (function () {
        const btnAdd = document.getElementById('btnAdd');
        const subCategoryNameField = document.getElementById('subCategoryNameField');
        const subCategoriesList = document.getElementById('subCategoriesList');
        btnAdd.addEventListener("click", () => {
            const subCategory = subCategoryNameField.value;
            if (!subCategory || subCategory.length == 0) return;
            let item = `<li class="list-group-item d-flex justify-content-between align-items-center">
                         ${subCategory}
                        <input type="hidden" name="sub_categories[]" value="${subCategory}">
                        <span class="clickable list-item-delete text-danger" onclick="deleteElement(this);"><icon class="fa fa-trash"></icon></span>
                </li>`;
            subCategoriesList.insertAdjacentHTML('beforeend', item);
            // let itemDeleteBtn = document.getElementsByClassName('list-item-delete');
            // for (let item of itemDeleteBtn) {
            //     item.addEventListener('click', (e) => {
            //         console.log(e.target.parentNode)
            //         ;
            //     })
            // }
            subCategoryNameField.value = null;
        })
    })();

    function deleteElement(e) {
        e.parentNode.remove();
    }

</script>
<?php require_once('footer.php'); ?>
