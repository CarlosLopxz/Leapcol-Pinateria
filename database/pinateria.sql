-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-08-2025 a las 06:15:17
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
(5, 3, '2025-07-31 13:58:07', '2025-07-31 13:59:20', 23.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0, ' | Cierre: sd'),
(6, 3, '2025-07-31 14:04:00', '2025-08-01 01:52:07', 12.00, 40000.00, 0.00, 0.00, 0.00, 0.00, 0, 'edsd'),
(7, 3, '2025-08-02 22:21:07', '2025-08-02 22:21:41', 40000.00, 12.00, 0.00, 0.00, 0.00, 0.00, 0, ''),
(8, 3, '2025-08-02 22:21:46', '2025-08-02 22:23:41', 21323.00, 100000.00, 0.00, 0.00, 0.00, 0.00, 0, '');

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
(1, 'Categoriasss', 'sadasdsdasd', 1, '2025-07-20 15:03:21');

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
(1, 'Cliente', 'General', '000', 'CC', '123', 'Cliente@gmail.com', 'dsfsd', 'sdfdf', 1, '2025-07-20 16:26:07', '2025-08-02 20:23:52'),
(2, 'aaa', 'aaa', '123', 'CC', '123', 'acarlos@gmail.com', 'sdf', 'xasfe', 1, '2025-08-02 20:02:43', NULL),
(3, 'Cliente', 'Prueba', '12345678', 'CC', '3001234567', 'cliente@prueba.com', NULL, NULL, 1, '2025-08-02 20:16:13', NULL);

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
(2, 1, 'TEST-001', '2025-07-20', '2025-07-20 19:28:27', 10000.00, 1900.00, 0.00, 11900.00, 0, 'Compra de pruebaa', 3),
(3, 1, 'TEST-SQL-001', '2025-07-20', '2025-07-20 19:29:45', 10000.00, 1900.00, 0.00, 11900.00, 0, 'Compra de prueba con SQL directo', 3),
(4, 1, 'DSW43', '2025-07-25', '2025-07-24 22:24:06', 75000.00, 0.00, 0.00, 75000.00, 1, '', 3),
(5, 1, 'aaaaaaaaaaaaaaaa', '2025-07-25', '2025-07-24 22:24:35', 30000.00, 0.00, 0.00, 30000.00, 2, '', 3),
(6, 1, '56765438HTG', '2025-08-03', '2025-08-02 21:39:41', 1080000.00, 0.00, 30000.00, 1050000.00, 1, 'compra de productos para la creacion de cosas', 3),
(7, 1, '', '2025-08-03', '2025-08-02 21:47:04', 5600.00, 0.00, 0.00, 5600.00, 1, '', 3),
(8, 1, 'ASDASDASD', '2025-08-03', '2025-08-02 22:02:42', 4815000.00, 0.00, 0.00, 4815000.00, 1, '', 3);

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
(3, 2, 1, 2, 15000.00, 30000.00),
(4, 4, 1, 5, 15000.00, 75000.00),
(6, 5, 2, 6, 5000.00, 30000.00),
(7, 6, 5, 90, 12000.00, 1080000.00),
(8, 7, 4, 8, 700.00, 5600.00),
(9, 3, 1, 2, 15000.00, 30000.00),
(10, 8, 7, 300, 16050.00, 4815000.00);

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
-- Volcado de datos para la tabla `detalle_produccion`
--

