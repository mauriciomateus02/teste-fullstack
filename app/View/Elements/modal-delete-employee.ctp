<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja excluir <strong id="employeeName"></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <?php
        echo $this->Form->create('Employee', [
            'id' => 'deleteForm',
            'type' => 'post',
            'url' => ['controller' => 'employees', 'action' => 'delete']
        ]);
        echo $this->Form->hidden('_method', ['value' => 'DELETE']);
        echo $this->Form->hidden('id', ['id' => 'deleteEmployeeId']); // Campo hidden para o ID
        ?>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>