-- Eliminar trigger anterior
DROP TRIGGER IF EXISTS transferir_creacion;

-- Crear trigger corregido
DELIMITER $$
CREATE TRIGGER transferir_creacion AFTER INSERT ON detalle_venta FOR EACH ROW
BEGIN
    DECLARE cliente_creacion_id INT;
    DECLARE es_cliente_creacion INT DEFAULT 0;
    
    -- Obtener cliente de la venta
    SELECT v.cliente_id INTO cliente_creacion_id 
    FROM ventas v WHERE v.id = NEW.venta_id;
    
    -- Verificar si es cliente creación (por nombre o por ID específico)
    SELECT COUNT(*) INTO es_cliente_creacion
    FROM clientes 
    WHERE id = cliente_creacion_id 
    AND (LOWER(CONCAT(nombre, ' ', apellido)) LIKE '%creacion%' 
         OR LOWER(CONCAT(nombre, ' ', apellido)) LIKE '%creación%');
    
    IF es_cliente_creacion > 0 THEN
        -- Crear tablas si no existen
        CREATE TABLE IF NOT EXISTS caja_creacion (
            id INT(11) NOT NULL AUTO_INCREMENT,
            monto_actual DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            estado TINYINT(1) NOT NULL DEFAULT 1,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE IF NOT EXISTS inventario_creacion (
            id INT(11) NOT NULL AUTO_INCREMENT,
            producto_id INT(11) NOT NULL,
            cantidad INT(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (id),
            FOREIGN KEY (producto_id) REFERENCES productos(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- Insertar registro inicial en caja si no existe
        INSERT IGNORE INTO caja_creacion (id, monto_actual) VALUES (1, 0.00);
        
        -- Agregar dinero a caja
        UPDATE caja_creacion SET monto_actual = monto_actual + NEW.subtotal WHERE id = 1;
        
        -- Agregar productos a inventario
        INSERT INTO inventario_creacion (producto_id, cantidad)
        VALUES (NEW.producto_id, NEW.cantidad)
        ON DUPLICATE KEY UPDATE cantidad = cantidad + NEW.cantidad;
    END IF;
END$$
DELIMITER ;