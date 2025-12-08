<?php

App::uses('AppController', 'Controller');

class ServicesController extends AppController
{

    public function register()
    {
        if (!empty($this->request->data)) {

            $this->Service->create();

            if ($this->Service->save($this->request->data)) {
                $this->Flash->success('Serviço cadastrado com sucesso!');
                return $this->redirect('/employees/register');
            } else {
                $this->Flash->error('Erro ao cadastrar o serviço.');
            }
        }
    }

    public function delete() {}

    public function update() {}

    public function index()
    {
        $services = $this->Service->find('all');
        $this->set('services', $services);
    }
}
