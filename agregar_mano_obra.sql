-- Script para agregar el campo mano_obra a la tabla productos
ALTER TABLE productos ADD COLUMN mano_obra DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER precio_venta;