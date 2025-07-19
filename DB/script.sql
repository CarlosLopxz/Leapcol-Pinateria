-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS pinateria;

-- Usar la base de datos
USE pinateria;

-- Tabla de roles
CREATE TABLE IF NOT EXISTS roles (
    idrol INT(11) NOT NULL AUTO_INCREMENT,
    nombrerol VARCHAR(50) NOT NULL,
    descripcion TEXT,
    status INT(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (idrol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar roles básicos
INSERT INTO roles (nombrerol, descripcion) VALUES 
('Administrador', 'Control total del sistema'),
('Vendedor', 'Gestión de ventas y clientes');

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    idusuario INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(100) DEFAULT NULL,
    rolid INT(11) NOT NULL,
    status INT(11) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idusuario),
    KEY rolid (rolid),
    CONSTRAINT fk_rol FOREIGN KEY (rolid) REFERENCES roles (idrol) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuario administrador por defecto
-- Contraseña: admin123 (hash generado con password_hash)
INSERT INTO usuarios (nombre, apellido, email, password, rolid) VALUES 
('Admin', 'Sistema', 'admin@pinateria.com', '$2y$10$YgD7Ow9vQnFAVNe5GBwz6.TbX1y.E8EjVb9aVQrAWMJHvjxHCXpJa', 1);