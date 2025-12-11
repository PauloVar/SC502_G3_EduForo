CREATE DATABASE IF NOT EXISTS eduforo
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE eduforo;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  correo VARCHAR(100) NOT NULL UNIQUE,
  usuario VARCHAR(15) NOT NULL UNIQUE,
  contrasenna VARCHAR(128) NOT NULL,
  fecha_nacimiento DATE,
  genero ENUM('masculino', 'femenino', 'otro'),
  es_admin TINYINT(1) NOT NULL DEFAULT 0
);

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



INSERT INTO centros (nombre, codigo, provincia, canton, nivel, direccion, telefono, correo) VALUES
('Liceo de Heredia', 'LH001', 'Heredia', 'Heredia', 'Secundaria', 'Centro de Heredia', '22600011', 'info@lhcr.com'),
('Escuela República de Argentina', 'EA002', 'San José', 'San José', 'Primaria', 'Barrio Luján', '22223344', 'argentina@cr.co.cr'),
('Colegio Técnico Profesional de Flores', 'CT003', 'Heredia', 'Flores', 'Técnico', 'San Joaquín de Flores', '22651122', 'ctpflores@cr.co.cr'),
('Escuela Pedro Murillo Pérez', 'EP004', 'Alajuela', 'Alajuela', 'Primaria', 'Centro de Alajuela', '24423355', 'pmp@escuelascr.com'),
('Colegio de Santa Ana', 'CS005', 'San José', 'Santa Ana', 'Secundaria', 'Centro de Santa Ana', '22825500', 'santaana@colegiocr.com'),
('CTP de Atenas', 'CT006', 'Alajuela', 'Atenas', 'Técnico', 'Atenas centro', '24465080', 'ctpatenas@cr.co.cr');

INSERT INTO publicaciones (centro_id, titulo, resumen, cuerpo, fecha_publicacion) VALUES
(1, 'Feria Científica 2025', 'Estudiantes presentan proyectos innovadores.', 'El Liceo de Heredia realizó su feria científica con más de 50 proyectos presentados...', NOW()),
(1, 'Campeonato Deportivo', 'El equipo ganó torneo regional.', 'El equipo de fútbol del Liceo de Heredia logró obtener el primer lugar...', NOW()),
(2, 'Semana Cultural', 'Actividades artísticas en la escuela.', 'La Escuela República de Argentina celebró su semana cultural con bailes, pintura...', NOW()),
(3, 'Nuevos Talleres Técnicos', 'Se abren 3 talleres adicionales.', 'El CTP de Flores anunció la apertura de talleres de robótica, redes...', NOW()),
(4, 'Festival de Lectura', 'Promoción de lectura infantil.', 'La escuela realizó un festival enfocado en hábitos de lectura para niños...', NOW()),
(5, 'Charlas Motivacionales', 'Dirigidas a estudiantes de secundaria.', 'El Colegio de Santa Ana impartió charlas sobre liderazgo y salud mental...', NOW());

INSERT INTO avisos_mep (titulo, resumen, cuerpo, enlace) VALUES
('Calendario Escolar 2025', 'Publicación oficial del calendario lectivo.', 'El MEP ha publicado el calendario escolar para el año 2025...', 'https://mep.go.cr/calendario2025'),
('Actualización Protocolo de Evaluación', 'Cambios aplican desde marzo.', 'Se informa a los centros educativos sobre la actualización del protocolo...', 'https://mep.go.cr/evaluacion2025'),
('Capacitación Docente Virtual', 'Cursos gratuitos para docentes.', 'Se abre la matrícula para cursos virtuales dirigidos a docentes...', 'https://mep.go.cr/capacitacion'),
('Guía de Seguridad Digital', 'Recomendaciones para estudiantes.', 'El MEP publicó una guía completa para la prevención de riesgos digitales...', 'https://mep.go.cr/seguridad-digital'),
('Suspensión de Lecciones por Lluvias', 'Afecta zona norte.', 'Debido a condiciones climáticas fuertes, se suspenden lecciones en ciertas áreas...', 'https://mep.go.cr/comunicados');

