-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2024 a las 06:49:34
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
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IdCategoria` int(11) NOT NULL,
  `Categoria` varchar(30) DEFAULT NULL,
  `Descripcion` varchar(30) DEFAULT NULL,
  `MetodoInventario` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `IdCliente` int(11) NOT NULL,
  `NombreCliente` varchar(30) DEFAULT NULL,
  `Correo` varchar(40) DEFAULT NULL,
  `Direccion` varchar(30) DEFAULT NULL,
  `MetodoDePago` varchar(30) DEFAULT NULL,
  `MetodoEnvio` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `IdCompra` int(11) NOT NULL,
  `FechaCompra` date DEFAULT NULL,
  `IdProductoC` int(11) DEFAULT NULL,
  `IdClienteC` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `TotalCompra` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detallecompras` (
  `IdDetalleCompra` int(11) NOT NULL,
  `IdCompraD` int(11) DEFAULT NULL,
  `Cantidad` int(10) DEFAULT NULL,
  `SubTotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
  `IdDetalleVenta` int(11) NOT NULL,
  `IdVentaDv` int(11) DEFAULT NULL,
  `IdSucursalVdv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `IdProducto` int(11) NOT NULL,
  `NombreProducto` varchar(30) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Foto` longblob DEFAULT NULL,
  `IdCategoriaP` int(11) DEFAULT NULL,
  `IdSucursalP` int(11) DEFAULT NULL,
  `IdProveedorP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `IdProveedor` int(11) NOT NULL,
  `NombreProveedor` varchar(30) DEFAULT NULL,
  `CorreoProveedor` varchar(40) DEFAULT NULL,
  `TelefonoProveedor` int(11) DEFAULT NULL,
  `MetodoDePagoAceptado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `IdSucursal` int(11) NOT NULL,
  `NombreSucursal` varchar(30) DEFAULT NULL,
  `Ubicacion` varchar(110) DEFAULT NULL,
  `Departamento` varchar(30) DEFAULT NULL,
  `Municipio` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido` varchar(30) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `DUI` int(11) DEFAULT NULL,
  `Contraseña` varchar(30) DEFAULT NULL,
  `Rol` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `IdVenta` int(11) NOT NULL,
  `FechaVenta` date DEFAULT NULL,
  `IdSucursalV` int(11) DEFAULT NULL,
  `IdProductoV` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `MetodoDePago` varchar(30) DEFAULT NULL,
  `MetodoEnvio` varchar(30) DEFAULT NULL,
  `TotalVenta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`IdCliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`IdCompra`),
  ADD KEY `IdProductoC` (`IdProductoC`),
  ADD KEY `IdClienteC` (`IdClienteC`);

--
-- Indices de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD PRIMARY KEY (`IdDetalleCompra`),
  ADD KEY `IdCompraD` (`IdCompraD`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`IdDetalleVenta`),
  ADD KEY `IdVentaDv` (`IdVentaDv`),
  ADD KEY `IdSucursalVdv` (`IdSucursalVdv`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdCategoriaP` (`IdCategoriaP`),
  ADD KEY `IdSucursalP` (`IdSucursalP`),
  ADD KEY `IdProveedorP` (`IdProveedorP`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`IdSucursal`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdSucursalV` (`IdSucursalV`),
  ADD KEY `IdProductoV` (`IdProductoV`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`IdProductoC`) REFERENCES `productos` (`IdProducto`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`IdClienteC`) REFERENCES `clientes` (`IdCliente`);

--
-- Filtros para la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD CONSTRAINT `detallecompras_ibfk_1` FOREIGN KEY (`IdCompraD`) REFERENCES `compras` (`IdCompra`);

--
-- Filtros para la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD CONSTRAINT `detalleventas_ibfk_1` FOREIGN KEY (`IdVentaDv`) REFERENCES `ventas` (`IdVenta`),
  ADD CONSTRAINT `detalleventas_ibfk_2` FOREIGN KEY (`IdSucursalVdv`) REFERENCES `sucursales` (`IdSucursal`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`IdCategoriaP`) REFERENCES `categorias` (`IdCategoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`IdSucursalP`) REFERENCES `sucursales` (`IdSucursal`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`IdProveedorP`) REFERENCES `proveedores` (`IdProveedor`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`IdSucursalV`) REFERENCES `sucursales` (`IdSucursal`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`IdProductoV`) REFERENCES `productos` (`IdProducto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
