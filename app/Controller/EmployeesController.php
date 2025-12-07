<?php

App::uses('AppController','Controller');

class EmployeesController extends AppController {

    public function register(){

    }

    public function delete(){

    }

    public function update(){

    }

    public function list(){

    }

    public function index(){
        $employees = $this->Employee->find('all');
        $this->set('employees', $employees);
    }
}