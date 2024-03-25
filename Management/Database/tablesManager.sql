CREATE TABLE IF NOT EXISTS users (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reviews FLOAT NOT NULL DEFAULT 0 CHECK (reviews >= 0.0 AND reviews <= 5.0),
	remember_token VARCHAR(255) NULL,
	remember_token_created_at TIMESTAMP NULL,
    profile_picture MEDIUMBLOB NULL
);
CREATE TABLE IF NOT EXISTS kids (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NULL,
    profile_picture_path VARCHAR(255) NULL, 
    scaredOf VARCHAR(500) NULL
);
CREATE TABLE IF NOT EXISTS countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS doors (
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    address VARCHAR(255) NOT NULL PRIMARY KEY,
    country INT NOT NULL,
    door_picture_path VARCHAR(255) NULL,
    reviews FLOAT NULL CHECK (reviews >= 0.0 AND reviews <= 5.0),   
    FOREIGN KEY (country) REFERENCES countries(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS room_pics (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    room_id VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    profile_picture_path VARCHAR(255) NULL,
    FOREIGN KEY (room_id) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS resides (
    kid INT NOT NULL,
    door VARCHAR(255) NOT NULL,
    PRIMARY KEY (kid, door),
    FOREIGN KEY (kid) REFERENCES kids(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (door) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS calendar (
    date DATE NOT NULL,
    door VARCHAR(255) NOT NULL,
    monster VARCHAR(255) NOT NULL,
    review FLOAT NULL CHECK (review >= 0.0 AND review <= 5.0),
    review_text TEXT NULL,
    PRIMARY KEY (date, door, monster),
    FOREIGN KEY (monster) REFERENCES users(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (door) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS preferites (
    monster VARCHAR(255) NOT NULL,
    door VARCHAR(255) NOT NULL,
    PRIMARY KEY (monster, door),
    FOREIGN KEY (monster) REFERENCES users(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (door) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);



INSERT INTO countries (name) VALUES ('Spain');
INSERT INTO countries (name) VALUES ('France');
INSERT INTO countries (name) VALUES ('Germany');
INSERT INTO countries (name) VALUES ('Italy');
INSERT INTO countries (name) VALUES ('United Kingdom');
INSERT INTO countries (name) VALUES ('United States');
INSERT INTO countries (name) VALUES ('Canada');
INSERT INTO countries (name) VALUES ('Mexico');

INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Alice', '1234567890', 'Management/Images/kids/alice.jpg', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Boo', '1234567890', 'Management/Images/kids/boo.jpg', 'Orc, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Charlie', '1234567890', 'Management/Images/kids/charlie.jpg', 'Troll, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Daisy', '1234567890', 'Management/Images/kids/daisy.jpg', 'Clown, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Eva', '1234567890', 'Management/Images/kids/eva.jpg', 'Wolfs');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Finn', '1234567890', 'Management/Images/kids/finn.jpg', 'Ghosts, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Gina', '1234567890', 'Management/Images/kids/gina.jpg', 'Zombies, Spiders');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Hugo', '1234567890', 'Management/Images/kids/hugo.jpg', 'Wolfs, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Ivy', '1234567890', 'Management/Images/kids/ivy.jpg', 'Ghosts, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Jack', '1234567890', 'Management/Images/kids/jack.jpg', 'Zombies, Spiders');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Katie', '1234567890', 'Management/Images/kids/katie.jpg', 'Clown, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Liam', '1234567890', 'Management/Images/kids/liam.jpg', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Mia', '1234567890', 'Management/Images/kids/mia.jpg', 'Orc, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Noah', '1234567890', 'Management/Images/kids/noah.jpg', 'Troll, Dad ');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Olivia', '1234567890', 'Management/Images/kids/olivia.jpg', 'Clown, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Parker', '1234567890', 'Management/Images/kids/parker.jpg', 'Wolfs');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Quinn', '1234567890', 'Management/Images/kids/quinn.jpg', 'Cats, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Ryan', '1234567890', 'Management/Images/kids/ryan.jpg', 'Zombies, Spiders');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Sophia', '1234567890', 'Management/Images/kids/sophia.jpg', 'Wolfs, Dogs');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Thomas', '1234567890', 'Management/Images/kids/thomas.jpg', 'Ghosts, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Uma', '1234567890', 'Management/Images/kids/uma.jpg', 'Zombies, Spiders');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Violet', '1234567890', 'Management/Images/kids/violet.jpg', 'Clown, His aunt');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('William', '1234567890', 'Management/Images/kids/william.jpg', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Xavier', '1234567890', 'Management/Images/kids/xavier.jpg', 'Orc, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Yara', '1234567890', 'Management/Images/kids/yara.jpg', '');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Zane', '1234567890', 'Management/Images/kids/zane.jpg', 'Clown, Dark');
/* INSERT INTO kids (name, phone, scaredOf) VALUES ('Alice', '1234567890', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, profile_picture_path, scaredOf) VALUES ('Boo', '1234567890', 'Management/Images/kids/boo.jpg', 'Orc, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Charlie', '1234567890', 'Troll, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Daisy', '1234567890', 'Clown, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Eva', '1234567890', 'Wolfs');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Finn', '1234567890', 'Ghosts, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Gina', '1234567890', 'Zombies, Spiders');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Hugo', '1234567890', 'Wolfs, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Ivy', '1234567890', 'Ghosts, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Jack', '1234567890', 'Zombies, Spiders');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Katie', '1234567890', 'Clown, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Liam', '1234567890', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Mia', '1234567890', 'Orc, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Noah', '1234567890', 'Troll, Dad ');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Olivia', '1234567890', 'Clown, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Parker', '1234567890', 'Wolfs');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Quinn', '1234567890', 'Cats, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Ryan', '1234567890', 'Zombies, Spiders');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Sophia', '1234567890', 'Wolfs, Dogs');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Thomas', '1234567890', 'Ghosts, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Uma', '1234567890', 'Zombies, Spiders');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Violet', '1234567890', 'Clown, His aunt');
INSERT INTO kids (name, phone, scaredOf) VALUES ('William', '1234567890', 'Goblin, Spiders, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Xavier', '1234567890', 'Orc, Dark');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Yara', '1234567890', '');
INSERT INTO kids (name, phone, scaredOf) VALUES ('Zane', '1234567890', 'Clown, Dark'); */


INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Princess', 'Stanza Principessa tutta rosa', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 1, 'Management/Images/doors/door1.jpg', 4.5);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Pirate', 'Stanza Pirata tutta nera', 'Rue du Pirate, 1, 75001 Paris, France', 2, 'Management/Images/doors/door2.jpg', 4.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Knight', 'Stanza Cavaliere tutta grigia', 'Ritterstraße, 1, 10178 Berlin, Germany', 3, 'Management/Images/doors/door3.jpg', 3.5);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Prince', 'Stanza Principe tutta azzurra', 'Via della Principessa, 1, 00100 Roma, Italy', 4, 'Management/Images/doors/door4.jpg', 3.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Queen', 'Stanza Regina tutta viola', 'Queen Street, 1, London W1B 5PW, United Kingdom', 5, 'Management/Images/doors/door5.jpg', 2.5);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('King', 'Stanza Re tutta gialla', '1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 6, 'Management/Images/doors/door6.jpg', 2.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Dragon', 'Stanza Drago tutta rossa', '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 7, 'Management/Images/doors/door7.jpg', 1.5);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Unicorn', 'Stanza Unicorno multicolor', 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 8, 'Management/Images/doors/door8.jpg', 1.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Mermaid', 'Stanza Sirena tutta azzurra', 'Calle de la Sirena, 2, 28008 Madrid, Spain', 1, 'Management/Images/doors/door9.jpg', 0.5);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Fairy', 'Stanza Fata tutta verde', 'Rue de la Fée, 2, 75001 Paris, France', 2, 'Management/Images/doors/door10.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Elf', 'Stanza Elfo tutta marrone', 'Ritterstraße, 2, 10178 Berlin, Germany', 3, 'Management/Images/doors/door11.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Goblin', 'Stanza Goblin tutta grigia', 'Via della Principessa, 2, 00100 Roma, Italy', 4, 'Management/Images/doors/door12.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Orc', 'Stanza Orco tutta nera', 'Queen Street, 2, London W1B 5PW, United Kingdom', 5, 'Management/Images/doors/door13.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Troll', 'Stanza Troll tutta marrone', '1601 Pennsylvania Ave NW, Washington, DC 20500, United States', 6, 'Management/Images/doors/door14.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Witch', 'Stanza Strega tutta viola', '112 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 7, 'Management/Images/doors/door15.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Wizard', 'Stanza Mago tutta blu', 'Paseo de la Reforma, 2, 06000 Ciudad de México, CDMX, Mexico', 8, 'Management/Images/doors/door16.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Sorcerer', 'Stanza Stregone tutta nera', 'Calle de la Sirena, 3, 28008 Madrid, Spain', 1, 'Management/Images/doors/door17.jpg', 0.0);
INSERT INTO doors (name, description, address, country, door_picture_path, reviews) VALUES ('Warlock', 'Stanza Mago Nero tutta nera', 'Rue de la Fée, 3, 75001 Paris, France', 2, 'Management/Images/doors/door18.jpg', 0.0);

