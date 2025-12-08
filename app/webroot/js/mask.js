$(document).ready(function () {

    $('#phone').on('input', function () {
        let v = $(this).val().replace(/\D/g, '');

        if (v.length > 11) v = v.slice(0, 11);

        if (v.length <= 10) {
            v = v.replace(/^(\d{2})(\d)/, "($1) $2");
            v = v.replace(/(\d{4})(\d)/, "$1-$2");
        } else {
            v = v.replace(/^(\d{2})(\d)/, "($1) $2");
            v = v.replace(/(\d{5})(\d)/, "$1-$2");
        }

        $(this).val(v);
    });

});