-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-06-2021 a las 13:24:22
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `joly`
--
CREATE DATABASE IF NOT EXISTS `joly` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `joly`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `imagen`, `condicion`) VALUES
(15, 11, 'GN-250GR', 'Guacamole Natural 250 Gr', 0, 'Guacamole natural con trocitos de aguacate', '1613059670.PNG', 1),
(16, 11, 'GP-250GR', 'Guacamole Picante 250 Gr', 0, 'Guacamole Picante con trocitos de aguacate', '1613059681.PNG', 1),
(18, 11, 'HU', 'Hummus', 8, '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(11, 'Guacamole', 'Producto Natural', 1),
(12, 'Promociones', 'Combos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_pago`
--

CREATE TABLE `comp_pago` (
  `id_comp_pago` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `letra_serie` varchar(3) NOT NULL,
  `serie_comprobante` varchar(3) NOT NULL,
  `num_comprobante` varchar(7) NOT NULL,
  `condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comp_pago`
--

INSERT INTO `comp_pago` (`id_comp_pago`, `nombre`, `letra_serie`, `serie_comprobante`, `num_comprobante`, `condicion`) VALUES
(6, 'Factura', 'F', '1', '0', 1),
(7, 'HolaComprobante', 'A', '001', '0000001', 1),
(8, 'Bono', 'B', '00', '2324324', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_negocio`
--

CREATE TABLE `datos_negocio` (
  `id_negocio` int(11) NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8 NOT NULL,
  `ndocumento` varchar(20) NOT NULL,
  `documento` int(11) NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 NOT NULL,
  `telefono` int(20) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `logo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pais` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `nombre_impuesto` varchar(10) NOT NULL,
  `monto_impuesto` float(4,2) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `simbolo` varchar(10) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_negocio`
--

INSERT INTO `datos_negocio` (`id_negocio`, `nombre`, `ndocumento`, `documento`, `direccion`, `telefono`, `email`, `logo`, `pais`, `ciudad`, `nombre_impuesto`, `monto_impuesto`, `moneda`, `simbolo`, `condicion`) VALUES
(2, 'JolyDips', 'NIT', 1017127127, 'Poblado', 31278632, 'camilo@jolydips.com', '1622938999.png', 'Colombia', 'Medellín', 'IVA', 19.00, 'PESOS', '$', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`, `estado`) VALUES
(34, 25, 15, 1, 1.00, 1.00, 1),
(36, 26, 16, 10, 1.00, 8900.00, 1),
(37, 27, 15, 10, 1.00, 8900.00, 1),
(38, 27, 16, 10, 1.00, 8900.00, 1),
(39, 28, 16, 10, 1.00, 9000.00, 1),
(40, 28, 15, 10, 1.00, 9000.00, 1),
(41, 29, 15, 17, 1.00, 9800.00, 1),
(42, 30, 15, 3, 1.00, 8900.00, 1),
(43, 30, 16, 2, 1.00, 8900.00, 1),
(44, 31, 15, 4, 1.00, 8900.00, 0),
(45, 31, 16, 8, 1.00, 8900.00, 0),
(46, 32, 15, 1, 1.00, 1.00, 0),
(47, 33, 16, 2, 5000.00, 9000.00, 1),
(48, 34, 16, 1, 1.00, 1.00, 1),
(49, 34, 15, 1, 1.00, 1.00, 1),
(50, 35, 16, 2, 10000.00, 20000.00, 1),
(51, 35, 15, 1, 11000.00, 121000.00, 1);

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
UPDATE articulo SET stock=stock + NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStock_ingreso_anulado` AFTER UPDATE ON `detalle_ingreso` FOR EACH ROW BEGIN
UPDATE articulo SET stock=stock - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`, `estado`) VALUES
(210, 111, 15, 1, 9000.00, 0.00, 0),
(212, 112, 15, 2, 8900.00, 0.00, 1),
(215, 113, 15, 2, 9000.00, 0.00, 1),
(216, 114, 16, 3, 8900.00, 0.00, 1),
(217, 114, 15, 2, 8900.00, 0.00, 1),
(218, 115, 15, 1, 1.00, 0.00, 1),
(219, 115, 16, 1, 8900.00, 0.00, 1),
(222, 116, 15, 2, 8900.00, 0.00, 1),
(223, 116, 16, 2, 8900.00, 0.00, 1),
(226, 117, 15, 3, 9000.00, 0.00, 1),
(227, 117, 16, 2, 9000.00, 0.00, 1),
(228, 118, 15, 10, 9000.00, 5000.00, 1),
(229, 118, 16, 10, 9000.00, 100000.00, 1),
(230, 119, 15, 7, 9000.00, 0.00, 1),
(231, 119, 16, 5, 9000.00, 0.00, 1),
(234, 120, 15, 6, 9000.00, 0.00, 1),
(237, 121, 15, 3, 9800.00, 0.00, 1),
(238, 121, 16, 6, 9000.00, 0.00, 1),
(239, 122, 15, 1, 8900.00, 0.00, 1),
(240, 122, 16, 1, 8900.00, 0.00, 1),
(241, 123, 15, 6, 8900.00, 2000.00, 1),
(242, 123, 16, 2, 8900.00, 500.00, 1),
(243, 124, 15, 1, 8900.00, 0.00, 1),
(244, 124, 16, 1, 8900.00, 0.00, 1),
(245, 125, 15, 1, 8900.00, 0.00, 1),
(246, 125, 16, 1, 8900.00, 0.00, 1),
(249, 126, 15, 1, 1.00, 1000.00, 0),
(250, 127, 16, 10, 9000.00, 0.00, 1),
(251, 127, 15, 8, 9000.00, 0.00, 1),
(252, 128, 16, 2, 20000.00, 0.00, 0),
(253, 128, 15, 2, 121000.00, 0.00, 0),
(254, 129, 15, 2, 200000.00, 0.00, 1),
(255, 129, 16, 3, 200000.00, 0.00, 1);

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_udpStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
UPDATE articulo SET stock = stock - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStock_venta_anulado` AFTER UPDATE ON `detalle_venta` FOR EACH ROW BEGIN
UPDATE articulo SET stock=stock + NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(25, 18, 1, 'Factura', 'Com', '1', '2021-02-06 00:00:00', 0.00, 1.00, 'Aceptado'),
(26, 18, 1, 'Factura', 'Com', '1', '2021-02-10 00:00:00', 0.00, 10.00, 'Aceptado'),
(27, 20, 1, 'Factura', 'Com', '6', '2021-02-11 00:00:00', 0.00, 20.00, 'Aceptado'),
(28, 20, 1, 'Factura', 'Com', '1243', '2021-02-14 00:00:00', 0.00, 20.00, 'Aceptado'),
(29, 20, 1, 'Factura', 'Comp', '5', '2021-02-17 00:00:00', 0.00, 17.00, 'Aceptado'),
(30, 20, 1, 'Factura', 'Comp', '2', '2021-03-01 00:00:00', 0.00, 5.00, 'Aceptado'),
(31, 20, 1, 'Factura', 'Comp', '3', '2021-03-02 00:00:00', 0.00, 12.00, 'Anulado'),
(32, 18, 1, 'Factura', '', 'Compra 1', '2021-06-03 00:00:00', 18.00, 1.18, 'Anulado'),
(33, 18, 1, 'Factura', '', '0000001', '2021-06-05 00:00:00', 19.00, 11900.00, 'Creada'),
(34, 18, 1, 'Factura', '', 'Compra 5', '2021-06-06 00:00:00', 0.00, 2.00, 'Aceptado'),
(35, 18, 1, 'Factura', '', 'Compra 6', '2021-06-06 00:00:00', 19.00, 36890.00, 'Aceptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `detalle` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`, `detalle`) VALUES
(1, 'Escritorio', 'Permitirá visualizar de forma rápida el conteo de registros de cada módulo'),
(2, 'Categorías y Productos', 'Permitirá crear, editar y cambiar de estado productos y categorías'),
(3, 'Compras', 'Permitirá crear y anular compras, así mismo crear, editar y cambiar de estado proveedores'),
(4, 'Ventas', 'Permitirá crear y anular ventas, así mismo crear, editar y cambiar de estado a clientes'),
(5, 'Acceso', 'Permitirá crear, editar y cambiar de estado a los usuarios'),
(6, 'Consulta Compras', 'Permitirá consultar un listado de compras en un rango determinado de fechas'),
(7, 'Consulta Ventas', 'Permitirá consultar un listado de ventas en un rango determinado de fechas y de un cliente en concreto'),
(8, 'Negocio, Comprobantes y tipos de pago', 'Permitirá modificar la información del negocio, así mismo como crear tipos de pago y crear, editar y desactivar comprobantes de pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `condicion`) VALUES
(17, 'Cliente', 'Jaime Zapata', 'CEDULA', '1017194872', 'Robledo', '3104072788', 'zapataval2304@gmail.com', 1),
(18, 'Proveedor', 'La granja', 'CEDULA', '1017127083', 'Belen', '30012874567', 'correo@gmail.com', 1),
(19, 'Cliente', 'Oscar Cano', 'CEDULA', '112827106', 'Belen los Alpes', '3016041308', 'oscarcs1214@gmail.com', 1),
(20, 'Proveedor', 'JolyDips', 'RUC', '1017127127', 'Poblado, Medellín', '3128518048', 'camilo@jolydips.com', 1),
(21, 'Cliente', 'Mario Sanmartín', 'CEDULA', '1039624713', 'Guayabal', '3504303890', 'mario@mario.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `idtipopago` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`idtipopago`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Efectivo', 'pago en efectivo', 1),
(4, 'Transferencia Bancolombia', 'Pago por transferencia Bancolombia', 1),
(5, 'Transferencia Bancaria', '$58.000 por Bancolombia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Juan Camilo', 'CEDULA', '72154871', 'Medellín, Colombia', '3128518047', 'admin@gmail.com', 'Administrador', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1622942709.jpg', 1),
(5, 'Juan Rengifo', 'CEDULA', '15316733', 'Calle falsa', '3152001282', 'juan@gmail.com', 'Empleado', 'juan', 'ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca', '1613059813.PNG', 1),
(6, 'Jaime  Zapata Valencia', 'CEDULA', '1017194872', 'Calle 65F # 117-59', '3104072788', 'zapataval2304@gmail.com', 'Sub Gerente', 'jzapval', 'cc06d61e3d1ea6a72abcc4974d42c304204d31d87130f7a0279383d182454c8e', '1614864607.png', 1),
(11, 'wanda', 'DNI', '12012', 'calle 4 No 54-59', '3155337207', 'wanda@gamil.com', 'Empleado', 'wanda', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '', 1),
(12, 'Jaime Zapata', 'DNI', '1017194872', 'Medellín, Colombia', '3104072788', 'zapataval2304@gmail.com', 'Administrador', 'jaime', '2a097b21dfbe7d9b3356a0a4979c5d8f5d4bb47111a9a39656f00dab3d0ddd09', '', 1),
(13, 'Diego', 'CEDULA', '1004', 'calle falsa', '315468', 'diego@gmail.com', 'Empleado', 'empleado 1', '35a9e381b1a27567549b5f8a6f783c167ebf809f1c4d6a9e367240484d8ce281', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(75, 5, 1),
(76, 5, 4),
(154, 12, 1),
(155, 12, 2),
(156, 12, 3),
(157, 12, 4),
(158, 12, 6),
(159, 12, 7),
(160, 12, 8),
(161, 6, 1),
(162, 6, 4),
(164, 11, 8),
(173, 13, 1),
(174, 13, 2),
(175, 13, 4),
(176, 1, 1),
(177, 1, 2),
(178, 1, 3),
(179, 1, 4),
(180, 1, 5),
(181, 1, 6),
(182, 1, 7),
(183, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(45) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) DEFAULT NULL,
  `total_venta` decimal(11,2) DEFAULT NULL,
  `tipo_pago` varchar(45) NOT NULL,
  `num_transac` varchar(45) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `tipo_pago`, `num_transac`, `estado`) VALUES
(111, 17, 1, 'Factura', 'F002', '0000001', '2021-02-06 00:00:00', 19.00, 10710.00, 'Efectivo', '', 'Anulado'),
(112, 17, 1, 'Factura', 'F002', '0000002', '2021-02-08 00:00:00', 0.00, 17800.00, 'Efectivo', '', 'Aceptado'),
(113, 17, 1, 'Factura', 'F002', '0000003', '2021-02-09 00:00:00', 19.00, 21420.00, 'Efectivo', '', 'Aceptado'),
(114, 19, 1, 'Factura', 'F002', '0000004', '2021-02-10 00:00:00', 0.00, 44500.00, 'Efectivo', '', 'Aceptado'),
(115, 19, 1, 'Factura', 'F002', '0000005', '2021-02-10 00:00:00', 19.00, 10592.19, 'Efectivo', '', 'Aceptado'),
(116, 21, 1, 'Factura', 'F002', '0000006', '2021-02-11 00:00:00', 0.00, 35600.00, 'Efectivo', '', 'Aceptado'),
(117, 19, 1, 'Factura', 'F002', '0000007', '2021-02-15 00:00:00', 0.00, 45000.00, 'Efectivo', '', 'Aceptado'),
(118, 17, 1, 'Factura', 'F002', '0000008', '2021-02-15 00:00:00', 19.00, 89250.00, 'Efectivo', '', 'Aceptado'),
(119, 19, 1, 'Factura', 'F002', '0000009', '2021-02-17 00:00:00', 0.00, 108000.00, 'Efectivo', '', 'Aceptado'),
(120, 21, 1, 'Factura', 'F002', '0000010', '2021-02-17 00:00:00', 19.00, 64260.00, 'Transferencia Bancolombia', '', 'Aceptado'),
(121, 17, 1, 'Factura', 'F002', '0000011', '2021-03-01 00:00:00', 19.00, 99246.00, 'Efectivo', '', 'Aceptado'),
(122, 17, 1, 'Factura', 'F002', '0000012', '2021-03-02 00:00:00', 19.00, 21182.00, 'Transferencia Bancolombia', 'TRN0000012345', 'Aceptado'),
(123, 21, 1, 'Factura', 'F002', '0000013', '2021-03-02 00:00:00', 19.00, 81753.00, 'Efectivo', '', 'Aceptado'),
(124, 17, 1, 'Factura', 'F002', '0000014', '2021-04-20 00:00:00', 19.00, 21182.00, 'Efectivo', '', 'Aceptado'),
(125, 17, 1, 'Factura', 'F002', '0000015', '2021-04-28 00:00:00', 19.00, 21182.00, 'Transferencia Bancolombia', 'DB0000012345', 'Aceptado'),
(126, 17, 1, 'Factura', 'F002', '0000016', '2021-06-03 00:00:00', 19.00, -1188.81, 'Efectivo', '', 'Anulado'),
(127, 17, 1, 'Factura', '', '0000017', '2021-06-05 00:00:00', 19.00, 192780.00, 'Efectivo', '', 'Aceptado'),
(128, 17, 1, 'Factura', 'F000', '0000018', '2021-06-06 00:00:00', 19.00, 335580.00, 'Transferencia Bancolombia', 'BN345678', 'Anulado'),
(129, 17, 1, 'Factura', 'F000', '0000019', '2021-06-06 00:00:00', 19.00, 359380.00, 'Efectivo', '', 'Aceptado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `comp_pago`
--
ALTER TABLE `comp_pago`
  ADD PRIMARY KEY (`id_comp_pago`);

--
-- Indices de la tabla `datos_negocio`
--
ALTER TABLE `datos_negocio`
  ADD PRIMARY KEY (`id_negocio`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`idtipopago`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_u_permiso_usuario_idx` (`idusuario`),
  ADD KEY `fk_usuario_permiso_idx` (`idpermiso`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona_idx` (`idcliente`),
  ADD KEY `fk_venta_usuario_idx` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comp_pago`
--
ALTER TABLE `comp_pago`
  MODIFY `id_comp_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `datos_negocio`
--
ALTER TABLE `datos_negocio`
  MODIFY `id_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `idtipopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `fk_detalle_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ingreso` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingreso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_u_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_persona` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
