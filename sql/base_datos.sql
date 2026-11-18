CREATE DATABASE IF NOT EXISTS carrito_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE carrito_bd;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS productos;
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    existencias INT NOT NULL DEFAULT 0
);

INSERT INTO productos (nombre, descripcion, precio, existencias) VALUES
('Laptop HP 15"', 'Laptop con procesador Intel Core i5, 8GB RAM, 512GB SSD', 850.00, 10),
('Mouse Inalámbrico Logitech', 'Mouse ergonómico con conexión USB', 25.50, 50),
('Teclado Mecánico Redragon', 'Teclado mecánico RGB con switches azules', 65.00, 30),
('Monitor Samsung 24"', 'Monitor Full HD con panel IPS', 180.00, 15),
('Auriculares Sony WH-1000XM4', 'Auriculares con cancelación de ruido', 299.99, 8),
('Webcam Logitech C920', 'Cámara web Full HD 1080p', 75.00, 20);