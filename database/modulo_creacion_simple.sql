-- Cliente especial para creación
INSERT INTO clientes (nombre, apellido, documento, tipo_documento, estado) 
VALUES ('Cliente', 'Creación', '00000000', 'CC', 1);

-- Caja de creación
CREATE TABLE caja_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    monto_actual DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO caja_creacion (monto_actual) VALUES (0.00);

-- Inventario de creación
CREATE TABLE inventario_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Trigger para transferir ventas al cliente creación
DELIMITER $$
CREATE TRIGGER transferir_creacion AFTER INSERT ON detalle_venta FOR EACH ROW
BEGIN
    DECLARE cliente_creacion_id INT;
    
    SELECT v.cliente_id INTO cliente_creacion_id 
    FROM ventas v WHERE v.id = NEW.venta_id;
    
    IF (SELECT COUNT(*) FROM clientes WHERE id = cliente_creacion_id AND nombre = 'Cliente' AND apellido = 'Creación') > 0 THEN
        -- Agregar dinero a caja
        UPDATE caja_creacion SET monto_actual = monto_actual + NEW.subtotal WHERE id = 1;
        
        -- Agregar productos a inventario
        INSERT INTO inventario_creacion (producto_id, cantidad)
        VALUES (NEW.producto_id, NEW.cantidad)
        ON DUPLICATE KEY UPDATE cantidad = cantidad + NEW.cantidad;
    END IF;
END$$
DELIMITER ;