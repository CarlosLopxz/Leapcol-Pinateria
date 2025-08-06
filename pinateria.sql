-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 06-08-2025 a las 08:34:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pinateria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_apertura` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_inicial` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ventas` decimal(10,2) DEFAULT 0.00,
  `total_efectivo` decimal(10,2) DEFAULT 0.00,
  `total_tarjeta` decimal(10,2) DEFAULT 0.00,
  `total_transferencia` decimal(10,2) DEFAULT 0.00,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Abierta, 0=Cerrada',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `usuario_id`, `fecha_apertura`, `fecha_cierre`, `monto_inicial`, `monto_final`, `total_ventas`, `total_efectivo`, `total_tarjeta`, `total_transferencia`, `estado`, `observaciones`) VALUES
(9, 3, '2025-08-04 22:29:00', NULL, 1.00, NULL, 0.00, 0.00, 0.00, 0.00, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(3, 'asdasd', 'asdsd', 1, '2025-08-04 13:05:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `tipo_documento` enum('CC','NIT','CE','PASAPORTE') DEFAULT 'CC',
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `numero_factura` varchar(50) DEFAULT NULL,
  `fecha_compra` date NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `impuestos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descuentos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 2=Pendiente, 0=Anulada',
  `observaciones` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `detalle_compras`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_compra` AFTER INSERT ON `detalle_compras` FOR EACH ROW BEGIN
    UPDATE productos 
    SET stock = stock + NEW.cantidad
    WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_produccion`
--

CREATE TABLE `detalle_produccion` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) NOT NULL,
  `producto_recurso_id` int(11) DEFAULT NULL,
  `cantidad_utilizada` int(11) NOT NULL,
  `recurso_manual` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_produccion`
--

INSERT INTO `detalle_produccion` (`id`, `produccion_id`, `producto_recurso_id`, `cantidad_utilizada`, `recurso_manual`) VALUES
(7, 5, 9, 1, NULL),
(8, 6, 10, 1, NULL),
(9, 6, 11, 1, NULL),
(10, 7, 10, 1, NULL),
(11, 7, 11, 1, NULL),
(12, 8, 13, 2, NULL),
(13, 8, 10, 1, NULL);

--
-- Disparadores `detalle_produccion`
--
DELIMITER $$
CREATE TRIGGER `aumentar_stock_producto_final` AFTER INSERT ON `detalle_produccion` FOR EACH ROW BEGIN
    -- Aumentar stock del producto final (solo una vez por producción)
    IF (SELECT COUNT(*) FROM detalle_produccion WHERE produccion_id = NEW.produccion_id) = 1 THEN
        UPDATE productos p
        INNER JOIN producciones pr ON pr.producto_final_id = p.id
        SET p.stock = p.stock + pr.cantidad_producir
        WHERE pr.id = NEW.produccion_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  `ganancia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `costo_unitario`, `subtotal`, `costo_total`, `ganancia`) VALUES
(33, 38, 9, 12, 14.00, 2.00, 168.00, 24.00, 144.00),
(34, 39, 15, 1, 3.00, 1.00, 3.00, 1.00, 2.00),
(35, 39, 14, 1, 42.00, 5.00, 42.00, 5.00, 37.00);

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_venta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
    UPDATE productos 
    SET stock = stock - NEW.cantidad
    WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_creacion`
--

CREATE TABLE `inventario_creacion` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_transferida` int(11) NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `fecha_transferencia` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_creacion`
--

INSERT INTO `inventario_creacion` (`id`, `producto_id`, `cantidad_transferida`, `cantidad_disponible`, `fecha_transferencia`, `usuario_id`, `observaciones`, `status`) VALUES
(1, 9, 4, 1, '2025-08-04 23:08:18', 3, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `url` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `nombre`, `descripcion`, `icono`, `url`, `estado`) VALUES
(1, 'Dashboard', 'Panel principal', 'fas fa-home', 'dashboard', 1),
(2, 'Categorías', 'Gestión de categorías', 'fas fa-tags', 'categorias', 1),
(3, 'Productos', 'Gestión de productos', 'fas fa-box', 'productos', 1),
(4, 'Producción', 'Gestión de producción', 'fas fa-cogs', 'produccion', 1),
(5, 'Clientes', 'Gestión de clientes', 'fas fa-users', 'clientes', 1),
(6, 'Proveedores', 'Gestión de proveedores', 'fas fa-truck', 'proveedores', 1),
(7, 'Compras', 'Gestión de compras', 'fas fa-truck', 'compras', 1),
(8, 'Ventas', 'Gestión de ventas', 'fas fa-shopping-cart', 'ventas', 1),
(9, 'Usuarios', 'Gestión de usuarios', 'fas fa-user-cog', 'usuarios', 1),
(10, 'Reportes', 'Reportes del sistema', 'fas fa-chart-bar', 'reportes', 1),
(11, 'Caja', 'Gestión de caja', 'fas fa-cash-register', 'caja', 1),
(12, 'Punto de Venta', 'Punto de venta rápido', 'fas fa-cash-register', 'pos', 1),
(13, 'Roles', 'Gestión de roles y permisos', 'fas fa-user-shield', 'roles', 1),
(14, 'Creación', 'Inventario de creación de piñatas', 'fas fa-hammer', 'creacion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `id` int(11) NOT NULL,
  `caja_id` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso','venta') NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` tinyint(1) DEFAULT 1 COMMENT '1=Efectivo, 2=Tarjeta, 3=Transferencia',
  `venta_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_creacion`
