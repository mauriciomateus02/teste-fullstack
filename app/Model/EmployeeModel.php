<?php 

App::uses('AppModel','Model');

class EmployeeModel extends AppModel{

    public $validate = array(
        'image_url' => array(
            'rule' => array(
                'extension',
                array('jpg', 'jpeg', 'png', 'gif')
            ),
            'message' => 'Por favor, envie uma imagem válida (JPG, PNG ou GIF)',
            'allowEmpty' => true,
            'required' => false,
            'on' => 'create'
        ),
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Nome é obrigatório'
        ),
        'email' => array(
            'rule' => 'email',
            'message' => 'Digite um e-mail válido'
        ),
         'phone' => array(
            'rule' => 'notEmpty',
            'message' => 'Nome é obrigatório'
        ),
    );

    public $hasMany = array(
        'EmployeeService' => array(
            'className'  => 'EmployeeService',
            'foreignKey' => 'employee_id'
        )
    );
}

?>