INSERT INTO resides (kid, door) VALUES (1, 'Calle de la Princesa, 1, 28008 Madrid, Spain');
INSERT INTO resides (kid, door) VALUES (2, 'Calle de la Princesa, 1, 28008 Madrid, Spain');
INSERT INTO resides (kid, door) VALUES (3, 'Rue du Pirate, 1, 75001 Paris, France');
INSERT INTO resides (kid, door) VALUES (4, 'Rue du Pirate, 1, 75001 Paris, France');
INSERT INTO resides (kid, door) VALUES (5, 'Ritterstraße, 1, 10178 Berlin, Germany');
INSERT INTO resides (kid, door) VALUES (6, 'Via della Principessa, 1, 00100 Roma, Italy');
INSERT INTO resides (kid, door) VALUES (7, 'Queen Street, 1, London W1B 5PW, United Kingdom');
INSERT INTO resides (kid, door) VALUES (8, '1600 Pennsylvania Ave NW, Washington, DC 20500, United States');
INSERT INTO resides (kid, door) VALUES (9, '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada');
INSERT INTO resides (kid, door) VALUES (10, 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico');
INSERT INTO resides (kid, door) VALUES (11, 'Calle de la Sirena, 2, 28008 Madrid, Spain');
INSERT INTO resides (kid, door) VALUES (12, 'Rue de la Fée, 2, 75001 Paris, France');
INSERT INTO resides (kid, door) VALUES (13, 'Ritterstraße, 2, 10178 Berlin, Germany');
INSERT INTO resides (kid, door) VALUES (14, 'Via della Principessa, 2, 00100 Roma, Italy');
INSERT INTO resides (kid, door) VALUES (15, 'Queen Street, 2, London W1B 5PW, United Kingdom');
INSERT INTO resides (kid, door) VALUES (16, '1601 Pennsylvania Ave NW, Washington, DC 20500, United States');
INSERT INTO resides (kid, door) VALUES (17, '112 Sussex Dr, Ottawa, ON K1A 0A1, Canada');
INSERT INTO resides (kid, door) VALUES (18, 'Paseo de la Reforma, 2, 06000 Ciudad de México, CDMX, Mexico');
INSERT INTO resides (kid, door) VALUES (19, 'Calle de la Sirena, 3, 28008 Madrid, Spain');
INSERT INTO resides (kid, door) VALUES (20, 'Rue de la Fée, 3, 75001 Paris, France');
INSERT INTO resides (kid, door) VALUES (21, 'Queen Street, 2, London W1B 5PW, United Kingdom');
INSERT INTO resides (kid, door) VALUES (22, '1601 Pennsylvania Ave NW, Washington, DC 20500, United States');
INSERT INTO resides (kid, door) VALUES (23, '112 Sussex Dr, Ottawa, ON K1A 0A1, Canada');
INSERT INTO resides (kid, door) VALUES (24, 'Paseo de la Reforma, 2, 06000 Ciudad de México, CDMX, Mexico');
INSERT INTO resides (kid, door) VALUES (25, 'Calle de la Sirena, 3, 28008 Madrid, Spain');




INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2021-01-01', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale.fazio.2002@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2021-01-01', 'Rue du Pirate, 1, 75001 Paris, France', 'vale.fazio.2002@gmail.com', NULL, NULL);
