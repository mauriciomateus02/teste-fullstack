# Projeto CakePHP2

Este projeto utiliza o **CakePHP** e precisa ser configurado em ambiente Windows. Abaixo estão as instruções e informações importantes para iniciar o desenvolvimento.

## Pré-requisitos

Antes de rodar o projeto, certifique-se de ter os seguintes itens instalados:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html) (Apache, MySQL/MariaDB e PHP)
- Composer
- CakePHP (já presente no projeto)


[Video sobre o sistema](https://drive.google.com/file/d/1wcb0v4NKfDZkpM0VcALgBeGSVi2dh1Gr/view?usp=sharing)

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
```

Procure o `'metadata'` e execute o seguintes códgo no Mysql:

```sql

  CREATE TABLE employees(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    image_url varchar(255),
    phone varchar(13) NOT NULL,
    price float NOT NULL,
    primary key (id)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE services(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description text NOT NULL,
    primary key(id)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE employees_services(
    id int(11) NOT NULL AUTO_INCREMENT,
    employee_id int (11) NOT NULL,
    service_id int(11) NOT NULL,

    PRIMARY KEY (id),
    
    FOREIGN key(employee_id)
    REFERENCES employees(id)
    ON DELETE CASCADE,

    FOREIGN key(service_id)
    REFERENCES services(id)
    ON DELETE CASCADE 
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

  CREATE TABLE clients_services (
    id int(11) NOT NULL AUTO_INCREMENT,
    client_id int (11) NOT NULL,
    service_id int(11) NOT NULL,
    employee_id int(11).

    date_service date NOT NULL,

    PRIMARY KEY (id),

    FOREIGN key(employee_id)
    REFERENCES employees(id)
    ON DELETE CASCADE,
    
    FOREIGN key(client_id)
    REFERENCES clients(id)
    ON DELETE CASCADE,

    FOREIGN key(service_id)
    REFERENCES services(id)
    ON DELETE CASCADE 
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

Os seguintes parâmetros são obrigatorios para o xlsx na importação dos serviços

| Parâmetro        | Obrigatorioedade                   |
|------------------|------------------------------------|
| name			   | Obrigadotrio						|
| description      | Obrigatório      					|

