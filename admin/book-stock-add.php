<?php
require '../core/db.php';
if (isset($_POST['submit'])) {
    $book_ids = $_POST['book_ids'];
    $qtys = $_POST['qtys'];
    $count = count($book_ids);
    if (!$count) {
        $error = "No items";
    } else {

        $sql = "";

        for ($i = 0; $i < $count; $i++) {
            $book_id = $book_ids[$i];
            $qty = $qtys[$i];
            $sql .= "INSERT INTO book_stock (book_id,trans_code,trans_id,in_qty) 
                    VALUES ({$book_id},'ADD-STOCK',0,{$qty});";
        }

        $res = $conn->multi_query($sql);

        if ($res) {
            header('location:book-stock.php');
        } else {
            $error = "Database error";
        }
    }
}
?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Stock Add</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Book Stock</li>
            <li class="breadcrumb-item active">Stock Add</li>
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
                        <div class="row mt-2">
                            <div class="col">
                                <div class="wrapper">
                                    <div class="search-input">
                                        <a href="" target="_blank" hidden></a>
                                        <input type="text" placeholder="Type to search book">

                                        <div class="autocom-box shadow">
                                            <!-- here list are inserted from javascript -->
                                        </div>
                                        <div class="icon"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col">
                                <form action="" method="post">


                                    <ul class="list-group" id="bookList">

                                    </ul>
                                    <div class="row justify-content-end pb-2">
                                        <div class="col-1">
                                            <a href="book-stock.php" class="btn btn-outline-secondary btn-lg float-end"
                                               name="submit">Cancel</a>
                                        </div>
                                        <div class="col-1">
                                            <button type="submit" class="btn btn-success btn-lg" name="submit">Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<script>
    // getting all required elements
    const searchWrapper = document.querySelector(".search-input");
    const inputBox = searchWrapper.querySelector("input");
    const suggBox = searchWrapper.querySelector(".autocom-box");
    const icon = searchWrapper.querySelector(".icon");
    let linkTag = searchWrapper.querySelector("a");
    let webLink;

    // if user press any key and release
    inputBox.onkeyup = async (e) => {
        let userData = e.target.value; //user enetered data
        let emptyArray = [];
        if (userData) {
            icon.onclick = () => {

            }
            emptyArray = await fetch('api/book.php?func=search_book&q=' + userData).then(r => r.json())
                .then(r => {
                    if (r.status) {
                        return r.data.map((e) => {
                            return `<li data-id=${e.id}>${e.name}</li>`;
                        });
                    } else {
                        return [];
                    }
                });
            searchWrapper.classList.add("active"); //show autocomplete box
            showSuggestions(emptyArray);
            let allList = suggBox.querySelectorAll("li");
            for (let i = 0; i < allList.length; i++) {
                //adding onclick attribute in all li tag
                allList[i].setAttribute("onclick", "changeBook(this)");
            }
        } else {
            searchWrapper.classList.remove("active"); //hide autocomplete box
        }
    }

    function select(element) {
        let selectData = element.textContent;
        inputBox.value = selectData;
        icon.onclick = () => {
            webLink = `https://www.google.com/search?q=${selectData}`;
            linkTag.setAttribute("href", webLink);
            linkTag.click();
        }
        searchWrapper.classList.remove("active");
    }


    function showSuggestions(list) {
        let listData;
        if (!list.length) {
            userValue = inputBox.value;
            listData = `<li>${userValue}</li>`;
        } else {
            listData = list.join('');
        }
        suggBox.innerHTML = listData;
    }


    function changeBook(element) {
        const bookList = document.getElementById('bookList');
        const bookName = element.textContent;
        const bookId = element.getAttribute('data-id');
        if (bookId) {
            let item = `<li class="list-group-item d-flex justify-content-between align-items-center">
                         ${bookName}
                        <input type="hidden" name="book_ids[]" value="${bookId}">
                        <input type="number" name="qtys[]" value="10" class="form-control w-25">
                        <span class="clickable list-item-delete text-danger" onclick="deleteElement(this);"><icon class="fa fa-trash"></icon></span>
                </li>`;
            bookList.insertAdjacentHTML('beforeend', item);
        }
        searchWrapper.classList.remove("active");
    }

    function deleteElement(e) {
        e.parentNode.remove();
    }
</script>
<?php require_once('footer.php'); ?>
