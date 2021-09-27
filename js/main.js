/* rating bar */
(function () {
    setUpRating();
}())

function setUpRating() {
    const ratingBarList = document.getElementsByClassName('rating-bar');
    for (let e of ratingBarList) {
        let rate = parseFloat(e.getAttribute('data-rate'));
        let max = parseFloat(e.getAttribute('data-max'));
        let html = '';
        for (let i = 1; i <= max; i++) {
            let val = rate - i;
            if (val > 1) {
                html += '<span class="fas fa-star theme-accent-color"></span>';
            } else if (val > 0) {
                html += ' <span class="fas fa-star-half-alt theme-accent-color"></span>';
            } else {
                html += '<span class="far fa-star"></span>';
            }
        }
        e.innerHTML = html;
    }
}

function successAlert(message) {
    _alert(message, false);
}

function errorAlert(message) {
    _alert(message, true);
}

function _alert(message, isError) {
    Swal.fire({
        position: 'top-end',
        icon: isError ? 'error' : 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
}
