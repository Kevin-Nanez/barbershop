DROP DATABASE IF EXISTS salon;
	
CREATE DATABASE IF NOT EXISTS salon;

USE salon;

CREATE TABLE usuario (
id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre VARCHAR(64) NOT NULL,
apellido VARCHAR(64) NOT NULL,
email VARCHAR(64) NOT NULL,
phone VARCHAR(12) NOT NULL,
user_password VARCHAR(64) NOT NULL,
admim TINYINT(1) NOT NULL,
confirmado TINYINT(1) NOT NULL,
token VARCHAR(15) 
);

INSERT INTO usuario(nombre,apellido,email,phone,user_password,admim,confirmado)
VALUES
("Kevin","Nañez","kevinn230@gmail.com","8126944690","$2y$10$oFmKWUcnPRjXeIxe1ubmHOjzHy51od.KD0i6Z8.fXHozNUEs6Nzuu",1,1),
("dulio","Nañez","dulio2304@gmail.com","8126944691","$2y$10$ru7B31B2uJS8ziHjpHCLDOkKNMqwedN.7l2jEn6AqnLS/KOoRL9Vi",0,1),
("jose","Nañez","jose2304@gmail.com","8126944692","$2y$10$qzMHg84WCGszdWWJU5myLe1erna9SwuPQCRxq5bC8am6JUXAULEJK",0,1);

 CREATE TABLE cita(
 id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
 fecha DATE,
 hora TIME,
 usuario_id INT(10),
 FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE SET NULL
 );
 
 CREATE TABLE servicio(
id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre VARCHAR(64),
precio DECIMAL(5,2)
 );
 
 INSERT INTO servicio(nombre,precio)
 VALUES
	('lou Feid',150),
	('Teiper feid',120),
	('Corte escolar',100),
	('Corte bellako',150),
	('Rayita en la ceja pa',20),
	('Barba/Bigote',50),
	('Figura',20);
 
 CREATE TABLE citaServicio(
 id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
 cita_id INT(10),
 servicio_id INT(10),
 FOREIGN KEY(cita_id) REFERENCES cita(id) ON DELETE SET NULL,
 FOREIGN KEY(servicio_id) REFERENCES servicio(id) ON DELETE SET NULL
 );
 
 select * from usuario;
 