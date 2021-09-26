(function () {
    setCartCount();
    calcCartAmount();
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

    const btnQryGroups = document.getElementsByClassName('btn-qty-group');
    for (let btnQryGroup of btnQryGroups) {

    }

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
        if (parseInt(r.count)) {
            cartCount.classList.add('icon-header-noti');
            cartCount.setAttribute('data-notify', r.count);
        }

    })
}

function calcCartAmount() {
    const cardTableBody = document.getElementById('cardTableBody');
    const cardTotal = document.getElementById('cardTotal');
    const cardSubtotal = document.getElementById('cardSubtotal');
    let total = 0.00;

    if (!cardTableBody) return;

    for (let tr of cardTableBody.children) {
        const subTotalElm = tr.getElementsByClassName('card-item-subtotal')[0];
        const qty = parseInt(tr.getElementsByClassName('card-item-qty')[0].innerHTML);
        const price = parseFloat(tr.getElementsByClassName('card-item-price')[0].innerHTML);
        const subTotal = qty * price;
        total += subTotal;
        subTotalElm.innerHTML = subTotal.toFixed(2);

    }

    cardTotal.innerHTML = "LKR " + total.toFixed(2);
    cardSubtotal.innerHTML = "LKR " + total.toFixed(2);

}

function decreaseQty(e, bookID) {
    _updateQty(e, bookID, false);
}

function increaseQty(e, bookID) {
    _updateQty(e, bookID, true);

}

function _updateQty(e, bookID, isIncrease) {
    const qtyElm = e.parentElement.getElementsByClassName('card-item-qty')[0];
    let qty = parseInt(qtyElm.innerHTML);
    qty = isIncrease ? qty + 1 : qty - 1;
    postData('api/cart.php?func=update_item_qty', {'book_id': bookID, 'qty': qty}).then((r) => {
        if (r) {
            if (qty < 1) {
                e.parentNode.parentNode.parentNode.remove();
                setCartCount();
            }
            qtyElm.innerHTML = qty.toString();
        }
        calcCartAmount();
    })
}