--

CREATE TABLE `movimientos_creacion` (
  `id` int(11) NOT NULL,
  `inventario_creacion_id` int(11) NOT NULL,
  `tipo_movimiento` enum('ENTRADA','SALIDA') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_creacion`
--

INSERT INTO `movimientos_creacion` (`id`, `inventario_creacion_id`, `tipo_movimiento`, `cantidad`, `descripcion`, `fecha_movimiento`, `usuario_id`) VALUES
(1, 1, 'ENTRADA', 4, 'Transferencia desde inventario principal', '2025-08-04 23:08:18', 3),
(2, 1, 'SALIDA', 3, 'asdasdsd', '2025-08-04 23:08:35', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol_id`, `modulo_id`) VALUES
(212, 1, 11),
(213, 1, 2),
(214, 1, 5),
(215, 1, 7),
(216, 1, 1),
(217, 1, 4),
(218, 1, 3),
(219, 1, 6),
(220, 1, 12),
(221, 1, 10),
(222, 1, 13),
(223, 1, 9),
(224, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciones`
--

CREATE TABLE `producciones` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `producto_final_id` int(11) NOT NULL,
  `cantidad_producir` int(11) NOT NULL,
  `fecha_produccion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 2=En proceso, 0=Cancelada',
  `observaciones` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producciones`
--

INSERT INTO `producciones` (`id`, `codigo`, `producto_final_id`, `cantidad_producir`, `fecha_produccion`, `estado`, `observaciones`, `usuario_id`) VALUES
(5, 'PR25080492', 10, 120, '2025-08-04 23:10:33', 1, '', 3),
(6, 'PR25080511', 12, 2, '2025-08-05 23:58:02', 1, '', 3),
(7, 'PR25080636', 13, 1, '2025-08-06 00:04:05', 1, '', 3),
(8, 'PR25080612', 14, 1, '2025-08-06 00:53:21', 1, '', 3),
(9, 'PR25080666', 16, 12, '2025-08-06 01:19:42', 1, '', 3),
(10, 'PR25080619', 17, 12, '2025-08-06 01:24:18', 1, '', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `unidad_venta` varchar(20) NOT NULL DEFAULT 'unidad',
  `precio_compra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio_venta` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mano_obra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `imagen` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `categoria_id`, `unidad_venta`, `precio_compra`, `precio_venta`, `mano_obra`, `stock`, `stock_minimo`, `imagen`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(9, 'asddasd', 'asdasdasd', '', 3, 'unidad', 2.00, 14.00, 0.00, -1, 5, '', 3, '2025-08-04 13:06:53', '2025-08-06 00:57:37'),
(10, 'P250804770', 'asdsasdasd', 'asdasdas', 3, 'unidad', 1.00, 12.00, 0.00, 0, 5, NULL, 3, '2025-08-04 23:10:33', '2025-08-06 00:57:35'),
(11, 'asdasdasda', 'Producto', '', 3, 'unidad', 1.00, 2.00, 0.00, 1, 5, '', 3, '2025-08-05 23:54:51', '2025-08-06 00:57:32'),
(12, 'P250805804', 'arlos', 'asdasd', 3, 'unidad', 1.00, 12.00, 0.00, 4, 5, NULL, 3, '2025-08-05 23:58:02', '2025-08-06 00:57:30'),
(13, 'P250806554', 'asdasdas', 'asdasd', 3, 'unidad', 2.00, 1.00, 0.00, 0, 5, NULL, 3, '2025-08-06 00:04:05', '2025-08-06 00:57:28'),
(14, 'P250806359', 'car', 'sadasd', 3, 'unidad', 5.00, 12.00, 30.00, 0, 5, NULL, 1, '2025-08-06 00:53:21', '2025-08-06 01:04:47'),
(15, 'asdasda', 'cal', 'asdasd', 3, 'unidad', 1.00, 3.00, 0.00, 3, 5, '', 1, '2025-08-06 01:04:07', '2025-08-06 01:04:47'),
(16, 'P250806108', 'asdasda', 'asdasd', 3, 'unidad', 0.00, 44.00, 32.00, 12, 5, NULL, 1, '2025-08-06 01:19:42', NULL),
(17, 'P250806826', 'vvvvv', 'vvv', 3, 'unidad', 0.00, 44.00, 12.00, 12, 5, NULL, 1, '2025-08-06 01:24:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `nombrerol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `nombrerol`, `descripcion`, `estado`) VALUES
(1, 'Administrador', 'Acceso completo al sistema', 1),
(2, 'Prueba', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `rolid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `usuario`, `email`, `password`, `token`, `rolid`, `status`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 'Admin', 'Sistema', 'admin', 'admin@pinateria.com', '$2y$10$PdEEfkMLWcdpaIcG2vP0sOhz3DlYm1rcsrjFBZMrBGhJprHe/ZFTy', NULL, 1, 1, '2025-07-20 16:27:33', '2025-07-31 13:33:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha_venta` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `impuestos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descuentos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pago_con` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `costo_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ganancia` decimal(10,2) NOT NULL DEFAULT 0.00,
  `metodo_pago` tinyint(1) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Completada, 0=Anulada',
  `observaciones` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `fecha_venta`, `subtotal`, `impuestos`, `descuentos`, `total`, `pago_con`, `cambio`, `costo_total`, `ganancia`, `metodo_pago`, `estado`, `observaciones`, `usuario_id`, `fecha_creacion`) VALUES
