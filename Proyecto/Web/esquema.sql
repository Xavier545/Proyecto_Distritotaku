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

-- Crear la tabla PRODUCT si no existe
CREATE TABLE IF NOT EXISTS PRODUCT (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    category VARCHAR(30) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    description TEXT,
    manufacturer VARCHAR(50),
    release_date DATE
);

ALTER TABLE PRODUCT ADD COLUMN image_url VARCHAR(255);


-- Insertar productos si la tabla está vacía
INSERT INTO PRODUCT (name, category, price, stock, description, manufacturer, release_date, image_url) VALUES
('Figura Goku Super Saiyan', 'Anime Figure', 29.99, 50, 'Figura de Goku transformado en Super Saiyan.', 'Bandai', '2021-01-15', 'images/goku_bicicleta.png'),
('Figura Naruto Uzumaki', 'Anime Figure', 24.99, 30, 'Figura de Naruto Uzumaki con su traje clásico.', 'Banpresto', '2020-11-10', 'images/naruto_niño.png'),
('Figura Luffy Gear 4', 'Anime Figure', 34.99, 20, 'Figura de Monkey D. Luffy en su modo Gear 4.', 'Megahouse', '2022-03-20', 'images/luffy_gear_five.png'),
('Figura Mikasa Ackerman', 'Anime Figure', 39.99, 15, 'Figura de Mikasa con su equipo de maniobras.', 'Good Smile Company', '2021-08-05', 'images/mikasa.png'),
('Figura Asuka Langley', 'Anime Figure', 44.99, 10, 'Figura de Asuka Langley en su plug suit.', 'Kotobukiya', '2019-12-25', 'images/asuka.png');

