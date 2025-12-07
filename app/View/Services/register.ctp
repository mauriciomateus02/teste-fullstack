
<div class="container mt-4">
    <h1>Usuários</h1>
    
    <!-- Botão para abrir modal -->
    <button type="button" class="btn btn-form-confirm-modal" data-bs-toggle="modal" data-bs-target="#serviceModal">
        <i class="bi bi-plus bi-action"></i>Cadastrar serviço
    </button>
    
    <!-- Modal Bootstrap 5 -->
    <?php echo $this->element('modal-service'); ?>
