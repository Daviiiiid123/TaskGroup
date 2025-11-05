-- Eliminado de la base de datos
DROP DATABASE IF EXISTS taskgroup;

-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS taskgroup;

-- Crear un usuario para poder manipular la base de datos
DROP USER IF EXISTS 'usuario'@'localhost';
CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'purple';
GRANT ALL PRIVILEGES ON taskgroup.* TO 'usuario'@'localhost' WITH GRANT OPTION;

-- Seleccionar la base de datos
USE taskgroup;

-- Crear una tabla para los usuarios
CREATE TABLE users (
	username varchar(255),
	email varchar(255) not null,
	passwd varchar(255) not null,
	primary key (username),
    unique (email)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

-- Crear una tabla para los proyects
create table proyects (
	id int auto_increment,
	title varchar(255),
	content varchar(255),
	primary key (id),
	foreign key (author) references users(username)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

-- Crear una tabla para los comentarios
create table tasks (
	id int auto_increment,	 
	content varchar(255),
	proyect int not null,
	primary key (id),
	foreign key (author) references users(username),
	foreign key (proyect) references proyects(id) on delete cascade
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table proyect_users (
    proyect_id int,
    username varchar(255),
    primary key (proyect_id, username),
    foreign key (proyect_id) references proyects(id) on delete cascade,
    foreign key (username) references users(username) on delete cascade,
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table task_users (
    task_id int,
    username varchar(255),
    primary key (task_id, username),
    foreign key (task_id) references tasks(id) on delete cascade,
    foreign key (username) references users(username) on delete cascade,
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

-- Introducir datos de prueba en la base de datos
INSERT INTO users (username, email, passwd) VALUES ('dani', 'dani@correofalso.com', 'dani');
INSERT INTO users (username, email, passwd) VALUES ('pepe', 'pepe@correofalso.com', 'pepe');

INSERT INTO proyects (title, content, author)
VALUES ('Me presento', 'hola soy dani', 'dani');
