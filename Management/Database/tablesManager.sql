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
    birthDate DATE NULL,
    profile_picture_path VARCHAR(255) NULL
);
CREATE TABLE IF NOT EXISTS countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS doors (
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL PRIMARY KEY,
    country INT NOT NULL,
    door_picture_path VARCHAR(255) NULL,
    reviews FLOAT NULL CHECK (reviews >= 0.0 AND reviews <= 5.0),   
    FOREIGN KEY (country) REFERENCES countries(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS doors_id (
    address VARCHAR(255) NOT NULL, 
    id INT NULL AUTO_INCREMENT PRIMARY KEY,
    FOREIGN KEY (address) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);
DELIMITER //
CREATE TRIGGER add_door_id_trigger
AFTER INSERT ON doors
FOR EACH ROW
BEGIN
    INSERT INTO doors_id (address) VALUES (NEW.address);
END;
//
DELIMITER ;

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

CREATE TABLE IF NOT EXISTS scaredOf (
    scare VARCHAR(255),
    kid INT NOT NULL,
    PRIMARY KEY (scare, kid),
    FOREIGN KEY (kid) REFERENCES kids(id) ON DELETE CASCADE ON UPDATE CASCADE
);
DELIMITER //
CREATE TRIGGER check_scaredOf_limit
BEFORE INSERT ON scaredOf
FOR EACH ROW
BEGIN
    DECLARE num_fears INT;
    SET num_fears = (SELECT COUNT(*) FROM scaredOf WHERE kid = NEW.kid);
    
    IF num_fears >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot insert more than 5 fears for a kid';
    END IF;
END //
DELIMITER ;

CREATE TABLE IF NOT EXISTS reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    review_date DATE DEFAULT CURRENT_TIMESTAMP,
    booking_date DATE,
    door VARCHAR(255) NOT NULL,
    monster VARCHAR(255) NOT NULL,
    review INT NOT NULL CHECK (review >= 0.0 AND review <= 5.0),
    review_text TEXT NULL,
    FOREIGN KEY (monster) REFERENCES users(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (door) REFERENCES doors(address) ON DELETE CASCADE ON UPDATE CASCADE
);
DELIMITER //
CREATE TRIGGER check_effective_booking_before_review
BEFORE INSERT ON reviews
FOR EACH ROW
BEGIN
    DECLARE count_reviews INT;
    
    -- Check if there is a previous booking in the calendar table for the same door and monster
    -- and if the booking date is before today
    SELECT COUNT(*) INTO count_reviews 
    FROM calendar 
    WHERE door = NEW.door 
    AND monster = NEW.monster 
    AND date < CURDATE();
    
    -- If no previous booking exists or all bookings are after today, raise an error
    IF count_reviews = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot insert review. No previous booking exists in the calendar table or all bookings are for future dates.';
    END IF;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER update_reviews_trigger AFTER INSERT ON reviews
FOR EACH ROW
BEGIN
    UPDATE doors
    SET reviews = (
        SELECT AVG(review)
        FROM reviews
        WHERE door = NEW.door
    )
    WHERE address = NEW.door;
END//
DELIMITER ;


INSERT INTO countries (name) VALUES ('Spain');
INSERT INTO countries (name) VALUES ('France');
INSERT INTO countries (name) VALUES ('Germany');
INSERT INTO countries (name) VALUES ('Italy');
INSERT INTO countries (name) VALUES ('United Kingdom');
INSERT INTO countries (name) VALUES ('United States');
INSERT INTO countries (name) VALUES ('Canada');
INSERT INTO countries (name) VALUES ('Mexico');

INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Alice', '2015-03-21', 'Management/Images/kids/alice.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Boo', '2011-11-05', 'Management/Images/kids/boo.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Charlie', '2010-09-17', 'Management/Images/kids/charlie.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Daisy', '2012-05-30', 'Management/Images/kids/daisy.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Eva', '2014-07-08', 'Management/Images/kids/eva.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Finn', '2013-01-14', 'Management/Images/kids/finn.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Gina', '2010-12-02', 'Management/Images/kids/gina.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Hugo', '2011-08-26', 'Management/Images/kids/hugo.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Ivy', '2012-10-09', 'Management/Images/kids/ivy.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Jack', '2014-04-18', 'Management/Images/kids/jack.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Katie', '2013-06-25', 'Management/Images/kids/katie.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Liam', '2010-02-07', 'Management/Images/kids/liam.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Mia', '2011-10-31', 'Management/Images/kids/mia.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Noah', '2013-09-10', 'Management/Images/kids/noah.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Olivia', '2014-12-28', 'Management/Images/kids/olivia.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Parker', '2012-08-14', 'Management/Images/kids/parker.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Quinn', '2010-06-03', 'Management/Images/kids/quinn.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Ryan', '2011-03-17', 'Management/Images/kids/ryan.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Sophia', '2014-02-22', 'Management/Images/kids/sophia.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Thomas', '2013-07-05', 'Management/Images/kids/thomas.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Uma', '2012-11-11', 'Management/Images/kids/uma.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Violet', '2010-09-03', 'Management/Images/kids/violet.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('William', '2011-05-19', 'Management/Images/kids/william.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Xavier', '2014-06-27', 'Management/Images/kids/xavier.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Yara', '2013-04-09', 'Management/Images/kids/yara.jpg');
INSERT INTO kids (name, birthDate, profile_picture_path) VALUES ('Zane', '2010-01-01', 'Management/Images/kids/zane.jpg');

INSERT INTO scaredOf (scare, kid) VALUES ('Orc', 2);
INSERT INTO scaredOf (scare, kid) VALUES ('Troll', 3);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 3);
INSERT INTO scaredOf (scare, kid) VALUES ('Clown', 4);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 4);
INSERT INTO scaredOf (scare, kid) VALUES ('Wolfs', 4);
INSERT INTO scaredOf (scare, kid) VALUES ('Ghosts', 5);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 5);
INSERT INTO scaredOf (scare, kid) VALUES ('Zombies', 5);
INSERT INTO scaredOf (scare, kid) VALUES ('Spiders', 5);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 6);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 6);
INSERT INTO scaredOf (scare, kid) VALUES ('Dad', 6);
INSERT INTO scaredOf (scare, kid) VALUES ('Clowns', 6);
INSERT INTO scaredOf (scare, kid) VALUES ('Aunt', 6);
INSERT INTO scaredOf (scare, kid) VALUES ('Wolfs', 8);
INSERT INTO scaredOf (scare, kid) VALUES ('Dogs', 8);
INSERT INTO scaredOf (scare, kid) VALUES ('Ghosts', 9);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 9);
INSERT INTO scaredOf (scare, kid) VALUES ('Aunt', 9);
INSERT INTO scaredOf (scare, kid) VALUES ('Sun', 10);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 10);
INSERT INTO scaredOf (scare, kid) VALUES ('Clown', 10);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 11);
INSERT INTO scaredOf (scare, kid) VALUES ('Spiders', 11);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 11);
INSERT INTO scaredOf (scare, kid) VALUES ('Orc', 12);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 12);
INSERT INTO scaredOf (scare, kid) VALUES ('Troll', 13);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 13);
INSERT INTO scaredOf (scare, kid) VALUES ('Ghosts', 14);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 14);
INSERT INTO scaredOf (scare, kid) VALUES ('Zombies', 15);
INSERT INTO scaredOf (scare, kid) VALUES ('Spiders', 15);
INSERT INTO scaredOf (scare, kid) VALUES ('Wolfs', 15);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 15);
INSERT INTO scaredOf (scare, kid) VALUES ('Ghosts', 16);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 16);
INSERT INTO scaredOf (scare, kid) VALUES ('Zombies', 16);
INSERT INTO scaredOf (scare, kid) VALUES ('Spiders', 16);
INSERT INTO scaredOf (scare, kid) VALUES ('Clown', 16);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 18);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 18);
INSERT INTO scaredOf (scare, kid) VALUES ('Aunt', 18);
INSERT INTO scaredOf (scare, kid) VALUES ('Snakes', 18);
INSERT INTO scaredOf (scare, kid) VALUES ('Sun', 19);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 19);
INSERT INTO scaredOf (scare, kid) VALUES ('Clown', 19);
INSERT INTO scaredOf (scare, kid) VALUES ('Dad', 20);
INSERT INTO scaredOf (scare, kid) VALUES ('Heights', 20);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 21);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 21);
INSERT INTO scaredOf (scare, kid) VALUES ('Aunt', 22);
INSERT INTO scaredOf (scare, kid) VALUES ('Snakes', 22);
INSERT INTO scaredOf (scare, kid) VALUES ('Sun', 23);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 23);
INSERT INTO scaredOf (scare, kid) VALUES ('Clown', 24);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 24);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 24);
INSERT INTO scaredOf (scare, kid) VALUES ('Dad', 25);
INSERT INTO scaredOf (scare, kid) VALUES ('Clowns', 25);
INSERT INTO scaredOf (scare, kid) VALUES ('Goblin', 25);
INSERT INTO scaredOf (scare, kid) VALUES ('Spiders', 25);
INSERT INTO scaredOf (scare, kid) VALUES ('Dark', 25);
INSERT INTO scaredOf (scare, kid) VALUES ('Aunt', 26);
INSERT INTO scaredOf (scare, kid) VALUES ('Heights', 26);

INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Princess', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 1, 'Management/Images/doors/door1.jpg', 4.5);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Pirate', 'Rue du Pirate, 1, 75001 Paris, France', 2, 'Management/Images/doors/door2.jpg', 4.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Knight', 'Ritterstraße, 1, 10178 Berlin, Germany', 3, 'Management/Images/doors/door3.jpg', 3.5);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Prince', 'Via della Principessa, 1, 00100 Roma, Italy', 4, 'Management/Images/doors/door4.jpg', 3.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Queen', 'Queen Street, 1, London W1B 5PW, United Kingdom', 5, 'Management/Images/doors/door5.jpg', 2.5);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('King', '1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 6, 'Management/Images/doors/door6.jpg', 2.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Dragon', '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 7, 'Management/Images/doors/door7.jpg', 1.5);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Unicorn', 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 8, 'Management/Images/doors/door8.jpg', 1.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Mermaid', 'Calle de la Sirena, 2, 28008 Madrid, Spain', 1, 'Management/Images/doors/door9.jpg', 0.5);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Fairy', 'Rue de la Fée, 2, 75001 Paris, France', 2, 'Management/Images/doors/door10.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Elf', 'Ritterstraße, 2, 10178 Berlin, Germany', 3, 'Management/Images/doors/door11.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Goblin', 'Via della Principessa, 2, 00100 Roma, Italy', 4, 'Management/Images/doors/door12.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Orc', 'Queen Street, 2, London W1B 5PW, United Kingdom', 5, 'Management/Images/doors/door13.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Troll', '1601 Pennsylvania Ave NW, Washington, DC 20500, United States', 6, 'Management/Images/doors/door14.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Witch', '112 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 7, 'Management/Images/doors/door15.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Wizard', 'Paseo de la Reforma, 2, 06000 Ciudad de México, CDMX, Mexico', 8, 'Management/Images/doors/door16.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Sorcerer', 'Calle de la Sirena, 3, 28008 Madrid, Spain', 1, 'Management/Images/doors/door17.jpg', 0.0);
INSERT INTO doors (name, address, country, door_picture_path, reviews) VALUES ('Warlock', 'Rue de la Fée, 3, 75001 Paris, France', 2, 'Management/Images/doors/door18.jpg', 0.0);

