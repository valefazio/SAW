--MONSTERS
CREATE TABLE IF NOT EXISTS users (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reviews INT NOT NULL DEFAULT 0 CHECK (reviews >= 0 AND reviews <= 5),
	remember_token VARCHAR(255) NULL,
	remember_token_created_at TIMESTAMP NULL,
    profile_picture BLOB NULL
);
CREATE TABLE IF NOT EXISTS kids (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NULL,
    profile_picture BLOB NULL
);
CREATE TABLE IF NOT EXISTS countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS doors (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    address VARCHAR(255) NOT NULL,
    country INT NOT NULL,
    kid INT NOT NULL,
    door_pic BLOB NULL,
    
    FOREIGN KEY (kid) REFERENCES kids(id) ON DELETE CASCADE,
    FOREIGN KEY (country) REFERENCES countries(id)
);
CREATE TABLE room_pics (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    filepath LONGBLOB NOT NULL,
    FOREIGN KEY (house_id) REFERENCES doors(room_id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS calendar (
    date DATE NOT NULL,
    door INT NOT NULL,
    monster VARCHAR(255) NOT NULL,
    PRIMARY KEY (date, door, monster),
    FOREIGN KEY (monster) REFERENCES users(email) ON DELETE CASCADE,
    FOREIGN KEY (door) REFERENCES doors(id) ON DELETE CASCADE
);

INSERT INTO countries (name) VALUES ('Spain');
INSERT INTO countries (name) VALUES ('France');
INSERT INTO countries (name) VALUES ('Germany');
INSERT INTO countries (name) VALUES ('Italy');
INSERT INTO countries (name) VALUES ('United Kingdom');
INSERT INTO countries (name) VALUES ('United States');
INSERT INTO countries (name) VALUES ('Canada');
INSERT INTO countries (name) VALUES ('Mexico');
INSERT INTO countries (name) VALUES ('Brazil');
INSERT INTO countries (name) VALUES ('Argentina');

INSERT INTO kids (name, phone) VALUES ('John Doe', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Doe', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Smith', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Smith', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Johnson', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Johnson', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Williams', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Williams', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Brown', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Brown', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Davis', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Davis', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Miller', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Miller', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Wilson', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Wilson', '987654321');
INSERT INTO kids (name, phone) VALUES ('John Moore', '123456789');
INSERT INTO kids (name, phone) VALUES ('Jane Moore', '987654321');

INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 1', 'This is the first door', 'Calle Falsa 123', 1, 1, 'door1.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 2', 'This is the second door', 'Calle Falsa 123', 1, 2, 'door2.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 3', 'This is the third door', 'Calle Falsa 123', 2, 3, 'door3.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 4', 'This is the fourth door', 'Calle Falsa 123', 2, 4, 'door4.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 5', 'This is the fifth door', 'Calle Falsa 123', 3, 5, 'door5.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 6', 'This is the sixth door', 'Calle Falsa 123', 3, 6, 'door6.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 7', 'This is the seventh door', 'Calle Falsa 123', 4, 7, 'door7.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 8', 'This is the eighth door', 'Calle Falsa 123', 4, 8, 'door8.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 9', 'This is the ninth door', 'Calle Falsa 123', 5, 9, 'door9.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 10', 'This is the tenth door', 'Calle Falsa 123', 5, 10, 'door10.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 11', 'This is the eleventh door', 'Calle Falsa 123', 6, 11, 'door11.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 12', 'This is the twelfth door', 'Calle Falsa 123', 6, 12, 'door12.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 13', 'This is the thirteenth door', 'Calle Falsa 123', 7, 13, 'door13.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 14', 'This is the fourteenth door', 'Calle Falsa 123', 7, 14, 'door14.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 15', 'This is the fifteenth door', 'Calle Falsa 123', 8, 15, 'door15.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 16', 'This is the sixteenth door', 'Calle Falsa 123', 8, 16, 'door16.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 17', 'This is the seventeenth door', 'Calle Falsa 123', 9, 17, 'door17.jpg');
INSERT INTO doors (name, description, address, country, kid, image_path) VALUES ('Door 18', 'This is the eighteenth door', 'Calle Falsa 123', 9, 18, 'door18.jpg');
