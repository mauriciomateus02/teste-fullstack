<div class="header-list-employees">
    <div class="title-header-employees">
        <?php echo $this->Html->tag('h1', $title_page); ?>
        <?php echo $this->Html->tag('p', 'Veja sua lista de prestadores de serviço'); ?>

    </div>
    <div class="header-btns">
        <button type="button" class="btn btn-form-confirm btn-actions btn-import" data-bs-toggle="modal" data-bs-target="#modalUploadEmployees">
            <i class="bi bi-upload bi-action"></i>Importar
        </button>
        <?php
        echo $this->Html->link(
            '<i class="bi bi-plus bi-action"></i> Add novo prestador',
            [
                'controller' => 'employees',
                'action' => 'register'
            ],
            [
                'class' => 'btn btn-form-confirm btn-actions',
                'escape' => false
            ]
        );
        ?>
    </div>
</div>

<div class="designer-search">
    <?php
    // Adicione o método GET e uma ação clara
    echo $this->Form->create('Employee', [
        'type' => 'get',
        'url' => ['controller' => 'employees', 'action' => 'index'],
        'id' => 'searchForm',
        'class' => 'search-form'
    ]);
    ?>
    <div class="input-search">
        <i class="bi bi-search"></i>
        <?php
        echo $this->Form->input(
            'q',
            array(
                'type' => 'text',
                'class' => 'border-0 form-control-custom',
                'label' => false,
                'div' => false,
                'placeholder' => 'Buscar',
                'id' => 'searchInput',
                'value' => isset($this->request->query['q']) ? $this->request->query['q'] : ''
            )
        );
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<div class="search-box" style="margin-bottom: 20px;">

</div>
<div class="container-table">
    <table class="table table-employee">
        <thead>
            <th><?php echo $this->Paginator->sort('name', 'Prestador'); ?></th>
            <th><?php echo $this->Paginator->sort('phone', 'Telefone'); ?></th>
            <th>Serviços</th>
            <th><?php echo $this->Paginator->sort('price', 'Valor'); ?></th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
                <tr>
                    <td class="show-employee">
                        <?php
                        $preview = '';

                        if (!empty($emp['Employee']['image_url'])) {
                            $preview = '' . $emp['Employee']['image_url'];
                        }

                        if (!empty($preview)) {
                            echo $this->Html->image($preview, [
                                'class' => 'preview-avatar',
                                'id' => 'preview-img'
                            ]);
                        } else {

                            $iniciais = mb_substr($emp['Employee']['name'], 0, 1) . mb_substr($emp['Employee']['last_name'], 0, 1);
                            echo $this->Html->tag(
                                'div',
                                $this->Html->tag('p', $iniciais),
                                array('class' => 'avatar-inicial')
                            );
                        }

                        ?>
                        <div class="label-employee">
                            <?php echo $this->Html->tag('p', ($emp['Employee']['name'] . ' ' . $emp['Employee']['last_name']), array(
                                'class' => 'label-name-employee'
                            )); ?>
                            <?php echo $this->Html->tag('p', ($emp['Employee']['email']), array(
                                'class' => 'label-email-employee'
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <div class="label-employee"><?php echo  $this->Html->tag('p', ($emp['Employee']['phone'])); ?></div>
                    </td>
                    <td>
                        <div class="label-employee">
                            <?php
                           
                            if (!empty($emp['Service'])) {
                                echo implode(', ', $emp['Service']);
                            } else {
                                echo 'Nenhum serviço atribuído';
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="label-employee"><?php echo  $this->Html->tag('p', 'R$ ' . ($emp['Employee']['price'])); ?></div>
                    </td>
                    <td>
                        <div class="column-actions">
                            <?php
                            echo $this->Html->link('<i class="bi bi-pencil"></i>', [
                                'controller' => 'employees',
                                'action' => 'update',
                                $emp['Employee']['id']
                            ], [
                                'class' => 'btn-list-action',
                                'escape' => false

                            ]);
                            ?>
                            <a
                                class="btn btn-list-action"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-employee-id="<?php echo $emp['Employee']['id']; ?>"
                                data-employee-name="<?php echo $emp['Employee']['name']; ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <div class="pagination">
        <?php
        $current_page = $this->Paginator->params()['page'];
        $max_page = $this->Paginator->params()['pageCount'];

        echo $this->Html->tag('p', 'Página ' . $current_page . ' de ' . $max_page, array(
            'class' => 'label-pages'
        ));
        ?>
        <ul class="pagination">
            <?php
            echo $this->Paginator->prev('Anterior', array(), null, array('class' => 'disabled'));
            echo $this->Paginator->next('Próximo', array(), null, array('class' => 'disabled'));
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('modal-upload'); ?>
<?php echo $this->element('modal-success-employee'); ?>
<?php echo $this->element('modal-delete-employee'); ?>