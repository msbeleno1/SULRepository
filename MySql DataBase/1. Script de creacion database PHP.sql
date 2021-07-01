DROP DATABASE IF EXISTS actividadphp;
CREATE DATABASE actividadphp;

USE actividadphp;

CREATE TABLE estado(
	id_estado INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    nombre_estado VARCHAR(15) NOT NULL
);

CREATE TABLE rol(
	id_rol INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    nombre_rol VARCHAR(15) NOT NULL
);

CREATE TABLE usuario(
	documento_usuario VARCHAR(20) NOT NULL PRIMARY KEY,
    nombre_usuario VARCHAR(150) NOT NULL,
    correo_usuario VARCHAR(50) NOT NULL,
    fecha_ult_login DATETIME NOT NULL,
    clave_usuario VARCHAR(250) NOT NULL,
    id_estado INT NOT NULL,
    id_rol  INT NOT NULL,
    FOREIGN KEY(id_estado) REFERENCES estado(id_estado) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY(id_rol) REFERENCES rol(id_rol) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE estudiante(
	documento_estudiante VARCHAR(20) NOT NULL PRIMARY KEY,
    nombre_estudiante VARCHAR(150) NOT NULL,
    correo_estudiante VARCHAR(50) NOT NULL,
    nota_1 DOUBLE NOT NULL,
    nota_2 DOUBLE NOT NULL,
    nota_3 DOUBLE NOT NULL,
    nota_4 DOUBLE NOT NULL,
    nota_final DOUBLE NOT NULL,
    documento_usuario VARCHAR(20) NOT NULL,
    FOREIGN KEY(documento_usuario) REFERENCES usuario(documento_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO estado (nombre_estado) VALUES ("ACTIVO"),("INACTIVO"),("BLOQUEADO");
INSERT INTO rol (nombre_rol) VALUES ("COORDINADOR"),("PROFESOR"),("ESTUDIANTE");