CREATE DATABASE MyNetflix;
USE MyNetflix;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'administrador', 'disabled') NOT NULL DEFAULT 'disabled',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE generos (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE directores (
    id_director INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE actores (
    id_actor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE peliculas (
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    id_genero INT NOT NULL,
    id_director INT NOT NULL,
    fecha_estreno DATE NOT NULL,
    duracion INT NOT NULL,
    imagen_cartelera VARCHAR(255),
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero),
    FOREIGN KEY (id_director) REFERENCES directores(id_director)
) ENGINE=InnoDB;

CREATE TABLE reparto (
    id_pelicula INT NOT NULL,
    id_actor INT NOT NULL,
    personaje VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_pelicula, id_actor),
    FOREIGN KEY (id_pelicula) REFERENCES peliculas(id_pelicula),
    FOREIGN KEY (id_actor) REFERENCES actores(id_actor)
) ENGINE=InnoDB;

CREATE TABLE likes (
    id_like INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_pelicula INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_pelicula) REFERENCES peliculas(id_pelicula)
) ENGINE=InnoDB;

INSERT INTO usuarios (email, pwd, rol) VALUES 
('administrador@netflix.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'administrador'),
('christian@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'cliente'),
('david@gmail.com', '$2y$10$zVaDbSdLEgjGPfpE9AlprON.6THmFJESu9So2S5t.ch4qPurk2X/O', 'disabled');

INSERT INTO generos (nombre) VALUES 
('Acción'), ('Comedia'), ('Drama'), ('Ciencia Ficción'), ('Terror');

INSERT INTO directores (nombre) VALUES 
('Christopher Nolan'), ('Quentin Tarantino'), ('Steven Spielberg');

INSERT INTO actores (nombre) VALUES 
('Leonardo DiCaprio'), ('Brad Pitt'), ('Angelina Jolie'), ('Tom Cruise'), 
('Robert Downey Jr.'), ('Scarlett Johansson'), ('Will Smith'), ('Johnny Depp'), 
('Meryl Streep'), ('Dwayne Johnson'), ('Emma Stone'), ('Tom Hanks');

INSERT INTO peliculas (titulo, id_genero, id_director, fecha_estreno, duracion, imagen_cartelera) VALUES
('Inception', 4, 1, '2010-07-16', 148, 'inception_poster.jpg'),
('Pulp Fiction', 1, 2, '1994-10-14', 154, 'pulp_fiction_poster.jpg'),
('Jurassic Park', 4, 3, '1993-06-11', 127, 'jurassic_park_poster.jpg'),
('The Dark Knight', 4, 1, '2008-07-18', 152, 'dark_knight_poster.jpg'),
('Fight Club', 1, 2, '1999-10-15', 139, 'fight_club_poster.jpg'),
('Avengers: Endgame', 4, 3, '2019-04-26', 181, 'endgame_poster.jpg'),
('Forrest Gump', 2, 3, '1994-07-06', 142, 'forrest_gump_poster.jpg'),
('Jumanji', 1, 3, '1995-12-15', 104, 'jumanji_poster.jpg'),
('The Pursuit of Happyness', 2, 3, '2006-12-15', 117, 'pursuit_of_happyness_poster.jpg'),
('Titanic', 2, 1, '1997-12-19', 195, 'titanic_poster.jpg');

INSERT INTO reparto (id_pelicula, id_actor, personaje) VALUES
(1, 1, 'Dom Cobb'),
(2, 2, 'Vincent Vega'),
(3, 3, 'Dr. Ellie Sattler'),
(4, 1, 'Bruce Wayne'),
(5, 2, 'The Narrator'),
(6, 4, 'Tony Stark'),
(7, 5, 'Forrest Gump'),
(8, 6, 'Ruby Roundhouse'),
(9, 7, 'Chris Gardner'),
(10, 1, 'Jack Dawson');

INSERT INTO likes (id_usuario, id_pelicula) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 3),
(1, 3),
(1, 2),
(2, 3);
