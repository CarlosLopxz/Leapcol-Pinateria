-- ACTUALIZACIÓN SISTEMA DE CAJA MEJORADO
-- Modificaciones para separar transferencias y efectivo, cancelaciones independientes

-- 1. Agregar campos para separar tipos de ingresos en cajas
ALTER TABLE `cajas` 
ADD COLUMN `total_transferencias` DECIMAL(10,2) DEFAULT 0 AFTER `total_transferencia`,
ADD COLUMN `total_efectivo_caja` DECIMAL(10,2) DEFAULT 0 AFTER `total_transferencias`;

-- 2. Crear tabla para productos no inventariados (ventas temporales)
CREATE TABLE IF NOT EXISTS `productos_temporales` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` INT NOT NULL,
    `agregado_inventario` TINYINT(1) DEFAULT 0,
    INDEX `idx_usuario` (`usuario_id`),
    INDEX `idx_fecha` (`fecha_creacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Crear tabla para cancelaciones de ventas (historial independiente)
CREATE TABLE IF NOT EXISTS `cancelaciones_venta` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `venta_id` INT NOT NULL,
    `motivo` TEXT,
    `monto_cancelado` DECIMAL(10,2) NOT NULL,
    `ajuste_caja` TINYINT(1) DEFAULT 0,
    `monto_devuelto` DECIMAL(10,2) DEFAULT 0,
    `fecha_cancelacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` INT NOT NULL,
    INDEX `idx_venta` (`venta_id`),
    INDEX `idx_fecha` (`fecha_cancelacion`),
    FOREIGN KEY (`venta_id`) REFERENCES `ventas`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`idusuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Actualizar tabla movimientos_caja para incluir referencia a cancelaciones
ALTER TABLE `movimientos_caja` 
ADD COLUMN `cancelacion_id` INT NULL AFTER `venta_id`,
ADD INDEX `idx_cancelacion` (`cancelacion_id`);

-- 5. Crear vista para resumen mejorado de caja
CREATE OR REPLACE VIEW `vista_resumen_caja` AS
SELECT 
    c.id,
    c.usuario_id,
    c.monto_inicial,
    c.fecha_apertura,
    c.fecha_cierre,
    c.monto_final,
    c.estado,
    u.nombre as usuario_nombre,
    
    -- Ingresos por transferencias (tarjetas, transferencias, etc.)
    COALESCE((SELECT SUM(monto) FROM movimientos_caja 
              WHERE caja_id = c.id AND tipo = 'venta' 
              AND metodo_pago IN (2, 3, 4)), 0) as ingresos_transferencias,
    
    -- Ingresos por efectivo (solo efectivo)
    COALESCE((SELECT SUM(monto) FROM movimientos_caja 
              WHERE caja_id = c.id AND tipo = 'venta' 
              AND metodo_pago = 1), 0) as ingresos_efectivo,
    
    -- Ingresos adicionales (no ventas)
    COALESCE((SELECT SUM(monto) FROM movimientos_caja 
              WHERE caja_id = c.id AND tipo = 'ingreso'), 0) as ingresos_adicionales,
    
    -- Egresos
    COALESCE((SELECT SUM(monto) FROM movimientos_caja 
              WHERE caja_id = c.id AND tipo = 'egreso'), 0) as total_egresos,
    
    -- Cancelaciones
    COALESCE((SELECT COUNT(*) FROM movimientos_caja 
              WHERE caja_id = c.id AND cancelacion_id IS NOT NULL), 0) as total_cancelaciones,
    
    -- Total actual en caja (solo efectivo + ingresos - egresos)
    (c.monto_inicial + 
     COALESCE((SELECT SUM(monto) FROM movimientos_caja 
               WHERE caja_id = c.id AND tipo = 'venta' AND metodo_pago = 1), 0) +
     COALESCE((SELECT SUM(monto) FROM movimientos_caja 
               WHERE caja_id = c.id AND tipo = 'ingreso'), 0) -
     COALESCE((SELECT SUM(monto) FROM movimientos_caja 
               WHERE caja_id = c.id AND tipo = 'egreso'), 0)) as efectivo_disponible

FROM cajas c
INNER JOIN usuarios u ON c.usuario_id = u.idusuario;

-- 6. Actualizar trigger para manejar los nuevos campos
DROP TRIGGER IF EXISTS `actualizar_totales_caja_mejorado`;

DELIMITER $$
CREATE TRIGGER `actualizar_totales_caja_mejorado` 
AFTER INSERT ON `movimientos_caja` FOR EACH ROW 
BEGIN
    -- Actualizar totales separados por tipo de pago
    UPDATE cajas SET 
        total_efectivo_caja = (
            SELECT COALESCE(SUM(monto), 0) 
            FROM movimientos_caja 
            WHERE caja_id = NEW.caja_id AND tipo = 'venta' AND metodo_pago = 1
        ),
        total_transferencias = (
            SELECT COALESCE(SUM(monto), 0) 
            FROM movimientos_caja 
            WHERE caja_id = NEW.caja_id AND tipo = 'venta' AND metodo_pago IN (2, 3, 4)
        ),
        total_ventas = (
            SELECT COALESCE(SUM(monto), 0) 
            FROM movimientos_caja 
            WHERE caja_id = NEW.caja_id AND tipo = 'venta'
        )
    WHERE id = NEW.caja_id;
END$$
DELIMITER ;

-- 7. Insertar datos de ejemplo para productos temporales (opcional)
INSERT INTO `productos_temporales` (`nombre`, `precio`, `usuario_id`) VALUES
('Producto Personalizado', 15000, 1),
('Servicio Especial', 25000, 1);

-- 8. Verificación final
SELECT 'ACTUALIZACIÓN COMPLETADA - SISTEMA DE CAJA MEJORADO' as status;
SELECT COUNT(*) as productos_temporales FROM productos_temporales;
SELECT COUNT(*) as cancelaciones FROM cancelaciones_venta;