-- Modificar el trigger existente para incluir lógica de creación
DROP TRIGGER IF EXISTS `actualizar_stock_venta`;

DELIMITER $$
CREATE TRIGGER `actualizar_stock_venta` AFTER INSERT ON `detalle_venta` FOR EACH ROW 
BEGIN
    DECLARE cliente_nombre VARCHAR(100) DEFAULT '';
    DECLARE es_creacion INT DEFAULT 0;
    
    -- Verificar si la venta es para el cliente "creacion"
    SELECT COALESCE(c.nombre, '') INTO cliente_nombre
    FROM ventas v 
    LEFT JOIN clientes c ON v.cliente_id = c.id
    WHERE v.id = NEW.venta_id;
    
    IF cliente_nombre = 'Cliente' THEN
        SET es_creacion = 1;
        
        -- Agregar al inventario de creación
        INSERT INTO inventario_creacion (producto_id, stock_creacion, costo_promedio)
        VALUES (NEW.producto_id, NEW.cantidad, NEW.costo_unitario)
        ON DUPLICATE KEY UPDATE 
            stock_creacion = stock_creacion + NEW.cantidad,
            costo_promedio = CASE 
                WHEN stock_creacion = 0 THEN NEW.costo_unitario
                ELSE ((costo_promedio * stock_creacion) + (NEW.costo_unitario * NEW.cantidad)) / (stock_creacion + NEW.cantidad)
            END;
        
        -- Verificar si hay caja de creación abierta, si no, crear una
        IF (SELECT COUNT(*) FROM caja_creacion WHERE estado = 1) = 0 THEN
            INSERT INTO caja_creacion (usuario_id, monto_inicial, observaciones)
            SELECT NEW.venta_id, 0, 'Caja abierta automáticamente'
            FROM ventas WHERE id = NEW.venta_id;
        END IF;
        
        -- Registrar movimiento en caja de creación
        INSERT INTO movimientos_caja_creacion (caja_creacion_id, tipo, concepto, monto, venta_id, usuario_id)
        SELECT 
            (SELECT id FROM caja_creacion WHERE estado = 1 ORDER BY id DESC LIMIT 1),
            'gasto',
            CONCAT('Compra: ', p.nombre, ' (Cant: ', NEW.cantidad, ')'),
            NEW.subtotal,
            NEW.venta_id,
            (SELECT usuario_id FROM ventas WHERE id = NEW.venta_id)
        FROM productos p WHERE p.id = NEW.producto_id;
        
        -- Actualizar total de gastos en caja de creación
        UPDATE caja_creacion 
        SET total_gastos = total_gastos + NEW.subtotal
        WHERE estado = 1 
        ORDER BY id DESC LIMIT 1;
    ELSE
        -- Lógica normal para otras ventas (descontar stock)
        UPDATE productos 
        SET stock = stock - NEW.cantidad
        WHERE id = NEW.producto_id;
    END IF;
END$$
DELIMITER ;