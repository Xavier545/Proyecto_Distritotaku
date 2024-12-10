-- Crear la tabla USER si no existe
CREATE TABLE IF NOT EXISTS USER (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    nickname VARCHAR(30) NOT NULL,
    rol VARCHAR(30) NOT NULL,
    pw VARCHAR(50) NOT NULL
);

-- Insertar usuarios si la tabla está vacía
INSERT INTO USER (firstname, lastname, nickname, rol, pw) VALUES
('Adrian', 'Callejas', 'carcaj', 'admin', 'cisco'),
('Gabriel', 'Silva', 'grubusp', 'user', 'cisco'),
('Laura', 'Ventis', 'Lyra', 'user', 'cisco'),
('Juan', 'Cortinas', 'Kaox', 'user', 'cisco');