$(document).on('change', '#upload-photo', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    $('#preview-img').attr('src', url).css('opacity', '1');
});