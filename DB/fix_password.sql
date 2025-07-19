-- Actualizar la contraseña del usuario admin
-- Contraseña: admin123 (hash generado con password_hash en PHP 7+)
UPDATE usuarios SET password = '$2y$10$O3vTzlJJFpMCQo.bNODcwuF9RxHHCXGALSHGKxrUMFnltQnwxRHPu' WHERE email = 'admin@pinateria.com';

-- Si el usuario no existe, crearlo
INSERT INTO usuarios (nombre, apellido, email, password, rolid, status)
SELECT 'Admin', 'Sistema', 'admin@pinateria.com', '$2y$10$O3vTzlJJFpMCQo.bNODcwuF9RxHHCXGALSHGKxrUMFnltQnwxRHPu', 1, 1
FROM dual
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'admin@pinateria.com');