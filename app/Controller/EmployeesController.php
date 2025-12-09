<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController
{

    public $uses = array('Employee', 'Service', 'EmployeeService');
    public $components = array('Paginator');

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

                    $employeeId = $this->Employee->id;

                    $dataToSave = [];

                    foreach ($this->request->data['services'] as $service) {
                        $dataToSave[] = [
                            'employee_id' => $employeeId,
                            'service_id'  => $service
                        ];
                    }

                    $this->EmployeeService->saveMany($dataToSave);

                    $this->Flash->success('Prestador cadastrado com sucesso!');
                    return $this->redirect('/employees/register');
                } else {
                    $this->Flash->error('Erro ao cadastrar o serviço.');
                }
            }
        }
    }

    public function delete() {}

    public function update($id = null)
    {
        $this->set('title_page', 'Edição de Prestador de Serviço');

        $employee = $this->Employee->findById($id);

        $employeeServices = $this->EmployeeService->find('list', array(
            'conditions' => array('EmployeeService.employee_id' => $id),
            'fields' => array('EmployeeService.service_id')
        ));

        if (!$employee) {
            throw new NotFoundException("Usuário não encontrado");
        }

        if ($this->request->is(['post', 'put', 'patch'])) {

            $this->Employee->id = $id;

            $file = $this->request->data['Employee']['image_url'];

            if (isset($file) && is_array($file) && $file['error'] === 0) {

                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $file['name']);

                move_uploaded_file(
                    $file['tmp_name'],
                    WWW_ROOT . 'img/' . $filename
                );

                $this->request->data['Employee']['image_url'] = $filename;
            } else {
                $this->request->data['Employee']['image_url'] = $employee['Employee']['image_url'];
            }



            if ($this->Employee->save($this->request->data)) {
                $this->Flash->success(__('Prestador atualizado com sucesso.'));

                $currentServices = array_values($employeeServices);
                $newServices = isset($this->request->data['services']) ? $this->request->data['services'] : array();


                $toAdd = array_diff($newServices, $currentServices);
                $toRemove = array_diff($currentServices, $newServices);

                if (!empty($toRemove)) {
                    $this->EmployeeService->deleteAll(array(
                        'EmployeeService.employee_id' => $id,
                        'EmployeeService.service_id' => $toRemove
                    ));
                }

                if (!empty($toAdd)) {
                    $dataToSave = [];

                    foreach ($toAdd as $service) {
                        $dataToSave[] = [
                            'employee_id' => $id,
                            'service_id'  => $service
                        ];
                    }

                    $this->EmployeeService->saveMany($dataToSave);
                }

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Erro ao atualizar.'));
        }

        $this->request->data = $employee;

        $services = $this->Service->find('all');

        $this->set(compact('employee', 'services', 'employeeServices'));
    }

    public function index()
    {
        $this->set('title_page', 'Prestadores de Serviço');

        // $employees = $this->Employee->find('all');
        // $this->set('employees', $employees);

        $conditions = array();

        // Se existir busca
        if (!empty($this->request->query['q'])) {
            $q = trim($this->request->query['q']);

            $conditions['OR'] = array(
                'Employee.name LIKE' => "%$q%",
                'Employee.last_name LIKE' => "%$q%",
                'Employee.email LIKE' => "%$q%"
            );
        }

        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 6, 
            'order' => array('Employee.id' => 'DESC')
        );

        $employees = $this->Paginator->paginate('Employee');

        $this->set(compact('employees'));
    }
}
