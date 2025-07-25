-- Tablas para el módulo de producción

-- Tabla de producciones
CREATE TABLE `producciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `producto_final_id` int(11) NOT NULL,
  `cantidad_producir` int(11) NOT NULL,
  `fecha_produccion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 2=En proceso, 0=Cancelada',
  `observaciones` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `producto_final_id` (`producto_final_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `producciones_ibfk_1` FOREIGN KEY (`producto_final_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `producciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de detalle de producción (recursos utilizados)
CREATE TABLE `detalle_produccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produccion_id` int(11) NOT NULL,
  `producto_recurso_id` int(11) NOT NULL,
  `cantidad_utilizada` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produccion_id` (`produccion_id`),
  KEY `producto_recurso_id` (`producto_recurso_id`),
  CONSTRAINT `detalle_produccion_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_produccion_ibfk_2` FOREIGN KEY (`producto_recurso_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- El manejo de stock se realiza directamente en el código PHP para mayor control