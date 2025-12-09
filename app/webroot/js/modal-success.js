function showSuccessModal() {
    var modal = document.getElementById('successModal');
    modal.style.display = 'flex';
    
    // Fechar após 2 segundos
    setTimeout(function() {
        modal.classList.add('hiding');
        
        setTimeout(function() {
            modal.style.display = 'none';
            modal.classList.remove('hiding');
        }, 300);
    }, 2000);
}