<?php

App::uses('AppController','Controller');

class ServicesController extends AppController {

    public function register(){

         if ($this->request->is('post')) {
            $this->Service->create();

            if ($this->Service->save($this->request->data)) {
                $this->Session->setFlash('Serviço criado com sucesso!');
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash('Erro ao criar o serviço.');
            }
        }

    }

    public function delete(){

    }

    public function update(){

    }

    public function list(){

    }

    public function index(){
        $services = $this->Service->find('all');
        $this->set('services', $services);
    }
}