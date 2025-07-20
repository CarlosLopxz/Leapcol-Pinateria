-- Tabla de proveedores
CREATE TABLE IF NOT EXISTS proveedores (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    contacto VARCHAR(100) NULL,
    telefono VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    direccion TEXT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de compras (cabecera)
CREATE TABLE IF NOT EXISTS compras (
    id INT(11) NOT NULL AUTO_INCREMENT,
    proveedor_id INT(11) NOT NULL,
    numero_factura VARCHAR(50) NULL,
    fecha_compra DATE NOT NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    impuestos DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descuentos DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 2=Pendiente, 0=Anulada',
    observaciones TEXT NULL,
    usuario_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de detalle de compras
CREATE TABLE IF NOT EXISTS detalle_compras (
    id INT(11) NOT NULL AUTO_INCREMENT,
    compra_id INT(11) NOT NULL,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de ejemplo en proveedores
INSERT INTO proveedores (nombre, contacto, telefono, email, direccion) VALUES 
('Distribuidora de Piñatas S.A.', 'Juan Pérez', '3001234567', 'contacto@distribuidora.com', 'Calle 123 #45-67'),
('Dulces al Mayor', 'María López', '3109876543', 'ventas@dulcesalmayor.com', 'Av. Principal #89-12'),
('Decoraciones Festivas', 'Carlos Rodríguez', '3205551234', 'info@decoracionesfestivas.com', 'Carrera 45 #67-89');