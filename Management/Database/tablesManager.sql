--MONSTERS
CREATE TABLE IF NOT EXISTS users (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    --admin BOOLEAN NOT NULL DEFAULT FALSE,
    reviews INT NOT NULL DEFAULT 0 CHECK (reviews >= 0 AND reviews <= 5),
	remember_token VARCHAR(255) NULL,
	remember_token_created_at TIMESTAMP NULL,
    profile_picture_path VARCHAR(255) NULL
);
--CHILDREN
CREATE TABLE IF NOT EXISTS owners (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    profile_picture_path VARCHAR(255) NULL
);
--COUNTRIES
CREATE TABLE IF NOT EXISTS countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
--DOORS/HOUSES
CREATE TABLE IF NOT EXISTS doors (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    address VARCHAR(255) NOT NULL,
    country INT NOT NULL,
    owner VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NULL,
    FOREIGN KEY (owner) REFERENCES owners(id),
    FOREIGN KEY (country) REFERENCES countries(id)
);
--CALENDAR
CREATE TABLE IF NOT EXISTS calendar (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    notes TEXT NULL,
    door INT NOT NULL,
    monster VARCHAR(255) NOT NULL,
    FOREIGN KEY (monster) REFERENCES users(email),
    FOREIGN KEY (door) REFERENCES doors(id)
);