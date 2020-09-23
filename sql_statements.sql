-- Gemaakt door Furkan Uçar OITAOO8B
-- tabel account aanmaken.
create table account(
    id int not null AUTO_INCREMENT,
    email varchar(250) not null UNIQUE,
    password varchar(250) not null,
    primary key(id)
);

-- tabel persoon aanmaken.
create table persoon(
    id int not null AUTO_INCREMENT,
    account_id int NOT NULL,
    username varchar(250) NOT NULL,
    firstname varchar(250) NOT NULL,
    middlename varchar(250),
    lastname varchar(250) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (account_id) REFERENCES account(id)
);
