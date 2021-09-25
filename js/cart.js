(function () {
    setCartCount();
    const cartSideView = document.getElementById('cartSideView');
    const cartSideViewItems = document.getElementById('cartSideViewItems');
    const cartSideViewTotal = document.getElementById('cartSideViewTotal');

    cartSideView.addEventListener('shown.bs.offcanvas', () => {
        // assets/gifs/loading.gif
        cartSideViewItems.innerHTML = '<div class="loading-gif">' +
            '<img src="assets/gifs/loading.gif" class="loading-gif">' +
            '</div>';
        postData('api/cart.php?func=get_cart_items', {}).then((r) => {
            let total = 0.00;
            let html = ''
            for (let item of r['data']) {
                total += parseInt(item.qty) * parseFloat(item.price);
                html += '<div class="theme-card shadow m-2">' +
                    '<div class="row g-0">' +
                    '<div class="col-2">' +
                    '<img src="' + item.img_url + '" class="img-fluid rounded-start" alt="...">' +
                    '</div>' +
                    '<div class="col pt-1 align-content-center ps-1">' +
                    '<h6 class="theme-text-title">' + item.name + '</h6>' +
                    '<small className="py-3 text-muted theme-text">' + item.qty + ' X ' + item.price + '</small>' +
                    '<div class="rating-bar" data-rate="1.2" data-max="5"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            cartSideViewItems.innerHTML = html;
            cartSideViewTotal.innerHTML = 'TOTAl ' + total.toFixed(2);
            setUpRating();
        });

    });

}());

function addToCart(bookId) {
    postData('api/cart.php?func=add_to_cart', {'book_id': bookId}).then((r) => {
        Swal.fire({
            position: 'top-end',
            icon: r.status ? 'success' : 'error',
            title: r.message,
            showConfirmButton: false,
            timer: 1500
        });
        setCartCount();
    })
}

function setCartCount() {
    const cartCount = document.getElementById('cartCount');
    postData('api/cart.php?func=get_cart_count', {}).then((r) => {
        cartCount.classList.remove('cartCount.classList');
        cartCount.removeAttribute('data-notify');
        if (r.count) {
            cartCount.classList.add('icon-header-noti');
            cartCount.setAttribute('data-notify', r.count);
        }

    })
}