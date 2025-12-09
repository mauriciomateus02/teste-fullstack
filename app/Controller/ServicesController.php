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

    public function index()
    {
        $services = $this->Service->find('all');
        $this->set('services', $services);
    }

    public function uploadFile()
    {
        if ($this->request->is('post')) {
            try {
                // Verificar se o arquivo foi enviado
                if (empty($this->request->data['Service']['list_employees']['tmp_name'])) {
                    throw new Exception('Nenhum arquivo foi enviado.');
                }

                $arquivo = $this->request->data['Service']['list_employees'];

                $this->validarArquivo($arquivo);

                $dados = $this->loadExcel($arquivo['tmp_name']);

                $resultado = $this->createServices($dados);

                $this->Flash->success(
                    sprintf('Upload concluído! %d Serviços criados com sucesso.', $resultado['sucesso']),
                    'default',
                    array('class' => 'alert alert-success')
                );

                if ($resultado['erros'] > 0) {
                    $this->Flash->error(
                        sprintf('Atenção: %d registros não foram importados.', $resultado['erros']),
                        'default',
                        array('class' => 'alert alert-warning')
                    );
                }
            } catch (Exception $e) {
                $this->Flash->error(
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
                            'description' => isset($row[1]) ? trim($row[1]) : '',
                            
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

    private function createServices($dados)
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
            $service = array(
                'Service' => array(
                    'name' => $linha['name'],
                    'description' => $linha['description'],
                )
            );

            // Criar novo registro
            $this->Service->create();

            if ($this->Service->save($service)) {
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
