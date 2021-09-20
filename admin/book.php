<?php
require "core/db.php";
/* pagination */
$sql = "SELECT COUNT(id) AS count FROM book WHERE is_delete = 0 ";
$count = $conn->query($sql)->fetch_array()['count'];
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$num_pages = ceil($count / $limit);
$start = ($page - 1) * $limit;

$sql = "SELECT 
        book.id,book.name AS name,price,isbn,
        CONCAT(book_author.fname,' ',book_author.fname) AS author,
        book_publisher.name AS publisher,
        book_language.language
        FROM book
        INNER JOIN book_author ON book_author.id = book.author_id
        INNER JOIN book_publisher ON book_publisher.id = book.publisher_id
        INNER JOIN book_language ON book_language.id = book.language_id
        WHERE book.is_delete = '0'  
        LIMIT {$start},{$limit}";
$books = $conn->query($sql);

if (isset($_POST['delete_submit'])) {
    $id = $_POST['id'];
    $sql = "UPDATE book SET is_delete = 1 WHERE id = {$id}";
    $res = $conn->multi_query($sql);
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
                    <p>Are you sure you want to delete this book?</p>
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
            <h1 class="mt-4">Books</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Books</li>
            </ol>

            <div class="d-grid  justify-content-end pb-2">
                <a href="book-add.php" class="btn btn-dark">Add New Book</a>
            </div>

            <div class="card">
                <div class="card-body table-wrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Language</th>
                            <th>Price</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($book = $books->fetch_array()): ?>
                            <tr>
                                <td><?= $book['name'] ?></td>
                                <td><?= $book['isbn'] ?></td>
                                <td><?= $book['author'] ?></td>
                                <td><?= $book['publisher'] ?></td>
                                <td><?= $book['language'] ?></td>
                                <td><?= $book['price'] ?></td>
                                <td class="text-end">
                                    <div>
                                        <a href="book-add.php?id=<?= $book['id'] ?>"
                                           class="btn btn-secondary">Edit</a>
                                        <button type="button"
                                                class="btn btn-danger btn-user-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                onclick="setDelete(<?= $book['id'] ?>)">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination float-end">
                            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                                <a class="page-link" href="<?= change_url_params('page', $page - 1) ?>">
                                    Previous
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                                    <a class="page-link" href="<?= change_url_params('page', $i) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($page == $num_pages) echo 'disabled'; ?>">
                                <a class="page-link"
                                   href="<?= change_url_params('page', $page + 1) ?>">
                                    Next
                                </a>
                            </li>
                        </ul>
                    </nav>
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