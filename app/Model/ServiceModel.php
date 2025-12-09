<?php

App::uses('AppModel', 'Model');

class ServiceModel extends AppModel
{

    public $hasMany = array(
        'EmployeeService' => array(
            'className'  => 'EmployeeService',
            'foreignKey' => 'service_id'
        )
    );

    public $hasAndBelongsToMany = array(
        'Employee' => array(
            'className' => 'Employee',
            'joinTable' => 'employee_services',
            'foreignKey' => 'service_id',
            'associationForeignKey' => 'employee_id'
        )
    );

    public $actsAs = array('Containable');
}
