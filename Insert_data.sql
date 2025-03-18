-- Additional genres
INSERT INTO genre (name) VALUES
('Science-Fiction'),
('Drame'),
('Comédie'),
('Action'),
('Fantastique'),
('Thriller'),
('Horreur'),
('Animation'),
('Aventure'),
('Romance'),
('Biopic'),
('Guerre'),
('Musical'),
('Documentaire'),
('Western'),
('Mystère'),
('Crime'),
('Comédie noire'),
('Film noir'),
('Sport');

-- Directors with updated birthdates
INSERT INTO director (name, birthdate, nationality) VALUES
('Christopher Nolan', '1970-07-30', 'Britannique-Américain'),
('Greta Gerwig', '1983-08-04', 'Américaine'),
('Denis Villeneuve', '1967-10-03', 'Canadien'),
('Quentin Tarantino', '1963-03-27', 'Américain'),
('Bong Joon-ho', '1969-09-14', 'Sud-Coréen'),
('Martin Scorsese', '1942-11-17', 'Américain'),
('Steven Spielberg', '1946-12-18', 'Américain'),
('Wes Anderson', '1969-05-01', 'Américain'),
('Guillermo del Toro', '1964-10-09', 'Mexicain'),
('Chloé Zhao', '1982-03-31', 'Chinoise'),
('Sofia Coppola', '1971-05-14', 'Américaine'),
('Pedro Almodóvar', '1949-09-25', 'Espagnol'),
('Céline Sciamma', '1978-11-12', 'Française'),
('Spike Lee', '1957-03-20', 'Américain'),
('Hayao Miyazaki', '1941-01-05', 'Japonais'),
('Kathryn Bigelow', '1951-11-27', 'Américaine'),
('Jordan Peele', '1979-02-21', 'Américain'),
('Jane Campion', '1954-04-30', 'Néo-Zélandaise'),
('Ridley Scott', '1937-11-30', 'Britannique'),
('Barry Jenkins', '1979-11-19', 'Américain'),
('Wong Kar-wai', '1958-07-17', 'Hongkongais'),
('Todd Phillips', '1970-12-20', 'Américain'),
('Damien Chazelle', '1985-01-19', 'Américain'),
('Ari Aster', '1986-07-15', 'Américain'),
('Alfonso Cuarón', '1961-11-28', 'Mexicain'),
('Yorgos Lanthimos', '1973-05-23', 'Grec'),
('Alejandro González Iñárritu', '1963-08-15', 'Mexicain'),
('David Fincher', '1962-08-28', 'Américain'),
('Ava DuVernay', '1972-08-24', 'Américaine'),
('Paul Thomas Anderson', '1970-06-26', 'Américain');

