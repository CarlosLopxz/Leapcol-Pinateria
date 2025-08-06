-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2025 at 07:20 AM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comeyax_pinate`
--

-- --------------------------------------------------------

--
-- Table structure for table `cajas`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cajas`
--

INSERT INTO `cajas` (`id`, `usuario_id`, `fecha_apertura`, `fecha_cierre`, `monto_inicial`, `monto_final`, `total_ventas`, `total_efectivo`, `total_tarjeta`, `total_transferencia`, `estado`, `observaciones`) VALUES
(9, 3, '2025-08-04 08:23:27', '2025-08-04 08:24:24', '1.00', '1.00', '0.00', '0.00', '0.00', '0.00', 0, ''),
(10, 3, '2025-08-04 11:56:14', NULL, '0.00', NULL, '0.00', '0.00', '0.00', '0.00', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categorias`
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
(56, 'Metalizados varios', '', 1, '2025-08-05 15:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `compras`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `detalle_compras`
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
-- Table structure for table `detalle_produccion`
--

CREATE TABLE `detalle_produccion` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) NOT NULL,
  `producto_recurso_id` int(11) NOT NULL,
  `cantidad_utilizada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detalle_produccion`
--

INSERT INTO `detalle_produccion` (`id`, `produccion_id`, `producto_recurso_id`, `cantidad_utilizada`) VALUES
(7, 5, 132, 1),
(8, 5, 189, 1),
(9, 6, 160, 1),
(10, 7, 185, 2);

--
-- Triggers `detalle_produccion`
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
-- Table structure for table `detalle_venta`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `costo_unitario`, `subtotal`, `costo_total`, `ganancia`) VALUES
(33, 38, 216, 1, '35000.00', '1700.00', '35000.00', '1700.00', '33300.00'),
(34, 39, 215, 1, '20000.00', '1500.00', '20000.00', '1500.00', '18500.00');

--
-- Triggers `detalle_venta`
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
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `url` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modulos`
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
-- Table structure for table `movimientos_caja`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permisos`
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
-- Table structure for table `producciones`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producciones`
--

INSERT INTO `producciones` (`id`, `codigo`, `producto_final_id`, `cantidad_producir`, `fecha_produccion`, `estado`, `observaciones`, `usuario_id`) VALUES
(5, 'PR25080537', 214, 1, '2025-08-05 11:27:51', 1, '', 3),
(6, 'PR25080582', 215, 1, '2025-08-05 11:31:18', 1, '', 3),
(7, 'PR25080550', 216, 2, '2025-08-05 11:39:45', 1, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `categoria_id`, `unidad_venta`, `precio_compra`, `precio_venta`, `stock`, `stock_minimo`, `imagen`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(9, '01', 'Globos Marron r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 5, 5, '', 1, '2025-08-04 09:33:09', '2025-08-04 09:49:42'),
(10, '02', 'Globos Vinotinto r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 5, 5, '', 1, '2025-08-04 09:34:38', NULL),
(11, '03', 'Globos Amarillo r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 2, 5, '', 1, '2025-08-04 09:35:26', NULL),
(12, '04', 'Globos Gris r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 3, 5, '', 1, '2025-08-04 09:36:17', NULL),
(13, '05', 'Globos Fucsia r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 0, 5, '', 1, '2025-08-04 09:37:13', NULL),
(14, '06', 'Globos Coral r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 16, 5, '', 1, '2025-08-04 09:38:30', NULL),
(15, '07', 'Globos Azul Satinado r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 4, 5, '', 1, '2025-08-04 09:40:08', NULL),
(16, '08', 'Globos Lila Cromado r9 x50', '', 4, 'unidad', '9000.00', '15000.00', 5, 5, '', 1, '2025-08-04 09:41:10', NULL),
(17, '09', 'Globos Verde Biche Cromado r9 x50', '', 4, 'unidad', '9000.00', '15000.00', 3, 5, '', 1, '2025-08-04 09:43:36', NULL),
(18, '10', 'Globos Verde Oscuro Cromado r9 x12', '', 4, 'unidad', '2000.00', '4000.00', 24, 5, '', 1, '2025-08-04 09:45:40', NULL),
(19, '11', 'Globos Dorado r9 x50', '', 4, 'unidad', '9000.00', '15000.00', 11, 5, '', 1, '2025-08-04 09:46:48', NULL),
(20, '12', 'Globos Arena r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 6, 5, '', 1, '2025-08-04 09:47:56', NULL),
(21, '13', 'Globos Negro r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 3, 5, '', 1, '2025-08-04 09:48:41', '2025-08-04 09:50:00'),
(22, '14', 'Globos Blanco r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 5, 5, '', 1, '2025-08-04 09:51:52', '2025-08-04 09:52:03'),
(23, '15', 'Globos Rosado r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 4, 5, '', 1, '2025-08-04 09:52:44', NULL),
(24, '16', 'Globos Azul Oscuro r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 8, 5, '', 1, '2025-08-04 09:53:41', NULL),
(25, '17', 'Globos Rojo r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 9, 5, '', 1, '2025-08-04 09:55:54', NULL),
(26, '18', 'Globos Naranjado r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 2, 5, '', 1, '2025-08-04 09:58:14', NULL),
(27, '19', 'Globos Verde Oscuro r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 2, 5, '', 1, '2025-08-04 09:58:52', NULL),
(28, '20', 'Globos Azul Claro r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 1, 5, '', 1, '2025-08-04 09:59:27', NULL),
(29, '21', 'Globos Morado r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 1, 5, '', 1, '2025-08-04 10:00:06', NULL),
(30, '22', 'Globos Morado r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 36, 5, '', 1, '2025-08-04 10:06:26', '2025-08-04 10:14:26'),
(31, '23', 'Globos Verde Pastel r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 42, 5, '', 1, '2025-08-04 10:07:32', '2025-08-04 10:15:23'),
(32, '24', 'Globos Rosado r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 27, 5, '', 1, '2025-08-04 10:08:49', NULL),
(33, '25', 'Globos Fucsia r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 24, 5, '', 1, '2025-08-04 10:09:47', NULL),
(34, '26', 'Globos Lila r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 34, 5, '', 1, '2025-08-04 10:12:39', '2025-08-04 10:16:15'),
(35, '27', 'Globos Azul Claro r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 22, 5, '', 1, '2025-08-04 10:19:09', NULL),
(36, '28', 'Globos Negro r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 2, 5, '', 1, '2025-08-04 10:19:39', NULL),
(37, '29', 'Globos Amarillo r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 31, 5, '', 1, '2025-08-04 10:20:44', NULL),
(38, '30', 'Globos Palo de rosa Cromado r12 x50', '', 4, 'unidad', '9000.00', '15000.00', 1, 5, '', 1, '2025-08-04 10:21:54', NULL),
(39, '31', 'Globos Palo de rosa r9 x50', '', 4, 'unidad', '5000.00', '7500.00', 1, 5, '', 1, '2025-08-04 10:23:10', NULL),
(40, '32', 'Globos Plateado Cromado r9 x50', '', 4, 'unidad', '9000.00', '15000.00', 3, 5, '', 1, '2025-08-04 10:25:49', NULL),
(41, '33', 'Globos Azul Cromado r9 x50', '', 4, 'unidad', '9000.00', '15000.00', 3, 5, '', 1, '2025-08-04 10:26:41', NULL),
(42, '34', 'Globos Verde Claro r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 20, 5, '', 1, '2025-08-04 10:30:01', NULL),
(43, '35', 'Globos Verde Biche r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 4, 5, '', 1, '2025-08-04 10:31:15', NULL),
(44, '36', 'Globos Verde Pastel r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 10, 5, '', 1, '2025-08-04 10:32:24', NULL),
(45, '37', 'Globos Piel r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 1, 5, '', 1, '2025-08-04 10:33:48', NULL),
(46, '38', 'Globos Uva r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 5, 5, '', 1, '2025-08-04 10:34:51', NULL),
(47, '39', 'Globos Amarillo r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 28, 5, '', 1, '2025-08-04 10:36:18', NULL),
(48, '40', 'Globos Morado r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 10, 5, '', 1, '2025-08-04 10:37:57', '2025-08-04 10:38:51'),
(49, '41', 'Globos Lila r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 4, 5, '', 1, '2025-08-04 10:38:33', NULL),
(50, '42', 'Globos Coral r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 14, 5, '', 1, '2025-08-04 10:44:48', NULL),
(51, '43', 'Globos Fucsia r12 x12', '', 4, 'unidad', '2000.00', '4500.00', 22, 5, '', 1, '2025-08-04 10:45:50', NULL),
(52, '44', 'Globos Fucsia r12 x50', '', 4, 'unidad', '10000.00', '18000.00', 14, 5, '', 1, '2025-08-04 10:46:42', NULL),
(53, '45', 'Globos palo de rosa Cromado r12 x12', '', 4, 'unidad', '5000.00', '8500.00', 27, 5, '', 1, '2025-08-04 10:51:24', NULL),
(54, '46', 'Globos Palo de rosa Cromado r18', '', 9, 'unidad', '3000.00', '6000.00', 38, 5, '', 1, '2025-08-04 10:53:23', '2025-08-04 10:53:44'),
(55, '47', 'Globos Oro Rosa Cromado r18', '', 9, 'unidad', '3000.00', '6000.00', 54, 5, '', 1, '2025-08-04 11:06:31', NULL),
(56, '48', 'Globos Plateado Cromado r18', '', 9, 'unidad', '3000.00', '6000.00', 13, 5, '', 1, '2025-08-04 11:08:26', NULL),
(57, '49', 'Globos Azul Cromado r18', '', 9, 'unidad', '3000.00', '6000.00', 38, 5, '', 1, '2025-08-04 11:09:26', NULL),
(58, '50', 'Globos de Blon de Futbol r12 x12', '', 4, 'unidad', '5000.00', '8500.00', 4, 5, '', 1, '2025-08-04 11:12:44', '2025-08-04 11:19:30'),
(59, '51', 'Globos Feliz Cumpleaños Negro r12 x12', '', 4, 'unidad', '5000.00', '8500.00', 34, 5, '', 3, '2025-08-04 11:16:08', '2025-08-04 11:18:22'),
(60, '52', 'Globos Feliz Cumpleaños r12 x12', '', 9, 'unidad', '500.00', '1000.00', 990, 5, '', 1, '2025-08-04 11:25:36', NULL),
(61, '53', 'Globos Feliz Dia r12 x12', '', 4, 'unidad', '5000.00', '8500.00', 14, 5, '', 1, '2025-08-04 11:28:01', NULL),
(62, '54', 'Globos Feliz Dia r12', '', 9, 'unidad', '500.00', '1000.00', 706, 5, '', 1, '2025-08-04 11:29:49', NULL),
(63, '55', 'Globos Transparentes r12', '', 9, 'unidad', '500.00', '800.00', 234, 5, '', 1, '2025-08-04 11:33:47', NULL),
(64, '56', 'Globos Mostaza r9', '', 9, 'unidad', '50.00', '200.00', 400, 5, '', 1, '2025-08-04 11:36:09', NULL),
(65, '57', 'Globos Palo de Rosa r12 x50', '', 4, 'unidad', '14000.00', '28000.00', 2, 5, '', 1, '2025-08-04 11:37:39', NULL),
(66, '58', 'Globos Verde Eucalipto r12 x50', '', 4, 'unidad', '14000.00', '28000.00', 2, 5, '', 1, '2025-08-04 11:38:44', NULL),
(67, '59', 'Globos Fucsia r12 x100', '', 4, 'unidad', '12000.00', '22000.00', 1, 5, '', 1, '2025-08-04 11:39:49', NULL),
(68, '60', 'Globos Plateado Cromado Sempertex r12 x50', '', 4, 'unidad', '1.00', '2.00', 2, 5, '', 1, '2025-08-04 11:41:58', NULL),
(69, '61', 'Globos Feliz Navidad Sempertex r12 x50', '', 4, 'unidad', '1.00', '2.00', 1, 5, '', 1, '2025-08-04 11:42:50', '2025-08-04 11:43:55'),
(70, '62', 'Globos Verde Oscuro Sempertex r5 x12', '', 4, 'unidad', '1.00', '2.00', 3, 5, '', 1, '2025-08-04 11:43:41', NULL),
(71, '63', 'Globos Mil Figuras Azul Cromado x50', '', 4, 'unidad', '11000.00', '22500.00', 1, 5, '', 1, '2025-08-04 11:44:48', '2025-08-04 11:45:16'),
(72, '64', 'papel cometa Fucsia', '', 3, 'unidad', '150.00', '300.00', 100, 5, '', 3, '2025-08-04 11:48:29', '2025-08-04 14:23:43'),
(73, '65', 'Mantel Dorado Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 79, 5, '', 1, '2025-08-04 15:05:52', NULL),
(74, '66', 'Mantel Plateado Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 110, 5, '', 1, '2025-08-04 15:07:45', NULL),
(75, '67', 'Mantel Azul Oscuro Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 62, 5, '', 1, '2025-08-04 15:08:38', NULL),
(76, '68', 'Mantel Rojo Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 31, 5, '', 1, '2025-08-04 15:09:15', NULL),
(77, '69', 'Mantel Negro', '', 16, 'unidad', '2500.00', '5000.00', 70, 5, '', 1, '2025-08-04 15:12:46', NULL),
(78, '70', 'Mantel Negro Estampado', '', 16, 'unidad', '2500.00', '7000.00', 8, 5, '', 1, '2025-08-04 15:13:31', NULL),
(79, '71', 'Mantel Rosado Estampado', '', 16, 'unidad', '2500.00', '7000.00', 10, 5, '', 1, '2025-08-04 15:17:45', NULL),
(80, '72', 'Mantel Fucsia Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 23, 5, '', 1, '2025-08-04 15:19:08', NULL),
(81, '73', 'Mantel Palo de Rosa Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 49, 5, '', 1, '2025-08-04 15:20:19', NULL),
(82, '74', 'Mantel Rosado Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 31, 5, '', 1, '2025-08-04 15:22:46', NULL),
(83, '75', 'Mantel Dorado Normal', '', 16, 'unidad', '2500.00', '7500.00', 90, 5, '', 1, '2025-08-04 15:24:27', NULL),
(84, '76', 'Mantel Morado Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 23, 5, '', 1, '2025-08-04 15:26:01', NULL),
(85, '77', 'Mantel Dorado Estampado Metalizado', '', 16, 'unidad', '2500.00', '7000.00', 15, 5, '', 1, '2025-08-04 15:27:04', NULL),
(86, '78', 'Mantel Gris', '', 16, 'unidad', '2500.00', '7000.00', 31, 5, '', 1, '2025-08-04 15:27:41', NULL),
(87, '79', 'Mantel Fucsia', '', 16, 'unidad', '2500.00', '5000.00', 31, 5, '', 1, '2025-08-04 15:28:26', NULL),
(88, '80', 'Mantel Morado', '', 16, 'unidad', '2500.00', '5000.00', 21, 5, '', 1, '2025-08-04 15:29:08', NULL),
(89, '81', 'Mantel Rosado', '', 16, 'unidad', '2500.00', '5000.00', 13, 5, '', 1, '2025-08-04 15:29:45', NULL),
(90, '82', 'Mantel Rosado Pastel', '', 16, 'unidad', '2500.00', '5000.00', 46, 5, '', 1, '2025-08-04 15:30:20', '2025-08-04 15:37:33'),
(91, '83', 'Mantel Blanco', '', 16, 'unidad', '2500.00', '5000.00', 13, 5, '', 1, '2025-08-04 15:30:49', NULL),
(92, '84', 'Mantel Naranjado', '', 16, 'unidad', '2500.00', '5000.00', 54, 5, '', 1, '2025-08-04 15:31:23', NULL),
(93, '85', 'Mantel Azul Oscuro', '', 16, 'unidad', '2500.00', '5000.00', 65, 5, '', 1, '2025-08-04 15:32:05', NULL),
(94, '86', 'Mantel Azul Claro', '', 16, 'unidad', '2500.00', '5000.00', 47, 5, '', 1, '2025-08-04 15:32:45', NULL),
(95, '87', 'Mantel Rojo', '', 16, 'unidad', '2500.00', '5000.00', 34, 5, '', 1, '2025-08-04 15:33:26', NULL),
(96, '88', 'Mantel Verde Biche', '', 16, 'unidad', '2500.00', '5000.00', 4, 5, '', 1, '2025-08-04 15:34:07', NULL),
(97, '89', 'Mantel de Personajes', '', 16, 'unidad', '2500.00', '5000.00', 96, 5, '', 1, '2025-08-04 15:35:15', NULL),
(98, '90', 'Mantel Amarillo', '', 16, 'unidad', '2500.00', '5000.00', 13, 5, '', 1, '2025-08-04 15:35:59', NULL),
(99, '91', 'Mantel Piel', '', 16, 'unidad', '2500.00', '5000.00', 25, 5, '', 1, '2025-08-04 15:36:37', NULL),
(100, '92', '0 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 29, 5, '', 1, '2025-08-04 15:48:29', NULL),
(101, '93', '0 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 59, 5, '', 1, '2025-08-04 15:50:01', NULL),
(102, '94', '0 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 21, 5, '', 1, '2025-08-04 15:50:57', NULL),
(103, '95', '1 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 103, 5, '', 1, '2025-08-04 15:54:47', NULL),
(104, '96', '1 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 120, 5, '', 1, '2025-08-04 15:57:14', NULL),
(105, '97', '1 Palo de rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 0, 5, '', 1, '2025-08-04 15:58:31', NULL),
(106, '98', '2 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 84, 5, '', 1, '2025-08-04 15:59:13', NULL),
(107, '99', '2 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 92, 5, '', 1, '2025-08-04 16:00:53', NULL),
(108, '100', '2 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 83, 5, '', 1, '2025-08-04 16:02:39', NULL),
(109, '101', '3 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 83, 5, '', 1, '2025-08-04 16:06:33', '2025-08-04 16:08:31'),
(110, '102', '3 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 66, 5, '', 1, '2025-08-04 16:08:58', NULL),
(111, '103', '3 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 46, 5, '', 1, '2025-08-04 16:10:43', NULL),
(112, '104', '4 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 20, 5, '', 1, '2025-08-04 16:11:55', NULL),
(113, '105', '4 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 44, 5, '', 1, '2025-08-04 16:13:13', NULL),
(114, '106', '4 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 64, 5, '', 1, '2025-08-04 16:14:15', NULL),
(115, '107', '5 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 105, 5, '', 1, '2025-08-04 16:17:01', NULL),
(116, '108', '5 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 112, 5, '', 1, '2025-08-04 17:44:18', NULL),
(117, '109', '5 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 9, 5, '', 1, '2025-08-04 17:48:16', NULL),
(118, '110', '6 Dorado 16\"', '', 8, 'unidad', '1500.00', '2500.00', 76, 5, '', 1, '2025-08-04 17:48:50', NULL),
(119, '111', '6 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 85, 5, '', 1, '2025-08-04 17:49:34', NULL),
(120, '112', '6 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 38, 5, '', 1, '2025-08-04 17:50:29', NULL),
(121, '113', '7 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 80, 5, '', 1, '2025-08-04 17:53:03', NULL),
(122, '114', '7 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 80, 5, '', 1, '2025-08-04 17:58:06', NULL),
(123, '115', '7 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 115, 5, '', 1, '2025-08-04 17:58:38', NULL),
(124, '116', '7 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 51, 5, '', 1, '2025-08-04 17:59:46', NULL),
(125, '117', '8 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 103, 5, '', 1, '2025-08-04 18:00:30', NULL),
(126, '118', '8 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 107, 5, '', 1, '2025-08-04 18:01:23', NULL),
(127, '119', '8 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 40, 5, '', 1, '2025-08-04 18:02:01', NULL),
(128, '120', '9 Plateado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 124, 5, '', 1, '2025-08-04 18:02:35', NULL),
(129, '121', '9 Dorado 16\"', '', 7, 'unidad', '1500.00', '2500.00', 124, 5, '', 1, '2025-08-04 18:03:20', NULL),
(130, '122', '9 Palo de Rosa 16\"', '', 7, 'unidad', '1500.00', '2500.00', 30, 5, '', 1, '2025-08-04 18:04:15', NULL),
(131, '123', '0 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 38, 5, '', 1, '2025-08-04 18:05:20', NULL),
(132, '124', '0 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 3, 5, '', 1, '2025-08-04 18:06:24', '2025-08-05 11:27:51'),
(133, '125', '0 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 0, 5, '', 1, '2025-08-04 18:07:11', NULL),
(134, '126', '1 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 177, 5, '', 1, '2025-08-04 18:07:43', NULL),
(135, '127', '1 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 118, 5, '', 1, '2025-08-04 18:08:35', NULL),
(136, '128', '1 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 0, 5, '', 1, '2025-08-04 18:09:16', NULL),
(137, '129', '3 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 90, 5, '', 1, '2025-08-04 18:09:48', NULL),
(138, '130', '3 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 83, 5, '', 1, '2025-08-04 18:10:35', NULL),
(139, '131', '3 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 0, 5, '', 1, '2025-08-04 18:11:12', '2025-08-04 18:11:22'),
(140, '132', '4 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 34, 5, '', 1, '2025-08-04 18:11:56', NULL),
(141, '133', '4 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 38, 5, '', 1, '2025-08-04 18:12:28', NULL),
(142, '134', '4 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 14, 5, '', 1, '2025-08-04 18:13:08', NULL),
(143, '135', '5 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 30, 5, '', 1, '2025-08-04 18:13:42', NULL),
(144, '136', '5 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 68, 5, '', 1, '2025-08-04 18:14:14', NULL),
(145, '137', '5 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '5000.00', 0, 5, '', 1, '2025-08-04 18:15:01', NULL),
(146, '138', '6 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 16, 5, '', 1, '2025-08-04 18:18:25', NULL),
(147, '139', '6 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 39, 5, '', 1, '2025-08-04 18:19:05', NULL),
(148, '140', '6 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 50, 5, '', 1, '2025-08-04 18:19:50', NULL),
(149, '141', '7 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 9, 5, '', 1, '2025-08-04 18:20:38', NULL),
(150, '142', '7 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 66, 5, '', 1, '2025-08-04 18:21:18', NULL),
(151, '143', '7 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 74, 5, '', 1, '2025-08-04 18:22:08', '2025-08-04 18:22:23'),
(152, '144', '8 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 72, 5, '', 1, '2025-08-04 18:22:58', NULL),
(153, '145', '8 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 61, 5, '', 1, '2025-08-04 18:23:47', NULL),
(154, '146', '8 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 14, 5, '', 1, '2025-08-04 18:24:29', NULL),
(155, '147', '9 Plateado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 139, 5, '', 1, '2025-08-04 18:25:13', NULL),
(156, '148', '9 Dorado 32\"', '', 7, 'unidad', '2000.00', '4000.00', 118, 5, '', 1, '2025-08-04 18:25:55', NULL),
(157, '149', '9 Palo de Rosa 32\"', '', 7, 'unidad', '2000.00', '4000.00', 8, 5, '', 1, '2025-08-04 18:26:29', NULL),
(158, '150', '0 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 16, 5, '', 1, '2025-08-04 18:27:25', NULL),
(159, '151', '0 Fucsia 32\"', '', 7, 'unidad', '2000.00', '4000.00', 2, 5, '', 1, '2025-08-04 18:27:57', NULL),
(160, '152', '0 Azul 16\"', '', 7, 'unidad', '1500.00', '2500.00', 3, 5, '', 1, '2025-08-04 18:28:32', '2025-08-05 11:31:18'),
(161, '153', '4 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 6, 5, '', 1, '2025-08-04 18:29:09', NULL),
(162, '154', '5 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 5, 5, '', 1, '2025-08-04 18:29:50', NULL),
(163, '155', '4 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 2, 5, '', 1, '2025-08-04 18:30:29', NULL),
(164, '156', '6 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 3, 5, '', 1, '2025-08-05 09:19:04', NULL),
(165, '157', '6 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 10, 5, '', 1, '2025-08-05 09:19:40', NULL),
(166, '158', '6 Fucsia 32\"', '', 7, 'unidad', '2000.00', '4000.00', 1, 5, '', 1, '2025-08-05 09:20:24', '2025-08-05 09:21:57'),
(167, '159', '6 Negro 32\"', '', 7, 'unidad', '2000.00', '4000.00', 9, 5, '', 1, '2025-08-05 09:20:52', '2025-08-05 09:21:42'),
(168, '160', '9 Negro 32\"', '', 7, 'unidad', '2000.00', '4000.00', 4, 5, '', 1, '2025-08-05 09:21:28', NULL),
(169, '161', '3 Negro 32\"', '', 7, 'unidad', '2000.00', '4000.00', 1, 5, '', 1, '2025-08-05 09:22:45', NULL),
(170, '162', '9 Fucsia 32\"', '', 7, 'unidad', '2000.00', '4000.00', 2, 5, '', 1, '2025-08-05 09:23:30', NULL),
(171, '163', '2 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 1, 5, '', 1, '2025-08-05 09:24:23', NULL),
(172, '164', '7 Fucsia 32\"', '', 7, 'unidad', '2000.00', '4000.00', 2, 5, '', 1, '2025-08-05 09:25:17', NULL),
(173, '165', '3 Fucsia 32\"', '', 7, 'unidad', '2000.00', '4000.00', 1, 5, '', 1, '2025-08-05 09:26:00', NULL),
(174, '166', '7 Azul 16\"', '', 7, 'unidad', '1500.00', '2500.00', 1, 5, '', 1, '2025-08-05 09:27:08', NULL),
(175, '167', '7 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 6, 5, '', 1, '2025-08-05 09:28:22', NULL),
(176, '168', '7 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 13, 5, '', 1, '2025-08-05 09:28:54', NULL),
(177, '169', '8 Azul 16\"', '', 7, 'unidad', '1500.00', '2500.00', 1, 5, '', 1, '2025-08-05 09:29:30', NULL),
(178, '170', '8 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 10, 5, '', 1, '2025-08-05 09:30:14', NULL),
(179, '171', '8 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 13, 5, '', 1, '2025-08-05 09:30:39', NULL),
(180, '172', '9 Fucsia 16\"', '', 7, 'unidad', '1500.00', '2500.00', 12, 5, '', 1, '2025-08-05 09:31:55', NULL),
(181, '173', '9 Azul 16\"', '', 7, 'unidad', '1500.00', '2500.00', 7, 5, '', 1, '2025-08-05 09:32:29', NULL),
(182, '174', '9 Negro 16\"', '', 7, 'unidad', '1500.00', '2500.00', 10, 5, '', 1, '2025-08-05 09:33:07', NULL),
(183, '175', 'Bolsa de Regalo de 4000', '', 10, 'unidad', '2000.00', '4000.00', 24, 5, '', 1, '2025-08-05 09:51:47', NULL),
(184, '176', 'Bolsa de Regalo de papel crack 4000', '', 10, 'unidad', '2500.00', '4000.00', 56, 5, '', 1, '2025-08-05 09:52:41', NULL),
(185, '177', 'Bolsa de Regalo de 3000', '', 10, 'unidad', '1700.00', '3000.00', 58, 5, '', 1, '2025-08-05 09:53:18', '2025-08-05 11:39:45'),
(186, '178', 'Bolsa de Regalo de papel crack 2000', '', 10, 'unidad', '900.00', '2000.00', 45, 5, '', 1, '2025-08-05 09:53:59', NULL),
(187, '179', 'Bolsa de Regalo Estampada 4000', '', 10, 'unidad', '2200.00', '4000.00', 1, 5, '', 1, '2025-08-05 09:54:51', NULL),
(188, '180', 'Bolsa de Regalo Estampada 3000', '', 10, 'unidad', '1500.00', '3000.00', 2, 5, '', 1, '2025-08-05 09:55:23', NULL),
(189, '181', 'Bolsa de Regalo de Acetato Mamá', '', 10, 'unidad', '5000.00', '8000.00', 10, 5, '', 1, '2025-08-05 09:56:27', '2025-08-05 11:27:51'),
(190, '182', 'Bolsa de Regalo de Acetato con tiras', '', 10, 'unidad', '6000.00', '11000.00', 15, 5, '', 1, '2025-08-05 09:57:14', NULL),
(191, '183', 'Cortina Plateada de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 73, 5, '', 1, '2025-08-05 10:56:48', '2025-08-05 11:14:37'),
(192, '184', 'Cortina Dorada de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 25, 5, '', 1, '2025-08-05 10:58:15', '2025-08-05 11:14:49'),
(193, '185', 'Cortina Dorada Mate de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 59, 5, '', 1, '2025-08-05 10:59:08', '2025-08-05 11:15:01'),
(194, '186', 'Cortina Palo de Rosa de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 21, 5, '', 1, '2025-08-05 11:00:09', '2025-08-05 11:15:20'),
(195, '187', 'Cortina Fucsia de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 78, 5, '', 1, '2025-08-05 11:01:23', '2025-08-05 11:15:33'),
(196, '188', 'Cortina Lila de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 22, 5, '', 1, '2025-08-05 11:02:16', '2025-08-05 11:15:50'),
(197, '189', 'Cortina Roja de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 36, 5, '', 1, '2025-08-05 11:03:06', '2025-08-05 11:16:03'),
(198, '190', 'Cortina Azul Claro de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 22, 5, '', 1, '2025-08-05 11:03:42', '2025-08-05 11:16:30'),
(199, '191', 'Cortina Azul Rey de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 10, 5, '', 1, '2025-08-05 11:04:28', '2025-08-05 11:16:49'),
(200, '192', 'Cortina Verde de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 16, 5, '', 1, '2025-08-05 11:05:04', '2025-08-05 11:16:57'),
(201, '193', 'Cortina Verde Eucalipto de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 14, 5, '', 1, '2025-08-05 11:05:43', '2025-08-05 11:17:08'),
(202, '194', 'Cortina Azul Tornasol de Tiras', '', 6, 'unidad', '2000.00', '6000.00', 53, 5, '', 1, '2025-08-05 11:07:19', NULL),
(203, '195', 'Cortina Fucsia Tornasol de Tiras', '', 6, 'unidad', '2000.00', '6000.00', 29, 5, '', 1, '2025-08-05 11:08:08', NULL),
(204, '196', 'Cortina Rosado Tornasol de Tiras', '', 6, 'unidad', '2000.00', '6000.00', 59, 5, '', 1, '2025-08-05 11:09:02', NULL),
(205, '197', 'Cortina Amarillo Tornasol de Tiras', '', 6, 'unidad', '2000.00', '6000.00', 53, 5, '', 1, '2025-08-05 11:09:48', NULL),
(206, '198', 'Cortina Blanco Tornasol de Tiras', '', 6, 'unidad', '2000.00', '6000.00', 27, 5, '', 1, '2025-08-05 11:10:35', NULL),
(207, '199', 'Cortina Rosada de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 10, 5, '', 1, '2025-08-05 11:12:15', '2025-08-05 11:17:27'),
(208, '200', 'Cortina Morada de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 37, 5, '', 1, '2025-08-05 11:18:34', NULL),
(209, '201', 'Cortina Azul Rey de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 32, 5, '', 1, '2025-08-05 11:19:29', NULL),
(210, '202', 'Cortina Verde de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 33, 5, '', 1, '2025-08-05 11:20:31', NULL),
(211, '203', 'Cortina Roja de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 52, 5, '', 1, '2025-08-05 11:22:28', NULL),
(212, '204', 'Cortina Rosada de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 25, 5, '', 1, '2025-08-05 11:23:06', NULL),
(213, '205', 'Cortina Dorada de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 66, 5, '', 1, '2025-08-05 11:24:52', NULL),
(214, 'P250805983', 'piñata', '', 40, 'unidad', '7000.00', '30000.00', 2, 5, NULL, 3, '2025-08-05 11:27:51', '2025-08-05 11:29:52'),
(215, 'P250805462', 'piñata dinosaurio', '', 40, 'unidad', '1500.00', '20000.00', 0, 5, NULL, 1, '2025-08-05 11:31:18', '2025-08-05 14:18:35'),
(216, 'P250805223', 'piñata azul', '', 40, 'unidad', '1700.00', '35000.00', 2, 5, NULL, 1, '2025-08-05 11:39:45', '2025-08-05 11:42:19'),
(217, '206', 'Cortina Plateada de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 42, 5, '', 1, '2025-08-05 14:49:18', NULL),
(218, '207', 'Cortina Azul Claro de Cuadros', '', 6, 'unidad', '1500.00', '4500.00', 15, 5, '', 1, '2025-08-05 14:50:00', NULL),
(219, '208', 'Cortina Plateada Estampada de Tiras', '', 6, 'unidad', '1500.00', '4500.00', 16, 5, '', 1, '2025-08-05 14:51:00', NULL),
(220, '209', 'HBD Plateado', '', 56, 'unidad', '1500.00', '3500.00', 78, 5, '', 1, '2025-08-05 16:09:53', NULL),
(221, '210', 'HBD Rosado', '', 56, 'unidad', '1500.00', '3500.00', 85, 5, '', 1, '2025-08-05 16:12:25', NULL),
(222, '211', 'HBD Negro', '', 56, 'unidad', '1500.00', '3500.00', 85, 5, '', 1, '2025-08-05 16:12:53', NULL),
(223, '212', 'HBD Dorado', '', 56, 'unidad', '1500.00', '3500.00', 67, 5, '', 1, '2025-08-05 16:13:31', NULL),
(224, '213', 'HBD Fucsia', '', 56, 'unidad', '1500.00', '3500.00', 96, 5, '', 1, '2025-08-05 16:14:36', NULL),
(225, '214', 'HBD Rojo', '', 56, 'unidad', '1500.00', '3500.00', 95, 5, '', 1, '2025-08-05 16:15:25', NULL),
(226, '215', 'HBD Colorido', '', 56, 'unidad', '1500.00', '3500.00', 4, 5, '', 1, '2025-08-05 16:15:54', NULL),
(227, '216', 'HBD Palo de Rosa', '', 56, 'unidad', '1500.00', '3500.00', 91, 5, '', 1, '2025-08-05 16:16:42', NULL),
(228, '217', 'HBD Azul', '', 56, 'unidad', '1500.00', '4500.00', 81, 5, '', 1, '2025-08-05 16:18:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `nombrerol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`idrol`, `nombrerol`, `descripcion`, `estado`) VALUES
(1, 'Administrador', 'Acceso completo al sistema', 1),
(2, 'Venta', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `usuario`, `email`, `password`, `token`, `rolid`, `status`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 'Admin', 'Sistema', 'admin', 'admin@pinateria.com', '$2y$10$PdEEfkMLWcdpaIcG2vP0sOhz3DlYm1rcsrjFBZMrBGhJprHe/ZFTy', NULL, 1, 1, '2025-07-20 16:27:33', '2025-07-31 13:33:33'),
(10, 'venta', '1', 'venta', 'venta@pinateria.com', '$2y$10$FtCz7u7APkRth3jcL5Nwj.s6XXfS0ZpkY33Cp8yZmzyuJBYmLeacu', NULL, 2, 1, '2025-08-04 08:29:18', '2025-08-04 08:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `fecha_venta`, `subtotal`, `impuestos`, `descuentos`, `total`, `pago_con`, `cambio`, `costo_total`, `ganancia`, `metodo_pago`, `estado`, `observaciones`, `usuario_id`, `fecha_creacion`) VALUES
(38, NULL, '2025-08-05 11:42:19', '35000.00', '0.00', '0.00', '40000.00', '50000.00', '10000.00', '0.00', '0.00', 1, 1, '', 3, '2025-08-05 11:42:19'),
(39, NULL, '2025-08-05 14:18:35', '20000.00', '0.00', '0.00', '25000.00', '30000.00', '5000.00', '0.00', '0.00', 1, 1, '', 3, '2025-08-05 14:18:35');

--
-- Triggers `ventas`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indexes for table `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`),
  ADD KEY `producto_recurso_id` (`producto_recurso_id`);

--
-- Indexes for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `modulo_id` (`modulo_id`);

--
-- Indexes for table `producciones`
--
ALTER TABLE `producciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `producto_final_id` (`producto_final_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rolid` (`rolid`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cajas`
--
ALTER TABLE `cajas`
  ADD CONSTRAINT `cajas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD CONSTRAINT `detalle_produccion_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_produccion_ibfk_2` FOREIGN KEY (`producto_recurso_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_caja_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION;

--
-- Constraints for table `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`idrol`) ON DELETE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `producciones`
--
ALTER TABLE `producciones`
  ADD CONSTRAINT `producciones_ibfk_1` FOREIGN KEY (`producto_final_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `producciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `roles` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE;


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
