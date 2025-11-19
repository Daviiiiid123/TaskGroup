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

-- Crear una tabla para los projects
create table projects (
	id int auto_increment,
	title varchar(255),
	primary key (id)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

-- Crear una tabla para los comentarios
create table tasks (
	id int auto_increment,
	title varchar(255) not null,
	content varchar(255),
	project int not null,
    is_done bit not null default 0,
	primary key (id),
	foreign key (project) references projects(id) on delete cascade
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table project_users (
    project_id int,
    username varchar(255),
    primary key (project_id, username),
    foreign key (project_id) references projects(id) on delete cascade,
    foreign key (username) references users(username) on delete cascade
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table task_users (
    task_id int,
    username varchar(255),
    primary key (task_id, username),
    foreign key (task_id) references tasks(id) on delete cascade,
    foreign key (username) references users(username) on delete cascade
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

-- Introducir datos de prueba en la base de datos
INSERT INTO users (username, email, passwd) VALUES ('dani', 'dani@correofalso.com', 'dani');
INSERT INTO users (username, email, passwd) VALUES ('pepe', 'pepe@correofalso.com', 'pepe');

INSERT INTO projects (title)
VALUES ('Proyecto ejemplo');

INSERT INTO projects (title)
VALUES ('Proyecto de TSW');

INSERT INTO projects (title)
VALUES ('Trabajo Base de Datos');

INSERT INTO projects (title)
VALUES ('App Web PHP');

INSERT INTO projects (title)
VALUES ('Sistema de Gestion');

INSERT INTO project_users (project_id, username)
VALUES (1, 'dani');

INSERT INTO project_users (project_id, username)
VALUES (2, 'dani');

INSERT INTO project_users (project_id, username)
VALUES (3, 'dani');

INSERT INTO project_users (project_id, username)
VALUES (4, 'dani');

INSERT INTO project_users (project_id, username)
VALUES (5, 'dani');
