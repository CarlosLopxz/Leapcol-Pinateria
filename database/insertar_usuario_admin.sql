-- Insertar rol de administrador si no existe
INSERT INTO roles (idrol, nombrerol, descripcion, estado) 
SELECT 1, 'Administrador', 'Control total del sistema', 1
FROM dual
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE idrol = 1);

-- Insertar usuario administrador si no existe
-- Contraseña: admin123 (hash bcrypt)
INSERT INTO usuarios (idusuario, nombre, apellido, usuario, email, password, rolid, estado) 
SELECT 1, 'Admin', 'Sistema', 'admin', 'admin@pinateria.com', '$2y$10$O7Pqv9K6/6/d0.1IvkrFuOTmUJ5hhXYE9vbXLJXwKvuYVUVRllxiO', 1, 1
FROM dual
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE idusuario = 1);