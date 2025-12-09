<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Cadastre um serviço</h5>
            </div>

            <?php echo $this->Form->create('Service', array(
                'id' => 'ServiceForm',
                'url' => array(
                    'controller' => 'services',
                    'action' => 'register'
                ),
                'class' => 'modal-form'
            )); ?>

            <div class="modal-body">
                <div class="column">
                    <div class="col-md-6 input-from-service">
                        <?php echo $this->Form->input('name', array(
                            'label' => 'Nome do Serviço',
                            'type' => 'text',
                            'class' => 'form-control',
                            'div' => array('class' => 'mb-3 '),
                            'placeholder' => 'Adicione o nome do serviço'
                        )); ?>
                    </div>
                    <div class="col-md-6 input-from-service">
                        <?php echo $this->Form->input('description', array(
                            'label' => 'Descrição',
                            'type' => 'text',
                            'class' => 'form-control ',
                            'div' => array('class' => 'mb-3'),
                            'placeholder' => 'Adicione uma descrição'
                        )); ?>
                    </div>
                </div>

                <!-- Área para mensagens de erro -->
                <div id="formErrors" class="alert alert-danger d-none"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-form-cancel btn-actions" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <?php

                echo $this->Form->button('Cadastrar', array(
                    'type' => 'submit',
                    'class' => 'btn btn-form-confirm btn-actions',
                    'escape' => false
                )); ?>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>