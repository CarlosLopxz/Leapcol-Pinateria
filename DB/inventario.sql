-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de subcategorías
CREATE TABLE IF NOT EXISTS subcategorias (
    id INT(11) NOT NULL AUTO_INCREMENT,
    categoria_id INT(11) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de almacenes
CREATE TABLE IF NOT EXISTS almacenes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    direccion TEXT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla principal de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(50) NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT NULL,
    categoria_id INT(11) NOT NULL,
    subcategoria_id INT(11) NULL,
    unidad_medida VARCHAR(20) NOT NULL DEFAULT 'unidad',
    tamanio VARCHAR(50) NULL,
    presentacion VARCHAR(50) NULL,
    almacen_id INT(11) NOT NULL DEFAULT 1,
    ubicacion VARCHAR(50) NULL,
    condiciones VARCHAR(100) NULL,
    observaciones TEXT NULL,
    stock_actual INT(11) NOT NULL DEFAULT 0,
    stock_minimo INT(11) NULL DEFAULT 0,
    stock_maximo INT(11) NULL,
    precio_compra DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    costos_adicionales DECIMAL(10,2) NULL DEFAULT 0.00,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (codigo),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (subcategoria_id) REFERENCES subcategorias(id),
    FOREIGN KEY (almacen_id) REFERENCES almacenes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de movimientos de inventario
CREATE TABLE IF NOT EXISTS movimientos_inventario (
    id INT(11) NOT NULL AUTO_INCREMENT,
    producto_id INT(11) NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida', 'ajuste') NOT NULL,
    cantidad INT(11) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    referencia VARCHAR(100) NULL,
    usuario_id INT(11) NOT NULL,
    fecha_movimiento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de ejemplo en categorías
INSERT INTO categorias (nombre, descripcion) VALUES 
('Piñatas', 'Todo tipo de piñatas para fiestas'),
('Dulces', 'Dulces y golosinas para rellenar piñatas'),
('Decoración', 'Artículos para decoración de fiestas'),
('Accesorios', 'Accesorios para fiestas y piñatas');

-- Insertar datos de ejemplo en subcategorías
INSERT INTO subcategorias (categoria_id, nombre) VALUES 
(1, 'Piñatas Infantiles'),
(1, 'Piñatas Adultos'),
(1, 'Piñatas Personalizadas'),
(2, 'Dulces Tradicionales'),
(2, 'Chocolates'),
(2, 'Gomitas'),
(3, 'Globos'),
(3, 'Guirnaldas'),
(3, 'Centros de Mesa'),
(4, 'Palos para Piñata'),
(4, 'Antifaces'),
(4, 'Bolsas para Dulces');

-- Insertar datos de ejemplo en almacenes
INSERT INTO almacenes (nombre, direccion) VALUES 
('Principal', 'Calle Principal #123'),
('Bodega', 'Av. Secundaria #456'),
('Tienda', 'Plaza Central Local #7');

-- Insertar datos de ejemplo en productos
INSERT INTO productos (codigo, nombre, descripcion, categoria_id, subcategoria_id, unidad_medida, tamanio, presentacion, almacen_id, ubicacion, condiciones, stock_actual, stock_minimo, precio_compra, precio_venta) VALUES 
('PIN001', 'Piñata Unicornio', 'Piñata con forma de unicornio, colores pastel', 1, 1, 'unidad', 'Grande', 'individual', 1, 'A-12-3', 'Temperatura ambiente', 15, 5, 150.00, 250.00),
('PIN002', 'Piñata Spider-Man', 'Piñata con forma de Spider-Man', 1, 1, 'unidad', 'Grande', 'individual', 1, 'A-12-4', 'Temperatura ambiente', 8, 5, 170.00, 280.00),
('DUL001', 'Bolsa de Dulces Surtidos', 'Bolsa con dulces variados para piñata', 2, 4, 'unidad', '500g', 'bolsa', 2, 'B-03-1', 'Lugar fresco y seco', 50, 20, 70.00, 120.00),
('DEC001', 'Globos Metálicos', 'Globos metálicos de colores variados', 3, 7, 'unidad', '12 pulgadas', 'paquete', 3, 'C-05-2', 'Temperatura ambiente', 100, 30, 20.00, 35.00),
('ACC001', 'Palo para Piñata', 'Palo de madera para golpear piñatas', 4, 10, 'unidad', '1m', 'individual', 1, 'D-01-1', 'Lugar seco', 25, 10, 25.00, 45.00);