-- Script completo para configurar el módulo de creación

-- 1. Crear cliente especial para creación
INSERT IGNORE INTO `clientes` (`nombre`, `apellido`, `documento`, `tipo_documento`, `telefono`, `email`, `direccion`, `ciudad`, `estado`) 
VALUES ('Creacion', 'Especial', '00000000', 'CC', '0000000000', 'creacion@pinateria.com', 'Interno', 'Sistema', 1);

-- 2. Agregar módulo de creación
INSERT IGNORE INTO `modulos` (`nombre`, `descripcion`, `icono`, `url`, `estado`) 
VALUES ('Creación', 'Módulo de creación independiente', 'fas fa-magic', 'creacion', 1);

-- 3. Dar permisos al rol administrador para el módulo de creación
INSERT IGNORE INTO `permisos` (`rol_id`, `modulo_id`) 
SELECT 1, id FROM `modulos` WHERE `url` = 'creacion';

-- 4. Crear tabla para inventario de creación
CREATE TABLE IF NOT EXISTS `inventario_creacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `stock_creacion` int(11) NOT NULL DEFAULT 0,
  `costo_promedio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `producto_id` (`producto_id`),
  FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Crear tabla para caja de creación
CREATE TABLE IF NOT EXISTS `caja_creacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `fecha_apertura` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_inicial` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ventas` decimal(10,2) DEFAULT 0.00,
  `total_gastos` decimal(10,2) DEFAULT 0.00,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Abierta, 0=Cerrada',
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Crear tabla para movimientos de caja de creación
CREATE TABLE IF NOT EXISTS `movimientos_caja_creacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caja_creacion_id` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso','venta','gasto') NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`caja_creacion_id`) REFERENCES `caja_creacion` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Modificar el trigger existente para incluir lógica de creación
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
    
    IF cliente_nombre = 'Creacion' THEN
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
        
        -- Verificar si hay caja de creación abierta, si no, crear una automáticamente
        IF (SELECT COUNT(*) FROM caja_creacion WHERE estado = 1) = 0 THEN
            INSERT INTO caja_creacion (usuario_id, monto_inicial, observaciones)
            SELECT usuario_id, 0, 'Caja abierta automáticamente por venta a creación'
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

-- 8. Mensaje de confirmación
SELECT 'Módulo de creación configurado correctamente' as mensaje;