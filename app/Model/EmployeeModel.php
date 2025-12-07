<?php 

App::uses('AppModel','Model');

class EmployeeModel extends AppModel{

    public $hasMany = array(
        'EmployeeService' => array(
            'className'  => 'EmployeeService',
            'foreignKey' => 'employee_id'
        )
    );
}

?>