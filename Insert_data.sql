-- Insert Directors
INSERT INTO director (director_id, name, birthdate, nationality) VALUES
(1, 'Christopher Nolan', '1970-07-30', 'British-American'),
(2, 'Greta Gerwig', '1983-08-04', 'American'),
(3, 'Denis Villeneuve', '1967-10-03', 'Canadian');

-- Insert Genres
INSERT INTO genre (genre_id, name) VALUES
(1, 'Science Fiction'),
(2, 'Drama'),
(3, 'Comedy'),
(4, 'Action');

-- Insert Actors
INSERT INTO actor (actor_id, name, nationality, birthdate) VALUES
(1, 'Leonardo DiCaprio', 'American', '1974-11-11'),
(2, 'Margot Robbie', 'Australian', '1990-07-02'),
(3, 'Timothée Chalamet', 'American', '1995-12-27'),
(4, 'Saoirse Ronan', 'Irish', '1994-04-12'),
(5, 'Christian Bale', 'British', '1974-01-30');

-- Insert Movies
INSERT INTO movie (movie_id, title, year_released, synopsis, running_time, director_id, genre_id) VALUES
(1, 'Inception', 2010, 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 148, 1, 1,'https://image.tmdb.org/t/p/original/ljsZTbVsrQSqZgWeep2B1QiDKuh.jpg'),
(2, 'Barbie', 2023, 'Barbie and Ken are having the time of their lives in the colorful and seemingly perfect world of Barbie Land. However, when they get a chance to go to the real world, they soon discover the complexities of human life.', 114, 2, 3, 'https://image.tmdb.org/t/p/original/dekMkQf0kqAmztUca9lX5e5Pjbp.jpg'),
(3, 'Dune', 2021, 'A noble family becomes embroiled in a war for control over the galaxy''s most valuable asset while its heir becomes undertaking a transformative journey.', 155, 3, 1,'https://image.tmdb.org/t/p/original/cDbNAY0KM84cxXhmj8f0dLWza3t.jpg');

-- Insert Casting
INSERT INTO casting (casting_id, role, actor_id, movie_id) VALUES
(1, 'Cobb', 1, 1),
(2, 'Barbie', 2, 2),
(3, 'Paul Atreides', 3, 3),
(4, 'Lady Jessica', 4, 3),
(5, 'Arthur', 5, 1);

-- Insert User Accounts
INSERT INTO user_account (user_id, username, date_joined, email, password) VALUES
(1, 'movielover2024', '2024-01-15', 'cinephile@example.com', 'hashedpassword123'),
(2, 'filmcritic', '2023-11-20', 'reviewer@example.com', 'securepassword456'),
(3, 'streamingfan', '2024-02-01', 'watcher@example.com', 'passwordhash789');

-- Insert Reviews
INSERT INTO review (review_id, note, comment, date_published, movie_id, user_id) VALUES
(1, 9, 'Mind-bending and visually stunning! Nolan does it again.', '2024-03-01', 1, 1),
(2, 8, 'Hilarious and surprisingly deep commentary on society.', '2024-03-02', 2, 2),
(3, 10, 'Epic sci-fi that beautifully captures the essence of the book.', '2024-03-03', 3, 3);

-- Insert Watchlist
INSERT INTO watchlist (id_watchlist, status, movie_id, user_id) VALUES
(1, 'Watched', 1, 1),
(2, 'To Watch', 2, 2),
(3, 'Watching', 3, 3);

-- Insert Friendships
INSERT INTO friendship (friendship_id, status, date_added, user_id_A, user_id_B) VALUES
(1, 'Active', '2024-02-15', 1, 2),
(2, 'Pending', '2024-02-20', 2, 3);