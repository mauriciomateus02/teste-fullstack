<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController
{

    public $uses = array('Employee', 'Service');

    public function register()
    {

        $this->set('title_page', 'Cadastro de Prestador de Serviço');

        $services = $this->Service->find('all');
        $this->set(compact('services'));

        if ($this->request->is('post')) {

            if (!empty($this->request->data)) {

                $file = $this->request->data['Employee']['image_url'];

                if (isset($file) && is_array($file) && $file['error'] === 0) {

                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $file['name']);

                    move_uploaded_file(
                        $file['tmp_name'],
                        WWW_ROOT . 'img/' . $filename
                    );

                    $this->request->data['Employee']['image_url'] = $filename;
                } else {
                    $this->request->data['Employee']['image_url'] = null;
                }

                $this->Employee->create();

                if ($this->Employee->save($this->request->data)) {
                    $this->Flash->success('Prestador cadastrado com sucesso!');
                    return $this->redirect('/employees/register');
                } else {
                    $this->Flash->error('Erro ao cadastrar o serviço.');
                }
            }
        }
    }

    public function delete() {}

    public function update() {}

    public function index()
    {
        $employees = $this->Employee->find('all');
        $this->set('employees', $employees);
    }
}
