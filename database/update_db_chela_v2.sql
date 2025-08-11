-- UPDATE COMPLETO BASE DE DATOS - SISTEMA CLIENTE CHELA V2
-- Nueva lógica más simple y confiable

-- 1. ELIMINAR TRIGGERS ANTIGUOS
DROP TRIGGER IF EXISTS `actualizar_stock_venta`;
DROP TRIGGER IF EXISTS `procesar_venta_creacion`;

-- 2. AGREGAR CAMPO DESTINO A TABLA VENTAS
ALTER TABLE `ventas` 
ADD COLUMN `destino` ENUM('normal', 'creacion') DEFAULT 'normal' 
AFTER `observaciones`;

-- 3. CREAR TRIGGER SIMPLE PARA DETALLE_VENTA
DELIMITER $$
CREATE TRIGGER `manejar_stock_venta` AFTER INSERT ON `detalle_venta` FOR EACH ROW 
BEGIN
    DECLARE venta_destino VARCHAR(20) DEFAULT 'normal';
    
    -- Obtener destino de la venta
    SELECT destino INTO venta_destino FROM ventas WHERE id = NEW.venta_id;
    
    IF venta_destino = 'creacion' THEN
        -- DESTINO CREACIÓN: Agregar a inventario_creacion
        INSERT INTO inventario_creacion (producto_id, stock_creacion, costo_promedio)
        VALUES (NEW.producto_id, NEW.cantidad, NEW.precio_unitario)
        ON DUPLICATE KEY UPDATE 
            stock_creacion = stock_creacion + NEW.cantidad,
            costo_promedio = ((costo_promedio * stock_creacion) + (NEW.precio_unitario * NEW.cantidad)) / (stock_creacion + NEW.cantidad),
            fecha_actualizacion = NOW();
    ELSE
        -- DESTINO NORMAL: Descontar stock
        UPDATE productos SET stock = stock - NEW.cantidad WHERE id = NEW.producto_id;
    END IF;
END$$
DELIMITER ;

-- 4. CREAR TRIGGER PARA ACTUALIZAR CAJA CREACIÓN
DELIMITER $$
CREATE TRIGGER `actualizar_caja_creacion` AFTER INSERT ON `ventas` FOR EACH ROW 
BEGIN
    IF NEW.destino = 'creacion' THEN
        -- Restar de caja creación (gasto)
        UPDATE caja_creacion 
        SET monto_actual = monto_actual - NEW.total,
            total_gastado = total_gastado + NEW.total
        WHERE estado = 1;
        
        -- Registrar movimiento
        INSERT INTO movimientos_caja_creacion (caja_creacion_id, tipo, concepto, monto, venta_id, usuario_id)
        VALUES (1, 'gasto', CONCAT('Compra interna - Venta #', NEW.id), NEW.total, NEW.id, NEW.usuario_id);
    END IF;
END$$
DELIMITER ;

-- 5. ACTUALIZAR VENTAS EXISTENTES DEL CLIENTE CHELA
UPDATE ventas SET destino = 'creacion' WHERE cliente_id = 8;

-- 6. PROCESAR VENTAS EXISTENTES NO PROCESADAS
INSERT INTO inventario_creacion (producto_id, stock_creacion, costo_promedio)
SELECT dv.producto_id, SUM(dv.cantidad), AVG(dv.precio_unitario)
FROM detalle_venta dv
JOIN ventas v ON dv.venta_id = v.id
WHERE v.destino = 'creacion' 
  AND dv.producto_id NOT IN (SELECT producto_id FROM inventario_creacion)
GROUP BY dv.producto_id
ON DUPLICATE KEY UPDATE 
    stock_creacion = stock_creacion + VALUES(stock_creacion),
    costo_promedio = ((costo_promedio * stock_creacion) + (VALUES(costo_promedio) * VALUES(stock_creacion))) / (stock_creacion + VALUES(stock_creacion));

-- 7. VERIFICACIÓN FINAL
SELECT 'SISTEMA ACTUALIZADO CORRECTAMENTE' as status;
SELECT COUNT(*) as total_productos_creacion FROM inventario_creacion;
SELECT destino, COUNT(*) as cantidad FROM ventas GROUP BY destino;