INSERT INTO room_pics (room_id, filename) VALUES ('Calle de la Princesa, 1, 28008 Madrid, Spain', 'Management/Images/rooms/11_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Rue du Pirate, 1, 75001 Paris, France', 'Management/Images/rooms/9_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Ritterstraße, 1, 10178 Berlin, Germany', 'Management/Images/rooms/6_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Via della Principessa, 1, 00100 Roma, Italy', 'Management/Images/rooms/10_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Queen Street, 1, London W1B 5PW, United Kingdom', 'Management/Images/rooms/12_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 'Management/Images/rooms/5_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 'Management/Images/rooms/1_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 'Management/Images/rooms/15_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Calle de la Sirena, 2, 28008 Madrid, Spain', 'Management/Images/rooms/7_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Rue de la Fée, 2, 75001 Paris, France', 'Management/Images/rooms/3_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Ritterstraße, 2, 10178 Berlin, Germany', 'Management/Images/rooms/2_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Via della Principessa, 2, 00100 Roma, Italy', 'Management/Images/rooms/4_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Queen Street, 2, London W1B 5PW, United Kingdom', 'Management/Images/rooms/8_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('1601 Pennsylvania Ave NW, Washington, DC 20500, United States', 'Management/Images/rooms/14_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('112 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 'Management/Images/rooms/17_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Paseo de la Reforma, 2, 06000 Ciudad de México, CDMX, Mexico', 'Management/Images/rooms/18_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Calle de la Sirena, 3, 28008 Madrid, Spain', 'Management/Images/rooms/13_1.jpg');
INSERT INTO room_pics (room_id, filename) VALUES ('Rue de la Fée, 3, 75001 Paris, France', 'Management/Images/rooms/16_1.jpg');

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



INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-01', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-01', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-01', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2025-01-01', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-02', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-03', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-04', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-05', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-06', 'Queen Street, 1, London W1B 5PW, United Kingdom', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-07', '1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-08', '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-09', 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-10', 'Calle de la Sirena, 2, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-04-11', 'Rue de la Fée, 2, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);

INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-01', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-01', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-01', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2025-05-01', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-02', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-03', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-04', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-05', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-06', 'Queen Street, 1, London W1B 5PW, United Kingdom', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-07', '1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-08', '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-09', 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-10', 'Calle de la Sirena, 2, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-11', 'Rue de la Fée, 2, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-22', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-28', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-30', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2025-05-21', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-27', 'Calle de la Princesa, 1, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-22', 'Rue du Pirate, 1, 75001 Paris, France', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-25', 'Ritterstraße, 1, 10178 Berlin, Germany', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-27', 'Via della Principessa, 1, 00100 Roma, Italy', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-28', 'Queen Street, 1, London W1B 5PW, United Kingdom', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-21', '1600 Pennsylvania Ave NW, Washington, DC 20500, United States', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-19', '111 Sussex Dr, Ottawa, ON K1A 0A1, Canada', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-17', 'Paseo de la Reforma, 1, 06000 Ciudad de México, CDMX, Mexico', 'vale@gmail.com', NULL, NULL);
INSERT INTO calendar (date, door, monster, review, review_text) VALUES ('2024-05-15', 'Calle de la Sirena, 2, 28008 Madrid, Spain', 'vale@gmail.com', NULL, NULL);