INSERT INTO `detalle_produccion` (`id`, `produccion_id`, `producto_recurso_id`, `cantidad_utilizada`) VALUES
(1, 1, 1, 1),
(2, 2, 5, 5),
(3, 2, 4, 30),
(4, 3, 5, 1),
(5, 3, 6, 1),
(6, 4, 6, 5);

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
(1, 12, 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00),
(2, 13, 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, 14, 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00),
(4, 15, 1, 3, 30000.00, 15000.00, 90000.00, 45000.00, 45000.00),
(5, 16, 1, 1, 30000.00, 15000.00, 30000.00, 15000.00, 15000.00),
(6, 16, 2, 1, 10000.00, 5000.00, 10000.00, 5000.00, 5000.00),
(7, 17, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(8, 18, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(9, 19, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(10, 20, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(11, 21, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(12, 22, 2, 6, 10000.00, 5000.00, 60000.00, 30000.00, 30000.00),
(13, 23, 4, 6, 3232.00, 652.17, 19392.00, 3913.02, 15478.98),
(14, 24, 2, 3, 10000.00, 5000.00, 30000.00, 15000.00, 15000.00),
(15, 24, 1, 3, 30000.00, 15000.00, 90000.00, 45000.00, 45000.00),
(16, 25, 1, 1, 30000.00, 15000.00, 30000.00, 15000.00, 15000.00),
(17, 26, 1, 1, 30000.00, 15000.00, 30000.00, 15000.00, 15000.00),
(18, 27, 4, 1, 3232.00, 652.17, 3232.00, 652.17, 2579.83),
(19, 28, 4, 4, 3232.00, 652.17, 12928.00, 2608.68, 10319.32),
(20, 29, 1, 5, 30000.00, 15000.00, 150000.00, 75000.00, 75000.00),
(21, 30, 4, 7, 3232.00, 652.17, 22624.00, 4565.19, 18058.81),
(22, 31, 1, 31, 30000.00, 15000.00, 930000.00, 465000.00, 465000.00),
(23, 32, 4, 1, 3232.00, 700.00, 3232.00, 700.00, 2532.00),
(24, 33, 1, 1, 50000.00, 0.00, 50000.00, 0.00, 0.00),
(25, 34, 1, 1, 50000.00, 0.00, 50000.00, 0.00, 0.00),
(26, 35, 8, 10, 10982.00, 450.00, 109820.00, 4500.00, 105320.00),
(27, 35, 6, 5, 15000.00, 4050.00, 75000.00, 20250.00, 54750.00),
(28, 35, 7, 7, 1000.00, 16050.00, 7000.00, 112350.00, -105350.00),
(29, 35, 5, 5, 15000.00, 12000.00, 75000.00, 60000.00, 15000.00),
(30, 36, 5, 17, 15000.00, 12000.00, 255000.00, 204000.00, 51000.00),
(31, 37, 8, 2, 10982.00, 450.00, 21964.00, 900.00, 21064.00),
(32, 37, 6, 2, 15000.00, 4050.00, 30000.00, 8100.00, 21900.00);

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
(13, 'Roles', 'Gestión de roles y permisos', 'fas fa-user-shield', 'roles', 1);

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

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`id`, `caja_id`, `tipo`, `concepto`, `monto`, `metodo_pago`, `venta_id`, `fecha`, `usuario_id`) VALUES
(23, 5, 'ingreso', 'compra', 50000.00, 1, NULL, '2025-07-31 13:58:18', 3),
(24, 6, 'ingreso', 'asdas', 44.00, 2, NULL, '2025-07-31 14:04:28', 3),
(25, 8, 'ingreso', 'cambio', 30000.00, 1, NULL, '2025-08-02 22:23:05', 3),
(26, 8, 'ingreso', 'venta exterior', 80000.00, 1, NULL, '2025-08-02 22:23:25', 3);

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
(199, 2, 12),
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
(1, 'PROD-20250724-6608', 4, 23, '2025-07-24 23:49:35', 1, 'dsd', 3),
(2, 'PR25080232', 6, 20, '2025-08-02 18:33:45', 1, '', 3),
(3, 'PR25080284', 7, 1, '2025-08-02 18:38:32', 1, '', 3),
(4, 'PR25080279', 8, 45, '2025-08-02 18:40:04', 1, '', 3);

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

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `categoria_id`, `unidad_venta`, `precio_compra`, `precio_venta`, `stock`, `stock_minimo`, `imagen`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'CHSTY', 'Dulce de coco', 'Hola', 1, 'unidad', 15000.00, 30000.00, -31, 5, '', 3, '2025-07-20 15:04:03', '2025-08-02 21:52:00'),
(2, 'P001', 'Producto de Prueba', 'Descripción del producto', 1, 'unidad', 5000.00, 10000.00, -1, 5, NULL, 3, '2025-07-20 16:26:45', '2025-08-02 22:12:06'),
(3, 'asdasd', 'asda', 'dasd', 1, 'unidad', 22.00, 222.00, 0, 5, '', 3, '2025-07-24 22:25:40', '2025-08-02 18:24:37'),
(4, 'PROD-20250724-1884', '23123', '3', 1, 'unidad', 700.00, 3232.00, -22, 5, NULL, 1, '2025-07-24 23:49:35', '2025-08-02 21:47:04'),
(5, 'TGTDF6753', 'Producto pruebaaaaa', 'producto xxxxx', 1, 'unidad', 12000.00, 15000.00, 84, 5, '', 1, '2025-08-02 18:18:15', '2025-08-02 21:39:41'),
(6, 'P250802447', 'decoraciones de fiestas', '', 1, 'unidad', 4050.00, 15000.00, 14, 5, NULL, 1, '2025-08-02 18:33:45', '2025-08-02 21:17:36'),
(7, 'P250802267', 'easd', 'asdasd', 1, 'unidad', 16050.00, 1000.00, 288, 5, NULL, 1, '2025-08-02 18:38:32', '2025-08-02 22:02:42'),
(8, 'P250802974', 'asadasd', 'sad', 1, 'unidad', 450.00, 10982.00, 66, 5, NULL, 1, '2025-08-02 18:40:04', '2025-08-02 21:17:36');

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
(1, 'Leapcol S.A.S', '3123', '123123123', 'acarlos@gmail.com', '3123123', 1, '2025-07-20 17:24:03'),
(2, 'ssa', 'cascas', '1', 'sx@gmail.copm', 'asdsad', 1, '2025-08-02 20:56:34');

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
(3, 'Admin', 'Sistema', 'admin', 'admin@pinateria.com', '$2y$10$PdEEfkMLWcdpaIcG2vP0sOhz3DlYm1rcsrjFBZMrBGhJprHe/ZFTy', NULL, 1, 1, '2025-07-20 16:27:33', '2025-07-31 13:33:33'),
(8, 'carlos', 'Sistema', 'admin', 'a@pinateria.com', '$2y$10$go55avXC6En4plONOmVUS.IS7L2x04qgfM19P8y1CHQHjDwefZ3mG', NULL, 2, 1, '2025-07-20 16:27:33', '2025-07-31 13:33:52'),
(9, 'carlos', 'Lopez Tapia', 'carlos lopez', 'carlos@gmail.com', '$2y$10$ELk1X3of7oyObu0CYkzsbuXQ53XeDC2oZe.9pOmjdje/c/Ahd.luy', NULL, 2, 1, '2025-08-02 22:25:49', '2025-08-02 22:29:03');

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
(12, NULL, '2025-07-20 16:28:14', 0.00, 0.00, 0.00, 11900.00, NULL, NULL, 0.00, 0.00, 1, 0, NULL, 3, '2025-07-20 16:28:14'),
(13, NULL, '2025-07-20 16:28:36', 0.00, 0.00, 0.00, 11900.00, NULL, NULL, 0.00, 0.00, 1, 0, NULL, 3, '2025-07-20 16:28:36'),
(14, NULL, '2025-07-20 16:53:50', 0.00, 0.00, 0.00, 11900.00, NULL, NULL, 0.00, 0.00, 1, 1, NULL, 3, '2025-07-20 16:53:50'),
(15, NULL, '2025-07-20 16:58:18', 90000.00, 17100.00, 0.00, 107100.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-20 16:58:18'),
(16, NULL, '2025-07-24 22:25:01', 40000.00, 7600.00, 0.00, 47600.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-24 22:25:01'),
(17, NULL, '2025-07-24 23:53:00', 3232.00, 614.00, 0.00, 3846.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-24 23:53:00'),
(18, NULL, '2025-07-24 23:53:45', 3232.00, 614.00, 0.00, 3846.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-24 23:53:45'),
(19, NULL, '2025-07-24 23:54:52', 3232.00, 614.00, 0.00, 3846.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-24 23:54:52'),
(20, NULL, '2025-07-24 23:58:47', 3232.00, 614.00, 0.00, 3846.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-24 23:58:47'),
(21, NULL, '2025-07-25 00:02:58', 3232.00, 614.00, 0.00, 3846.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-25 00:02:58'),
(22, NULL, '2025-07-25 00:03:31', 60000.00, 11400.00, 0.00, 71400.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-25 00:03:31'),
(23, NULL, '2025-07-25 00:56:27', 19392.00, 3684.00, 0.00, 23076.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 8, '2025-07-25 00:56:27'),
(24, NULL, '2025-07-25 01:02:32', 120000.00, 22800.00, 0.00, 142800.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 8, '2025-07-25 01:02:32'),
(25, NULL, '2025-07-25 01:08:34', 30000.00, 5700.00, 0.00, 35700.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 8, '2025-07-25 01:08:34'),
(26, NULL, '2025-07-25 01:22:38', 30000.00, 0.00, 0.00, 30000.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 8, '2025-07-25 01:22:38'),
(27, NULL, '2025-07-25 01:26:44', 3232.00, 0.00, 0.00, 3232.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 8, '2025-07-25 01:26:44'),
(28, 2, '2025-07-26 23:46:09', 12928.00, 0.00, 0.00, 12928.00, NULL, NULL, 0.00, 0.00, 1, 1, '', 3, '2025-07-26 23:46:09'),
(29, 3, '2025-07-26 23:49:55', 150000.00, 0.00, 0.00, 150000.00, 200000.00, 50000.00, 0.00, 0.00, 1, 1, '', 3, '2025-07-26 23:49:55'),
(30, 2, '2025-07-27 00:01:40', 22624.00, 0.00, 0.00, 22624.00, 30000.00, 7376.00, 0.00, 0.00, 1, 1, '', 3, '2025-07-27 00:01:40'),
(31, 3, '2025-07-27 00:04:40', 930000.00, 0.00, 0.00, 930000.00, 1000000.00, 70000.00, 0.00, 0.00, 1, 1, '', 3, '2025-07-27 00:04:40'),
(32, 2, '2025-07-31 13:28:17', 3232.00, 0.00, 0.00, 3232.00, 4000.00, 768.00, 0.00, 0.00, 1, 1, '', 3, '2025-07-31 13:28:17'),
(33, 3, '2025-08-02 20:16:13', 50000.00, 0.00, 0.00, 50000.00, NULL, NULL, 0.00, 0.00, 1, 1, NULL, 3, '2025-08-02 20:16:13'),
(34, 3, '2025-08-02 20:16:55', 50000.00, 0.00, 0.00, 50000.00, NULL, NULL, 0.00, 0.00, 1, 1, NULL, 3, '2025-08-02 20:16:55'),
(35, NULL, '2025-08-02 20:41:21', 266820.00, 0.00, 0.00, 266820.00, 300000.00, 33180.00, 0.00, 0.00, 1, 1, '', 3, '2025-08-02 20:41:21'),
(36, NULL, '2025-08-02 20:48:04', 255000.00, 0.00, 0.00, 255000.00, 300000.00, 45000.00, 0.00, 0.00, 1, 1, '', 3, '2025-08-02 20:48:04'),
(37, NULL, '2025-08-02 21:17:36', 51964.00, 0.00, 0.00, 51964.00, 52000.00, 36.00, 0.00, 0.00, 1, 1, '', 3, '2025-08-02 21:17:36');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT de la tabla `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_caja_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION;

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
