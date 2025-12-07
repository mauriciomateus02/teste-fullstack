<?php 

App::uses('AppModel','Model');

class ServiceModel extends AppModel{

    public $hasMany = array(
        'EmployeeService' => array(
            'className'  => 'EmployeeService',
            'foreignKey' => 'service_id'
        )
    );

}

?>