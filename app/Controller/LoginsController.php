<?php

App::uses('AppController','Controller');

class LoginsController extends AppController {


    public function Login(){

        $order = array('Login.id' => 'asc');
        $logins = $this->Login->find('all',compact('order'));

        $this->set('logins',$logins);
    }

}