(38, NULL, '2025-08-04 22:27:48', 168.00, 0.00, 0.00, 10168.00, 20000.00, 9832.00, 0.00, 0.00, 1, 1, '', 3, '2025-08-04 22:27:48'),
(39, NULL, '2025-08-06 01:04:47', 45.00, 0.00, 0.00, 45.00, 50.00, 5.00, 0.00, 0.00, 1, 1, '', 3, '2025-08-06 01:04:47');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `restaurar_stock_venta` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
    IF OLD.estado = 1 AND NEW.estado = 0 THEN
        UPDATE productos, detalle_venta 
        SET productos.stock = productos.stock + detalle_venta.cantidad
        WHERE detalle_venta.venta_id = NEW.id 
        AND detalle_venta.producto_id = productos.id;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`),
  ADD KEY `producto_recurso_id` (`producto_recurso_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `inventario_creacion`
--
ALTER TABLE `inventario_creacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `movimientos_creacion`
--
ALTER TABLE `movimientos_creacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventario_creacion_id` (`inventario_creacion_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `modulo_id` (`modulo_id`);

--
-- Indices de la tabla `producciones`
--
ALTER TABLE `producciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `producto_final_id` (`producto_final_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `inventario_creacion`
--
ALTER TABLE `inventario_creacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `movimientos_creacion`
--
ALTER TABLE `movimientos_creacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT de la tabla `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD CONSTRAINT `cajas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD CONSTRAINT `detalle_produccion_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_produccion_ibfk_2` FOREIGN KEY (`producto_recurso_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario_creacion`
--
ALTER TABLE `inventario_creacion`
  ADD CONSTRAINT `inventario_creacion_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_creacion_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_caja_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `movimientos_creacion`
--
ALTER TABLE `movimientos_creacion`
  ADD CONSTRAINT `movimientos_creacion_ibfk_1` FOREIGN KEY (`inventario_creacion_id`) REFERENCES `inventario_creacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_creacion_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`idrol`) ON DELETE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producciones`
--
ALTER TABLE `producciones`
  ADD CONSTRAINT `producciones_ibfk_1` FOREIGN KEY (`producto_final_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `producciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `roles` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
