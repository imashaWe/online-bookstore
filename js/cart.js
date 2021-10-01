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
            if (!parseInt(r.status)) {
                cartSideViewItems.innerHTML = `<h5 class="text-center">${r.message}</h5>`;
                return;
            }
            if (!r['data'].length) {
                html = "<h3>No Items</h3>";
                disableButtons("setCheckoutBtn");
            }
            for (let item of r['data']) {
                total += parseInt(item.qty) * parseFloat(item.price);
                const rate = Math.floor(Math.random() * (1000 - 100) + 100) / 100;
                html += '<div class="theme-card shadow m-2">' +
                    '<div class="row g-0">' +
                    '<div class="col-2">' +
                    '<img src="' + item.img_url + '" class="img-fluid rounded-start" alt="...">' +
                    '</div>' +
                    '<div class="col pt-1 align-content-center ps-1">' +
                    '<h6 class="theme-text-title">' + item.name + '</h6>' +
                    '<small className="py-3 text-muted theme-text">' + item.qty + ' X ' + item.price + '</small>' +
                    '<div class="rating-bar" data-rate=' + rate + ' data-max="5"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            cartSideViewItems.innerHTML = html;
            cartSideViewTotal.innerHTML = 'TOTAL ' + total.toFixed(2);
            setUpRating();
        });

    });

}());

function addToCart(bookId) {
    postData('api/cart.php?func=add_to_cart', {'book_id': bookId}).then((r) => {

        if (r.status) {
            successAlert(r.message);
        } else {
            errorAlert(r.message);
        }

        setCartCount();
    })
}

function setCartCount() {
    const cartCount = document.getElementById('cartCount');
    postData('api/cart.php?func=get_cart_count', {}).then((r) => {
        cartCount.classList.remove('icon-header-noti');
        cartCount.removeAttribute('data-notify');
        if (parseInt(r.count)) {
            cartCount.classList.add('icon-header-noti');
            cartCount.setAttribute('data-notify', r.count);
        }

    })
}

function calcCartAmount() {
    const cartTableBody = document.getElementById('cartTableBody');
    const cartTotal = document.getElementById('cartTotal');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const couponCodeTbody = document.getElementById('couponCodeTbody');
    let total = 0.00;

    if (!cartTableBody && !couponCodeTbody) return;

    for (let tr of cartTableBody.children) {
        const subTotalElm = tr.getElementsByClassName('cart-item-subtotal')[0];
        const qty = parseInt(tr.getElementsByClassName('cart-item-qty')[0].innerHTML);
        const price = parseFloat(tr.getElementsByClassName('cart-item-price')[0].innerHTML);
        const subTotal = qty * price;
        total += subTotal;
        subTotalElm.innerHTML = subTotal.toFixed(2);

    }
    const subTotal = total;
    for (let tr of couponCodeTbody.children) {
        const discountElm = tr.getElementsByClassName('coupon-code-discount')[0];
        const discount = parseFloat(discountElm.getAttribute('data-discount'));
        const discountValue = subTotal * discount
        discountElm.innerHTML = 'LKR -' + discountValue.toFixed(2);
        total -= discountValue;
    }

    cartTotal.innerHTML = "LKR " + total.toFixed(2);
    cartSubtotal.innerHTML = "LKR " + subTotal.toFixed(2);

}

function decreaseQty(e, bookID) {
    _updateQty(e, bookID, false);
}

function increaseQty(e, bookID) {
    _updateQty(e, bookID, true);

}

function _updateQty(e, bookID, isIncrease) {
    const qtyElm = e.parentElement.getElementsByClassName('cart-item-qty')[0];
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