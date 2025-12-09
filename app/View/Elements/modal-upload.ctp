<div class="modal fade" id="modalUploadEmployees" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faça o upload da sua lista de servidores</h4>
            </div>

            <?php echo $this->Form->create('Employee', array(
                'type' => 'file',
                'url' => array('controller' => 'Employees', 'action' => 'uploadFile'),
                'id' => 'formUploadServidores'
            )); ?>

            <div class="modal-body">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="glyphicon glyphicon-cloud-upload" style="font-size: 48px; color: #ccc;"></i>
                    </div>

                    <div class="designer-submit-file">
                        <?php echo $this->Html->image('upload.png', array(
                            'class' => 'preview-icon-upload'
                        )); ?>
                    </div>

                    <p class="upload-text">
                        <strong>Clique para enviar</strong> ou arraste e solte<br>
                        <small>XLS, XLSX (máx. 25 MB)</small>
                    </p>

                    <?php echo $this->Form->input('list_employees', [
                        'type' => 'file',
                        'label' => false,
                        'id' => 'arquivoServidores',
                        'accept' => '.xls,.xlsx',
                    ]); ?>
                </div>


                <div id="filePreview" style="display: none; margin-top: 20px;">
                    <div class="file-preview-box">
                        <div class="file-icon-wrapper">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name" id="fileName"></div>
                            <div class="file-size" id="fileSize"></div>
                        </div>
                        <div class="file-status">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="progress-wrapper">
                        <div class="progress-bar-custom" id="uploadProgress" style="width: 0%"></div>
                    </div>
                    <div class="progress-text" id="progressText">0%</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-form-cancel btn-actions" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <?php

                echo $this->Form->button('Adiconar', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-actions',
                    'escape' => false,
                    'id' => "btnAdicionar",
                    'disabled' => true
                )); ?>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>