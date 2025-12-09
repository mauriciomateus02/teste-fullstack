<h1><?php echo $title_page; ?></h1>

<div class="header-form">
    <?php
    echo $this->Html->tag('h2', 'Informações pessoais');
    echo $this->Html->tag('p', 'Cadastre suas informações e adicione uma foto. ');
    ?>
</div>

<?php echo $this->Form->create('Employee', array(
    'id' => 'EmployeesForm',
    'url' => array('controller' => 'employees', 'action' => 'register'),
    'type' => 'file',
    'enctype' => 'multipart/form-data',
    'class' => 'form-register-employee'
)); ?>

<div class="line-inputs">

    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Nome') ?>
    </div>

    <div class="inputs-name">
        <?php
        echo $this->Form->input('name', array(
            'type' => 'text',
            'class' => 'form-control ',
            'div' => array('class' => 'mb-3 form-input'),
            'placeholder' => 'Nome',
            'label' => false
        ));
        echo $this->Form->input('last_name', array(
            'type' => 'text',
            'class' => 'form-control ',
            'div' => array('class' => 'mb-3 form-input'),
            'placeholder' => 'Sobrenome',
            'label' => false
        ));
        ?>
    </div>
</div>
<div class="line-inputs">
    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Email') ?>
    </div>
    <div class="designer-email">
        <div class="input-email">
            <i class="bi bi-envelope"></i>
            <?php
            echo $this->Form->input('email', array(
                'type' => 'email',
                'class' => 'border-0 form-control-custom',
                'label' => false,
                'div' => false,
                'placeholder' => 'E-mail'
            ));
            ?>
        </div>
    </div>
</div>
<div class="line-inputs">

    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Sua foto'); ?>
        <?php echo $this->Html->tag('p', 'Ela aparecerá no seu perfil.', array(
            'class' => 'informations-form'
        )); ?>
    </div>

    <div class="upload-image">

        <?php echo $this->Html->image('user.png', array(
            'class' => 'preview-avatar',
            'id' => 'preview-img'
        )); ?>

        <div class="upload-area">

            <div class="designer-submit-file">
                <?php echo $this->Html->image('upload.png', array(
                    'class' => 'preview-icon-upload'
                )); ?>
            </div>

            <div class="labels-input-file">
                <?php
                echo $this->Html->tag(
                    'p',
                    '<span class="fw-600">Clique para enviar</span> ou arraste e solte',
                    ['escape' => false]
                );

                echo $this->Html->tag('p', 'SVG, PNG, JPG or GIF (max. 800x400px)', array(
                    'class' => 'informations-form'
                )); ?>
            </div>

            <?php
            echo $this->Form->input('image_url', [
                'type' => 'file',
                'accept' => 'image/*',
                'id' => 'upload-photo',
                'label' => false,
                'div' => false,
                'class' => 'input-file'
            ]);

            echo $this->Form->hidden('photo_dir');
            echo $this->Form->hidden('photo_size');
            echo $this->Form->hidden('photo_type');
            ?>
        </div>
    </div>
</div>

<div class="line-inputs">
    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Telefone') ?>
    </div>
    <div class="input-phone">
        <?php
        echo $this->Form->input('phone', array(
            'type' => 'text',
            'class' => 'form-control',
            'label' => false,
            'div' => false,
            'placeholder' => '(__) _____-____',
            'id' => 'phone',
            'maxlength' => 15,
            'pattern' => '\(\d{2}\) \d{4,5}-\d{4}'
        ));
        ?>
    </div>
</div>

<div class="line-inputs">
    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Quais serviço você vai prestar?') ?>
    </div>
    <div class="line-actions-service">
        <select id="services" name="services[]" multiple="multiple" style="width: 100%">
            <?php
            foreach ($services as $service) {
                echo $this->Html->tag(
                    'option',
                    $service['Service']['name'],
                    array('value' => $service['Service']['id'])
                );
            }
            ?>
        </select>

        <button type="button" class="btn btn-form-confirm-modal btn-form-confirm" data-bs-toggle="modal" data-bs-target="#serviceModal">
            <i class="bi bi-plus bi-action"></i>Cadastrar serviço
        </button>
    </div>
</div>

<div class="line-inputs">
    <div class="labels-input">
        <?php echo $this->Html->tag('p', 'Valor do serviço') ?>
    </div>
    <div class="designer-price">
        <div class="input-price">
            <i><?php echo $this->Html->image('real.png', array(
                    'class' => 'icon-coin'
                )); ?></i>
            <?php
            echo $this->Form->input('price', array(
                'type' => 'number',
                'class' => 'border-0 form-control-custom',
                'label' => false,
                'div' => false,
                'placeholder' => 'Ex.: 200,00'
            ));
            ?>
        </div>
    </div>
</div>

<div class="line-btn-actions">
    <?php

    echo $this->Html->link(
        'Cancelar',
        [
            'controller' => 'employees',
            'action' => 'index'
        ],
        ['class' => 'btn btn-form-cancel btn-actions'] // classe do botão
    );
    echo $this->Form->button('Salvar', array(
        'type' => 'submit',
        'class' => 'btn btn-form-confirm btn-actions',
        'escape' => false
    ));
    ?>
</div>


<?php echo $this->Form->end(); ?>


<?php echo $this->element('modal-service'); ?>