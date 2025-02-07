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

INSERT INTO peliculas (titulo, id_genero, id_director, fecha_estreno, duracion, imagen_cartelera, description_pelicula) VALUES
('The Matrix', 4, 1, '1999-03-31', 136, 'matrix_poster.jpg', 'Un programador de computadoras descubre que la realidad que percibe es en realidad una simulación creada por máquinas para controlar a la humanidad.'),
('Mad Max: Fury Road', 4, 1, '2015-05-15', 120, 'mad_max_fury_road_poster.jpg', 'En un futuro post-apocalíptico, un hombre y una mujer luchan por sobrevivir mientras escapan de un dictador tiránico.'),
('The Shawshank Redemption', 2, 1, '1994-09-22', 142, 'shawshank_poster.jpg', 'Un hombre condenado injustamente por asesinato encuentra la esperanza mientras está en prisión.'),
('Spider-Man: Into the Spider-Verse', 9, 1, '2018-12-14', 117, 'spiderverse_poster.jpg', 'Un adolescente de Brooklyn se convierte en Spider-Man y se une a otros Spider-People de universos alternativos para enfrentar a un villano peligroso.'),
('Shutter Island', 8, 1, '2010-02-19', 138, 'shutter_island_poster.jpg', 'Un detective investiga la desaparición de una paciente en un hospital psiquiátrico aislado, donde descubre secretos oscuros.'),
('La La Land', 9, 1, '2016-12-09', 128, 'lalaland_poster.jpg', 'Dos artistas en Los Ángeles luchan por encontrar el éxito y el amor mientras navegan por los altibajos de la vida.'),
('The Conjuring', 5, 1, '2013-07-19', 112, 'conjuring_poster.jpg', 'Un par de investigadores paranormales ayudan a una familia aterrada por presencias malévolas en su hogar.'),
('The Lion King', 9, 1, '1994-06-24', 88, 'lion_king_poster.jpg', 'Un joven león es desterrado de su hogar y debe aprender a aceptar su destino como rey mientras enfrenta peligros y traiciones.'),
('Star Wars: A New Hope', 4, 1, '1977-05-25', 121, 'star_wars_hope_poster.jpg', 'Un joven granjero se une a una princesa y a un contrabandista para rescatar a la galaxia del Imperio Galáctico.'),
('Deadpool', 4, 1, '2016-02-12', 108, 'deadpool_poster.jpg', 'Un ex-soldado con habilidades curativas y un humor irreverente lucha contra el crimen mientras busca vengarse de su pasado.'),
('Frozen', 9, 1, '2013-11-27', 102, 'frozen_poster.jpg', 'Dos hermanas se embarcan en una aventura épica para salvar su reino de un invierno eterno causado por uno de sus propios poderes mágicos.'),
('The Avengers', 4, 1, '2012-05-04', 143, 'avengers_poster.jpg', 'Los superhéroes más poderosos del planeta se unen para salvar el mundo de una invasión alienígena.'),
('Guardians of the Galaxy', 4, 1, '2014-08-01', 121, 'guardians_of_the_galaxy_poster.jpg', 'Un grupo de inadaptados se une para robar un artefacto poderoso y evitar que caiga en las manos equivocadas.'),
('The Silence of the Lambs', 8, 1, '1991-02-14', 118, 'silence_of_the_lambs_poster.jpg', 'Una joven agente del FBI se enfrenta a un asesino en serie mientras consulta con un caníbal encarcelado para atrapar al criminal.'),
('Inglourious Basterds', 4, 1, '2009-08-21', 153, 'inglourious_basterds_poster.jpg', 'Un grupo de soldados judíos-americanos lleva a cabo misiones de venganza durante la Segunda Guerra Mundial.'),
('The Revenant', 4, 1, '2015-12-25', 156, 'revenant_poster.jpg', 'Un hombre herido y abandonado en el desierto lucha por sobrevivir y vengarse de aquellos que lo dejaron morir.'),
('The Social Network', 2, 1, '2010-10-01', 120, 'social_network_poster.jpg', 'La historia del surgimiento de Facebook y las disputas legales que siguieron a su éxito.'),
('Toy Story 3', 9, 1, '2010-06-18', 103, 'toy_story_3_poster.jpg', 'Los juguetes de Andy enfrentan su futuro incierto cuando él se prepara para ir a la universidad y sus amigos deben encontrar un nuevo hogar.');

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
