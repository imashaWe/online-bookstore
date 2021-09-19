<?php require_once "header.php" ?>
<main>
    <div class="container">

        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php for ($i = 0; $i < 20; $i++): ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="item-pic item-img-hov">
                                <img src="https://picsum.photos/200" alt="IMG-PRODUCT">
                                <a href="#" class="item-btn flex-c-m item-btn-font item-btn-hov item-trans">
                                    Quick View
                                </a>
                            </div>
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

    </div>
</main>
<?php require_once "footer.php" ?>

