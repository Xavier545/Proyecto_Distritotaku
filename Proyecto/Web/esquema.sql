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