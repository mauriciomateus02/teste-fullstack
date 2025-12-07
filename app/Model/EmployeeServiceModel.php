<?php 

App::uses('AppModel','Model');

class EmployeeServiceModel extends AppModel{

    public $belongsTo = array(
        'Employee' => array(
            'className'  => 'Employee',
            'foreignKey' => 'employee_id'
        ),
        'Service' => array(
            'className'  => 'Service',
            'foreignKey' => 'service_id'
        )
    );
}

?>