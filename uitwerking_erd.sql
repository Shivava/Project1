CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id)
);

CREATE TABLE authors(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id)
);

CREATE TABLE books(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    publishing_year VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id),
    FOREIGN KEY(author_id) REFERENCES authors(id)
);

CREATE TABLE favourites(
    id INT NOT NULL AUTO_INCREMENT
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(book_id) REFERENCES books(id)
);