-- Expanded actor list
INSERT INTO actor (name, nationality, birthdate) VALUES
('Leonardo DiCaprio', 'Américain', '1974-11-11'),
('Margot Robbie', 'Australienne', '1990-07-02'),
('Timothée Chalamet', 'Américain', '1995-12-27'),
('Saoirse Ronan', 'Irlandaise', '1994-04-12'),
('Christian Bale', 'Britannique', '1974-01-30'),
('Samuel L. Jackson', 'Américain', '1948-12-21'),
('Song Kang-ho', 'Sud-Coréen', '1967-01-17'),
('Robert De Niro', 'Américain', '1943-08-17'),
('Meryl Streep', 'Américaine', '1949-06-22'),
('Tom Hanks', 'Américain', '1956-07-09'),
('Viola Davis', 'Américaine', '1965-08-11'),
('Denzel Washington', 'Américain', '1954-12-28'),
('Cate Blanchett', 'Australienne', '1969-05-14'),
('Ryan Gosling', 'Canadien', '1980-11-12'),
('Emma Stone', 'Américaine', '1988-11-06'),
('Daniel Day-Lewis', 'Britannique-Irlandais', '1957-04-29'),
('Tilda Swinton', 'Britannique', '1960-11-05'),
('Joaquin Phoenix', 'Américain', '1974-10-28'),
('Isabelle Huppert', 'Française', '1953-03-16'),
('Gong Li', 'Chinoise', '1965-12-31'),
('Javier Bardem', 'Espagnol', '1969-03-01'),
('Frances McDormand', 'Américaine', '1957-06-23'),
('Brad Pitt', 'Américain', '1963-12-18'),
('Scarlett Johansson', 'Américaine', '1984-11-22'),
('Anthony Hopkins', 'Britannique', '1937-12-31'),
('Florence Pugh', 'Britannique', '1996-01-03'),
('Mahershala Ali', 'Américain', '1974-02-16'),
('Zhao Tao', 'Chinoise', '1977-01-28'),
('Léa Seydoux', 'Française', '1985-07-01'),
('Zendaya', 'Américaine', '1996-09-01'),
('Oscar Isaac', 'Américain', '1979-03-09'),
('Rebecca Ferguson', 'Suédoise', '1983-10-19'),
('Tony Leung', 'Hongkongais', '1962-06-27'),
('Maggie Cheung', 'Hongkongaise', '1964-09-20'),
('Adèle Haenel', 'Française', '1989-01-01'),
('Lupita Nyong\'o', 'Kényane-Mexicaine', '1983-03-01'),
('Toni Collette', 'Australienne', '1972-11-01'),
('Gary Oldman', 'Britannique', '1958-03-21'),
('Michelle Yeoh', 'Malaisienne', '1962-08-06'),
('Willem Dafoe', 'Américain', '1955-07-22'),
('Jessica Chastain', 'Américaine', '1977-03-24'),
('Adam Driver', 'Américain', '1983-11-19'),
('Marion Cotillard', 'Française', '1975-09-30'),
('John David Washington', 'Américain', '1984-07-28'),
('Ana de Armas', 'Cubaine', '1988-04-30'),
('Dev Patel', 'Britannique', '1990-04-23'),
('Choi Min-sik', 'Sud-Coréen', '1962-05-30'),
('Naomie Harris', 'Britannique', '1976-09-06'),
('Keanu Reeves', 'Canadien', '1964-09-02'),
('Michael B. Jordan', 'Américain', '1987-02-09'),
('Joseph Gordon-Levitt', 'Américain', '1981-02-17'),
('Anne Hathaway', 'Américaine', '1982-11-12'),
('Ellen Page', 'Canadienne', '1987-02-21'),
('Tom Hardy', 'Britannique', '1977-09-15'),
('Ken Watanabe', 'Japonais', '1959-10-21'),
('John Boyega', 'Britannique', '1992-03-17'),
('Daisy Ridley', 'Britannique', '1992-04-10'),
('Jason Momoa', 'Américain', '1979-08-01'),
('Josh Brolin', 'Américain', '1968-02-12'),
('Jude Law', 'Britannique', '1972-12-29'),
('Jeff Goldblum', 'Américain', '1952-10-22'),
('Willem Dafoe', 'Américain', '1955-07-22');

