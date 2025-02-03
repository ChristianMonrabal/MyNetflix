CREATE DATABASE MyNetflix;
USE MyNetflix;

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'administrador', 'disabled') NOT NULL DEFAULT 'disabled',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de Géneros
CREATE TABLE generos (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;

-- Tabla de Directores
CREATE TABLE directores (
    id_director INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabla de Actores
CREATE TABLE actores (
    id_actor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabla de Películas
CREATE TABLE peliculas (
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    id_genero INT NOT NULL,
    id_director INT NOT NULL,
    anio INT NOT NULL,
    duracion INT NOT NULL, -- Duración en minutos
    clasificacion ENUM('G', 'PG', 'PG-13', 'R', 'NC-17') NOT NULL,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE,
    FOREIGN KEY (id_director) REFERENCES directores(id_director) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de Reparto (Relaciona actores con películas)
CREATE TABLE reparto (
    id_pelicula INT NOT NULL,
    id_actor INT NOT NULL,
    personaje VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_pelicula, id_actor),
    FOREIGN KEY (id_pelicula) REFERENCES peliculas(id_pelicula) ON DELETE CASCADE,
    FOREIGN KEY (id_actor) REFERENCES actores(id_actor) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertar usuarios de ejemplo
INSERT INTO usuarios (email, pwd, rol) VALUES 
('administrador@netflix.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'administrador'),
('christian@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'cliente'),
('david@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'disabled');

-- Insertar géneros
INSERT INTO generos (nombre) VALUES 
('Acción'), ('Comedia'), ('Drama'), ('Ciencia Ficción'), ('Terror');

-- Insertar directores
INSERT INTO directores (nombre) VALUES 
('Christopher Nolan'), ('Quentin Tarantino'), ('Steven Spielberg');

-- Insertar actores
INSERT INTO actores (nombre) VALUES 
('Leonardo DiCaprio'), ('Brad Pitt'), ('Angelina Jolie'), ('Tom Cruise');

-- Insertar películas
INSERT INTO peliculas (titulo, id_genero, id_director, anio, duracion, clasificacion) VALUES
('Inception', 4, 1, 2010, 148, 'PG-13'),
('Pulp Fiction', 1, 2, 1994, 154, 'R'),
('Jurassic Park', 4, 3, 1993, 127, 'PG-13');

-- Insertar reparto
INSERT INTO reparto (id_pelicula, id_actor, personaje) VALUES
(1, 1, 'Dom Cobb'),
(2, 2, 'Vincent Vega'),
(3, 3, 'Dr. Ellie Sattler');
