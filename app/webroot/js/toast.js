var flash = document.getElementById('flashMessage');
flash.classList.add('show');

setTimeout(function () {
    flash.classList.remove('show');
}, 3000);