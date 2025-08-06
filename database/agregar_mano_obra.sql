-- Agregar campo mano_obra a la tabla productos
ALTER TABLE `productos` ADD `mano_obra` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `precio_venta`;

-- Actualizar productos existentes que fueron creados por producción
-- (opcional: solo si quieres migrar datos existentes)
UPDATE `productos` SET `mano_obra` = 0.00 WHERE `mano_obra` IS NULL;