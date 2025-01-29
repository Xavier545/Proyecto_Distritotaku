-- Crear la tabla USER si no existe
CREATE TABLE IF NOT EXISTS USER (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    nickname VARCHAR(30) NOT NULL,
    rol VARCHAR(30) NOT NULL,
    pw VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    address VARCHAR(100),
    postal_code VARCHAR(10),
    city VARCHAR(30),
    birthdate DATE
);

-- Insertar usuarios si la tabla está vacía
INSERT INTO USER (firstname, lastname, nickname, rol, pw, email, address, postal_code, city, birthdate) VALUES
('Adrian', 'Callejas', 'carcaj', 'admin', 'cisco', 'adrian@example.com', 'Calle Falsa 123', '12345', 'Ciudad Falsa', '1990-01-01'),
('Gabriel', 'Silva', 'grubusp', 'user', 'cisco', 'gabriel@example.com', 'Avenida Siempre Viva 742', '54321', 'Springfield', '1992-02-02'),
('Laura', 'Ventis', 'Lyra', 'user', 'cisco', 'laura@example.com', 'Calle de la Paz 456', '67890', 'Madrid', '1995-03-03'),
('Juan', 'Cortinas', 'Kaox', 'user', 'cisco', 'juan@example.com', 'Calle del Sol 789', '13579', 'Barcelona', '1988-04-04');

-- Crear la tabla CATEGORY si no existe
CREATE TABLE IF NOT EXISTS CATEGORY (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar las categorías "Camiseta" y "Figura de Anime" si la tabla está vacía
INSERT IGNORE INTO CATEGORY (name) VALUES
('Figura de Anime'),
('Camiseta');

-- Crear la tabla PRODUCT si no existe
CREATE TABLE IF NOT EXISTS PRODUCT (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    category_id INT(6) UNSIGNED,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    description TEXT,
    manufacturer VARCHAR(50),
    release_date DATE,
    image_url VARCHAR(255),
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES CATEGORY(id)
);

-- Insertar productos si la tabla está vacía
INSERT INTO PRODUCT (name, category_id, price, stock, description, manufacturer, release_date, image_url) VALUES
('Figura Goku Super Saiyan', (SELECT id FROM CATEGORY WHERE name = 'Figura de Anime'), 29.99, 50, 'Figura de Goku transformado en Super Saiyan.', 'Bandai', '2021-01-15', 'images/goku_bicicleta.png'),
('Figura Naruto Uzumaki', (SELECT id FROM CATEGORY WHERE name = 'Figura de Anime'), 24.99, 30, 'Figura de Naruto Uzumaki con su traje clásico.', 'Banpresto', '2020-11-10', 'images/naruto_niño.png'),
('Figura Luffy Gear 4', (SELECT id FROM CATEGORY WHERE name = 'Figura de Anime'), 34.99, 20, 'Figura de Monkey D. Luffy en su modo Gear 4.', 'Megahouse', '2022-03-20', 'images/luffy_gear_five.png'),
('Figura Mikasa Ackerman', (SELECT id FROM CATEGORY WHERE name = 'Figura de Anime'), 39.99, 15, 'Figura de Mikasa con su equipo de maniobras.', 'Good Smile Company', '2021-08-05', 'images/mikasa.png'),
('Figura Asuka Langley', (SELECT id FROM CATEGORY WHERE name = 'Figura de Anime'), 44.99, 10, 'Figura de Asuka Langley en su plug suit.', 'Kotobukiya', '2019-12-25', 'images/asuka.png');
