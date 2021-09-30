<?php
require_once 'core/user.php';
require_once 'core/db.php';

login_access_protect();

$uid = $USER['uid'];

$sql = "SELECT book.* FROM user_wishlist 
        INNER JOIN book ON book.id = user_wishlist.book_id
        WHERE user_wishlist.uid = {$uid}";
$wishlist = $conn->query($sql);
?>
<?php require_once "header.php" ?>

    <main>
        <div class="container py-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12 text-center">
                                <div class="table-responsive">
                                    <table class="table table-wrap">
                                        <tbody class="theme-text">
                                        <?php while ($row = $wishlist->fetch_array()): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= $row['img_url'] ?>" class="img-profile"
                                                         style="height: 20vh">
                                                </td>
                                                <td>
                                                    <?= $row['name'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['price'] ?>
                                                </td>

                                                <td>
                                                    <a type="button"
                                                       href="book-view.php?slug=<?= $row['slug'] ?>"
                                                       class="theme-btn theme-btn-dark-animated">
                                                        See Details
                                                    </a>
                                                    <button type="button"
                                                            class="theme-btn theme-btn-light"
                                                            onclick="remove(<?= $row['id'] ?>)">
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script>
        function remove(bookID) {
            postData('api/wishlist.php?func=remove_from_wishlist', {'book_id': bookID}).then((r) => {
                if (r.status) {
                    successAlert(r.message);
                    location.reload();
                } else {
                    errorAlert(r.message);
                }
            });
        }
    </script>
<?php require_once "footer.php" ?>