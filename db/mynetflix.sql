CREATE DATABASE MyNetflix;
USE MyNetflix;

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'administrador','disabled') NOT NULL DEFAULT 'disabled',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de Películas
CREATE TABLE peliculas (
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    poster VARCHAR(255),
    fecha_estreno DATE,
    likes INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de Likes
CREATE TABLE likes (
    id_like INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    pelicula_id INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id_pelicula) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


-- Inserts
INSERT INTO usuarios (email, pwd, rol) 
VALUES 
('administrador@netflix.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'administrador'),
('christian@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'disabled'),
('david@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'disabled');

