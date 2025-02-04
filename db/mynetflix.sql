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
    description_pelicula TEXT,
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
('Acción'), ('Comedia'), ('Drama'), ('Ciencia Ficción'), ('Terror'), 
('Aventura'), ('Fantástico'), ('Thriller'), ('Romance'), ('Animación');

INSERT INTO directores (nombre) VALUES 
('Christopher Nolan'), ('Quentin Tarantino'), ('Steven Spielberg'),
('James Cameron'), ('Martin Scorsese'), ('Ridley Scott'),
('Francis Ford Coppola'), ('Guillermo del Toro'), ('Tim Burton'),
('Peter Jackson');

INSERT INTO actores (nombre) VALUES 
('Leonardo DiCaprio'), ('Brad Pitt'), ('Angelina Jolie'), ('Tom Cruise'), 
('Robert Downey Jr.'), ('Scarlett Johansson'), ('Will Smith'), ('Johnny Depp'), 
('Meryl Streep'), ('Dwayne Johnson'), ('Emma Stone'), ('Tom Hanks'),
('Christian Bale'), ('Morgan Freeman'), ('Natalie Portman'), ('Matt Damon'),
('Keanu Reeves'), ('Harrison Ford'), ('Anne Hathaway'), ('Ryan Gosling'),
('Joaquin Phoenix'), ('Viola Davis'), ('Jake Gyllenhaal'), ('Charlize Theron');

INSERT INTO peliculas (titulo, id_genero, id_director, fecha_estreno, duracion, imagen_cartelera, description_pelicula) VALUES
('Inception', 4, 1, '2010-07-16', 148, 'inception_poster.jpg', 'Un ladrón que roba secretos corporativos a través del uso de la tecnología de sueños es contratado para implantar una idea en la mente de un CEO.'),
('Pulp Fiction', 1, 2, '1994-10-14', 154, 'pulp_fiction_poster.jpg', 'Las vidas de dos asesinos a sueldo, un boxeador, un gánster y su esposa, y dos ladrones de restaurantes se entrelazan en cuatro relatos de violencia y redención.'),
('Jurassic Park', 4, 3, '1993-06-11', 127, 'jurassic_park_poster.jpg', 'Un parque temático con dinosaurios clonados se convierte en una pesadilla cuando fallan las medidas de seguridad.'),
('The Dark Knight', 4, 1, '2008-07-18', 152, 'dark_knight_poster.jpg', 'Batman enfrenta al Joker, un criminal anárquico que siembra el caos en Gotham City.'),
('Fight Club', 1, 2, '1999-10-15', 139, 'fight_club_poster.jpg', 'Un hombre insomne y un vendedor de jabón forman un club de peleas clandestino que se convierte en un movimiento revolucionario.'),
('Avengers: Endgame', 4, 3, '2019-04-26', 181, 'endgame_poster.jpg', 'Los Vengadores restantes intentan revertir las acciones de Thanos y restaurar el universo.'),
('Forrest Gump', 2, 3, '1994-07-06', 142, 'forrest_gump_poster.jpg', 'Un hombre con un coeficiente intelectual bajo pero buenas intenciones influye en eventos históricos mientras busca a su amor de la infancia.'),
('Jumanji', 6, 3, '1995-12-15', 104, 'jumanji_poster.jpg', 'Dos niños liberan a un hombre atrapado en un juego de mesa mágico y deben terminarlo para detener el caos que desata.'),
('The Pursuit of Happyness', 2, 3, '2006-12-15', 117, 'pursuit_of_happyness_poster.jpg', 'Un hombre lucha por una vida mejor para su hijo mientras enfrenta la adversidad y la pobreza.'),
('Titanic', 9, 4, '1997-12-19', 195, 'titanic_poster.jpg', 'Un joven artista y una mujer de la alta sociedad se enamoran a bordo del Titanic antes de su trágico hundimiento.'),
('Gladiator', 6, 6, '2000-05-05', 155, 'gladiator_poster.jpg', 'Un general romano es traicionado y convertido en esclavo, buscando venganza en la arena.'),
('Interstellar', 4, 1, '2014-11-07', 169, 'interstellar_poster.jpg', 'Un grupo de exploradores viaja a través de un agujero de gusano en el espacio en un intento de salvar la humanidad.'),
('The Godfather', 8, 7, '1972-03-24', 175, 'godfather_poster.jpg', 'La historia de la familia mafiosa Corleone mientras tratan de mantener su poder y legado.'),
('Pan’s Labyrinth', 7, 8, '2006-10-11', 118, 'pans_labyrinth_poster.jpg', 'Una niña se sumerge en un mundo de criaturas fantásticas en la España de la posguerra.'),
('The Lord of the Rings: The Fellowship of the Ring', 7, 10, '2001-12-19', 178, 'lotr_fellowship_poster.jpg', 'Un hobbit debe destruir un anillo mágico antes de que caiga en manos del malvado Sauron.');

INSERT INTO reparto (id_pelicula, id_actor, personaje) VALUES
(1, 1, 'Dom Cobb'),
(1, 14, 'Alfred Pennyworth'),
(2, 2, 'Vincent Vega'),
(3, 3, 'Dr. Ellie Sattler'),
(4, 1, 'Bruce Wayne'),
(4, 13, 'The Joker'),
(5, 2, 'The Narrator'),
(6, 4, 'Tony Stark'),
(7, 5, 'Forrest Gump'),
(8, 6, 'Ruby Roundhouse'),
(9, 7, 'Chris Gardner'),
(10, 1, 'Jack Dawson'),
(11, 16, 'Maximus Decimus Meridius'),
(12, 17, 'Cooper'),
(13, 18, 'Don Vito Corleone'),
(14, 19, 'Ofelia'),
(15, 20, 'Frodo Baggins'),
(15, 21, 'Gandalf'),
(15, 22, 'Aragorn');

INSERT INTO likes (id_usuario, id_pelicula) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 3),
(1, 3),
(1, 2),
(2, 3);
