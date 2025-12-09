# Projeto CakePHP2

Este projeto utiliza o **CakePHP** e precisa ser configurado em ambiente Windows. Abaixo estão as instruções e informações importantes para iniciar o desenvolvimento.

## Pré-requisitos

Antes de rodar o projeto, certifique-se de ter os seguintes itens instalados:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html) (Apache, MySQL/MariaDB e PHP)
- Composer
- CakePHP (já presente no projeto)

## Configuração do Banco de Dados

1. Abra o **XAMPP Control Panel** e inicie o **Apache** e o **MySQL**.
2. Acesse o **phpMyAdmin** (normalmente em `http://localhost/phpmyadmin`) e crie o banco de dados para o projeto.
3. No CakePHP, configure o banco de dados editando o arquivo:


Procure a seção `'Datasources'` e configure os seguintes parâmetros:

```php
'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',       // usuário do MySQL
        'password' => '',           // senha do MySQL
        'database' => 'nome_do_banco',
        'port' => '3306',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'encoding' => 'utf8mb4',
        'timezone' => 'UTC',
    ],
],
