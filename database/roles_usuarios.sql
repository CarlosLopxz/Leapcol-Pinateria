-- Insertar roles básicos
INSERT INTO roles (nombrerol, descripcion, estado) VALUES
('Administrador', 'Acceso completo al sistema', 1),
('Vendedor', 'Acceso a ventas y productos', 1),
('Cajero', 'Acceso solo a punto de venta', 1);

-- Actualizar usuario admin existente (si existe)
UPDATE usuarios SET rolid = 1 WHERE idusuario = 1;