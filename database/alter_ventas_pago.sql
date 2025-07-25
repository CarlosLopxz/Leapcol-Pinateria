-- Agregar campos para pago y cambio en la tabla ventas
ALTER TABLE `ventas` 
ADD COLUMN `pago_con` decimal(10,2) DEFAULT NULL AFTER `total`,
ADD COLUMN `cambio` decimal(10,2) DEFAULT NULL AFTER `pago_con`;