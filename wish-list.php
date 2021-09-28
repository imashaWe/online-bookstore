<?php require_once "header.php" ?>

    <main>
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="cart-side-view.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>
            <div class="m-4" class="text-start">
                <h3>Wishlist</h3>
            </div>
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12 text-center">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <img width="100" height="200" src="" class="img-fluid"
                                                 alt="Book Image">
                                        </td>
                                        <td>
                                            BOOK NAME
                                        </td>
                                        <td>
                                            PRICE
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-dark">ADD TO CART</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary">See Details</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img width="100" height="200" src="" class="img-fluid"
                                                 alt="Book Image">
                                        </td>
                                        <td>
                                            BOOK NAME
                                        </td>
                                        <td>
                                            PRICE
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-dark">ADD TO CART</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary">See Details</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-danger">Clear All</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <br>
<?php require_once "footer.php" ?>