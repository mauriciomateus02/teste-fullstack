CREATE TABLE `logins`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    primary key (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE clients{
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    phone varchar(13) NOT NULL,
    primary key (id)
}

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