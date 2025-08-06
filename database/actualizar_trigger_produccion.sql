-- Eliminar el trigger que descuenta automáticamente del inventario
DROP TRIGGER IF EXISTS `procesar_produccion`;

-- Crear nuevo trigger que solo aumenta el stock del producto final
DELIMITER $$
CREATE TRIGGER `aumentar_stock_producto_final` AFTER INSERT ON `detalle_produccion` FOR EACH ROW BEGIN
    -- Aumentar stock del producto final (solo una vez por producción)
    IF (SELECT COUNT(*) FROM detalle_produccion WHERE produccion_id = NEW.produccion_id) = 1 THEN
        UPDATE productos p
        INNER JOIN producciones pr ON pr.producto_final_id = p.id
        SET p.stock = p.stock + pr.cantidad_producir
        WHERE pr.id = NEW.produccion_id;
    END IF;
END$$
DELIMITER ;