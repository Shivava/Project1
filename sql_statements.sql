-- Gemaakt door Furkan Uçar OITAOO8B
-- tabel account aanmaken.
CREATE TABLE account(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(250) NOT NULL UNIQUE,
    password VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel persoon aanmaken.
CREATE TABLE persoon(
    id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    username VARCHAR(250) NOT NULL,
    firstname VARCHAR(250) NOT NULL,
    middlename VARCHAR(250),
    lastname VARCHAR(250) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (account_id) REFERENCES account(id)
);
