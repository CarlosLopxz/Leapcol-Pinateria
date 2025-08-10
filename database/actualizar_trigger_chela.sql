-- Actualizar trigger para reconocer al cliente "Cliente Chela"
DROP TRIGGER IF EXISTS `actualizar_stock_venta`;

DELIMITER $$
CREATE TRIGGER `actualizar_stock_venta` AFTER INSERT ON `detalle_venta` FOR EACH ROW 
BEGIN
    DECLARE cliente_nombre VARCHAR(100) DEFAULT '';
    
    -- Verificar si la venta es para el cliente "Cliente" (Chela)
    SELECT COALESCE(c.nombre, '') INTO cliente_nombre
    FROM ventas v 
    LEFT JOIN clientes c ON v.cliente_id = c.id
    WHERE v.id = NEW.venta_id;
    
    IF cliente_nombre = 'Cliente' THEN
        -- Agregar al inventario de creación
        INSERT INTO inventario_creacion (producto_id, stock_creacion, costo_promedio)
        VALUES (NEW.producto_id, NEW.cantidad, NEW.precio_unitario)
        ON DUPLICATE KEY UPDATE 
            stock_creacion = stock_creacion + NEW.cantidad,
            costo_promedio = CASE 
                WHEN stock_creacion = 0 THEN NEW.precio_unitario
                ELSE ((costo_promedio * stock_creacion) + (NEW.precio_unitario * NEW.cantidad)) / (stock_creacion + NEW.cantidad)
            END;
        
        -- Actualizar monto en caja de creación
        UPDATE caja_creacion 
        SET monto_actual = monto_actual + NEW.subtotal
        WHERE estado = 1;
    ELSE
        -- Lógica normal para otras ventas (descontar stock)
        UPDATE productos 
        SET stock = stock - NEW.cantidad
        WHERE id = NEW.producto_id;
    END IF;
END$$
DELIMITER ;