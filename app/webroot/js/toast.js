// Local: app/webroot/js/toast.js

function toast(message, type) {
    type = type || 'info';
    
    const container = document.getElementById('toast-container');
    
    if (!container) {
        console.error('Toast container não encontrado');
        return;
    }
    
    const icons = {
        success: '✓',
        error: '✕',
        warning: '!',
        info: 'i'
    };
    
    const div = document.createElement('div');
    div.className = 'toast ' + type;
    div.innerHTML = 
        '<div class="toast-icon">' + icons[type] + '</div>' +
        '<div class="toast-content">' + message + '</div>' +
        '<button class="toast-close" onclick="closeToast(this)">×</button>';
    
    container.appendChild(div);
    
    // Auto fechar após 5 segundos
    setTimeout(function() {
        closeToast(div.querySelector('.toast-close'));
    }, 5000);
}

function closeToast(button) {
    const toastElement = button.parentElement;
    toastElement.classList.add('hide');
    
    setTimeout(function() {
        toastElement.remove();
    }, 300);
}