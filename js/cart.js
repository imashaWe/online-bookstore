(function () {

    const cartSideView = document.getElementById('cartSideView');
    const cartSideItemsView = document.getElementById('cartSideItemsView');

    cartSideView.addEventListener('shown.bs.offcanvas', () => {
        // assets/gifs/loading.gif
        cartSideItemsView.innerHTML = '<img src="assets/gifs/loading.gif">';

    });

}());

function addToCart(bookId) {
    postData('api/cart.php?func=add_to_cart', {'book_id': bookId}).then((r) => {
        console.log(r);
        Swal.fire({
            position: 'top-end',
            icon: r.status ? 'success' : 'error',
            title: r.message,
            showConfirmButton: false,
            timer: 1500
        });
    })
}

function getCartItems() {

}