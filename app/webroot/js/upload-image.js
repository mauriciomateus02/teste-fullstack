$(document).on('change', '#upload-photo', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    $('#preview-img').attr('src', url).css('opacity', '1');
});

$(document).ready(function () {
    var uploadArea = $('#uploadArea1');
    var fileInput = $('#upload-photo');
    var previewImage = $('#preview-image');
    var originalSrc = previewImage.attr('src');

    // Click na área para abrir seletor de arquivo
    uploadArea.on('click', function (e) {
        if (e.target.tagName !== 'INPUT') {
            fileInput.click();
        }
    });

    // Quando selecionar arquivo
    fileInput.on('change', function (e) {
        handleFile(e.target.files[0]);
    });

    // Prevenir comportamento padrão do drag
    uploadArea.on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.addClass('drag-over');
    });

    uploadArea.on('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.removeClass('drag-over');
    });

    // Quando soltar arquivo
    uploadArea.on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.removeClass('drag-over');

        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            var file = files[0];

            // Atualizar o input file
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput[0].files = dataTransfer.files;

            handleFile(file);
        }
    });

    // Função para processar o arquivo
    function handleFile(file) {
        if (!file) return;

        // Validar se é imagem
        if (!file.type.match('image.*')) {
            alert('Por favor, selecione apenas arquivos de imagem.');
            return;
        }

        // Validar tamanho (exemplo: 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Arquivo muito grande! Máximo 5MB.');
            return;
        }

        // Preencher campos hidden
        $('#EmployeePhotoDir').val(file.name);
        $('#EmployeePhotoSize').val(file.size);
        $('#EmployeePhotoType').val(file.type);

        // Preview da imagem
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview-img').attr('src', e.target.result).css('opacity', '1');
        };
        reader.readAsDataURL(file);
    }
});