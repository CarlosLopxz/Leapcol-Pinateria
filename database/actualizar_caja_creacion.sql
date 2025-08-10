-- Actualizar tabla caja_creacion para agregar campos de totales
ALTER TABLE `caja_creacion` 
ADD COLUMN `total_gastado` decimal(10,2) DEFAULT 0.00 COMMENT 'Ventas al cliente Chela',
ADD COLUMN `total_vendido` decimal(10,2) DEFAULT 0.00 COMMENT 'Ventas con destino caja creacion';

-- Actualizar registro existente
UPDATE `caja_creacion` SET 
    `total_gastado` = 0.00,
    `total_vendido` = 0.00
WHERE `id` = 1;