ALTER TABLE detalle_produccion MODIFY COLUMN producto_recurso_id INT(11) NULL;
ALTER TABLE detalle_produccion DROP FOREIGN KEY detalle_produccion_ibfk_2;
ALTER TABLE detalle_produccion ADD CONSTRAINT detalle_produccion_ibfk_2 FOREIGN KEY (producto_recurso_id) REFERENCES productos(id) ON DELETE NO ACTION ON UPDATE CASCADE;