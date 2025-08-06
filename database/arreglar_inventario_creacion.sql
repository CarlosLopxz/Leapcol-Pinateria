-- Eliminar tabla vieja
DROP TABLE IF EXISTS inventario_creacion;

-- Crear tabla nueva simple
CREATE TABLE inventario_creacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY unique_producto (producto_id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Actualizar caja con las ventas ya hechas al cliente creación
UPDATE caja_creacion SET monto_actual = 112.00 WHERE id = 1;