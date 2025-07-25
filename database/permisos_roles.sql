-- Tabla de módulos del sistema
CREATE TABLE `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `url` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de permisos (relación roles-módulos)
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rol_id` (`rol_id`),
  KEY `modulo_id` (`modulo_id`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`idrol`) ON DELETE CASCADE,
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar módulos del sistema
INSERT INTO `modulos` (`nombre`, `descripcion`, `icono`, `url`, `estado`) VALUES
('Dashboard', 'Panel principal', 'fas fa-home', 'dashboard', 1),
('Categorías', 'Gestión de categorías', 'fas fa-tags', 'categorias', 1),
('Productos', 'Gestión de productos', 'fas fa-box', 'productos', 1),
('Producción', 'Gestión de producción', 'fas fa-cogs', 'produccion', 1),
('Clientes', 'Gestión de clientes', 'fas fa-users', 'clientes', 1),
('Proveedores', 'Gestión de proveedores', 'fas fa-truck', 'proveedores', 1),
('Compras', 'Gestión de compras', 'fas fa-truck', 'compras', 1),
('Ventas', 'Gestión de ventas', 'fas fa-shopping-cart', 'ventas', 1),
('Usuarios', 'Gestión de usuarios', 'fas fa-user-cog', 'usuarios', 1),
('Reportes', 'Reportes del sistema', 'fas fa-chart-bar', 'reportes', 1);

-- Dar todos los permisos al rol Administrador (ID 1)
INSERT INTO `permisos` (`rol_id`, `modulo_id`) 
SELECT 1, id FROM modulos WHERE estado = 1;