-- Insertion de genres
INSERT INTO genre (name) VALUES
('Science-Fiction'),
('Drame'),
('Comédie'),
('Action'),
('Fantastique');

-- Insertion de réalisateurs
INSERT INTO director (name, birthdate, nationality) VALUES
('Christopher Nolan', '1970-07-30', 'Britannique-Américain'),
('Greta Gerwig', '1983-08-04', 'Américaine'),
('Denis Villeneuve', '1967-10-03', 'Canadien'),
('Quentin Tarantino', '1963-03-27', 'Américain'),
('Bong Joon-ho', '1969-09-14', 'Sud-Coréen');

-- Insertion d'acteurs
INSERT INTO actor (name, nationality, birthdate) VALUES
('Leonardo DiCaprio', 'Américain', '1974-11-11'),
('Margot Robbie', 'Australienne', '1990-07-02'),
('Timothée Chalamet', 'Américain', '1995-12-27'),
('Saoirse Ronan', 'Irlandaise', '1994-04-12'),
('Christian Bale', 'Britannique', '1974-01-30'),
('Samuel L. Jackson', 'Américain', '1948-12-21'),
('Song Kang-ho', 'Sud-Coréen', '1967-01-17');

-- Insertion de films
INSERT INTO movie (title, year_released, synopsis, running_time, poster_path) VALUES
('Inception', 2010, 'Un voleur qui s''approprie des secrets d''entreprises par la technologie de partage de rêves reçoit la tâche inverse d''implanter une idée dans l''esprit d''un P-DG.', 148, 'https://image.tmdb.org/t/p/original/ljsZTbVsrQSqZgWeep2B1QiDKuh.jpg'),
('Barbie', 2023, 'Barbie et Ken passent le temps de leur vie dans le monde coloré et apparemment parfait de Barbie Land. Cependant, quand ils ont la chance d''aller dans le monde réel, ils découvrent rapidement les complexités de la vie humaine.', 114, 'https://image.tmdb.org/t/p/original/dekMkQf0kqAmztUca9lX5e5Pjbp.jpg'),
('Dune', 2021, 'Une famille noble devient impliquée dans une guerre pour le contrôle du bien le plus précieux de la galaxie, tandis que son héritier entreprend un voyage transformateur.', 155, 'https://image.tmdb.org/t/p/original/cDbNAY0KM84cxXhmj8f0dLWza3t.jpg'),
('Pulp Fiction', 1994, 'Les vies de deux tueurs à gages, d''un boxeur, d\'un gangster et de sa femme s\'entremêlent dans quatre récits de violence et de rédemption.', 154, 'https://image.tmdb.org/t/p/original/jYqKxBbAUdfKq3BfHKivJytFiPL.jpg'),
('Parasite', 2019, 'Toute la famille de Ki-taek est au chômage. Leur situation économique est précaire jusqu\'à ce que son fils trouve un emploi de tuteur dans une famille riche.', 132, 'https://image.tmdb.org/t/p/original/x23Fqkt00uqV2TzfSiB60hrc3HY.jpg');

-- Insertion d'associations de genres
INSERT INTO genre_association (movie_id, genre_id) VALUES
(1, 1),  -- Inception - Science-Fiction
(2, 3),  -- Barbie - Comédie
(3, 1),  -- Dune - Science-Fiction
(4, 2),  -- Pulp Fiction - Drame
(5, 2);  -- Parasite - Drame

-- Insertion d'associations de réalisateurs
INSERT INTO director_association (movie_id, director_id) VALUES
(1, 1),  -- Inception - Christopher Nolan
(2, 2),  -- Barbie - Greta Gerwig
(3, 3),  -- Dune - Denis Villeneuve
(4, 4),  -- Pulp Fiction - Quentin Tarantino
(5, 5);  -- Parasite - Bong Joon-ho

-- Insertion de castings
INSERT INTO casting (role, actor_id, movie_id) VALUES
('Cobb', 1, 1),
('Barbie', 2, 2),
('Paul Atreides', 3, 3),
('Vincent Vega', 6, 4),
('Kim Ki-taek', 7, 5);

-- Insertion de comptes utilisateurs
INSERT INTO user_account (username, date_joined, email, password) VALUES
('amourducinema', '2024-01-15', 'cinephile@exemple.com', 'motdepasse123'),
('critiquedereve', '2023-11-20', 'critique@exemple.com', 'motdepasse456'),
('fandefilms', '2024-02-01', 'spectateur@exemple.com', 'motdepasse789');

-- Insertion de relations d'amitié
INSERT INTO friendship (status, date_added, user_id_A, user_id_B) VALUES
('Actif', '2024-02-15', 1, 2),
('En attente', '2024-02-20', 2, 3);

-- Insertion de listes de surveillance
INSERT INTO watchlist (status, movie_id, user_id) VALUES
('Vu', 1, 1),
('À regarder', 2, 2),
('En cours', 3, 3);

-- Insertion de critiques
INSERT INTO review (note, comment, date_published, movie_id, user_id) VALUES
(9.0, 'Un film à l''architecture complexe et visuellement stupéfiant ! Nolan récidive.', '2024-03-01', 1, 1),
(8.5, 'Hilarant et avec un commentaire surprenant sur la société.', '2024-03-02', 2, 2),
(10.0, 'Une épopée de science-fiction qui capture magnifiquement l''essence du livre.', '2024-03-03', 3, 3);
