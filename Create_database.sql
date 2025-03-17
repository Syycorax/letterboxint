CREATE TABLE user_account(
   user_id BIGINT AUTO_INCREMENT,
      username VARCHAR(64) UNIQUE,
      date_joined DATE,
      email VARCHAR(320) UNIQUE,
      password VARCHAR(256),
      PRIMARY KEY(user_id),
      is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE movie(
   movie_id BIGINT AUTO_INCREMENT,
   title VARCHAR(128),
   year_released SMALLINT,
   synopsis VARCHAR(512),
   running_time SMALLINT,
   poster_path VARCHAR(256) DEFAULT NULL,
   PRIMARY KEY(movie_id)
);
CREATE TABLE director(
   director_id BIGINT AUTO_INCREMENT,
   name VARCHAR(64),
   birthdate DATE,
   nationality VARCHAR(64),
   PRIMARY KEY(director_id)
);
CREATE TABLE genre(
   genre_id BIGINT AUTO_INCREMENT,
   name VARCHAR(64),
   PRIMARY KEY(genre_id)
);
CREATE TABLE actor(
   actor_id BIGINT AUTO_INCREMENT,
   name VARCHAR(64),
   nationality VARCHAR(64),
   birthdate DATE,
   PRIMARY KEY(actor_id)
);
CREATE TABLE friendship(
   friendship_id BIGINT AUTO_INCREMENT,
   status VARCHAR(32),
   date_added DATE,
   user_id_A BIGINT NOT NULL,
   user_id_B BIGINT NOT NULL,
   PRIMARY KEY(friendship_id),
   CONSTRAINT unique_user_pair UNIQUE(user_id_A, user_id_B),
   FOREIGN KEY(user_id_A) REFERENCES user_account(user_id) ON DELETE CASCADE,
   FOREIGN KEY(user_id_B) REFERENCES user_account(user_id) ON DELETE CASCADE
);
CREATE TABLE review(
   review_id BIGINT AUTO_INCREMENT,
   note FLOAT,
   comment VARCHAR(2048),
   date_published DATE,
   movie_id BIGINT NOT NULL,
   user_id BIGINT NOT NULL,
   PRIMARY KEY(review_id),
   FOREIGN KEY(movie_id) REFERENCES movie(movie_id) ON DELETE CASCADE,
   FOREIGN KEY(user_id) REFERENCES user_account(user_id) ON DELETE CASCADE,
   CONSTRAINT unique_review UNIQUE(movie_id, user_id)
);
CREATE TABLE watchlist(
   id_watchlist BIGINT AUTO_INCREMENT,
   status VARCHAR(32),
   movie_id BIGINT NOT NULL,
   user_id BIGINT NOT NULL,
   PRIMARY KEY(id_watchlist),
   FOREIGN KEY(movie_id) REFERENCES movie(movie_id) ON DELETE CASCADE,
   FOREIGN KEY(user_id) REFERENCES user_account(user_id) ,
   CONSTRAINT unique_watchlist UNIQUE(movie_id, user_id)
);
CREATE TABLE casting(
   casting_id BIGINT AUTO_INCREMENT,
   role VARCHAR(64),
   actor_id BIGINT NOT NULL,
   movie_id BIGINT NOT NULL,
   PRIMARY KEY(casting_id),
   FOREIGN KEY(actor_id) REFERENCES actor(actor_id) ON DELETE CASCADE,
   FOREIGN KEY(movie_id) REFERENCES movie(movie_id) ON DELETE CASCADE
);
CREATE TABLE genre_association(
   movie_id BIGINT NOT NULL,
   genre_id BIGINT NOT NULL,
   PRIMARY KEY(movie_id, genre_id),
   FOREIGN KEY(movie_id) REFERENCES movie(movie_id) ON DELETE CASCADE,
   FOREIGN KEY(genre_id) REFERENCES genre(genre_id) ON DELETE CASCADE
);
CREATE TABLE director_association(
   movie_id BIGINT NOT NULL,
   director_id BIGINT NOT NULL,
   PRIMARY KEY(movie_id, director_id),
   FOREIGN KEY(movie_id) REFERENCES movie(movie_id) ON DELETE CASCADE,
   FOREIGN KEY(director_id) REFERENCES director(director_id) ON DELETE CASCADE
);
CREATE VIEW user_watched_movies AS
SELECT 
   ua.user_id,
   ua.username,
   COUNT(w.movie_id) AS watched_movies_count
FROM 
   user_account ua
JOIN 
   watchlist w ON ua.user_id = w.user_id
WHERE 
   w.status = 'seen'
GROUP BY 
   ua.user_id, ua.username;

CREATE VIEW users_not_admin AS
SELECT 
   user_id,
   username,
FROM
   user_account
WHERE
   is_admin = FALSE;


CREATE USER 'utilisateur'@'%' IDENTIFIED BY 'password';
CREATE USER 'admin'@'%' IDENTIFIED BY 'adminpassword';
GRANT SELECT, INSERT, UPDATE ON database.review TO 'utilisateur'@'%';
GRANT SELECT, INSERT, UPDATE ON database.user_account TO 'utilisateur'@'%';
GRANT SELECT, INSERT, UPDATE ON database.watchlist TO 'utilisateur'@'%';
GRANT SELECT, INSERT, UPDATE ON database.friendship TO 'utilisateur'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE on *.* TO 'admin'@'%';