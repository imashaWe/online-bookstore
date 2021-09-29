(function () {
    initWishlist();
}());

function addToWishlist(bookID) {
    postData('api/wishlist.php?func=add_to_wishlist', {'book_id': bookID}).then((r) => {
        if (r.status) {
            successAlert(r.message);
            initWishlist();
        } else {
            errorAlert(r.message);
        }
    });
}

function removeFromWishlist(bookID) {
    postData('api/wishlist.php?func=remove_from_wishlist', {'book_id': bookID}).then((r) => {
        if (r.status) {
            successAlert(r.message);
            initWishlist();
        } else {
            errorAlert(r.message);
        }
    });
}

function initWishlist() {
    postData('api/wishlist.php?func=get_wishlist_ids', {}).then((r) => {

        const wishlistCountElm = document.getElementById('wishlistCountElm');
        const wishlistElms = document.getElementsByClassName('btn-set-wishlist');
        let wishlistIds = [];
        if (r.status) {
            const count = r.data.length;
            wishlistIds = r.data;

            wishlistCountElm.classList.remove('icon-header-noti');
            wishlistCountElm.removeAttribute('data-notify');

            if (parseInt(count)) {
                wishlistCountElm.classList.add('icon-header-noti');
                wishlistCountElm.setAttribute('data-notify', count);

            }

        }

        for (let wishlistElm of wishlistElms) {
            const bookId = wishlistElm.getAttribute('data-id');

            if (wishlistIds.indexOf(bookId) != -1) {
                wishlistElm.innerHTML = '<i class="fas fa-heart fa-lg theme-accent-color"></i>';
                wishlistElm.setAttribute("onclick", "removeFromWishlist(" + bookId + ")");
            } else {
                wishlistElm.innerHTML = '<i class="far fa-heart fa-lg"></i>';
                wishlistElm.setAttribute("onclick", "addToWishlist(" + bookId + ")");
            }
        }

    });
}