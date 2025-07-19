-- Insertar un usuario de prueba
-- Contraseña: admin123 (hash generado con password_hash)
INSERT INTO usuarios (nombre, apellido, email, password, rolid, status) VALUES 
('Admin', 'Sistema', 'admin@pinateria.com', '$2y$10$YgD7Ow9vQnFAVNe5GBwz6.TbX1y.E8EjVb9aVQrAWMJHvjxHCXpJa', 1, 1);