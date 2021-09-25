/* rating bar */
(function () {
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
}())


/* Toast messages */
function toastSuccess(message) {
    const toastElm = document.getElementById('toastElm');
    const toastElmMessage = document.getElementById('toastElmMessage');
    toastElmMessage.innerHTML = '<i class="fas fa-check-circle"></i>&nbsp;' + message + '';
    const toast = bootstrap.Toast.getOrCreateInstance(toastElm);
    toast.show();

}
