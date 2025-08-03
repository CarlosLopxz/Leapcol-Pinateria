-- Agregar el módulo de roles que falta en la tabla modulos
INSERT INTO `modulos` (`id`, `nombre`, `descripcion`, `icono`, `url`, `estado`) VALUES
(13, 'Roles', 'Gestión de roles y permisos', 'fas fa-user-shield', 'roles', 1);

-- Verificar que se insertó correctamente
SELECT * FROM modulos WHERE url = 'roles';