-- Movies with detailed information
INSERT INTO movie (title, year_released, synopsis, running_time, poster_path) VALUES
('Inception', 2010, 'Un voleur qui s''approprie des secrets d''entreprises par la technologie de partage de rêves reçoit la tâche inverse d''implanter une idée dans l''esprit d''un P-DG.', 148, 'https://image.tmdb.org/t/p/original/ljsZTbVsrQSqZgWeep2B1QiDKuh.jpg'),
('Barbie', 2023, 'Barbie et Ken passent le temps de leur vie dans le monde coloré et apparemment parfait de Barbie Land. Cependant, quand ils ont la chance d''aller dans le monde réel, ils découvrent rapidement les complexités de la vie humaine.', 114, 'https://image.tmdb.org/t/p/original/dekMkQf0kqAmztUca9lX5e5Pjbp.jpg'),
('Dune', 2021, 'Une famille noble devient impliquée dans une guerre pour le contrôle du bien le plus précieux de la galaxie, tandis que son héritier entreprend un voyage transformateur.', 155, 'https://image.tmdb.org/t/p/original/cDbNAY0KM84cxXhmj8f0dLWza3t.jpg'),
('Pulp Fiction', 1994, 'Les vies de deux tueurs à gages, d''un boxeur, d\'un gangster et de sa femme s\'entremêlent dans quatre récits de violence et de rédemption.', 154, 'https://image.tmdb.org/t/p/original/jYqKxBbAUdfKq3BfHKivJytFiPL.jpg'),
('Parasite', 2019, 'Toute la famille de Ki-taek est au chômage. Leur situation économique est précaire jusqu\'à ce que son fils trouve un emploi de tuteur dans une famille riche.', 132, 'https://image.tmdb.org/t/p/original/x23Fqkt00uqV2TzfSiB60hrc3HY.jpg'),
('The Godfather', 1972, 'Le patriarche vieillissant d\'une dynastie de la mafia transfère le contrôle de son empire clandestin à son fils réticent.', 175, 'https://image.tmdb.org/t/p/original/3bhkrj58Vtu7enYsRolD1fZdja1.jpg'),
('Interstellar', 2014, 'Une équipe d\'explorateurs voyage à travers un trou de ver dans l\'espace dans une tentative de sauver l\'humanité.', 169, 'https://image.tmdb.org/t/p/original/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg'),
('Spirited Away', 2001, 'Pendant le déménagement de sa famille, une jeune fille de 10 ans entre dans un monde dominé par des dieux, des sorcières et des esprits.', 125, 'https://image.tmdb.org/t/p/original/39wmItIWsg5sZMyRUHLkWBcuVCM.jpg'),
('The Grand Budapest Hotel', 2014, 'Les aventures de Gustave H, un concierge légendaire d\'un célèbre hôtel européen, et de Zero Moustafa, le garçon d\'étage qui devient son ami le plus fidèle.', 99, 'https://image.tmdb.org/t/p/original/eWdyYQreja6JGCzqHWXpWHDrrPo.jpg'),
('Nomadland', 2020, 'Après l\'effondrement économique d\'une ville de l\'ère industrielle, une femme devient nomade et entreprend un voyage à travers l\'Ouest américain.', 108, 'https://image.tmdb.org/t/p/original/66GUmWpTHgAjyp4aBSXy63PZTiC.jpg'),
('The Shape of Water', 2017, 'Dans un laboratoire gouvernemental secret, une femme de ménage muette se lie d\'amitié avec une créature aquatique humanoïde.', 123, 'https://image.tmdb.org/t/p/original/k4FwHlMhuRR5BISY2Gm2QZHlH5Q.jpg'),
('Moonlight', 2016, 'Une chronique de la vie d\'un jeune homme noir qui grandit dans un quartier difficile de Miami.', 111, 'https://image.tmdb.org/t/p/original/rcICfiL9fvwRjoWHxW8QeroLYrJ.jpg'),
('Get Out', 2017, 'Un jeune homme afro-américain visite la famille de sa petite amie blanche pour le week-end, où ses inquiétudes concernant l\'accueil se transforment en une découverte terrifiante.', 104, 'https://image.tmdb.org/t/p/original/qZMlR4rc8lgVz67JdbchfjmfMip.jpg'),
('The Irishman', 2019, 'Un tueur à gages âgé réfléchit à sa vie et en particulier au rôle qu\'il a joué dans la disparition d\'un dirigeant syndical.', 209, 'https://image.tmdb.org/t/p/original/mbm8k3GFhXS0ROd9AD1gqYbIFbM.jpg'),
('In the Mood for Love', 2000, 'Deux voisins forment une forte liaison après avoir découvert que leurs conjoints ont une liaison.', 98, 'https://image.tmdb.org/t/p/original/iYypPT4bhqXfq1b6EnmxvRt6b2Y.jpg'),
('Portrait de la jeune fille en feu', 2019, 'À la fin du XVIIIe siècle, une peintre est chargée de réaliser le portrait de mariage d\'une jeune femme.', 122, 'https://image.tmdb.org/t/p/original/3NTEMlG5mQdIAlKDl3AJG0rX29Z.jpg'),
('Blade Runner 2049', 2017, 'Un jeune blade runner découvre un secret enfoui qui le mène à retrouver Rick Deckard, disparu depuis 30 ans.', 163, 'https://image.tmdb.org/t/p/original/gajva2L0rPYkEWjzgFlBXCAVBE5.jpg'),
('Joker', 2019, 'Un comédien raté devient fou et se transforme en un criminel psychopathe à Gotham City.', 122, 'https://image.tmdb.org/t/p/original/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg'),
('La La Land', 2016, 'Un pianiste de jazz et une actrice en herbe tombent amoureux tout en poursuivant leurs rêves à Los Angeles.', 128, 'https://media.themoviedb.org/t/p/w300_and_h450_bestv2/5KIj6aioW1UtUT1IV0qqW5iZbNH.jpg'),
('Hereditary', 2018, 'Une famille commence à découvrir des secrets terrifiants sur leur généalogie après la mort de leur grand-mère recluse.', 127, 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/p9fmuz2Oj3HtEJEqbIwkFGUhVXD.jpg'),
('Roma', 2018, 'Une année dans la vie d\'une femme de ménage travaillant pour une famille de la classe moyenne à Mexico dans les années 1970.', 135, 'https://image.tmdb.org/t/p/original/dtIIyQyALk57ko5bjac7hi01YQ.jpg'),
('The Favourite', 2018, 'Au début du XVIIIe siècle, l\'Angleterre est en guerre avec la France. La reine Anne, à la santé fragile, occupe le trône tandis que son amie Lady Sarah gouverne le pays à sa place.', 119, 'https://image.tmdb.org/t/p/original/cwBq0onfmeilU5xgqNNjJAMPfpw.jpg'),
('Inglourious Basterds', 2009, 'Dans la France occupée pendant la Seconde Guerre mondiale, un groupe de soldats juifs américains prévoit d\'assassiner des nazis.', 153, 'https://image.tmdb.org/t/p/original/7sfbEnaARXDDhKm0CZ7D7uc2sbo.jpg'),
('The Revenant', 2015, 'Un trappeur est laissé pour mort après une attaque d\'ours et est trahi par son équipe. Il survit et entreprend un voyage pour se venger.', 156, 'https://image.tmdb.org/t/p/original/ji3ecJphATlVgWNY0B0RVXZizdf.jpg'),
('Arrival', 2016, 'Une linguiste est recrutée par l\'armée pour communiquer avec des extraterrestres qui ont atterri sur Terre.', 116, 'https://image.tmdb.org/t/p/original/x2FJsf1ElAgr63Y3PNPtJrcmpoe.jpg'),
('The Dark Knight', 2008, 'Batman s\'associe au procureur Harvey Dent pour démanteler le crime organisé à Gotham, mais ils se retrouvent confrontés à un nouveau génie criminel connu sous le nom du Joker.', 152, 'https://image.tmdb.org/t/p/original/1hRoyzDtpgMU7Dz4JF22RANzQO7.jpg'),
('The Prestige', 2006, 'Après un tragique accident, deux magiciens de scène s\'engagent dans une bataille pour créer l\'illusion ultime tout en sacrifiant tout ce qu\'ils ont.', 130, 'https://image.tmdb.org/t/p/original/bdN3gXuIZYaJP7ftKK2sU0nPtEA.jpg'),
('Little Women', 2019, 'L\'histoire des sœurs March, quatre jeunes femmes chacune déterminée à vivre sa vie selon ses propres termes.', 135, 'https://image.tmdb.org/t/p/original/yn5ihODtZ7ofn8pDYfxCmxh8AXI.jpg'),
('Ladybird', 2017, 'Une lycéenne, qui se fait appeler \"Lady Bird\", navigue entre les relations tumultueuses avec sa mère et ses amis pendant sa dernière année.', 94, 'https://image.tmdb.org/t/p/original/5aUFf14QRtm5Cg3EA2wBhrCN7vA.jpg'),
('Sicario', 2015, 'Une idéaliste du FBI est recrutée par une force opérationnelle gouvernementale pour aider dans la guerre croissante contre la drogue à la frontière entre les États-Unis et le Mexique.', 121, 'https://image.tmdb.org/t/p/original/lz8vNyXeidqqOdJW9ZjnDAMb5Vr.jpg'),
('Enemy', 2013, 'Un homme cherche son exact sosie après l\'avoir repéré dans un film.', 91, 'https://image.tmdb.org/t/p/original/vFEsk9D9LZV2dJW47JWnS7o5Oys.jpg'),
('Kill Bill: Volume 1', 2003, 'Après s\'être réveillée d\'un coma de quatre ans, une ancienne assassin se venge de l\'équipe d\'assassins qui l\'a trahie.', 111, 'https://image.tmdb.org/t/p/original/v7TaX8kXMXs5yFFGR41guUDNcnB.jpg'),
('Django Unchained', 2012, 'Avec l\'aide d\'un chasseur de primes allemand, un esclave affranchi part sauver sa femme d\'un cruel propriétaire de plantation au Mississippi.', 165, 'https://image.tmdb.org/t/p/original/7oWY8VDWW7thTzWh3OKYRkWUlD5.jpg'),
('Memories of Murder', 2003, 'Dans une petite ville rurale de Corée du Sud en 1986, des détectives locaux et un détective de Séoul traquent un tueur en série.', 131, 'https://image.tmdb.org/t/p/original/lSnKblwJ6AQF7ICcZZMG6RJ4dziK.jpg'),
('Snowpiercer', 2013, 'Dans un futur où une expérience ratée pour contrer le réchauffement climatique a tué toute vie sur terre sauf les passagers d\'un train qui perpétuellement fait le tour du globe.', 126, 'https://image.tmdb.org/t/p/original/mUQmMM6LSHuH2awJH7KUkT8HYkI.jpg'),
('Goodfellas', 1990, 'La vie de Henry Hill et ses amis de la mafia qui ont grandi ensemble.', 146, 'https://image.tmdb.org/t/p/original/aKuFiU82s5ISJpGZp7YkIr3kCUd.jpg'),
('The Departed', 2006, 'Une taupe dans la police de Boston essaie d\'identifier et de dénoncer un espion infiltré dans la police par un groupe criminel.', 151, 'https://image.tmdb.org/t/p/original/nT97ifVT2J1yXaJSEoGD1Db3JhP.jpg'),
('Jurassic Park', 1993, 'Un milliardaire et une équipe de généticiens créent un parc d\'attractions peuplé de dinosaures ressuscités, mais tout tourne au chaos.', 127, 'https://image.tmdb.org/t/p/original/9i3plLl89DHMz7mahksDaAo7HIS.jpg'),
('E.T. the Extra-Terrestrial', 1982, 'Un jeune garçon se lie d\'amitié avec un extraterrestre, perdu sur Terre, et l\'aide à retourner sur sa planète.', 115, 'https://image.tmdb.org/t/p/original/an0nD6uq6byfxXCfk6lQBzdL2J1.jpg'),
('Princess Mononoke', 1997, 'Dans une lutte contre la déforestation, une princesse guerrière élevée par des loups s\'allie avec un prince pour sauver une forêt sacrée.', 134, 'https://image.tmdb.org/t/p/original/pdtzEreKvKAlqa2YEBaGwiA45V8.jpg'),
('My Neighbor Totoro', 1988, 'Deux jeunes filles déménagent à la campagne avec leur père pour se rapprocher de leur mère hospitalisée et découvrent des esprits animés de la forêt.', 86, 'https://image.tmdb.org/t/p/original/rtGDOeG9LzoerkDGZF9dnVeLppL.jpg'),
('Pan\'s Labyrinth', 2006, 'Au milieu de la guerre civile espagnole, une jeune fille découvre un labyrinthe mystérieux où elle rencontre un faune qui lui confie trois tâches.', 118, 'https://image.tmdb.org/t/p/original/d6jUbQj7sjWCUU6OqSt6za48rW7.jpg'),
('The Devil\'s Backbone', 2001, 'Après la mort de son père, un jeune garçon est envoyé dans un orphelinat mystérieux pendant la guerre civile espagnole.', 106, 'https://image.tmdb.org/t/p/original/iqJhHjD7SxZzIZnYcN7Dbu6a8Yy.jpg'),
('Us', 2019, 'Une famille est attaquée par un groupe de doppelgängers terrifiants.', 116, 'https://image.tmdb.org/t/p/original/ux2dU1jQ2ACIMShzB3yP93Udpzc.jpg'),
('Nope', 2022, 'Les résidents d\'une vallée isolée de l\'intérieur de la Californie sont témoins d\'une découverte étrange et effrayante.', 130, 'https://image.tmdb.org/t/p/original/AcKVlWaNVVVFQwro3nLXqPljcYA.jpg'),
('The Power of the Dog', 2021, 'Un rancher charismatique inspire la peur et l\'admiration chez ceux qui l\'entourent, jusqu\'à ce que l\'arrivée du nouveau mari de sa belle-sœur et de son fils change la donne.', 126, 'https://image.tmdb.org/t/p/original/kEy48iCzGnp0ao1cZbNeWR6yIhC.jpg'),
('The Piano', 1993, 'Une femme muette est envoyée en Nouvelle-Zélande avec sa jeune fille pour un mariage arrangé avec un agriculteur.', 121, 'https://image.tmdb.org/t/p/original/3GNQJu2B9U0jGu8wNq4esBo7vES.jpg'),
('Alien', 1979, 'L\'équipage d\'un vaisseau spatial commercial rencontre une forme de vie mortelle après avoir enquêté sur un signal inconnu.', 117, 'https://image.tmdb.org/t/p/original/vfrQk5IPloGg1v9Rzbh2Eg3VGyM.jpg'),
('Blade Runner', 1982, 'Un blade runner doit poursuivre et terminer quatre réplicants qui ont volé un vaisseau spatial et sont revenus sur Terre pour trouver leur créateur.', 117, 'https://image.tmdb.org/t/p/original/63N9uy8nd9j7Eog2axPQ8lbr3Wj.jpg'),
('Fight Club', 1999, 'Un employé de bureau insomniaque et un fabricant de savon rebelle forment un club de combat clandestin qui évolue en quelque chose de beaucoup plus.', 139, 'https://image.tmdb.org/t/p/original/pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg'),
('Se7en', 1995, 'Deux détectives, un vétéran et un débutant, chassent un tueur en série qui utilise les sept péchés capitaux comme motifs pour ses meurtres.', 127, 'https://image.tmdb.org/t/p/original/69Sns8WoET6CfaYlIkHbla4l7nC.jpg'),
('12 Years a Slave', 2013, 'Dans les années précédant la guerre civile, un homme noir libre est kidnappé et vendu dans l\'esclavage.', 134, 'https://image.tmdb.org/t/p/original/kb3X943WMIJYVg4SOAyK0pmWL5D.jpg'),
('Selma', 2014, 'Une chronique de la campagne de Martin Luther King pour garantir les droits de vote égaux par une marche épique de Selma à Montgomery, Alabama, en 1965.', 128, 'https://image.tmdb.org/t/p/original/nTan1MJO9mwtCEMmV69v9hG5tug.jpg'),
('There Will Be Blood', 2007, 'Un prospecteur de pétrole déplace une petite ville au début du XXe siècle et commence une opération qui le rend riche mais tord son âme.', 158, 'https://image.tmdb.org/t/p/original/fa0RDkAlCec0STeMNAhPaF89q6U.jpg'),
('Phantom Thread', 2017, 'Dans le Londres de l\'après-guerre, un couturier renommé habille les membres de la haute société et la famille royale jusqu\'à ce que sa vie bien ordonnée soit perturbée par une jeune femme obstinée.', 130, 'https://image.tmdb.org/t/p/original/yZ8j8xKk2xQ1d88hB8YG6LZfRQj.jpg');

-- Genre associations for each movie (at least 2 per movie)
INSERT INTO genre_association (movie_id, genre_id) VALUES
-- Inception (Science-Fiction, Action, Thriller)
(1, 1), (1, 4), (1, 6),
-- Barbie (Comédie, Aventure, Fantastique)
(2, 3), (2, 9), (2, 5),
-- Dune (Science-Fiction, Aventure, Drame)
(3, 1), (3, 9), (3, 2),
-- Pulp Fiction (Drame, Crime, Thriller)
(4, 2), (4, 17), (4, 6),
-- Parasite (Drame, Thriller, Comédie noire)
(5, 2), (5, 6), (5, 18),
-- The Godfather (Drame, Crime)
(6, 2), (6, 17),
-- Interstellar (Science-Fiction, Aventure, Drame)
(7, 1), (7, 9), (7, 2),
-- Spirited Away (Animation, Fantastique, Aventure)
(8, 8), (8, 5), (8, 9),
-- The Grand Budapest Hotel (Comédie, Aventure, Drame)
(9, 3), (9, 9), (9, 2),
-- Nomadland (Drame, Western)
(10, 2), (10, 15),
-- The Shape of Water (Fantastique, Drame, Romance)
(11, 5), (11, 2), (11, 10),
-- Moonlight (Drame, Romance)
(12, 2), (12, 10),
-- Get Out (Horreur, Thriller, Mystère)
(13, 7), (13, 6), (13, 16),
-- The Irishman (Crime, Drame, Biopic)
(14, 17), (14, 2), (14, 11),
-- In the Mood for Love (Drame, Romance)
(15, 2), (15, 10),
-- Portrait de la jeune fille en feu (Drame, Romance, Histoire)
(16, 2), (16, 10), (16, 11),
-- Blade Runner 2049 (Science-Fiction, Thriller, Drame)
(17, 1), (17, 6), (17, 2),
-- Joker (Drame, Crime, Thriller)
(18, 2), (18, 17), (18, 6),
-- La La Land (Comédie, Drame, Musical)
(19, 3), (19, 2), (19, 13),
-- Hereditary (Horreur, Drame, Thriller)
(20, 7), (20, 2), (20, 6),
-- Roma (Drame)
(21, 2),
-- The Favourite (Drame, Comédie, Histoire)
(22, 2), (22, 3), (22, 11),
-- Inglourious Basterds (Guerre, Drame, Action)
(23, 12), (23, 2), (23, 4),
-- The Revenant (Aventure, Drame, Western)
(24, 9), (24, 2), (24, 15),
-- Arrival (Science-Fiction, Drame, Mystère)
(25, 1), (25, 2), (25, 16),
-- The Dark Knight (Action, Drame, Crime)
(26, 4), (26, 2), (26, 17),
-- The Prestige (Drame, Mystère, Science-Fiction)
(27, 2), (27, 16), (27, 1),
-- Little Women (Drame, Romance)
(28, 2), (28, 10),
-- Ladybird (Drame, Comédie)
(29, 2), (29, 3),
-- Sicario (Action, Crime, Drame)
(30, 4), (30, 17), (30, 2),
-- Enemy (Thriller, Mystère, Drame)
(31, 6), (31, 16), (31, 2),
-- Kill Bill: Volume 1 (Action, Crime, Thriller)
(32, 4), (32, 17), (32, 6),
-- Django Unchained (Western, Drame, Action)
(33, 15), (33, 2), (33, 4),
-- Memories of Murder (Crime, Drame, Mystère)
(34, 17), (34, 2), (34, 16),
-- Snowpiercer (Science-Fiction, Action, Drame)
(35, 1), (35, 4), (35, 2),
-- Goodfellas (Crime, Drame)
(36, 17), (36, 2),
-- The Departed (Crime, Drame, Thriller)
(37, 17), (37, 2), (37, 6),
-- Jurassic Park (Aventure, Science-Fiction)
(38, 9), (38, 1),
-- E.T. the Extra-Terrestrial (Science-Fiction, Aventure, Famille)
(39, 1), (39, 9), (39, 5),
-- Princess Mononoke (Animation, Aventure, Fantastique)
(40, 8), (40, 9), (40, 5),
-- My Neighbor Totoro (Animation, Fantastique, Famille)
(41, 8), (41, 5), (41, 9),
-- Pan's Labyrinth (Fantastique, Drame, Guerre)
(42, 5), (42, 2), (42, 12),
-- The Devil's Backbone (Drame, Horreur, Fantastique)
(43, 2), (43, 7), (43, 5),
-- Us (Horreur, Thriller, Mystère)
(44, 7), (44, 6), (44, 16),
-- Nope (Science-Fiction, Horreur, Mystère)
(45, 1), (45, 7), (45, 16),
-- The Power of the Dog (Drame, Western)
(46, 2), (46, 15),
-- The Piano (Drame, Romance, Musical)
(47, 2), (47, 10), (47, 13),
-- Alien (Science-Fiction, Horreur)
(48, 1), (48, 7),
-- Blade Runner (Science-Fiction, Thriller)
(49, 1), (49, 6),
-- Fight Club (Drame, Thriller)
(50, 2), (50, 6),
-- Se7en (Crime, Thriller, Mystère)
(51, 17), (51, 6), (51, 16),
-- 12 Years a Slave (Drame, Histoire, Biopic)
(52, 2), (52, 11),
-- Selma (Drame, Histoire, Biopic)
(53, 2), (53, 11),
-- There Will Be Blood (Drame, Western)
(54, 2), (54, 15),
-- Phantom Thread (Drame, Romance)
(55, 2), (55, 10);

-- Director associations for each movie
INSERT INTO director_association (movie_id, director_id) VALUES
-- Inception - Christopher Nolan
(1, 1),

-- Barbie - Greta Gerwig
(2, 2),

-- Dune - Denis Villeneuve
(3, 3),

-- Pulp Fiction - Quentin Tarantino
(4, 4),

-- Parasite - Bong Joon-ho
(5, 5),

-- The Godfather - Martin Scorsese
(6, 6),

-- Interstellar - Christopher Nolan
(7, 1),

-- Spirited Away - Hayao Miyazaki
(8, 15),

-- The Grand Budapest Hotel - Wes Anderson
(9, 8),

-- Nomadland - Chloé Zhao
(10, 10),

-- The Shape of Water - Guillermo del Toro
(11, 9),

-- Moonlight - Barry Jenkins
(12, 20),

-- Get Out - Jordan Peele
(13, 17),

-- The Irishman - Martin Scorsese
(14, 6),

-- In the Mood for Love - Wong Kar-wai
(15, 21),

-- Portrait de la jeune fille en feu - Céline Sciamma
(16, 13),

-- Blade Runner 2049 - Denis Villeneuve
(17, 3),

-- Joker - Todd Phillips
(18, 22),

-- La La Land - Damien Chazelle
(19, 23),

-- Hereditary - Ari Aster
(20, 24),

-- Roma - Alfonso Cuarón
(21, 25),

-- The Favourite - Yorgos Lanthimos
(22, 26),

-- Inglourious Basterds - Quentin Tarantino
(23, 4),

-- The Revenant - Alejandro González Iñárritu
(24, 27),

-- Arrival - Denis Villeneuve
(25, 3),

-- The Dark Knight - Christopher Nolan
(26, 1),

-- The Prestige - Christopher Nolan
(27, 1),

-- Little Women - Greta Gerwig
(28, 2),

-- Ladybird - Greta Gerwig
(29, 2),

-- Sicario - Denis Villeneuve
(30, 3),

-- Enemy - Denis Villeneuve
(31, 3),

-- Kill Bill: Volume 1 - Quentin Tarantino
(32, 4),

-- Django Unchained - Quentin Tarantino
(33, 4),

-- Memories of Murder - Bong Joon-ho
(34, 5),

-- Snowpiercer - Bong Joon-ho
(35, 5),

-- Goodfellas - Martin Scorsese
(36, 6),

-- The Departed - Martin Scorsese
(37, 6),

-- Jurassic Park - Steven Spielberg
(38, 7),

-- E.T. the Extra-Terrestrial - Steven Spielberg
(39, 7),

-- Princess Mononoke - Hayao Miyazaki
(40, 15),

-- My Neighbor Totoro - Hayao Miyazaki
(41, 15),

-- Pan's Labyrinth - Guillermo del Toro
(42, 9),

-- The Devil's Backbone - Guillermo del Toro
(43, 9),

-- Us - Jordan Peele
(44, 17),

-- Nope - Jordan Peele
(45, 17),

-- The Power of the Dog - Jane Campion
(46, 18),

-- The Piano - Jane Campion
(47, 18),

-- Alien - Ridley Scott
(48, 19),

-- Blade Runner - Ridley Scott
(49, 19),

-- Fight Club - David Fincher
(50, 28),

-- Se7en - David Fincher
(51, 28),

-- 12 Years a Slave - Steve McQueen
(52, 20),

-- Selma - Ava DuVernay
(53, 29),

-- There Will Be Blood - Paul Thomas Anderson
(54, 30),

-- Phantom Thread - Paul Thomas Anderson
(55, 30);

-- Insertion de castings
INSERT INTO casting (role, actor_id, movie_id) VALUES
('Cobb', 1, 1),
('Barbie', 2, 2),
('Paul Atreides', 3, 3),
('Vincent Vega', 6, 4),
('Kim Ki-taek', 7, 5),
('Michael Corleone', 8, 6),
('Cooper', 9, 7),
('Chihiro', 10, 8),
('Gustave H.', 11, 9),
('Fern', 12, 10),
('Elisa Esposito', 13, 11),
('Chiron', 14, 12),
('Chris Washington', 15, 13),
('Frank Sheeran', 16, 14),
('Chow Mo-wan', 17, 15),
('Marianne', 18, 16),
('K', 19, 17),
('Arthur Fleck', 20, 18),
('Sebastian', 21, 19),
('Annie Graham', 22, 20),
('Cleo', 23, 21),
('Queen Anne', 24, 22),
('Lt. Aldo Raine', 25, 23),
('Hugh Glass', 26, 24),
('Louise Banks', 27, 25),
('Bruce Wayne', 28, 26),
('Robert Angier', 29, 27),
('Jo March', 30, 28),
('Christine "Lady Bird" McPherson', 31, 29),
('Kate Macer', 32, 30),
('Adam Bell', 33, 31),
('The Bride', 34, 32),
('Django', 35, 33),
('Detective Park Doo-man', 36, 34),
('Curtis', 37, 35),
('Henry Hill', 38, 36),
('Billy Costigan', 39, 37),
('Dr. Alan Grant', 40, 38),
('Elliott', 41, 39),
('Ashitaka', 42, 40),
('Satsuki', 43, 41),
('Ofelia', 44, 42),
('Carlos', 45, 43),
('Adelaide Wilson', 46, 44),
('OJ Haywood', 47, 45),
('Phil Burbank', 48, 46),
('Ada McGrath', 49, 47),
('Ellen Ripley', 50, 48),
('Rick Deckard', 51, 49),
('The Narrator', 52, 50),
('Detective David Mills', 53, 51),
('Solomon Northup', 54, 52),
('Dr. Martin Luther King Jr.', 55, 53),
('Daniel Plainview', 56, 54),
('Reynolds Woodcock', 57, 55);

-- Insertion de comptes utilisateurs
INSERT INTO user_account (username, date_joined, email, password) VALUES
('amourducinema', '2024-01-15', 'cinephile@exemple.com', 'motdepasse123'),
('critiquedereve', '2023-11-20', 'critique@exemple.com', 'motdepasse456'),
('fandefilms', '2024-02-01', 'spectateur@exemple.com', 'motdepasse789');

INSERT INTO user_account (username, date_joined, email, password, is_admin) VALUES
('admin', '2024-02-01', 'admin@admin.com', 'admin' , TRUE);

-- Insertion de relations d'amitié
INSERT INTO friendship (status, date_added, user_id_A, user_id_B) VALUES
('Actif', '2024-02-15', 1, 2),
('En attente', '2024-02-20', 2, 3);
