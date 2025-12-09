$(document).ready(function() {
    var selectedFile = null;
    
    $('#uploadArea').on('click', function() {
        $('#arquivoServidores').click();
    });
    
    $('#arquivoServidores').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            handleFile(file);
        }
    });
    
    $('#uploadArea').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('drag-over');
    });
    
    $('#uploadArea').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
    });
    
    $('#uploadArea').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
        
        var file = e.originalEvent.dataTransfer.files[0];
        if (file) {
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('arquivoServidores').files = dataTransfer.files;
            handleFile(file);
        }
    });
    
    function handleFile(file) {
        if (file.size > 25 * 1024 * 1024) {
            alert('Arquivo muito grande! Máximo 25 MB.');
            return;
        }
        
        var ext = file.name.split('.').pop().toLowerCase();
        if (ext !== 'xls' && ext !== 'xlsx') {
            alert('Formato inválido! Apenas XLS ou XLSX.');
            return;
        }
        
        selectedFile = file;
        
        $('#filePreview').show();
        $('#fileName').text(file.name);
        $('#fileSize').text(formatFileSize(file.size));
        $('#btnAdicionar').prop('disabled', false);
        
        simulateProgress();
    }
    
    $('#removeFile').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        selectedFile = null;
        $('#arquivoServidores').val('');
        $('#filePreview').hide();
        $('#btnAdicionar').prop('disabled', true);
        $('#uploadProgress').css('width', '0%');
        $('#progressText').text('0%');
    });
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(2) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }
    
    function simulateProgress() {
        var progress = 0;
        var interval = setInterval(function() {
            progress += 10;
            $('#uploadProgress').css('width', progress + '%');
            $('#progressText').text(progress + '%');
            
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 50);
    }
    
    $('#modalUploadServidores').on('hidden.bs.modal', function() {
        $('#removeFile').click();
    });
});