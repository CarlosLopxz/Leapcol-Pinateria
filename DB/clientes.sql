-- Tabla de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    documento VARCHAR(20) NULL,
    tipo_documento ENUM('CC', 'NIT', 'CE', 'PASAPORTE') DEFAULT 'CC',
    telefono VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    direccion TEXT NULL,
    ciudad VARCHAR(50) NULL,
    fecha_nacimiento DATE NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de ventas (cabecera)
CREATE TABLE IF NOT EXISTS ventas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    cliente_id INT(11) NOT NULL,
    numero_factura VARCHAR(50) NULL,
    fecha_venta DATE NOT NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    impuestos DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descuentos DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 2=Pendiente, 0=Anulada',
    observaciones TEXT NULL,
    usuario_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de detalle de ventas
CREATE TABLE IF NOT EXISTS detalle_ventas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    venta_id INT(11) NOT NULL,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de ejemplo en clientes
INSERT INTO clientes (nombre, apellido, documento, tipo_documento, telefono, email, direccion, ciudad) VALUES 
('Juan', 'Pérez', '1234567890', 'CC', '3001234567', 'juan.perez@example.com', 'Calle 123 #45-67', 'Bogotá'),
('María', 'González', '0987654321', 'CC', '3109876543', 'maria.gonzalez@example.com', 'Av. Principal #89-12', 'Medellín'),
('Carlos', 'Rodríguez', '5678901234', 'CC', '3205551234', 'carlos.rodriguez@example.com', 'Carrera 45 #67-89', 'Cali'),
('Empresa', 'ABC', '900123456', 'NIT', '6012345678', 'contacto@empresaabc.com', 'Calle Comercial #123', 'Bogotá');