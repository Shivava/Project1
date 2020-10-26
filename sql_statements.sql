-- Gemaakt door Furkan Uçar OITAOO8B
-- create new db
CREATE DATABASE project1;


-- tabel account aanmaken.
CREATE TABLE account(
    id INT NOT NULL AUTO_INCREMENT,
    usertype_id INT NOT NULL,
    username VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL UNIQUE,
    password VARCHAR(250) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(usertype_id) REFERENCES usertype(id)
);

-- tabel persoon aanmaken.
CREATE TABLE persoon(
    id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    firstname VARCHAR(250) NOT NULL,
    middlename VARCHAR(250),
    lastname VARCHAR(250) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(account_id) REFERENCES account(id)
);

-- tabel usertype aanmaken.
CREATE TABLE usertype(
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(250) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id)
);

-- insert entry into table account
INSERT INTO account VALUES (NULL, 'Kees', 'k.geldstraat@rocva.nl', 'admin')

-- create a variable and store id of matchin email (email=unique)
SET @V1 := (SELECT id FROM account WHERE email='k.geldstraat@rocva.nl');

-- insert enrty into persoon, use account_id from table account (@v1)
INSERT INTO persoon VALUES (null, @v1, 'kees', '', 'geldstraat');


ALTER TABLE account ADD username (VARCHAR(250) NOT NULL);
