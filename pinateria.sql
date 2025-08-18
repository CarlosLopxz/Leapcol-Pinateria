-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 18-08-2025 a las 07:44:31
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
(11, 3, '2025-08-16 00:03:17', '2025-08-16 00:38:31', 1.00, 300.00, 0.00, 0.00, 0.00, 0.00, 0, ' | Cierre: Cerrado desde POS'),
(12, 3, '2025-08-16 00:44:22', '2025-08-17 00:15:22', 10000.00, 28000.00, 18000.00, 18000.00, 0.00, 0.00, 0, ' | Cierre: Cerrado desde POS'),
(13, 3, '2025-08-17 00:15:34', '2025-08-17 00:37:53', 30000.00, 200000.00, 187900.00, 160900.00, 0.00, 27000.00, 0, ' | Cierre: Cerrado desde POS'),
(14, 3, '2025-08-17 18:29:28', '2025-08-17 19:07:34', 30000.00, NULL, 468500.00, 116000.00, 0.00, 352500.00, 0, ' | Cerrada automáticamente por duplicado'),
(15, 3, '2025-08-17 19:05:16', '2025-08-17 21:22:14', 30000.00, 74000.00, 104000.00, 48500.00, 0.00, 55500.00, 0, ' | Cierre: Cerrado desde POS'),
(16, 3, '2025-08-17 21:22:33', '2025-08-18 00:35:08', 0.00, 320000.00, 884500.00, 320000.00, 0.00, 564500.00, 0, ' | Cierre: Cerrado desde POS'),
(17, 3, '2025-08-18 00:35:14', NULL, 100000.00, NULL, 45000.00, 45000.00, 0.00, 0.00, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_creacion`
--

CREATE TABLE `caja_creacion` (
  `id` int(11) NOT NULL,
  `monto_actual` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `total_gastado` decimal(10,2) DEFAULT 0.00 COMMENT 'Ventas al cliente Chela',
  `total_vendido` decimal(10,2) DEFAULT 0.00 COMMENT 'Ventas con destino caja creacion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Papeleria', 'variedades en papeleria', 1, '2025-08-04 08:38:18'),
(4, 'Paquetes de Globos', '.', 1, '2025-08-04 08:38:41'),
(5, 'Cajas', 'variedad de Cajas', 1, '2025-08-04 08:39:16'),
(6, 'Cortinas', '', 1, '2025-08-04 08:39:30'),
(7, 'Numeros Metalizados', '', 1, '2025-08-04 08:39:45'),
(8, 'Globos Metalizados', '', 1, '2025-08-04 08:39:58'),
(9, 'Globos Individuales', '', 1, '2025-08-04 08:40:14'),
(10, 'Bolsas de Regalos', '', 1, '2025-08-04 08:40:29'),
(11, 'Dulceria', '', 1, '2025-08-04 08:40:43'),
(12, 'Flores', '', 1, '2025-08-04 08:40:56'),
(13, 'Esquelas', '', 1, '2025-08-04 08:44:17'),
(14, 'Velas', '', 1, '2025-08-04 08:44:25'),
(15, 'Tarjetas', '', 1, '2025-08-04 08:44:35'),
(16, 'Manteles', '', 1, '2025-08-04 08:44:53'),
(17, 'Picadillos', '', 1, '2025-08-04 08:45:36'),
(19, 'Pines', '', 1, '2025-08-04 08:47:43'),
(20, 'Botellas', '', 1, '2025-08-04 08:48:09'),
(21, 'Cajas Sorpresa', '', 1, '2025-08-04 08:50:40'),
(22, 'Banderines', '', 1, '2025-08-04 08:50:59'),
(23, 'Banderines personalizados', '', 1, '2025-08-04 08:51:51'),
(24, 'Pompones', '', 1, '2025-08-04 08:52:55'),
(25, 'Fondo de Anchetas', '', 1, '2025-08-04 08:53:33'),
(26, 'Topper', '', 1, '2025-08-04 08:53:40'),
(27, 'Coronas', '', 1, '2025-08-04 08:54:13'),
(28, 'Abanicos', '', 1, '2025-08-04 08:55:00'),
(29, 'peluches', '', 1, '2025-08-04 08:55:33'),
(30, 'Hora Loca', '', 1, '2025-08-04 08:56:02'),
(31, 'Lasos', '', 1, '2025-08-04 08:56:13'),
(32, 'Penachos metalizados', '', 1, '2025-08-04 08:57:06'),
(33, 'Juguetes', '', 1, '2025-08-04 08:57:20'),
(34, 'Bases de Anchetas', '', 1, '2025-08-04 08:58:11'),
(35, 'Buquets Metalizados', '', 1, '2025-08-04 08:58:25'),
(36, 'Personalizaciones Varias', '', 1, '2025-08-04 08:59:53'),
(37, 'Espumas', '', 1, '2025-08-04 09:01:45'),
(38, 'Buquets', '', 1, '2025-08-04 09:02:10'),
(39, 'Termos', '', 1, '2025-08-04 09:02:27'),
(40, 'Piñatas', '', 1, '2025-08-04 09:03:17'),
(41, 'Maizenas carnavaleras', '', 1, '2025-08-04 09:03:42'),
(42, 'Mug', '', 1, '2025-08-04 09:05:21'),
(43, 'Fondos', '', 1, '2025-08-04 09:05:36'),
(44, 'Accesorios', '', 1, '2025-08-04 09:05:45'),
(45, 'Moños', '', 1, '2025-08-04 09:06:35'),
(46, 'Desechables', '', 1, '2025-08-04 09:08:08'),
(47, 'Abrillantadores', '', 1, '2025-08-04 09:08:41'),
(48, 'portaglobos', '', 1, '2025-08-04 09:09:06'),
(49, 'Vinilos', '', 1, '2025-08-04 09:10:50'),
(50, 'Hojas', '', 1, '2025-08-04 09:11:12'),
(51, 'Mantel de Anchetas', '', 1, '2025-08-04 09:15:06'),
(52, 'Halloween', '', 1, '2025-08-04 09:15:28'),
(53, 'Amor y Amistad', '', 1, '2025-08-04 09:15:45'),
(54, 'Fin de Año', '', 1, '2025-08-04 09:15:59'),
(55, 'Manualidades', 'Todas las cosas hechas manualmenmte', 1, '2025-08-04 14:09:43'),
(56, 'Metalizados varios', '', 1, '2025-08-05 15:15:01'),
(57, 'Apliques en Icopor', '', 1, '2025-08-06 14:53:46'),
(58, 'Bomboneras', '', 1, '2025-08-06 15:03:54'),
(59, 'Otro', '', 1, '2025-08-06 15:16:05');

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

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `documento`, `tipo_documento`, `telefono`, `email`, `direccion`, `ciudad`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(8, 'Cliente', 'Chela', '00000000', 'CC', '0000000000', 'creacion@pinateria.com', 'Interno', 'Sistema', 1, '2025-08-06 03:00:53', '2025-08-06 10:56:02');

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

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `numero_factura`, `fecha_compra`, `fecha_registro`, `subtotal`, `impuestos`, `descuentos`, `total`, `estado`, `observaciones`, `usuario_id`) VALUES
(9, 4, '01', '2025-08-05', '2025-08-06 10:17:28', 23800.00, 0.00, 23000.00, 800.00, 1, '', 3);

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
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(11, 9, 160, 2, 1500.00, 3000.00),
(12, 9, 185, 4, 1700.00, 6800.00),
(13, 9, 132, 2, 2000.00, 4000.00),
(14, 9, 189, 2, 5000.00, 10000.00);

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
  `producto_recurso_id` int(11) NOT NULL,
  `cantidad_utilizada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `detalle_produccion`
--
DELIMITER $$
CREATE TRIGGER `procesar_produccion` AFTER INSERT ON `detalle_produccion` FOR EACH ROW BEGIN
    -- Descontar stock del recurso utilizado
    UPDATE productos 
    SET stock = stock - NEW.cantidad_utilizada
    WHERE id = NEW.producto_recurso_id;
    
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
(103, 112, 37, 4, 4500.00, 2000.00, 18000.00, 8000.00, 10000.00),
(104, 114, 47, 1, 18000.00, 10000.00, 18000.00, 10000.00, 8000.00),
(105, 116, 11, 1, 7500.00, 5000.00, 7500.00, 5000.00, 2500.00),
(106, 117, 372, 6, 4500.00, 2000.00, 27000.00, 12000.00, 15000.00),
(107, 118, 24, 5, 7500.00, 5000.00, 37500.00, 25000.00, 12500.00),
(108, 118, 387, 6, 4500.00, 2600.00, 27000.00, 15600.00, 11400.00),
(109, 118, 380, 5, 5800.00, 2500.00, 29000.00, 12500.00, 16500.00),
(110, 119, 11, 1, 7500.00, 5000.00, 7500.00, 5000.00, 2500.00),
(111, 120, 20, 6, 7500.00, 5000.00, 45000.00, 30000.00, 15000.00),
(112, 121, 35, 5, 4500.00, 2000.00, 22500.00, 10000.00, 12500.00),
(113, 124, 37, 6, 4500.00, 2000.00, 27000.00, 12000.00, 15000.00),
(114, 125, 37, 1, 4500.00, 2000.00, 4500.00, 2000.00, 2500.00),
(115, 127, 47, 1, 18000.00, 10000.00, 18000.00, 10000.00, 8000.00),
(116, 128, 37, 1, 4500.00, 2000.00, 4500.00, 2000.00, 2500.00),
(117, 129, 37, 1, 4500.00, 2000.00, 4500.00, 2000.00, 2500.00),
(118, 130, 37, 6, 4500.00, 2000.00, 27000.00, 12000.00, 15000.00),
(119, 131, 372, 6, 4500.00, 2000.00, 27000.00, 12000.00, 15000.00),
(120, 132, 368, 11, 11000.00, 6000.00, 121000.00, 66000.00, 55000.00),
(121, 135, 368, 25, 11000.00, 6000.00, 275000.00, 150000.00, 125000.00),
(122, 136, 368, 25, 11000.00, 6000.00, 275000.00, 150000.00, 125000.00),
(123, 137, 37, 5, 4500.00, 2000.00, 22500.00, 10000.00, 12500.00),
(124, 138, 37, 1, 4500.00, 2000.00, 4500.00, 2000.00, 2500.00),
(125, 139, 37, 6, 4500.00, 2000.00, 27000.00, 12000.00, 15000.00),
(126, 140, 37, 10, 4500.00, 2000.00, 45000.00, 20000.00, 25000.00),
(127, 141, 37, 8, 4500.00, 2000.00, 36000.00, 16000.00, 20000.00),
(128, 142, 37, 1, 4500.00, 2000.00, 4500.00, 2000.00, 2500.00),
(129, 143, 11, 2, 7500.00, 5000.00, 15000.00, 10000.00, 5000.00),
(130, 144, 11, 4, 7500.00, 5000.00, 30000.00, 20000.00, 10000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_creacion`
--

CREATE TABLE `inventario_creacion` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `stock_creacion` int(11) NOT NULL DEFAULT 0,
  `costo_promedio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 'Creación', 'Módulo de creación independiente', 'fas fa-magic', 'creacion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `id` int(11) NOT NULL,
  `caja_id` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso','venta','anulacion') NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` tinyint(1) DEFAULT 1 COMMENT '1=Efectivo, 2=Tarjeta, 3=Transferencia',
  `venta_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`id`, `caja_id`, `tipo`, `concepto`, `monto`, `metodo_pago`, `venta_id`, `fecha`, `usuario_id`) VALUES
(58, 11, 'ingreso', 'asdas', 123.00, 1, NULL, '2025-08-16 00:03:30', 3),
(59, 12, 'venta', 'Venta #112', 18000.00, 1, 112, '2025-08-16 00:49:13', 3),
(60, 13, 'venta', 'Venta #114', 18000.00, 1, 114, '2025-08-17 00:20:29', 3),
(61, 13, 'venta', 'Venta #116', 142900.00, 1, 116, '2025-08-17 00:24:00', 3),
(62, 13, 'venta', 'Venta #117', 27000.00, 4, 117, '2025-08-17 00:25:05', 3),
(63, 13, 'ingreso', 'luca', 30000.00, 1, NULL, '2025-08-17 00:37:14', 3),
(64, 13, 'egreso', 'luis', 15000.00, 1, NULL, '2025-08-17 00:37:34', 3),
(65, 14, 'ingreso', 'luca', 1111.00, 1, NULL, '2025-08-17 18:35:04', 3),
(66, 14, 'egreso', 'fgred', 20000.00, 1, NULL, '2025-08-17 18:35:18', 3),
(67, 14, 'ingreso', 'a', 3000.00, 4, NULL, '2025-08-17 18:35:42', 3),
(68, 14, 'ingreso', 'luca', 30000.00, 1, NULL, '2025-08-17 18:39:33', 3),
(69, 14, 'ingreso', 'luca', 30000.00, 1, NULL, '2025-08-17 18:43:06', 3),
(70, 14, 'ingreso', 'aaaa', 10000.00, 1, NULL, '2025-08-17 18:43:17', 3),
(71, 14, 'egreso', 'ttttt', 30000.00, 1, NULL, '2025-08-17 18:43:46', 3),
(72, 14, 'venta', 'Venta #118', 63500.00, 1, 118, '2025-08-17 18:45:52', 3),
(73, 14, 'venta', 'Venta #119', 7500.00, 1, 119, '2025-08-17 18:46:43', 3),
(74, 14, 'venta', 'Venta #120', 45000.00, 1, 120, '2025-08-17 18:47:08', 3),
(75, 14, 'venta', 'Venta #121', 22500.00, 4, 121, '2025-08-17 18:47:35', 3),
(76, 14, 'venta', 'Venta #122', 300000.00, 4, 122, '2025-08-17 18:48:08', 3),
(77, 14, 'venta', 'Venta #123', 30000.00, 4, 123, '2025-08-17 18:49:28', 3),
(78, 15, 'venta', 'Venta #124', 17000.00, 1, 124, '2025-08-17 19:42:46', 3),
(79, 15, 'venta', 'Venta #125', 4500.00, 1, 125, '2025-08-17 19:50:41', 3),
(80, 15, 'venta', 'Venta #126', 55500.00, 4, 126, '2025-08-17 19:53:46', 3),
(81, 15, '', 'Anulación de venta #124', -17000.00, 1, 124, '2025-08-17 20:33:09', 3),
(82, 15, 'venta', 'Venta #127', 18000.00, 1, 127, '2025-08-17 20:35:46', 3),
(83, 15, '', 'Venta anulada #127', -18000.00, 1, 127, '2025-08-17 20:36:00', 3),
(84, 15, 'venta', 'Venta #128', 4500.00, 1, 128, '2025-08-17 21:05:50', 3),
(85, 15, '', 'Anulación de venta #128', -4500.00, 1, 128, '2025-08-17 21:06:30', 3),
(86, 15, 'venta', 'Venta #129', 4500.00, 1, 129, '2025-08-17 21:08:02', 3),
(87, 15, 'anulacion', 'Anulación de venta #125', -4500.00, 1, 125, '2025-08-17 21:19:19', 3),
(88, 16, 'venta', 'Venta #130', 27000.00, 1, 130, '2025-08-17 21:22:46', 3),
(89, 16, 'venta', 'Venta #131', 27000.00, 1, 131, '2025-08-17 21:22:55', 3),
(90, 16, 'venta', 'Venta #132', 120000.00, 1, 132, '2025-08-17 21:23:21', 3),
(91, 16, 'venta', 'Venta #133', 11000.00, 1, 133, '2025-08-17 21:23:47', 3),
(92, 16, 'venta', 'Venta #134', 10000.00, 4, 134, '2025-08-17 21:24:05', 3),
(93, 16, 'anulacion', 'Venta anulada #130', -27000.00, 1, 130, '2025-08-17 21:29:00', 3),
(94, 16, 'anulacion', 'Venta anulada #132', -120000.00, 1, 132, '2025-08-17 21:40:24', 3),
(95, 16, 'venta', 'Venta #135', 275000.00, 4, 135, '2025-08-17 21:41:49', 3),
(96, 16, 'anulacion', 'Venta anulada #135', -275000.00, 4, 135, '2025-08-17 21:43:19', 3),
(97, 16, 'venta', 'Venta #136', 275000.00, 4, 136, '2025-08-17 21:45:11', 3),
(98, 16, 'anulacion', 'Venta anulada #136', -275000.00, 4, 136, '2025-08-17 21:45:45', 3),
(99, 16, 'anulacion', 'Venta anulada #133', -11000.00, 1, 133, '2025-08-17 21:50:36', 3),
(100, 16, 'venta', 'Venta #137', 22500.00, 1, 137, '2025-08-17 21:53:27', 3),
(101, 16, 'anulacion', 'Venta anulada #137', -22500.00, 1, 137, '2025-08-17 21:54:16', 3),
(102, 16, 'venta', 'Venta #138', 4500.00, 4, 138, '2025-08-17 21:55:10', 3),
(103, 16, 'venta', 'Venta #139', 27000.00, 1, 139, '2025-08-17 21:55:32', 3),
(104, 16, 'venta', 'Venta #140', 45000.00, 1, 140, '2025-08-17 21:56:18', 3),
(105, 16, 'venta', 'Venta #141', 36000.00, 1, 141, '2025-08-17 21:59:48', 3),
(106, 16, 'venta', 'Venta #142', 4500.00, 1, 142, '2025-08-17 22:04:04', 3),
(107, 17, 'venta', 'Venta #143', 15000.00, 1, 143, '2025-08-18 00:36:35', 3),
(108, 17, 'venta', 'Venta #144', 30000.00, 1, 144, '2025-08-18 00:43:48', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja_creacion`
--

CREATE TABLE `movimientos_caja_creacion` (
  `id` int(11) NOT NULL,
  `caja_creacion_id` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso','venta','gasto') NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(224, 1, 8),
(225, 2, 11),
(226, 2, 12);

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
(9, '01', 'Globos Marron r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 5, 5, '', 1, '2025-08-04 09:33:09', '2025-08-04 09:49:42'),
(10, '02', 'Globos Vinotinto r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 5, 5, '', 1, '2025-08-04 09:34:38', NULL),
(11, '03', 'Globos Amarillo r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 8, 5, '', 1, '2025-08-04 09:35:26', '2025-08-18 00:43:59'),
(12, '04', 'Globos Gris r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 3, 5, '', 1, '2025-08-04 09:36:17', NULL),
(13, '05', 'Globos Fucsia r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 0, 5, '', 3, '2025-08-04 09:37:13', '2025-08-08 15:34:26'),
(14, '06', 'Globos Coral r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 16, 5, '', 1, '2025-08-04 09:38:30', NULL),
(15, '07', 'Globos Azul Satinado r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 4, 5, '', 1, '2025-08-04 09:40:08', NULL),
(16, '08', 'Globos Lila Cromado r9 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 5, 5, '', 1, '2025-08-04 09:41:10', NULL),
(17, '09', 'Globos Verde Biche Cromado r9 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 3, 5, '', 1, '2025-08-04 09:43:36', NULL),
(18, '10', 'Globos Verde Oscuro Cromado r9 x12', '', 4, 'unidad', 2000.00, 4000.00, 0.00, 22, 5, '', 1, '2025-08-04 09:45:40', '2025-08-06 10:47:56'),
(19, '11', 'Globos Dorado r9 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 8, 5, '', 1, '2025-08-04 09:46:48', '2025-08-08 10:35:25'),
(20, '12', 'Globos Arena r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 0, 5, '', 1, '2025-08-04 09:47:56', '2025-08-17 18:47:08'),
(21, '13', 'Globos Negro r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 2, 5, '', 1, '2025-08-04 09:48:41', '2025-08-08 15:31:30'),
(22, '14', 'Globos Blanco r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 4, 5, '', 1, '2025-08-04 09:51:52', '2025-08-08 09:20:06'),
(23, '15', 'Globos Rosado r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 2, 5, '', 1, '2025-08-04 09:52:44', '2025-08-08 15:31:30'),
(24, '16', 'Globos Azul Oscuro r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 2, 5, '', 1, '2025-08-04 09:53:41', '2025-08-17 18:45:52'),
(25, '17', 'Globos Rojo r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 9, 5, '', 1, '2025-08-04 09:55:54', NULL),
(26, '18', 'Globos Naranjado r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 2, 5, '', 1, '2025-08-04 09:58:14', NULL),
(27, '19', 'Globos Verde Oscuro r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 2, 5, '', 1, '2025-08-04 09:58:52', NULL),
(28, '20', 'Globos Azul Claro r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 0, 5, '', 1, '2025-08-04 09:59:27', '2025-08-08 09:20:06'),
(29, '21', 'Globos Morado r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 0, 5, '', 1, '2025-08-04 10:00:06', '2025-08-08 11:10:52'),
(30, '22', 'Globos Morado r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 36, 5, '', 1, '2025-08-04 10:06:26', '2025-08-04 10:14:26'),
(31, '23', 'Globos Verde Pastel r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 42, 5, '', 1, '2025-08-04 10:07:32', '2025-08-04 10:15:23'),
(32, '24', 'Globos Rosado r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 27, 5, '', 1, '2025-08-04 10:08:49', NULL),
(33, '25', 'Globos Fucsia r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 24, 5, '', 1, '2025-08-04 10:09:47', NULL),
(34, '26', 'Globos Lila r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 34, 5, '', 1, '2025-08-04 10:12:39', '2025-08-04 10:16:15'),
(35, '27', 'Globos Azul Claro r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 16, 5, '', 1, '2025-08-04 10:19:09', '2025-08-17 18:47:35'),
(36, '28', 'Globos Negro r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 2, 5, '', 1, '2025-08-04 10:19:39', NULL),
(37, '29', 'Globos Amarillo r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 49, 5, '', 1, '2025-08-04 10:20:44', '2025-08-17 22:04:37'),
(38, '30', 'Globos Palo de rosa Cromado r12 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 1, 5, '', 1, '2025-08-04 10:21:54', NULL),
(39, '31', 'Globos Palo de rosa r9 x50', '', 4, 'unidad', 5000.00, 7500.00, 0.00, 0, 5, '', 1, '2025-08-04 10:23:10', '2025-08-08 09:20:06'),
(40, '32', 'Globos Plateado Cromado r9 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 3, 5, '', 1, '2025-08-04 10:25:49', NULL),
(41, '33', 'Globos Azul Cromado r9 x50', '', 4, 'unidad', 9000.00, 15000.00, 0.00, 3, 5, '', 1, '2025-08-04 10:26:41', NULL),
(42, '34', 'Globos Verde Claro r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 20, 5, '', 1, '2025-08-04 10:30:01', NULL),
(43, '35', 'Globos Verde Biche r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 4, 5, '', 1, '2025-08-04 10:31:15', NULL),
(44, '36', 'Globos Verde Pastel r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 10, 5, '', 1, '2025-08-04 10:32:24', NULL),
(45, '37', 'Globos Piel r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 1, 5, '', 1, '2025-08-04 10:33:48', NULL),
(46, '38', 'Globos Uva r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 5, 5, '', 1, '2025-08-04 10:34:51', NULL),
(47, '39', 'Globos Amarillo r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 28, 5, '', 1, '2025-08-04 10:36:18', '2025-08-17 20:36:00'),
(48, '40', 'Globos Morado r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 10, 5, '', 1, '2025-08-04 10:37:57', '2025-08-04 10:38:51'),
(49, '41', 'Globos Lila r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 3, 5, '', 1, '2025-08-04 10:38:33', '2025-08-08 16:56:21'),
(50, '42', 'Globos Coral r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 14, 5, '', 1, '2025-08-04 10:44:48', NULL),
(51, '43', 'Globos Fucsia r12 x12', '', 4, 'unidad', 2000.00, 4500.00, 0.00, 22, 5, '', 1, '2025-08-04 10:45:50', NULL),
(52, '44', 'Globos Fucsia r12 x50', '', 4, 'unidad', 10000.00, 18000.00, 0.00, 14, 5, '', 1, '2025-08-04 10:46:42', NULL),
(53, '45', 'Globos palo de rosa Cromado r12 x12', '', 4, 'unidad', 5000.00, 8500.00, 0.00, 27, 5, '', 1, '2025-08-04 10:51:24', NULL),
(54, '46', 'Globos Palo de rosa Cromado r18', '', 9, 'unidad', 3000.00, 6000.00, 0.00, 38, 5, '', 1, '2025-08-04 10:53:23', '2025-08-04 10:53:44'),
(55, '47', 'Globos Oro Rosa Cromado r18', '', 9, 'unidad', 3000.00, 6000.00, 0.00, 54, 5, '', 1, '2025-08-04 11:06:31', NULL),
(56, '48', 'Globos Plateado Cromado r18', '', 9, 'unidad', 3000.00, 6000.00, 0.00, 13, 5, '', 1, '2025-08-04 11:08:26', NULL),
(57, '49', 'Globos Azul Cromado r18', '', 9, 'unidad', 3000.00, 6000.00, 0.00, 38, 5, '', 1, '2025-08-04 11:09:26', NULL),
(58, '50', 'Globos de Balon de Futbol r12 x12', '', 4, 'unidad', 5000.00, 8500.00, 0.00, 3, 5, '', 1, '2025-08-04 11:12:44', '2025-08-08 09:20:06'),
(59, '51', 'Globos Feliz Cumpleaños Negro r12 x12', '', 4, 'unidad', 5000.00, 8500.00, 0.00, 34, 5, '', 3, '2025-08-04 11:16:08', '2025-08-04 11:18:22'),
(60, '52', 'Globos Feliz Cumpleaños r12', '', 9, 'unidad', 500.00, 1000.00, 0.00, 978, 5, '', 1, '2025-08-04 11:25:36', '2025-08-08 09:20:57'),
(61, '53', 'Globos Feliz Dia r12 x12', '', 4, 'unidad', 5000.00, 8500.00, 0.00, 14, 5, '', 1, '2025-08-04 11:28:01', NULL),
(62, '54', 'Globos Feliz Dia r12', '', 9, 'unidad', 500.00, 1000.00, 0.00, 706, 5, '', 1, '2025-08-04 11:29:49', NULL),
(63, '55', 'Globos Transparentes r12', '', 9, 'unidad', 500.00, 800.00, 0.00, 234, 5, '', 1, '2025-08-04 11:33:47', NULL),
(64, '56', 'Globos Mostaza r9', '', 9, 'unidad', 50.00, 200.00, 0.00, 400, 5, '', 1, '2025-08-04 11:36:09', NULL),
(65, '57', 'Globos Palo de Rosa r12 x50', '', 4, 'unidad', 14000.00, 28000.00, 0.00, 2, 5, '', 1, '2025-08-04 11:37:39', NULL),
(66, '58', 'Globos Verde Eucalipto r12 x50', '', 4, 'unidad', 14000.00, 28000.00, 0.00, 2, 5, '', 1, '2025-08-04 11:38:44', NULL),
(67, '59', 'Globos Fucsia r12 x100', '', 4, 'unidad', 12000.00, 22000.00, 0.00, 1, 5, '', 1, '2025-08-04 11:39:49', NULL),
(68, '60', 'Globos Plateado Cromado Sempertex r12 x50', '', 4, 'unidad', 1.00, 2.00, 0.00, 2, 5, '', 1, '2025-08-04 11:41:58', NULL),
(69, '61', 'Globos Feliz Navidad Sempertex r12 x50', '', 4, 'unidad', 1.00, 2.00, 0.00, 1, 5, '', 1, '2025-08-04 11:42:50', '2025-08-04 11:43:55'),
(70, '62', 'Globos Verde Oscuro Sempertex r5 x12', '', 4, 'unidad', 1.00, 2.00, 0.00, 3, 5, '', 1, '2025-08-04 11:43:41', NULL),
(71, '63', 'Globos Mil Figuras Azul Cromado x50', '', 4, 'unidad', 11000.00, 22500.00, 0.00, 1, 5, '', 1, '2025-08-04 11:44:48', '2025-08-04 11:45:16'),
(72, '64', 'papel cometa Fucsia', '', 3, 'unidad', 150.00, 300.00, 0.00, 100, 5, '', 3, '2025-08-04 11:48:29', '2025-08-04 14:23:43'),
(73, '65', 'Mantel Dorado Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 79, 5, '', 1, '2025-08-04 15:05:52', NULL),
(74, '66', 'Mantel Plateado Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 109, 5, '', 1, '2025-08-04 15:07:45', '2025-08-09 15:32:27'),
(75, '67', 'Mantel Azul Oscuro Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 61, 5, '', 1, '2025-08-04 15:08:38', '2025-08-08 17:47:20'),
(76, '68', 'Mantel Rojo Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 31, 5, '', 1, '2025-08-04 15:09:15', NULL),
(77, '69', 'Mantel Negro', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 70, 5, '', 1, '2025-08-04 15:12:46', NULL),
(78, '70', 'Mantel Negro Estampado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 8, 5, '', 1, '2025-08-04 15:13:31', NULL),
(79, '71', 'Mantel Rosado Estampado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 10, 5, '', 1, '2025-08-04 15:17:45', NULL),
(80, '72', 'Mantel Fucsia Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 23, 5, '', 1, '2025-08-04 15:19:08', NULL),
(81, '73', 'Mantel Palo de Rosa Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 49, 5, '', 1, '2025-08-04 15:20:19', NULL),
(82, '74', 'Mantel Rosado Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 31, 5, '', 1, '2025-08-04 15:22:46', NULL),
(83, '75', 'Mantel Dorado Normal', '', 16, 'unidad', 2500.00, 7500.00, 0.00, 90, 5, '', 1, '2025-08-04 15:24:27', NULL),
(84, '76', 'Mantel Morado Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 23, 5, '', 1, '2025-08-04 15:26:01', NULL),
(85, '77', 'Mantel Dorado Estampado Metalizado', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 15, 5, '', 1, '2025-08-04 15:27:04', NULL),
(86, '78', 'Mantel Gris', '', 16, 'unidad', 2500.00, 7000.00, 0.00, 30, 5, '', 1, '2025-08-04 15:27:41', '2025-08-09 16:06:04'),
(87, '79', 'Mantel Fucsia', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 31, 5, '', 1, '2025-08-04 15:28:26', NULL),
(88, '80', 'Mantel Morado', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 21, 5, '', 1, '2025-08-04 15:29:08', NULL),
(89, '81', 'Mantel Rosado', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 13, 5, '', 1, '2025-08-04 15:29:45', NULL),
(90, '82', 'Mantel Rosado Pastel', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 45, 5, '', 1, '2025-08-04 15:30:20', '2025-08-09 17:55:04'),
(91, '83', 'Mantel Blanco', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 13, 5, '', 1, '2025-08-04 15:30:49', NULL),
(92, '84', 'Mantel Naranjado', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 54, 5, '', 1, '2025-08-04 15:31:23', NULL),
(93, '85', 'Mantel Azul Oscuro', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 65, 5, '', 1, '2025-08-04 15:32:05', NULL),
(94, '86', 'Mantel Azul Claro', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 47, 5, '', 1, '2025-08-04 15:32:45', NULL),
(95, '87', 'Mantel Rojo', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 34, 5, '', 1, '2025-08-04 15:33:26', NULL),
(96, '88', 'Mantel Verde Biche', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 4, 5, '', 1, '2025-08-04 15:34:07', NULL),
(97, '89', 'Mantel de Personajes', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 96, 5, '', 1, '2025-08-04 15:35:15', NULL),
(98, '90', 'Mantel Amarillo', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 13, 5, '', 1, '2025-08-04 15:35:59', NULL),
(99, '91', 'Mantel Piel', '', 16, 'unidad', 2500.00, 5000.00, 0.00, 25, 5, '', 1, '2025-08-04 15:36:37', NULL),
(100, '92', '0 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 26, 5, '', 1, '2025-08-04 15:48:29', '2025-08-08 11:24:28'),
(101, '93', '0 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 58, 5, '', 1, '2025-08-04 15:50:01', '2025-08-08 09:20:06'),
(102, '94', '0 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 21, 5, '', 1, '2025-08-04 15:50:57', NULL),
(103, '95', '1 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 102, 5, '', 1, '2025-08-04 15:54:47', '2025-08-08 11:10:52'),
(104, '96', '1 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 119, 5, '', 1, '2025-08-04 15:57:14', '2025-08-08 09:20:06'),
(105, '97', '1 Palo de rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 0, 5, '', 1, '2025-08-04 15:58:31', NULL),
(106, '98', '2 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 84, 5, '', 1, '2025-08-04 15:59:13', NULL),
(107, '99', '2 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 92, 5, '', 1, '2025-08-04 16:00:53', NULL),
(108, '100', '2 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 83, 5, '', 1, '2025-08-04 16:02:39', NULL),
(109, '101', '3 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 83, 5, '', 1, '2025-08-04 16:06:33', '2025-08-04 16:08:31'),
(110, '102', '3 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 66, 5, '', 1, '2025-08-04 16:08:58', NULL),
(111, '103', '3 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 45, 5, '', 1, '2025-08-04 16:10:43', '2025-08-08 09:20:06'),
(112, '104', '4 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 19, 5, '', 1, '2025-08-04 16:11:55', '2025-08-08 09:20:06'),
(113, '105', '4 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 44, 5, '', 1, '2025-08-04 16:13:13', NULL),
(114, '106', '4 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 64, 5, '', 1, '2025-08-04 16:14:15', NULL),
(115, '107', '5 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 105, 5, '', 1, '2025-08-04 16:17:01', NULL),
(116, '108', '5 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 112, 5, '', 1, '2025-08-04 17:44:18', NULL),
(117, '109', '5 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 9, 5, '', 1, '2025-08-04 17:48:16', NULL),
(118, '110', '6 Dorado 16\"', '', 8, 'unidad', 1500.00, 2500.00, 0.00, 76, 5, '', 1, '2025-08-04 17:48:50', NULL),
(119, '111', '6 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 84, 5, '', 1, '2025-08-04 17:49:34', '2025-08-08 11:10:52'),
(120, '112', '6 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 38, 5, '', 1, '2025-08-04 17:50:29', NULL),
(121, '113', '7 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 80, 5, '', 1, '2025-08-04 17:53:03', NULL),
(122, '114', '7 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 80, 5, '', 1, '2025-08-04 17:58:06', NULL),
(123, '115', '7 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 115, 5, '', 1, '2025-08-04 17:58:38', NULL),
(124, '116', '7 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 50, 5, '', 1, '2025-08-04 17:59:46', '2025-08-08 15:31:30'),
(125, '117', '8 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 103, 5, '', 1, '2025-08-04 18:00:30', NULL),
(126, '118', '8 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 107, 5, '', 1, '2025-08-04 18:01:23', NULL),
(127, '119', '8 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 40, 5, '', 1, '2025-08-04 18:02:01', NULL),
(128, '120', '9 Plateado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 124, 5, '', 1, '2025-08-04 18:02:35', NULL),
(129, '121', '9 Dorado 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 124, 5, '', 1, '2025-08-04 18:03:20', NULL),
(130, '122', '9 Palo de Rosa 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 30, 5, '', 1, '2025-08-04 18:04:15', NULL),
(131, '123', '0 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 38, 5, '', 1, '2025-08-04 18:05:20', NULL),
(132, '124', '0 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 8, 5, '', 1, '2025-08-04 18:06:24', '2025-08-10 23:10:23'),
(133, '125', '0 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 0, 5, '', 1, '2025-08-04 18:07:11', NULL),
(134, '126', '1 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 176, 5, '', 1, '2025-08-04 18:07:43', '2025-08-09 09:38:57'),
(135, '127', '1 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 117, 5, '', 1, '2025-08-04 18:08:35', '2025-08-09 18:32:08'),
(136, '128', '1 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 0, 5, '', 1, '2025-08-04 18:09:16', NULL),
(137, '129', '3 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 90, 5, '', 1, '2025-08-04 18:09:48', NULL),
(138, '130', '3 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 83, 5, '', 1, '2025-08-04 18:10:35', NULL),
(139, '131', '3 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 0, 5, '', 1, '2025-08-04 18:11:12', '2025-08-04 18:11:22'),
(140, '132', '4 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 34, 5, '', 1, '2025-08-04 18:11:56', NULL),
(141, '133', '4 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 38, 5, '', 1, '2025-08-04 18:12:28', NULL),
(142, '134', '4 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 14, 5, '', 1, '2025-08-04 18:13:08', NULL),
(143, '135', '5 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 29, 5, '', 1, '2025-08-04 18:13:42', '2025-08-09 18:32:08'),
(144, '136', '5 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 68, 5, '', 1, '2025-08-04 18:14:14', NULL),
(145, '137', '5 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 5000.00, 0.00, 0, 5, '', 1, '2025-08-04 18:15:01', NULL),
(146, '138', '6 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 16, 5, '', 1, '2025-08-04 18:18:25', NULL),
(147, '139', '6 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 39, 5, '', 1, '2025-08-04 18:19:05', NULL),
(148, '140', '6 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 50, 5, '', 1, '2025-08-04 18:19:50', NULL),
(149, '141', '7 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 9, 5, '', 1, '2025-08-04 18:20:38', NULL),
(150, '142', '7 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 64, 5, '', 1, '2025-08-04 18:21:18', '2025-08-08 09:20:06'),
(151, '143', '7 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 74, 5, '', 1, '2025-08-04 18:22:08', '2025-08-04 18:22:23'),
(152, '144', '8 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 72, 5, '', 1, '2025-08-04 18:22:58', NULL),
(153, '145', '8 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 61, 5, '', 1, '2025-08-04 18:23:47', NULL),
(154, '146', '8 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 14, 5, '', 1, '2025-08-04 18:24:29', NULL),
(155, '147', '9 Plateado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 139, 5, '', 1, '2025-08-04 18:25:13', NULL),
(156, '148', '9 Dorado 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 118, 5, '', 1, '2025-08-04 18:25:55', NULL),
(157, '149', '9 Palo de Rosa 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 8, 5, '', 1, '2025-08-04 18:26:29', NULL),
(158, '150', '0 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 16, 5, '', 1, '2025-08-04 18:27:25', NULL),
(159, '151', '0 Fucsia 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 2, 5, '', 1, '2025-08-04 18:27:57', NULL),
(160, '152', '0 Azul 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 7, 5, '', 1, '2025-08-04 18:28:32', '2025-08-10 23:10:23'),
(161, '153', '4 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 6, 5, '', 1, '2025-08-04 18:29:09', NULL),
(162, '154', '5 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 5, 5, '', 1, '2025-08-04 18:29:50', NULL),
(163, '155', '4 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 2, 5, '', 1, '2025-08-04 18:30:29', NULL),
(164, '156', '6 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 3, 5, '', 1, '2025-08-05 09:19:04', NULL),
(165, '157', '6 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 10, 5, '', 1, '2025-08-05 09:19:40', NULL),
(166, '158', '6 Fucsia 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 1, 5, '', 1, '2025-08-05 09:20:24', '2025-08-05 09:21:57'),
(167, '159', '6 Negro 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 9, 5, '', 1, '2025-08-05 09:20:52', '2025-08-05 09:21:42'),
(168, '160', '9 Negro 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 4, 5, '', 1, '2025-08-05 09:21:28', NULL),
(169, '161', '3 Negro 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 1, 5, '', 1, '2025-08-05 09:22:45', NULL),
(170, '162', '9 Fucsia 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 2, 5, '', 1, '2025-08-05 09:23:30', NULL),
(171, '163', '2 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 1, 5, '', 1, '2025-08-05 09:24:23', NULL),
(172, '164', '7 Fucsia 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 2, 5, '', 1, '2025-08-05 09:25:17', NULL),
(173, '165', '3 Fucsia 32\"', '', 7, 'unidad', 2000.00, 4000.00, 0.00, 1, 5, '', 1, '2025-08-05 09:26:00', NULL),
(174, '166', '7 Azul 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 1, 5, '', 1, '2025-08-05 09:27:08', NULL),
(175, '167', '7 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 6, 5, '', 1, '2025-08-05 09:28:22', NULL),
(176, '168', '7 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 13, 5, '', 1, '2025-08-05 09:28:54', NULL),
(177, '169', '8 Azul 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 1, 5, '', 1, '2025-08-05 09:29:30', NULL),
(178, '170', '8 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 10, 5, '', 1, '2025-08-05 09:30:14', NULL),
(179, '171', '8 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 13, 5, '', 1, '2025-08-05 09:30:39', NULL),
(180, '172', '9 Fucsia 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 12, 5, '', 1, '2025-08-05 09:31:55', NULL),
(181, '173', '9 Azul 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 7, 5, '', 1, '2025-08-05 09:32:29', NULL),
(182, '174', '9 Negro 16\"', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 9, 5, '', 1, '2025-08-05 09:33:07', '2025-08-08 09:20:06'),
(183, '175', 'Bolsa de Regalo de 4000', '', 10, 'unidad', 2000.00, 4000.00, 0.00, 24, 5, '', 1, '2025-08-05 09:51:47', NULL),
(184, '176', 'Bolsa de Regalo de papel crack 4000', '', 10, 'unidad', 2500.00, 4000.00, 0.00, 56, 5, '', 1, '2025-08-05 09:52:41', NULL),
(185, '177', 'Bolsa de Regalo de 3000', '', 10, 'unidad', 1700.00, 3000.00, 0.00, 68, 5, '', 1, '2025-08-05 09:53:18', '2025-08-10 23:10:23'),
(186, '178', 'Bolsa de Regalo de papel crack 2000', '', 10, 'unidad', 900.00, 2000.00, 0.00, 45, 5, '', 1, '2025-08-05 09:53:59', '2025-08-09 09:00:27'),
(187, '179', 'Bolsa de Regalo Estampada 4000', '', 10, 'unidad', 2200.00, 4000.00, 0.00, 1, 5, '', 1, '2025-08-05 09:54:51', NULL),
(188, '180', 'Bolsa de Regalo Estampada 3000', '', 10, 'unidad', 1500.00, 3000.00, 0.00, 2, 5, '', 1, '2025-08-05 09:55:23', NULL),
(189, '181', 'Bolsa grande de Regalo Acetato Mama', '', 10, 'unidad', 5000.00, 8000.00, 0.00, 14, 5, '', 1, '2025-08-05 09:56:27', '2025-08-10 23:10:23'),
(190, '182', 'Bolsa de Regalo de Acetato con tiras', '', 10, 'unidad', 6000.00, 11000.00, 0.00, 15, 5, '', 1, '2025-08-05 09:57:14', NULL),
(191, '183', 'Cortina Plateada de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 69, 5, '', 1, '2025-08-05 10:56:48', '2025-08-08 11:10:52'),
(192, '184', 'Cortina Dorada de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 25, 5, '', 1, '2025-08-05 10:58:15', '2025-08-05 11:14:49'),
(193, '185', 'Cortina Dorada Mate de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 59, 5, '', 1, '2025-08-05 10:59:08', '2025-08-05 11:15:01'),
(194, '186', 'Cortina Palo de Rosa de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 21, 5, '', 1, '2025-08-05 11:00:09', '2025-08-05 11:15:20'),
(195, '187', 'Cortina Fucsia de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 78, 5, '', 1, '2025-08-05 11:01:23', '2025-08-05 11:15:33'),
(196, '188', 'Cortina Lila de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 22, 5, '', 1, '2025-08-05 11:02:16', '2025-08-05 11:15:50'),
(197, '189', 'Cortina Roja de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 36, 5, '', 1, '2025-08-05 11:03:06', '2025-08-05 11:16:03'),
(198, '190', 'Cortina Azul Claro de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 22, 5, '', 1, '2025-08-05 11:03:42', '2025-08-05 11:16:30'),
(199, '191', 'Cortina Azul Rey de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 10, 5, '', 1, '2025-08-05 11:04:28', '2025-08-05 11:16:49'),
(200, '192', 'Cortina Verde de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 16, 5, '', 1, '2025-08-05 11:05:04', '2025-08-05 11:16:57'),
(201, '193', 'Cortina Verde Eucalipto de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 14, 5, '', 1, '2025-08-05 11:05:43', '2025-08-05 11:17:08'),
(202, '194', 'Cortina Azul Tornasol de Tiras', '', 6, 'unidad', 2000.00, 6000.00, 0.00, 53, 5, '', 1, '2025-08-05 11:07:19', NULL),
(203, '195', 'Cortina Fucsia Tornasol de Tiras', '', 6, 'unidad', 2000.00, 6000.00, 0.00, 29, 5, '', 1, '2025-08-05 11:08:08', NULL),
(204, '196', 'Cortina Rosado Tornasol de Tiras', '', 6, 'unidad', 2000.00, 6000.00, 0.00, 59, 5, '', 1, '2025-08-05 11:09:02', NULL),
(205, '197', 'Cortina Amarillo Tornasol de Tiras', '', 6, 'unidad', 2000.00, 6000.00, 0.00, 53, 5, '', 1, '2025-08-05 11:09:48', NULL),
(206, '198', 'Cortina Blanco Tornasol de Tiras', '', 6, 'unidad', 2000.00, 6000.00, 0.00, 27, 5, '', 1, '2025-08-05 11:10:35', NULL),
(207, '199', 'Cortina Rosada de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 10, 5, '', 1, '2025-08-05 11:12:15', '2025-08-05 11:17:27'),
(208, '200', 'Cortina Morada de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 37, 5, '', 1, '2025-08-05 11:18:34', NULL),
(209, '201', 'Cortina Azul Rey de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 32, 5, '', 1, '2025-08-05 11:19:29', NULL),
(210, '202', 'Cortina Verde de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 33, 5, '', 1, '2025-08-05 11:20:31', NULL),
(211, '203', 'Cortina Roja de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 52, 5, '', 1, '2025-08-05 11:22:28', NULL),
(212, '204', 'Cortina Rosada de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 25, 5, '', 1, '2025-08-05 11:23:06', NULL),
(213, '205', 'Cortina Dorada de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 64, 5, '', 1, '2025-08-05 11:24:52', '2025-08-09 16:06:04'),
(214, 'P250805983', 'piñata', '', 40, 'unidad', 7000.00, 30000.00, 0.00, 2, 5, NULL, 3, '2025-08-05 11:27:51', '2025-08-05 11:29:52'),
(215, 'P250805462', 'piñata dinosaurio', '', 40, 'unidad', 1500.00, 20000.00, 0.00, 0, 5, NULL, 1, '2025-08-05 11:31:18', '2025-08-05 14:18:35'),
(216, 'P250805223', 'piñata azul', '', 40, 'unidad', 1700.00, 35000.00, 0.00, 2, 5, NULL, 1, '2025-08-05 11:39:45', '2025-08-05 11:42:19'),
(217, '206', 'Cortina Plateada de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 42, 5, '', 1, '2025-08-05 14:49:18', '2025-08-08 09:10:28'),
(218, '207', 'Cortina Azul Claro de Cuadros', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 15, 5, '', 1, '2025-08-05 14:50:00', NULL),
(219, '208', 'Cortina Plateada Estampada de Tiras', '', 6, 'unidad', 1500.00, 4500.00, 0.00, 16, 5, '', 1, '2025-08-05 14:51:00', NULL),
(220, '209', 'HBD Plateado', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 78, 5, '', 1, '2025-08-05 16:09:53', NULL),
(221, '210', 'HBD Rosado', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 85, 5, '', 1, '2025-08-05 16:12:25', NULL),
(222, '211', 'HBD Negro', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 85, 5, '', 1, '2025-08-05 16:12:53', NULL),
(223, '212', 'HBD Dorado', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 66, 5, '', 1, '2025-08-05 16:13:31', '2025-08-08 09:20:06'),
(224, '213', 'HBD Fucsia', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 96, 5, '', 1, '2025-08-05 16:14:36', NULL),
(225, '214', 'HBD Rojo', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 95, 5, '', 1, '2025-08-05 16:15:25', NULL),
(226, '215', 'HBD Colorido', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 4, 5, '', 1, '2025-08-05 16:15:54', NULL),
(227, '216', 'HBD Palo de Rosa', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 91, 5, '', 1, '2025-08-05 16:16:42', NULL),
(228, '217', 'HBD Azul', '', 56, 'unidad', 1500.00, 4500.00, 0.00, 81, 5, '', 1, '2025-08-05 16:18:09', NULL),
(229, 'P250806922', 'a', 'a', 28, 'unidad', 0.00, 1.00, 0.00, 1, 5, NULL, 3, '2025-08-06 02:39:26', '2025-08-06 02:47:15'),
(230, 'P250806163', 'a', 'a', 28, 'unidad', 0.00, 1.00, 0.00, 2, 5, NULL, 1, '2025-08-06 02:46:05', '2025-08-06 03:08:23'),
(231, 'MANUAL_9_1754466365', '123', 'Recurso manual para producción', 28, 'unidad', 0.00, 0.00, 0.00, -2, 5, NULL, 3, '2025-08-06 02:46:05', '2025-08-06 02:46:05'),
(232, '218', 'Bienvenido Dorado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 88, 5, '', 1, '2025-08-06 09:08:28', NULL),
(233, '219', 'Bienvenido Plateado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 89, 5, '', 1, '2025-08-06 09:09:30', NULL),
(234, '220', 'Mi Bautizo Dorado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 49, 5, '', 1, '2025-08-06 09:11:17', NULL),
(235, '221', 'Mi Bautizo Plateado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 20, 5, '', 1, '2025-08-06 09:12:16', NULL),
(236, '222', 'Mis 15 Dorado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 102, 5, '', 1, '2025-08-06 09:15:50', NULL),
(237, '223', 'Mis 15 Rosado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 99, 5, '', 1, '2025-08-06 09:16:46', NULL),
(238, '224', 'Mis 15 Palo de Rosa Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 102, 5, '', 1, '2025-08-06 09:17:36', NULL),
(239, '225', 'Mis 15 Plateado Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 32, 5, '', 1, '2025-08-06 09:18:12', NULL),
(240, '226', 'Mis 15 Azul Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 1, 5, '', 1, '2025-08-06 09:18:49', NULL),
(241, '227', 'Feliz Aniversario Palo de Rosa Metalizado', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 1, 5, '', 1, '2025-08-06 09:22:56', NULL),
(242, '228', 'Feliz Cumpleaños Dorado Metalizado', '', 56, 'unidad', 2000.00, 4500.00, 0.00, 1, 5, '', 1, '2025-08-06 09:24:24', NULL),
(243, '229', 'Feliz Cumpleaños Plateado Metalizado', '', 56, 'unidad', 2000.00, 4500.00, 0.00, 12, 5, '', 1, '2025-08-06 09:25:01', '2025-08-09 16:06:04'),
(244, '230', 'Feliz Cumpleaños Multicolor Metalizado', '', 56, 'unidad', 2000.00, 4500.00, 0.00, 4, 5, '', 1, '2025-08-06 09:25:36', NULL),
(245, '231', 'Buquets Surtidos', '', 35, 'unidad', 2500.00, 5500.00, 0.00, 178, 5, '', 1, '2025-08-06 09:28:16', NULL),
(246, '232', 'Corazon Multicolor Metalizado', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 13, 5, '', 1, '2025-08-06 09:44:20', NULL),
(247, '233', 'Estrella Multicolor Metalizado', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 10, 5, '', 1, '2025-08-06 09:45:22', NULL),
(248, '234', 'Luna con Estrella Dorada Metalizado', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 6, 5, '', 1, '2025-08-06 09:46:30', NULL),
(249, '235', 'Luna con Estrella Plateada Metalizado', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 4, 5, '', 1, '2025-08-06 09:47:55', NULL),
(250, '236', 'Luna con Estrella Palo de Rosa Metalizado', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 5, 5, '', 1, '2025-08-06 09:48:39', NULL),
(251, '237', 'Copa Dorada Metalizada', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 14, 5, '', 1, '2025-08-06 09:49:31', NULL),
(252, '238', 'Botella Palo de Rosa Metalizada', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 17, 5, '', 1, '2025-08-06 09:50:34', NULL),
(253, '239', 'Botella Negra Metalizada', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 17, 5, '', 1, '2025-08-06 09:51:09', NULL),
(254, '240', 'Corona Dorada Grande Metalizada', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 10, 5, '', 1, '2025-08-06 09:52:39', NULL),
(255, '241', 'Corona Plateada Grande Metalizada', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 13, 5, '', 1, '2025-08-06 09:53:29', NULL),
(256, '242', 'Corona Rosada Grande Metalizada', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 14, 5, '', 1, '2025-08-06 09:54:01', NULL),
(257, '243', 'Corona Azul Grande Metalizada', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 3, 5, '', 1, '2025-08-06 09:55:23', NULL),
(258, '244', 'Corona Negra Grande Metalizada', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 20, 5, '', 1, '2025-08-06 09:56:01', NULL),
(259, '245', 'Estrella de Mar Metalizada', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 6, 5, '', 1, '2025-08-06 09:57:22', NULL),
(260, '246', 'Caballito de Mar Metalizada', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 4, 5, '', 1, '2025-08-06 09:58:12', NULL),
(261, '247', 'Pulpo Metalizado', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 6, 5, '', 1, '2025-08-06 09:58:57', NULL),
(262, '248', 'Concha de Mar Metalizada', '', 56, 'unidad', 3000.00, 6000.00, 0.00, 9, 5, '', 1, '2025-08-06 10:02:32', NULL),
(263, '249', 'Aleta de Sirena Dorada Metalizada', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 7, 5, '', 1, '2025-08-06 10:04:01', NULL),
(264, '250', 'Aleta de Sirena Plateada Metalizada', '', 56, 'unidad', 1500.00, 3500.00, 0.00, 10, 5, '', 1, '2025-08-06 10:04:53', NULL),
(265, '251', 'Astronauta Metalizado', '', 56, 'unidad', 2500.00, 5000.00, 0.00, 7, 5, '', 1, '2025-08-06 10:05:40', NULL),
(266, '252', 'Emoji Metalizado', '', 56, 'unidad', 700.00, 1500.00, 0.00, 3, 5, '', 1, '2025-08-06 10:06:22', NULL),
(267, '253', 'Feliz Año Nuevo Metalizado', '', 56, 'unidad', 1500.00, 3000.00, 0.00, 4, 5, '', 1, '2025-08-06 10:07:04', NULL),
(268, '254', 'Pastel Metalizado', '', 56, 'unidad', 1000.00, 2500.00, 0.00, 2, 5, '', 1, '2025-08-06 10:07:40', NULL),
(269, '255', 'Love Plateado Metalizado', '', 56, 'unidad', 2000.00, 4000.00, 0.00, 2, 5, '', 1, '2025-08-06 10:09:51', NULL),
(270, '256', 'Letras Surtidas Metalizadas', '', 56, 'unidad', 800.00, 2000.00, 0.00, 86, 5, '', 1, '2025-08-06 10:10:34', NULL),
(271, 'P250806932', 'piñata dinosaurio verde', '', 40, 'unidad', 5000.00, 10000.00, 0.00, 2, 5, NULL, 1, '2025-08-06 10:22:14', '2025-08-06 10:22:14'),
(272, '257', 'Papel cometa rosado', '', 3, 'unidad', 20.00, 300.00, 0.00, 0, 5, '', 1, '2025-08-06 10:26:59', '2025-08-06 10:42:52'),
(273, 'P250806209', 'piñata peppa', '', 40, 'unidad', 40.00, 10000.00, 0.00, 2, 5, NULL, 1, '2025-08-06 10:28:15', '2025-08-06 10:28:15'),
(274, '258', 'Globos Individuales 200', '', 9, 'unidad', 1.00, 200.00, 0.00, 2000, 5, '', 1, '2025-08-06 10:59:34', '2025-08-08 11:01:56'),
(275, '259', 'Collar Hawaiano', '', 30, 'unidad', 300.00, 1000.00, 0.00, 90, 5, '', 1, '2025-08-06 14:41:50', NULL),
(276, '260', 'Cucharas de Personajes', '', 46, 'unidad', 500.00, 1000.00, 0.00, 79, 5, '', 1, '2025-08-06 14:42:47', NULL),
(277, '261', 'Cucharas x100', '', 46, 'unidad', 12000.00, 27000.00, 0.00, 9, 5, '', 1, '2025-08-06 14:45:37', '2025-08-06 14:47:12'),
(278, '262', 'Platos Desechables', '', 46, 'unidad', 3000.00, 7200.00, 0.00, 39, 5, '', 1, '2025-08-06 14:47:56', NULL),
(279, '263', 'Mantel de Anchetas', '', 51, 'unidad', 1200.00, 3000.00, 0.00, 22, 5, '', 1, '2025-08-06 14:48:36', NULL),
(280, '264', 'Feston', '', 59, 'unidad', 1500.00, 2500.00, 0.00, 102, 5, '', 1, '2025-08-06 14:49:33', '2025-08-07 10:09:14'),
(281, '265', 'Platos Desechables de Personajes', '', 46, 'unidad', 1200.00, 3000.00, 0.00, 2, 5, '', 1, '2025-08-06 14:50:59', '2025-08-06 14:51:17'),
(282, '266', 'Banderin Colorido', '', 22, 'unidad', 1800.00, 4500.00, 0.00, 11, 5, '', 1, '2025-08-06 14:52:48', NULL),
(283, '267', 'Aplique en Icopor para Tortas', '', 57, 'unidad', 1500.00, 3000.00, 0.00, 39, 5, '', 1, '2025-08-06 14:55:32', NULL),
(284, '268', 'calabazas de Hallowen', '', 57, 'unidad', 800.00, 1500.00, 0.00, 28, 5, '', 1, '2025-08-06 14:56:42', NULL),
(285, '269', 'Fondo de Personajes Pequeño', '', 43, 'unidad', 6000.00, 12000.00, 0.00, 12, 5, '', 1, '2025-08-06 14:57:37', NULL),
(286, '270', 'Fondo de Personajes Grande', '', 43, 'unidad', 12000.00, 30000.00, 0.00, 7, 5, '', 1, '2025-08-06 14:58:39', NULL),
(287, '271', 'Apliques Medianos en Icopor', '', 57, 'unidad', 1500.00, 4000.00, 0.00, 17, 5, '', 1, '2025-08-06 15:00:25', NULL),
(288, '272', 'Apliques Grandes en Icopor', '', 57, 'unidad', 4000.00, 10000.00, 0.00, 2, 5, '', 1, '2025-08-06 15:01:07', NULL),
(289, '273', 'Numeros Grandes en Icopor', '', 57, 'unidad', 1500.00, 6000.00, 0.00, 6, 5, '', 1, '2025-08-06 15:02:00', NULL),
(290, '274', 'Apliques Pequeños en Icopor', '', 57, 'unidad', 1200.00, 3000.00, 0.00, 24, 5, '', 1, '2025-08-06 15:03:03', NULL),
(291, '275', 'Bomboneras en Icopor', '', 58, 'unidad', 12000.00, 25000.00, 0.00, 18, 5, '', 1, '2025-08-06 15:04:47', NULL),
(292, '276', 'Parche de Pirata', '', 52, 'unidad', 900.00, 2500.00, 0.00, 8, 5, '', 1, '2025-08-06 15:12:56', '2025-08-08 09:29:56'),
(293, '277', 'Arañas', '', 52, 'unidad', 2000.00, 4500.00, 0.00, 20, 5, '', 1, '2025-08-06 15:13:49', NULL),
(294, '278', 'Banderin Cuadrado de Personajes', '', 22, 'unidad', 1500.00, 3000.00, 0.00, 24, 5, '', 1, '2025-08-06 15:15:27', NULL),
(295, '279', 'Antifaz de Personajes', '', 59, 'unidad', 1200.00, 2500.00, 0.00, 7, 5, '', 1, '2025-08-06 15:16:50', NULL),
(296, '280', 'Gafas Doradas', '', 59, 'unidad', 1200.00, 2500.00, 0.00, 3, 5, '', 1, '2025-08-06 15:17:53', NULL),
(297, '281', 'Piñatas de Carton', '', 40, 'unidad', 2500.00, 5000.00, 0.00, 4, 5, '', 1, '2025-08-06 15:23:56', NULL),
(298, '282', 'Porta Flores x4', '', 59, 'unidad', 2000.00, 4000.00, 0.00, 3, 5, '', 1, '2025-08-06 15:25:26', NULL),
(299, '283', 'Alas de Mariposas', '', 52, 'unidad', 8000.00, 15000.00, 0.00, 2, 5, '', 1, '2025-08-06 15:30:34', NULL),
(300, '284', 'Disfraz', '', 52, 'unidad', 18000.00, 30000.00, 0.00, 10, 5, '', 1, '2025-08-06 15:31:35', NULL),
(301, '285', 'Esquela con Soporte', '', 13, 'unidad', 6000.00, 10000.00, 0.00, 8, 5, '', 1, '2025-08-06 15:32:25', NULL),
(302, '286', 'Flores de 2000', '', 12, 'unidad', 800.00, 2000.00, 0.00, 198, 5, '', 1, '2025-08-06 16:57:57', NULL),
(303, '287', 'Flores de 3000', '', 12, 'unidad', 1200.00, 3000.00, 0.00, 108, 5, '', 1, '2025-08-06 16:59:44', NULL),
(304, '288', 'Flores de 4000', '', 12, 'unidad', 2000.00, 4000.00, 0.00, 35, 5, '', 1, '2025-08-06 17:00:54', NULL),
(305, '289', 'Girasol', '', 12, 'unidad', 2500.00, 5000.00, 0.00, 18, 5, '', 1, '2025-08-06 17:09:23', '2025-08-06 17:09:41'),
(306, '290', 'Margaritas', '', 12, 'unidad', 4000.00, 8000.00, 0.00, 11, 5, '', 1, '2025-08-06 17:10:24', NULL),
(307, '291', 'Cayenas', '', 12, 'unidad', 2500.00, 5000.00, 0.00, 4, 5, '', 1, '2025-08-06 17:11:08', NULL),
(308, '292', 'Flor Negra Grande', '', 12, 'unidad', 4000.00, 7000.00, 0.00, 12, 5, '', 1, '2025-08-06 17:12:31', NULL),
(309, '293', 'Hojas Pequeñas', '', 50, 'unidad', 800.00, 2000.00, 0.00, 4, 5, '', 1, '2025-08-06 17:13:29', NULL),
(310, '294', 'Hojas Medianas', '', 50, 'unidad', 1200.00, 3000.00, 0.00, 46, 5, '', 1, '2025-08-06 17:14:24', NULL),
(311, '295', 'Hojas Grandes', '', 50, 'unidad', 1200.00, 3500.00, 0.00, 17, 5, '', 1, '2025-08-06 17:15:06', NULL),
(312, '296', 'Hojas Surtidas', '', 50, 'unidad', 1200.00, 3500.00, 0.00, 7, 5, '', 1, '2025-08-06 17:15:46', NULL),
(313, '297', 'Hojas con Soporte', '', 50, 'unidad', 1200.00, 3000.00, 0.00, 12, 5, '', 1, '2025-08-06 17:16:23', NULL),
(314, '298', 'Abanico Pequeño', '', 28, 'unidad', 1000.00, 2500.00, 0.00, 40, 5, '', 1, '2025-08-06 17:28:11', NULL),
(315, '299', 'Abanico Grande', '', 28, 'unidad', 2000.00, 4000.00, 0.00, 152, 5, '', 1, '2025-08-06 18:39:32', NULL),
(316, '300', 'Corbatin Hora Loca', '', 30, 'unidad', 3000.00, 7200.00, 0.00, 6, 5, '', 1, '2025-08-07 08:53:55', NULL),
(317, '301', 'Antifaz Hora Loca', '', 30, 'unidad', 5000.00, 10500.00, 0.00, 1, 5, '', 1, '2025-08-07 08:54:39', NULL),
(318, '302', 'Velas Neón Hora Loca', '', 30, 'unidad', 6000.00, 12000.00, 0.00, 19, 5, '', 1, '2025-08-07 08:55:45', NULL),
(319, '303', 'Vinchas FC Neon', '', 30, 'unidad', 12000.00, 25000.00, 0.00, 6, 5, '', 1, '2025-08-07 08:57:08', NULL),
(320, '304', 'Vinchas Neon', '', 30, 'unidad', 9000.00, 20000.00, 0.00, 1, 5, '', 1, '2025-08-07 08:58:10', NULL),
(321, '305', 'Vinchas de Personajes', '', 30, 'unidad', 4000.00, 10000.00, 0.00, 8, 5, '', 1, '2025-08-07 08:58:53', NULL),
(322, '306', 'Vasos Tequila', '', 30, 'unidad', 1500.00, 3000.00, 0.00, 96, 5, '', 1, '2025-08-07 09:12:58', NULL),
(323, '307', 'Vasos Cervecero', '', 30, 'unidad', 1000.00, 2000.00, 0.00, 96, 5, '', 1, '2025-08-07 09:14:21', NULL),
(324, '308', 'Vasos Aguardiente Grande', '', 30, 'unidad', 1000.00, 2500.00, 0.00, 95, 5, '', 1, '2025-08-07 09:15:29', NULL),
(325, '309', 'Vasos Aguardiente Pequeño', '', 30, 'unidad', 1000.00, 2000.00, 0.00, 84, 5, '', 1, '2025-08-07 09:16:28', NULL),
(326, '310', 'Pitillos x100 Neon', '', 46, 'unidad', 2500.00, 5000.00, 0.00, 31, 5, '', 1, '2025-08-07 10:01:41', NULL),
(327, '311', 'Lasos en Foami', '', 59, 'unidad', 1200.00, 3000.00, 0.00, 59, 5, '', 1, '2025-08-07 10:04:27', NULL),
(328, '312', 'Bases para Ramos en Cartulina', '', 12, 'unidad', 2000.00, 4000.00, 0.00, 15, 5, '', 1, '2025-08-07 10:05:23', NULL),
(329, '313', 'Bases para Ramos en Papel Coreano', '', 12, 'unidad', 2200.00, 5000.00, 0.00, 37, 5, '', 1, '2025-08-07 10:06:04', NULL),
(330, '314', 'Bases para Ramos en Fomi', '', 12, 'unidad', 4300.00, 8000.00, 0.00, 12, 5, '', 1, '2025-08-07 10:07:41', NULL),
(331, '315', 'Porta Rosas', '', 12, 'unidad', 2000.00, 4000.00, 0.00, 24, 5, '', 1, '2025-08-07 10:12:05', NULL),
(332, '316', 'Pines Para Personalizar', '', 19, 'unidad', 2000.00, 4500.00, 0.00, 33, 5, '', 1, '2025-08-07 10:15:55', NULL),
(333, '317', 'Esquela personalizable', '', 13, 'unidad', 2500.00, 5000.00, 0.00, 15, 5, '', 1, '2025-08-07 10:17:32', NULL),
(334, '318', 'Rosas en Fomi x paquete', '', 12, 'unidad', 3000.00, 7000.00, 0.00, 3, 5, '', 1, '2025-08-07 10:18:45', NULL),
(335, '319', 'Osos en Resina', '', 59, 'unidad', 1000.00, 2000.00, 0.00, 50, 5, '', 1, '2025-08-07 10:19:47', NULL),
(336, '320', 'Topper mis 15 Plastico', '', 26, 'unidad', 1200.00, 2000.00, 0.00, 7, 5, '', 1, '2025-08-07 10:23:35', NULL),
(337, '321', 'Topper rosas en cartulina pequeñas', '', 26, 'unidad', 1000.00, 2000.00, 0.00, 13, 5, '', 1, '2025-08-07 10:24:39', NULL),
(338, '322', 'Topper rosas en cartulina Grande', '', 26, 'unidad', 2500.00, 5000.00, 0.00, 3, 5, '', 1, '2025-08-07 10:25:28', NULL),
(339, '323', 'Topper Te Amo Troquelado', '', 26, 'unidad', 1000.00, 2000.00, 0.00, 59, 5, '', 1, '2025-08-07 10:26:51', NULL),
(340, '324', 'Topper Love Corazón cartulina Metalizada', '', 26, 'unidad', 1500.00, 3000.00, 0.00, 7, 5, '', 1, '2025-08-07 14:13:33', NULL),
(341, '325', 'Topper Feliz Dia mama Redondo', '', 26, 'unidad', 1000.00, 2000.00, 0.00, 15, 5, '', 1, '2025-08-07 14:16:05', '2025-08-08 16:52:37'),
(342, '326', 'Fondo Amor y Amistad Redondo', '', 25, 'unidad', 2000.00, 4000.00, 0.00, 14, 5, '', 1, '2025-08-07 14:17:20', NULL),
(343, '327', 'Topper Feliz Dia en 3d', '', 26, 'unidad', 1200.00, 3000.00, 0.00, 2, 5, '', 1, '2025-08-07 14:18:41', NULL),
(344, '328', 'Topper Mi Bautizo 3d', '', 26, 'unidad', 1500.00, 4000.00, 0.00, 4, 5, '', 1, '2025-08-07 14:19:25', NULL),
(345, '329', 'Topper Feliz Aniversario 3d', '', 26, 'unidad', 2000.00, 4000.00, 0.00, 5, 5, '', 1, '2025-08-07 14:20:23', NULL),
(346, '330', 'Topper de Personajes 3d', '', 26, 'unidad', 8000.00, 14000.00, 0.00, 58, 5, '', 1, '2025-08-07 14:21:13', NULL),
(347, '331', 'Topper de Personajes en 2d', '', 26, 'unidad', 4000.00, 8000.00, 0.00, 2, 5, '', 1, '2025-08-07 14:22:13', NULL),
(348, '332', 'Hojas de Cartulina Troqueladas Pequeñas', '', 50, 'unidad', 1200.00, 3000.00, 0.00, 12, 5, '', 1, '2025-08-07 14:24:17', NULL),
(349, '333', 'Topper Happy Birthday Cartulina Metalizada', '', 26, 'unidad', 1000.00, 2000.00, 0.00, 20, 5, '', 1, '2025-08-07 14:25:57', NULL),
(350, '334', 'Topper Happy Birthday de cartulina 2d', '', 26, 'unidad', 2000.00, 4000.00, 0.00, 8, 5, '', 1, '2025-08-07 14:30:03', NULL),
(351, '335', 'Topper Happy Birthday Metalizado Redondo', '', 26, 'unidad', 2000.00, 4000.00, 0.00, 3, 5, '', 1, '2025-08-07 14:31:40', NULL),
(352, '336', 'Corona de Carton metalizada', '', 27, 'unidad', 2000.00, 5000.00, 0.00, 8, 5, '', 1, '2025-08-07 14:33:00', NULL),
(353, '337', 'Hojas Troqueladas de cartulina metalizada', '', 50, 'unidad', 2000.00, 4000.00, 0.00, 30, 5, '', 1, '2025-08-07 14:34:21', NULL),
(354, '338', 'Banderin Te Quiero Mini', '', 22, 'unidad', 1500.00, 3000.00, 0.00, 10, 5, '', 1, '2025-08-07 14:37:22', NULL),
(355, '339', 'Banderin Feliz Dia papá mini', '', 22, 'unidad', 1000.00, 2000.00, 0.00, 13, 5, '', 1, '2025-08-07 14:38:31', NULL),
(356, '340', 'Love de Luz Led', '', 59, 'unidad', 5000.00, 12000.00, 0.00, 11, 5, '', 1, '2025-08-07 14:39:43', '2025-08-07 14:39:50'),
(357, '341', 'Bases de Trufas', '', 59, 'unidad', 1500.00, 2400.00, 0.00, 7, 5, '', 1, '2025-08-07 14:40:55', NULL),
(358, '342', 'Liston de ramos', '', 12, 'unidad', 2200.00, 5000.00, 0.00, 18, 5, '', 1, '2025-08-07 14:41:36', NULL),
(359, '343', 'Frases en Vinilo de 3000', '', 49, 'unidad', 1000.00, 3000.00, 0.00, 98, 5, '', 1, '2025-08-07 14:42:36', NULL),
(360, '344', 'Topper niña Morena', '', 26, 'unidad', 2000.00, 5000.00, 0.00, 1, 5, '', 1, '2025-08-07 14:43:31', NULL),
(361, '345', 'Aplique de Osos', '', 26, 'unidad', 2000.00, 5000.00, 0.00, 5, 5, '', 1, '2025-08-07 14:44:45', NULL),
(362, '346', 'Cajita Dulcera Mini', '', 5, 'unidad', 1000.00, 2000.00, 0.00, 5, 5, '', 1, '2025-08-07 14:45:24', NULL),
(363, '347', 'Caja Cono', '', 5, 'unidad', 3500.00, 6000.00, 0.00, 23, 5, '', 1, '2025-08-07 14:46:07', NULL),
(364, '348', 'Penachos', '', 24, 'unidad', 4000.00, 6500.00, 0.00, 104, 5, '', 1, '2025-08-07 14:47:38', NULL),
(365, '349', 'Lasos en tela', '', 31, 'unidad', 4000.00, 6000.00, 0.00, 107, 5, '', 1, '2025-08-07 14:49:38', NULL),
(366, '350', 'Moños de 2000', '', 45, 'unidad', 1000.00, 2000.00, 0.00, 30, 5, '', 1, '2025-08-07 14:51:01', '2025-08-08 18:04:10'),
(367, '351', 'Banderin Carnavalero', '', 22, 'unidad', 2500.00, 5000.00, 0.00, 4, 5, '', 1, '2025-08-07 14:57:07', NULL),
(368, '352', 'Pin FeliZ Dia Mama', '', 19, 'unidad', 6000.00, 11000.00, 0.00, 51, 5, '', 1, '2025-08-07 14:58:35', '2025-08-17 21:45:45'),
(369, '353', 'Mariposas cameo medianas en 3d', '', 59, 'unidad', 1500.00, 3000.00, 0.00, 3, 5, '', 1, '2025-08-07 15:00:00', NULL),
(370, '354', 'Porta tarjetas', '', 59, 'unidad', 2500.00, 4800.00, 0.00, 18, 5, '', 1, '2025-08-07 15:00:50', NULL),
(371, '355', 'Mariposa Grande Cameo', '', 59, 'unidad', 5000.00, 10000.00, 0.00, 2, 5, '', 1, '2025-08-07 15:02:16', NULL),
(372, '356', 'Pin Escribible', '', 19, 'unidad', 2000.00, 4500.00, 0.00, 15, 5, '', 1, '2025-08-07 15:03:38', '2025-08-17 21:22:55'),
(373, '357', 'Paquete de Rosas Troqueladas Sin armar', '', 12, 'unidad', 1000.00, 2000.00, 0.00, 9, 5, '', 1, '2025-08-07 15:08:40', NULL),
(374, '358', 'Piñata Mini', '', 40, 'unidad', 8000.00, 15000.00, 0.00, 12, 5, '', 1, '2025-08-07 15:09:19', NULL),
(375, '359', 'Picadillo de papel cometa', '', 17, 'unidad', 800.00, 2000.00, 0.00, 365, 5, '', 1, '2025-08-07 15:14:36', '2025-08-09 10:54:02'),
(376, '360', 'Picadillo de papel Metalizado', '', 17, 'unidad', 1200.00, 2500.00, 0.00, 70, 5, '', 1, '2025-08-07 15:16:24', '2025-08-08 17:18:25'),
(377, '361', 'Cajas Sorpresa de Personajes', '', 21, 'unidad', 4000.00, 9000.00, 0.00, 53, 5, '', 1, '2025-08-07 15:25:32', NULL),
(378, '362', 'Tarjetas de Invitación de 3000', '', 15, 'unidad', 1500.00, 3000.00, 0.00, 63, 5, '', 1, '2025-08-07 15:26:31', NULL),
(379, '363', 'Tarjetas de Invitación de 2000', '', 15, 'unidad', 1000.00, 2000.00, 0.00, 911, 5, '', 1, '2025-08-07 15:29:39', '2025-08-08 09:20:06'),
(380, '364', 'Bandas', '', 59, 'unidad', 2500.00, 5800.00, 0.00, 143, 5, '', 1, '2025-08-07 15:40:01', '2025-08-17 18:45:52'),
(381, '365', 'Banderin Manual', '', 22, 'unidad', 2500.00, 5000.00, 0.00, 22, 5, '', 1, '2025-08-07 15:42:25', NULL),
(382, '366', 'Banderin Fashión', '', 22, 'unidad', 2000.00, 4000.00, 0.00, 1, 5, '', 1, '2025-08-07 15:43:02', NULL),
(383, '367', 'Fondo de Anchetas de 5000', '', 25, 'unidad', 2300.00, 5000.00, 0.00, 27, 5, '', 1, '2025-08-07 15:44:18', NULL),
(384, '368', 'Fondo de Anchetas de 4000', '', 25, 'unidad', 2000.00, 4000.00, 0.00, 128, 5, '', 1, '2025-08-07 15:44:59', NULL),
(385, '369', 'Banderin Triangular', '', 22, 'unidad', 2000.00, 4000.00, 0.00, 76, 5, '', 1, '2025-08-07 15:46:22', NULL),
(386, '370', 'Banner Feliz Cumpleaños', '', 59, 'unidad', 1500.00, 3500.00, 0.00, 117, 5, '', 1, '2025-08-07 15:48:19', NULL),
(387, '371', 'Pin Feliz Cumpleaños de Madera', '', 19, 'unidad', 2600.00, 4500.00, 0.00, 86, 5, '', 1, '2025-08-07 15:49:21', '2025-08-17 18:45:52'),
(388, '372', 'Pin Feliz Cumpleaños Acrilico', '', 19, 'unidad', 1600.00, 3800.00, 0.00, 340, 5, '', 1, '2025-08-07 15:50:56', '2025-08-09 17:55:04'),
(389, '373', 'Pin numero en Acrilico', '', 19, 'unidad', 1200.00, 3000.00, 0.00, 21, 5, '', 1, '2025-08-07 15:52:13', NULL),
(390, '374', 'Crispetera', '', 59, 'unidad', 1200.00, 2500.00, 0.00, 44, 5, '', 1, '2025-08-07 15:53:21', NULL),
(391, '375', 'Corona Pequeña', '', 27, 'unidad', 2600.00, 4500.00, 0.00, 23, 5, '', 1, '2025-08-07 15:54:14', NULL),
(392, '376', 'Mariposas 2d', '', 59, 'unidad', 3000.00, 5800.00, 0.00, 31, 5, '', 1, '2025-08-07 15:55:56', NULL),
(393, '377', 'Mariposas Troqueladas', '', 59, 'unidad', 2900.00, 5500.00, 0.00, 60, 5, '', 1, '2025-08-07 15:56:40', NULL),
(394, '378', 'Mariposas Negra', '', 59, 'unidad', 3000.00, 5500.00, 0.00, 59, 5, '', 1, '2025-08-07 15:57:33', NULL),
(395, '379', 'Mariposas Blancas', '', 59, 'unidad', 3000.00, 5500.00, 0.00, 50, 5, '', 1, '2025-08-07 15:58:44', '2025-08-09 15:34:25'),
(396, '380', 'Mariposas de Colores', '', 59, 'unidad', 3000.00, 5800.00, 0.00, 50, 5, '', 1, '2025-08-07 15:59:50', '2025-08-07 16:00:11'),
(397, '381', 'Mariposas Cameo', '', 59, 'unidad', 1500.00, 3000.00, 0.00, 43, 5, '', 1, '2025-08-07 16:01:44', NULL),
(398, '382', 'Velas Espiral', '', 14, 'unidad', 2200.00, 4200.00, 0.00, 121, 5, '', 1, '2025-08-07 16:02:58', '2025-08-09 08:42:31'),
(399, '383', 'Velas x6', '', 14, 'unidad', 1000.00, 2000.00, 0.00, 658, 5, '', 1, '2025-08-07 16:05:12', NULL),
(400, '384', 'velas x8', '', 14, 'unidad', 2500.00, 4500.00, 0.00, 347, 5, '', 1, '2025-08-07 16:11:20', '2025-08-08 18:03:43'),
(401, '385', 'Velas x12', '', 14, 'unidad', 2500.00, 5000.00, 0.00, 271, 5, '', 1, '2025-08-07 16:14:14', NULL),
(402, '386', 'Velas Feliz Cumpleaños Sencilla', '', 14, 'unidad', 2500.00, 5000.00, 0.00, 261, 5, '', 1, '2025-08-07 16:17:34', NULL),
(403, '387', 'Velas Feliz Cumpleaños Corazon', '', 14, 'unidad', 3000.00, 6000.00, 0.00, 71, 5, '', 1, '2025-08-07 16:18:38', '2025-08-07 16:20:51'),
(404, '388', 'Velas Feliz Cumpleaños', '', 14, 'unidad', 2500.00, 5500.00, 0.00, 195, 5, '', 1, '2025-08-07 16:21:52', NULL),
(405, '389', 'Velas Abanico', '', 14, 'unidad', 3000.00, 6000.00, 0.00, 31, 5, '', 1, '2025-08-07 16:22:51', NULL);
INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `categoria_id`, `unidad_venta`, `precio_compra`, `precio_venta`, `mano_obra`, `stock`, `stock_minimo`, `imagen`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(406, '390', 'Velas de Numeros', '', 14, 'unidad', 1000.00, 2000.00, 0.00, 159, 5, '', 1, '2025-08-07 16:23:33', NULL),
(407, '391', 'Velas Tono Pastel', '', 14, 'unidad', 3200.00, 6200.00, 0.00, 65, 5, '', 1, '2025-08-07 16:24:23', NULL),
(408, '392', 'Velas de Corazon Pequeño', '', 14, 'unidad', 2500.00, 5500.00, 0.00, 11, 5, '', 1, '2025-08-07 16:26:03', NULL),
(409, '393', 'Abrillantador de 13500', '', 47, 'unidad', 7000.00, 13500.00, 0.00, 14, 5, '', 1, '2025-08-07 16:27:13', NULL),
(410, '394', 'Abrillantador de 10000', '', 47, 'unidad', 5000.00, 10000.00, 0.00, 35, 5, '', 1, '2025-08-07 16:28:14', NULL),
(411, '395', 'Vinilos de 2500', '', 49, 'unidad', 1500.00, 2500.00, 0.00, 186, 5, '', 1, '2025-08-07 16:49:27', NULL),
(412, '396', 'Vinilos de 1000', '', 49, 'unidad', 500.00, 1000.00, 0.00, 155, 5, '', 1, '2025-08-07 16:54:47', NULL),
(413, '397', 'Luz Led', '', 59, 'unidad', 2000.00, 4500.00, 0.00, 20, 5, '', 1, '2025-08-07 16:56:24', NULL),
(414, '398', 'Lluvia de Escarcha', '', 59, 'unidad', 1500.00, 2500.00, 0.00, 30, 5, '', 1, '2025-08-07 16:57:40', NULL),
(415, '399', 'Escarcha Tornasol', '', 59, 'unidad', 1500.00, 3000.00, 0.00, 15, 5, '', 1, '2025-08-07 16:58:15', NULL),
(416, '400', 'Botellas Tipo Leche Pequeña', '', 20, 'unidad', 1000.00, 2000.00, 0.00, 83, 5, '', 1, '2025-08-07 17:00:03', NULL),
(417, '401', 'Botellas Tipo Leche Grande', '', 20, 'unidad', 1500.00, 2500.00, 0.00, 96, 5, '', 1, '2025-08-07 17:00:54', NULL),
(418, '402', 'Botellas Tipo Compota', '', 20, 'unidad', 1500.00, 3000.00, 0.00, 89, 5, '', 1, '2025-08-07 17:01:41', NULL),
(419, '403', 'Botella Frasco Grande', '', 20, 'unidad', 2200.00, 3900.00, 0.00, 14, 5, '', 1, '2025-08-07 17:12:12', NULL),
(420, '404', 'Botella Frasco Pequeño', '', 20, 'unidad', 1800.00, 2700.00, 0.00, 22, 5, '', 1, '2025-08-07 17:12:43', NULL),
(421, '405', 'Botellas Tipo Jugo Pequeño', '', 20, 'unidad', 1000.00, 2000.00, 0.00, 47, 5, '', 1, '2025-08-07 17:14:14', NULL),
(422, '406', 'Botella Tipo Jugo Grande', '', 20, 'unidad', 1500.00, 3000.00, 0.00, 6, 5, '', 1, '2025-08-07 17:15:00', NULL),
(423, '407', 'Inflador Fino', '', 59, 'unidad', 4000.00, 9600.00, 0.00, 81, 5, '', 1, '2025-08-07 17:18:23', '2025-08-07 17:22:43'),
(424, '408', 'Inflador Sencillo', '', 59, 'unidad', 3300.00, 6600.00, 0.00, 19, 5, '', 1, '2025-08-07 17:19:08', NULL),
(425, '409', 'Esquelas de 12000', '', 13, 'unidad', 6000.00, 12000.00, 0.00, 5, 5, '', 1, '2025-08-07 17:24:37', NULL),
(426, '410', 'Esquelas de 6000', '', 13, 'unidad', 3000.00, 6000.00, 0.00, 27, 5, '', 1, '2025-08-07 17:25:35', NULL),
(427, '411', 'Esquelas de 5000', '', 13, 'unidad', 2500.00, 5000.00, 0.00, 6, 5, '', 1, '2025-08-07 17:26:01', NULL),
(428, '412', 'Esquelas de 4000', '', 13, 'unidad', 2000.00, 4000.00, 0.00, 44, 5, '', 1, '2025-08-07 17:30:27', NULL),
(429, '413', 'Esquelas de 3000', '', 13, 'unidad', 1500.00, 3000.00, 0.00, 27, 5, '', 1, '2025-08-07 17:30:57', NULL),
(430, 'P250808261', 'cajita', '', 5, 'unidad', 900.00, 15000.00, 20000.00, 4, 5, NULL, 3, '2025-08-08 09:23:43', '2025-08-08 09:26:46'),
(431, 'P250808497', 'cajitas', '', 5, 'unidad', 900.00, 10000.00, 2000.00, 1, 5, NULL, 1, '2025-08-08 09:29:56', '2025-08-08 09:33:31'),
(432, '414', 'globos individuales 400', '', 9, 'unidad', 100.00, 400.00, 0.00, 2000, 5, '', 1, '2025-08-08 10:27:50', '2025-08-08 11:01:48'),
(433, '415', 'globos individuales 1000', '', 9, 'unidad', 500.00, 1000.00, 0.00, 1999, 5, '', 1, '2025-08-08 10:29:12', '2025-08-08 14:15:06'),
(434, '416', 'globos individuales mil figuras', '', 9, 'unidad', 200.00, 500.00, 0.00, 2000, 5, '', 1, '2025-08-08 10:31:14', '2025-08-08 11:01:27'),
(435, '417', 'numero rojo metalizado', '', 7, 'unidad', 1500.00, 2500.00, 0.00, 30, 5, '', 1, '2025-08-08 12:01:20', NULL),
(436, '418', 'Globos Fucsia r9 x50', '', 4, 'unidad', 4500.00, 7500.00, 0.00, 3, 5, '', 1, '2025-08-08 15:33:24', '2025-08-08 15:33:55'),
(437, '419', 'Referencia 6052', '', 5, 'unidad', 1500.00, 3000.00, 0.00, 13, 5, '', 1, '2025-08-08 15:57:59', '2025-08-08 15:58:41'),
(438, '420', 'Referencia 6053', '', 5, 'unidad', 2000.00, 4000.00, 0.00, 10, 5, '', 1, '2025-08-08 15:59:26', NULL),
(439, '421', 'Referencia 6057', '', 5, 'unidad', 2500.00, 5000.00, 0.00, 7, 5, '', 1, '2025-08-08 16:00:33', '2025-08-09 10:54:02'),
(440, '422', 'Referencia 6069', '', 5, 'unidad', 2500.00, 5500.00, 0.00, 10, 5, '', 1, '2025-08-08 16:01:05', NULL),
(441, '423', 'Referencia 3032', '', 5, 'unidad', 4000.00, 8000.00, 0.00, 3, 5, '', 1, '2025-08-08 16:01:44', NULL),
(442, '424', 'Referencia 7350', '', 5, 'unidad', 2000.00, 4000.00, 0.00, 13, 5, '', 1, '2025-08-08 16:02:28', NULL),
(443, '425', 'Referencia 7351', '', 5, 'unidad', 3000.00, 6000.00, 0.00, 19, 5, '', 1, '2025-08-08 16:03:19', NULL),
(444, '426', 'Referencia 7352', '', 5, 'unidad', 4000.00, 8000.00, 0.00, 45, 5, '', 1, '2025-08-08 16:05:17', NULL),
(445, '427', 'Caja de Carton Personalizada 20000', '', 5, 'unidad', 10000.00, 20000.00, 0.00, 13, 5, '', 1, '2025-08-08 16:06:20', '2025-08-08 16:27:29'),
(446, '428', 'Caja Tipo Lonchera con Acetato', '', 5, 'unidad', 3000.00, 6000.00, 0.00, 16, 5, '', 1, '2025-08-08 16:07:24', NULL),
(447, '429', 'Caja Con Estrellas', '', 5, 'unidad', 3000.00, 6000.00, 0.00, 27, 5, '', 1, '2025-08-08 16:09:51', NULL),
(448, '430', 'Caja Tortera Verde', '', 5, 'unidad', 4000.00, 8000.00, 0.00, 6, 5, '', 1, '2025-08-08 16:16:18', NULL),
(449, '431', 'Caja agujero de corazon Grande', '', 5, 'unidad', 1500.00, 3000.00, 0.00, 2, 5, '', 1, '2025-08-08 16:17:58', '2025-08-08 16:23:17'),
(450, '432', 'Caja agujero de Corazon Pequeña', '', 5, 'unidad', 1000.00, 2000.00, 0.00, 3, 5, '', 1, '2025-08-08 16:23:01', NULL),
(451, '433', 'Caja Corazon de Acetato', '', 5, 'unidad', 6000.00, 12000.00, 0.00, 12, 5, '', 1, '2025-08-08 16:24:41', NULL),
(452, '434', 'Caja Tapa de Acetato Pequeña', '', 5, 'unidad', 4000.00, 8000.00, 0.00, 16, 5, '', 1, '2025-08-08 16:25:32', NULL),
(453, '435', 'Caja Tapa de Acetato Grande', '', 5, 'unidad', 7000.00, 15000.00, 0.00, 8, 5, '', 1, '2025-08-08 16:26:17', NULL),
(454, '436', 'Caja de Carton Personalizada 15000', '', 5, 'unidad', 4000.00, 7000.00, 0.00, 7, 5, '', 1, '2025-08-08 16:27:13', NULL),
(455, '437', 'Caja Rectangular con Tapa de Acetato', '', 5, 'unidad', 6000.00, 12000.00, 0.00, 4, 5, '', 1, '2025-08-08 16:29:03', NULL),
(456, '438', 'Caja Porta cerveza', '', 5, 'unidad', 4000.00, 7000.00, 0.00, 20, 5, '', 1, '2025-08-08 16:29:56', NULL),
(457, '439', 'Cajas de Dinosaurio', '', 5, 'unidad', 2500.00, 4500.00, 0.00, 35, 5, '', 1, '2025-08-08 16:33:04', NULL),
(458, '440', 'Crispeteras Individuales', '', 5, 'unidad', 1200.00, 2500.00, 0.00, 44, 5, '', 1, '2025-08-08 16:33:51', NULL),
(459, '441', 'Cubo Acetato Grande', '', 5, 'unidad', 5000.00, 11000.00, 0.00, 13, 5, '', 1, '2025-08-08 16:37:12', NULL),
(460, '442', 'Cubo Acetato Mediano', '', 5, 'unidad', 4000.00, 8000.00, 0.00, 15, 5, '', 1, '2025-08-08 16:37:58', NULL),
(461, '443', 'Cubo Acetato Pequeño', '', 5, 'unidad', 3000.00, 6000.00, 0.00, 6, 5, '', 1, '2025-08-08 16:38:29', NULL),
(462, '444', 'Lonchera Acetato Grande', '', 5, 'unidad', 6000.00, 10900.00, 0.00, 23, 5, '', 1, '2025-08-08 16:40:33', NULL),
(463, '445', 'Lonchera Acetato Mediana', '', 5, 'unidad', 3500.00, 7500.00, 0.00, 12, 5, '', 1, '2025-08-08 16:41:31', NULL),
(464, '446', 'Lonchera Acetato Pequeña', '', 5, 'unidad', 0.00, 1.00, 0.00, 0, 5, '', 1, '2025-08-08 16:42:11', NULL),
(465, '447', 'Caja Acetato Dulcera Grande', '', 5, 'unidad', 1400.00, 2800.00, 0.00, 51, 5, '', 1, '2025-08-08 16:46:35', NULL),
(466, '448', 'Caja Acetato Dulcera Mediana', '', 5, 'unidad', 1200.00, 2500.00, 0.00, 49, 5, '', 1, '2025-08-08 16:48:06', NULL),
(467, '449', 'Caja Acetato Dulcera Pequeña', '', 5, 'unidad', 1000.00, 2000.00, 0.00, 37, 5, '', 1, '2025-08-08 16:49:22', NULL),
(468, '450', 'Caja Acetato Dulcera Mini', '', 5, 'unidad', 900.00, 1900.00, 0.00, 45, 5, '', 1, '2025-08-08 16:49:58', NULL),
(469, '451', 'Caja Acetato Dulcera con oreja Grande', '', 5, 'unidad', 1500.00, 3000.00, 0.00, 47, 5, '', 1, '2025-08-08 16:51:22', NULL),
(470, '452', 'Caja Acetato Dulcera con oreja Pequeña', '', 5, 'unidad', 1500.00, 2500.00, 0.00, 50, 5, '', 1, '2025-08-08 16:51:52', NULL),
(471, '453', 'Bolsa Mediana de Regalo Acetato Mama', '', 5, 'unidad', 2500.00, 4500.00, 0.00, 9, 5, '', 1, '2025-08-08 16:54:30', NULL),
(472, '454', 'Bolsa Pequeña de Regalo Acetato Mama', '', 5, 'unidad', 2000.00, 4000.00, 0.00, 12, 5, '', 1, '2025-08-08 16:55:04', NULL);

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

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `telefono`, `email`, `direccion`, `estado`, `fecha_creacion`) VALUES
(4, 'globos.com', 'globo', '3233337961', '', '', 1, '2025-08-06 10:16:17');

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
(2, 'Venta', '', 1);

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
(3, 'Admin', 'Sistema', 'admin', 'admin@pinateria.com', '$2y$10$PdEEfkMLWcdpaIcG2vP0sOhz3DlYm1rcsrjFBZMrBGhJprHe/ZFTy', NULL, 1, 1, '2025-07-20 16:27:33', '2025-07-31 13:33:33'),
(10, 'venta', '1', 'venta', 'venta@pinateria.com', '$2y$10$FtCz7u7APkRth3jcL5Nwj.s6XXfS0ZpkY33Cp8yZmzyuJBYmLeacu', NULL, 2, 1, '2025-08-04 08:29:18', '2025-08-04 08:30:32');

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
  `destino` enum('normal','creacion') DEFAULT 'normal',
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `fecha_venta`, `subtotal`, `impuestos`, `descuentos`, `total`, `pago_con`, `cambio`, `costo_total`, `ganancia`, `metodo_pago`, `estado`, `observaciones`, `destino`, `usuario_id`, `fecha_creacion`) VALUES
(112, NULL, '2025-08-16 00:49:13', 18000.00, 0.00, 0.00, 18000.00, 60000.00, 2000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-16 00:49:13'),
(114, NULL, '2025-08-17 00:20:29', 18000.00, 0.00, 0.00, 18000.00, 20000.00, 2000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 00:20:29'),
(116, NULL, '2025-08-17 00:24:00', 7500.00, 0.00, 0.00, 7500.00, 150000.00, 7100.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 00:24:00'),
(117, NULL, '2025-08-17 00:25:05', 27000.00, 0.00, 0.00, 27000.00, 0.00, 0.00, 0.00, 0.00, 4, 1, '', 'normal', 3, '2025-08-17 00:25:05'),
(118, NULL, '2025-08-17 18:45:52', 93500.00, 0.00, 30000.00, 63500.00, 70000.00, 6500.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 18:45:52'),
(119, NULL, '2025-08-17 18:46:43', 7500.00, 0.00, 0.00, 7500.00, 8000.00, 500.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 18:46:43'),
(120, NULL, '2025-08-17 18:47:08', 45000.00, 0.00, 0.00, 45000.00, 50000.00, 5000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 18:47:08'),
(121, NULL, '2025-08-17 18:47:35', 22500.00, 0.00, 0.00, 22500.00, 0.00, 0.00, 0.00, 0.00, 4, 1, '', 'normal', 3, '2025-08-17 18:47:35'),
(122, NULL, '2025-08-17 18:48:08', 300000.00, 0.00, 0.00, 300000.00, 0.00, 0.00, 0.00, 0.00, 4, 0, '', 'normal', 3, '2025-08-17 18:48:08'),
(123, NULL, '2025-08-17 18:49:27', 30000.00, 0.00, 0.00, 30000.00, 0.00, 0.00, 0.00, 0.00, 4, 0, '', 'normal', 3, '2025-08-17 18:49:27'),
(124, NULL, '2025-08-17 19:42:46', 27000.00, 0.00, 10000.00, 17000.00, 20000.00, 3000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 19:42:46'),
(125, NULL, '2025-08-17 19:50:41', 4500.00, 0.00, 0.00, 4500.00, 5000.00, 500.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 19:50:41'),
(126, NULL, '2025-08-17 19:53:46', 60000.00, 0.00, 4500.00, 55500.00, 0.00, 0.00, 0.00, 0.00, 4, 0, '', 'normal', 3, '2025-08-17 19:53:46'),
(127, NULL, '2025-08-17 20:35:46', 18000.00, 0.00, 0.00, 18000.00, 20000.00, 2000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 20:35:46'),
(128, NULL, '2025-08-17 21:05:50', 4500.00, 0.00, 0.00, 4500.00, 5000.00, 500.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 21:05:50'),
(129, NULL, '2025-08-17 21:08:02', 4500.00, 0.00, 0.00, 4500.00, 5000.00, 500.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 21:08:02'),
(130, NULL, '2025-08-17 21:22:46', 27000.00, 0.00, 0.00, 27000.00, 30000.00, 3000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 21:22:46'),
(131, NULL, '2025-08-17 21:22:55', 27000.00, 0.00, 0.00, 27000.00, 30000.00, 3000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 21:22:55'),
(132, NULL, '2025-08-17 21:23:21', 121000.00, 0.00, 1000.00, 120000.00, 120000.00, 0.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 21:23:21'),
(133, NULL, '2025-08-17 21:23:47', 11000.00, 0.00, 0.00, 11000.00, 20000.00, 9000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 21:23:47'),
(134, NULL, '2025-08-17 21:24:05', 10000.00, 0.00, 0.00, 10000.00, 0.00, 0.00, 0.00, 0.00, 4, 1, '', 'normal', 3, '2025-08-17 21:24:05'),
(135, NULL, '2025-08-17 21:41:49', 275000.00, 0.00, 0.00, 275000.00, 0.00, 0.00, 0.00, 0.00, 4, 0, '', 'normal', 3, '2025-08-17 21:41:49'),
(136, NULL, '2025-08-17 21:45:11', 275000.00, 0.00, 0.00, 275000.00, 0.00, 0.00, 0.00, 0.00, 4, 0, '', 'normal', 3, '2025-08-17 21:45:11'),
(137, NULL, '2025-08-17 21:53:27', 22500.00, 0.00, 0.00, 22500.00, 30000.00, 7500.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-17 21:53:27'),
(138, NULL, '2025-08-17 21:55:10', 4500.00, 0.00, 0.00, 4500.00, 0.00, 0.00, 0.00, 0.00, 4, 1, '', 'normal', 3, '2025-08-17 21:55:10'),
(139, NULL, '2025-08-17 21:55:32', 27000.00, 0.00, 0.00, 27000.00, 30000.00, 3000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 21:55:32'),
(140, NULL, '2025-08-17 21:56:18', 45000.00, 0.00, 0.00, 45000.00, 50000.00, 5000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 21:56:18'),
(141, NULL, '2025-08-17 21:59:48', 36000.00, 0.00, 0.00, 36000.00, 40000.00, 4000.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 21:59:48'),
(142, NULL, '2025-08-17 22:04:04', 4500.00, 0.00, 0.00, 4500.00, 5000.00, 500.00, 0.00, 0.00, 1, 1, '', 'normal', 3, '2025-08-17 22:04:04'),
(143, NULL, '2025-08-18 00:36:35', 15000.00, 0.00, 0.00, 15000.00, 20000.00, 5000.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-18 00:36:35'),
(144, NULL, '2025-08-18 00:43:48', 30000.00, 0.00, 0.00, 30000.00, 30000.00, 0.00, 0.00, 0.00, 1, 0, '', 'normal', 3, '2025-08-18 00:43:48');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_caja_creacion` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    IF NEW.destino = 'creacion' THEN
        -- Actualizar caja creación (restar monto y sumar a total_gastado)
        UPDATE caja_creacion 
        SET monto_actual = monto_actual - NEW.total,
            total_gastado = total_gastado + NEW.total
        WHERE estado = 1;
        
        -- Registrar movimiento
        INSERT INTO movimientos_caja_creacion (caja_creacion_id, tipo, concepto, monto, venta_id, usuario_id)
        VALUES (1, 'gasto', CONCAT('Compra interna - Venta #', NEW.id), NEW.total, NEW.id, NEW.usuario_id);
    END IF;
END
$$
DELIMITER ;
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
-- Indices de la tabla `caja_creacion`
--
ALTER TABLE `caja_creacion`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `producto_id` (`producto_id`);

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
-- Indices de la tabla `movimientos_caja_creacion`
--
ALTER TABLE `movimientos_caja_creacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_creacion_id` (`caja_creacion_id`),
  ADD KEY `venta_id` (`venta_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `caja_creacion`
--
ALTER TABLE `caja_creacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `inventario_creacion`
--
ALTER TABLE `inventario_creacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja_creacion`
--
ALTER TABLE `movimientos_caja_creacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT de la tabla `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

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
  ADD CONSTRAINT `inventario_creacion_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_caja_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `movimientos_caja_creacion`
--
ALTER TABLE `movimientos_caja_creacion`
  ADD CONSTRAINT `movimientos_caja_creacion_ibfk_1` FOREIGN KEY (`caja_creacion_id`) REFERENCES `caja_creacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_creacion_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_caja_creacion_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION;

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
