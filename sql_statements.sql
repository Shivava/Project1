-- Gemaakt door Furkan Uçar OITAOO8B 
-- tabel account aanmaken.
create table account(
id int not null AUTO_INCREMENT,
email varchar(250) UNIQUE,
password varchar(250),
primary key(id)
);

-- tabel persoon aanmaken.
create table persoon(
id int not null AUTO_INCREMENT,
username varchar(250),
primary key(id),
FOREIGN KEY (id) REFERENCES account(id)
);
