CREATE DATABASE IF NOT EXISTS eduforo
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE eduforo;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  correo VARCHAR(100) NOT NULL UNIQUE,
  usuario VARCHAR(15) NOT NULL UNIQUE,
  contrasenna VARCHAR(16) NOT NULL,
  es_admin TINYINT(1) NOT NULL DEFAULT 0
);


INSERT INTO usuarios (nombre, correo, usuario, contrasenna, es_admin)
VALUES ('Admin', 'admin@eduforo.com', 'admin', 'admin123', 1);

CREATE TABLE centros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  codigo VARCHAR(6) NOT NULL UNIQUE,
  provincia VARCHAR(25),
  canton VARCHAR(25),
  nivel VARCHAR(25),
  direccion VARCHAR(255),
  telefono VARCHAR(8),
  correo VARCHAR(100)
);

CREATE TABLE publicaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  centro_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  resumen VARCHAR(255),
  cuerpo VARCHAR(2000) NOT NULL,
  fecha_publicacion DATETIME NULL,
  CONSTRAINT fk_pub_centro FOREIGN KEY (centro_id) REFERENCES centros(id)
);

CREATE TABLE avisos_mep (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  resumen VARCHAR(255),
  cuerpo VARCHAR(2000) NOT NULL,
  enlace VARCHAR(255),
  fecha_publicacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE favoritos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  centro_id INT NOT NULL,
  CONSTRAINT fk_fav_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  CONSTRAINT fk_fav_centro FOREIGN KEY (centro_id) REFERENCES centros(id),
  UNIQUE KEY uq_favorito (usuario_id, centro_id)
);
