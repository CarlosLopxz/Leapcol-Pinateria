-- Crear cliente especial para creación
INSERT INTO clientes (nombre, apellido, documento, tipo_documento, telefono, email, direccion, ciudad, estado) 
VALUES ('Cliente', 'Creación', '00000000', 'CC', '0000000000', 'creacion@pinateria.com', 'Inventario Creación', 'Local', 1);

-- Crear tabla para caja de creación
CREATE TABLE caja_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fecha_apertura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    monto_inicial DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    monto_final DECIMAL(10,2) NULL,
    total_ingresos DECIMAL(10,2) DEFAULT 0.00,
    estado TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Abierta, 0=Cerrada',
    observaciones TEXT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para inventario de creación
CREATE TABLE inventario_creacion_productos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    producto_id INT(11) NOT NULL,
    cantidad_disponible INT(11) NOT NULL DEFAULT 0,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para movimientos de caja creación
CREATE TABLE movimientos_caja_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    caja_creacion_id INT(11) NOT NULL,
    tipo ENUM('ingreso','egreso') NOT NULL,
    concepto VARCHAR(200) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    venta_id INT(11) NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (caja_creacion_id) REFERENCES caja_creacion(id) ON DELETE CASCADE,
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para ventas de creación
CREATE TABLE ventas_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    venta_id INT(11) NOT NULL,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    fecha_venta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Trigger para transferir productos vendidos al cliente creación al inventario de creación
DELIMITER $$
CREATE TRIGGER transferir_a_creacion AFTER INSERT ON detalle_venta FOR EACH ROW
BEGIN
    DECLARE cliente_creacion_id INT;
    DECLARE es_cliente_creacion INT DEFAULT 0;
    
    -- Obtener el cliente de la venta
    SELECT v.cliente_id INTO cliente_creacion_id 
    FROM ventas v 
    WHERE v.id = NEW.venta_id;
    
    -- Verificar si es el cliente creación
    SELECT COUNT(*) INTO es_cliente_creacion 
    FROM clientes c 
    WHERE c.id = cliente_creacion_id 
    AND c.nombre = 'Cliente' 
    AND c.apellido = 'Creación';
    
    IF es_cliente_creacion > 0 THEN
        -- Insertar en ventas_creacion
        INSERT INTO ventas_creacion (venta_id, producto_id, cantidad, precio_unitario, subtotal)
        VALUES (NEW.venta_id, NEW.producto_id, NEW.cantidad, NEW.precio_unitario, NEW.subtotal);
        
        -- Agregar al inventario de creación
        INSERT INTO inventario_creacion_productos (producto_id, cantidad_disponible, precio_venta)
        VALUES (NEW.producto_id, NEW.cantidad, NEW.precio_unitario)
        ON DUPLICATE KEY UPDATE 
        cantidad_disponible = cantidad_disponible + NEW.cantidad;
        
        -- Agregar movimiento a caja creación (si hay caja abierta)
        INSERT INTO movimientos_caja_creacion (caja_creacion_id, tipo, concepto, monto, venta_id)
        SELECT cc.id, 'ingreso', CONCAT('Venta - ', p.nombre), NEW.subtotal, NEW.venta_id
        FROM caja_creacion cc, productos p
        WHERE cc.estado = 1 AND p.id = NEW.producto_id
        LIMIT 1;
        
        -- Actualizar total en caja creación
        UPDATE caja_creacion 
        SET total_ingresos = total_ingresos + NEW.subtotal
        WHERE estado = 1;
    END IF;
END$$
DELIMITER ;