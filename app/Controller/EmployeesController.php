<?php

App::uses('AppController', 'Controller');
class EmployeesController extends AppController
{


    public $uses = array('Employee', 'Service', 'EmployeeService');
    public $components = array('Paginator', 'Session');

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

    public function delete()
    {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $id = $this->request->data['Employee']['id'];

        if (!$id) {
            $this->Flash->error(__('ID não fornecido.'));
            return $this->redirect(['action' => 'index']);
        }

        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Prestador não encontrado.'));
        }

        if ($this->Employee->delete($id)) {
            $this->EmployeeService->deleteAll(['EmployeeService.employee_id' => $id]);

            $this->Flash->success(__('Prestador excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o prestador. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

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
            'order' => array('Employee.id' => 'DESC'),
            'recursive' => 2
        );

        $employees = $this->Paginator->paginate('Employee');

        $this->loadModel('EmployeeService');

        foreach ($employees as $key => $emp) {
            $employeeServices = $this->EmployeeService->find('all', [
                'conditions' => array('EmployeeService.employee_id' => $emp['Employee']['id']),
                'fields' => array('EmployeeService.service_id')
            ]);
            $serviceNames = [];
            foreach ($employeeServices as $s) {
                $serviceId = $s['EmployeeService']['service_id'];

                $service = $this->Service->findById($serviceId);

                if (!empty($service)) {
                    $serviceNames[] = $service['Service']['name'];
                }
            }

            $employees[$key]['Service'] = $serviceNames;
        }

        $this->set(compact('employees'));
    }

    public function uploadFile()
    {
        if ($this->request->is('post')) {
            try {
                // Verificar se o arquivo foi enviado
                if (empty($this->request->data['Employee']['list_employees']['tmp_name'])) {
                    throw new Exception('Nenhum arquivo foi enviado.');
                }

                $arquivo = $this->request->data['Employee']['list_employees'];

                $this->validarArquivo($arquivo);

                $dados = $this->loadExcel($arquivo['tmp_name']);

                $resultado = $this->createEmployees($dados);

                $this->Session->setFlash(
                    sprintf('Upload concluído! %d funcionários criados com sucesso.', $resultado['sucesso']),
                    'default',
                    array('class' => 'alert alert-success')
                );

                if ($resultado['erros'] > 0) {
                    $this->Session->setFlash(
                        sprintf('Atenção: %d registros não foram importados.', $resultado['erros']),
                        'default',
                        array('class' => 'alert alert-warning')
                    );
                }
            } catch (Exception $e) {
                $this->Session->setFlash(
                    'Erro ao processar arquivo: ' . $e->getMessage(),
                    'default',
                    array('class' => 'alert alert-danger')
                );
            }

            return $this->redirect(array('action' => 'index'));
        }
    }

    private function validarArquivo($arquivo)
    {
        if ($arquivo['size'] > 25 * 1024 * 1024) {
            throw new Exception('Arquivo muito grande. Máximo 25 MB.');
        }

        $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, array('xls', 'xlsx'))) {
            throw new Exception('Formato inválido. Apenas XLS ou XLSX.');
        }

        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload do arquivo.');
        }

        return true;
    }

    private function loadExcel($caminhoArquivo)
    {
        // Importar SimpleXLSX dentro do método
        require_once APP . 'Vendor' . DS . 'SimpleXLSX.php';

        try {
            // Carregar o arquivo Excel
            if ($xlsx = \Shuchkin\SimpleXLSX::parse($caminhoArquivo)) {
                $rows = $xlsx->rows();
                $dados = array();

                // Pular a primeira linha (cabeçalho) e processar as demais
                foreach ($rows as $key => $row) {
                    // Pular linha de cabeçalho (índice 0)
                    if ($key === 0) {
                        continue;
                    }

                    // Processar apenas se a linha não estiver vazia
                    if (!empty($row[0]) || !empty($row[2])) {
                        $dados[] = array(
                            'name' => isset($row[0]) ? trim($row[0]) : '',
                            'last_name' => isset($row[1]) ? trim($row[1]) : '',
                            'email' => isset($row[2]) ? trim($row[2]) : '',
                            'phone' => isset($row[3]) ? trim($row[3]) : '',
                            'price' => isset($row[4]) ? trim($row[4]) : '',
                        );
                    }
                }

                return $dados;
            } else {
                throw new Exception(\Shuchkin\SimpleXLSX::parseError());
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao ler arquivo Excel: ' . $e->getMessage());
        }
    }

    private function createEmployees($dados)
    {
        $sucesso = 0;
        $erros = 0;
        $errosDetalhados = array();

        foreach ($dados as $linha) {
            // Validar campos obrigatórios
            if (empty($linha['name']) || empty($linha['email'])) {
                $erros++;
                $errosDetalhados[] = "Linha com nome ou email vazio";
                continue;
            }

            // Preparar dados para salvar
            $employee = array(
                'Employee' => array(
                    'name' => $linha['name'],
                    'last_name' => $linha['last_name'],
                    'email' => $linha['email'],
                    'phone' => $linha['phone'],
                    'price' => $linha['price'],
                )
            );

            // Criar novo registro
            $this->Employee->create();

            if ($this->Employee->save($employee)) {
                $sucesso++;
            } else {
                $erros++;
                $errosDetalhados[] = "Erro ao salvar: " . $linha['name'];
            }
        }

        // Log de erros
        if (!empty($errosDetalhados)) {
            $this->log($errosDetalhados, 'import_errors');
        }

        return array(
            'sucesso' => $sucesso,
            'erros' => $erros,
            'detalhes' => $errosDetalhados
        );
    }
}
