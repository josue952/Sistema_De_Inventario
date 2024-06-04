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
CREATE DATABASE IF NOT EXISTS `inventario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE inventario;
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
    `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
    `Nombre` varchar(30) NOT NULL,
    `Apellido` varchar(30) NOT NULL,
    `Email` varchar(40) NOT NULL,
    `DUI` int(9) NOT NULL,
    `Contraseña` varchar(30) NOT NULL,
    `Rol` varchar(15) NOT NULL,
    PRIMARY KEY (`idUsuario`),
    UNIQUE (`DUI`),
    CHECK (`Rol` IN ('Administrador', 'Empleado', 'Cajero'))
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
    `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
    `Categoria` varchar(30) NOT NULL,
    `Descripcion` varchar(150) NOT NULL,
    `MetodoInventario` varchar(30) NOT NULL,
    PRIMARY KEY (`idCategoria`),
    CHECK (`MetodoInventario` IN ('PEPS', 'UEPS', 'Promedio'))
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
    `idSucursal` int(11) NOT NULL AUTO_INCREMENT,
    `NombreSucursal` varchar(50)  NOT NULL,
    `Ubicacion` varchar(250)   NOT NULL,
    `Departamento` varchar(30)  NOT NULL,
    `Municipio` varchar(30)  NOT NULL,
    PRIMARY KEY (`idSucursal`)
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
    `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
    `NombreProveedor` varchar(30) NOT NULL,
    `CorreoProveedor` varchar(40) NOT NULL,
    `TelefonoProveedor` int(11) NOT NULL,
    `MetodoDePagoAceptado` varchar(30) NOT NULL,
    PRIMARY KEY (`idProveedor`),
    CHECK (`MetodoDePagoAceptado` IN ('Efectivo', 'Transferencia', 'Deposito'))
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
    `idCompra` int(11) NOT NULL AUTO_INCREMENT,
    `FechaCompra` DATE NOT NULL,
    `idProveedor` int(11) NOT NULL,
    `idSucursal` int(11) NOT NULL,
    `TotalCompra` decimal(10,2) DEFAULT NULL,
    PRIMARY KEY (`idCompra`),
    FOREIGN KEY (`idProveedor`) REFERENCES `proveedores`(`idProveedor`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idSucursal`) REFERENCES `sucursales`(`idSucursal`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Sirve para cambiar el formato de la fecha de la compra de 'yyyy-mm-dd' a 'dd/mm/yyyy'
SELECT DATE_FORMAT(FechaCompra, '%d/%m/%Y') AS FechaCompraF FROM compras;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detalleCompras` (
    `idDetalleCompra` int(11) NOT NULL AUTO_INCREMENT,
    `idCompra` int(11) NOT NULL,
    `NombreProducto` varchar(50) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    `Precio` decimal(10,2) NOT NULL,
    `SubTotal` decimal(10,2) NOT NULL,
    PRIMARY KEY (`idDetalleCompra`),
    FOREIGN KEY (`idCompra`) REFERENCES `compras`(`idCompra`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
    `idProducto` int(11) NOT NULL AUTO_INCREMENT,
    `NombreProducto` varchar(50) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    `Precio` decimal(10,2) NOT NULL,
    `Foto` longblob DEFAULT NULL,
    `idCategoria` int(11) DEFAULT NULL, -- No es obligatorio para la creacion del producto, pero luego se debe asignar
    `idSucursal` int(11) DEFAULT NULL, -- No es obligatorio para la creacion del producto, pero luego se debe asignar
    PRIMARY KEY (`idProducto`),
    FOREIGN KEY (`idCategoria`) REFERENCES `categorias`(`idCategoria`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idSucursal`) REFERENCES `sucursales`(`idSucursal`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
    `idCliente` int(11) NOT NULL AUTO_INCREMENT,
    `NombreCliente` varchar(30) NOT NULL,
    `Correo` varchar(40) NOT NULL,
    `Direccion` varchar(30) NOT NULL,
    `MetodoDePago` varchar(30) NOT NULL,
    `MetodoEnvio` varchar(30) NOT NULL,
    PRIMARY KEY (`idCliente`),
    CHECK (`MetodoDePago` IN ('Efectivo', 'Tarjeta', 'Transferencia')),
    CHECK (`MetodoEnvio` IN ('Domicilio', 'Retiro'))
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
    `idVenta` int(11) NOT NULL AUTO_INCREMENT,
    `FechaVenta` DATE NOT NULL,
    `idCliente` int(11) NOT NULL,
    `TotalVenta` decimal(10,2) NOT NULL,
    PRIMARY KEY (`idVenta`),
    FOREIGN KEY (`idCliente`) REFERENCES `clientes`(`idCliente`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Sirve para cambiar el formato de la fecha de la compra de 'yyyy-mm-dd' a 'dd/mm/yyyy'
SELECT DATE_FORMAT(FechaVenta, '%d/%m/%Y') AS FechaVentaF FROM ventas;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleVentas` (
    `idDetalleVenta` int(11) NOT NULL AUTO_INCREMENT,
    `idVenta` int(11) NOT NULL,
    `idProducto` int(11) NOT NULL,
    `NombreProducto` varchar(50) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    `Precio` decimal(10,2) NOT NULL,
    `idSucursal` int(11) NOT NULL,
    `SubTotal` decimal(10,2) NOT NULL,
    PRIMARY KEY (`idDetalleVenta`),
    FOREIGN KEY (`idVenta`) REFERENCES `ventas`(`idVenta`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idProducto`) REFERENCES `productos`(`idProducto`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idSucursal`) REFERENCES `sucursales`(`idSucursal`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `entradas`
CREATE TABLE `entradas` (
    `idEntrada` int(11) NOT NULL AUTO_INCREMENT,
    `FechaEntrada` DATE NOT NULL,
    `idProducto` int(11) NOT NULL,
    `Motivo` varchar(250) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    `idProveedor` int(11) DEFAULT NULL, -- Opcional, si se relaciona con una compra
    PRIMARY KEY (`idEntrada`),
    FOREIGN KEY (`idProducto`) REFERENCES `productos`(`idProducto`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idProveedor`) REFERENCES `proveedores`(`idProveedor`)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Sirve para cambiar el formato de la fecha de la compra de 'yyyy-mm-dd' a 'dd/mm/yyyy'
SELECT DATE_FORMAT(FechaEntrada, '%d/%m/%Y') AS FechaEntradaF FROM entradas;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `salidas`

CREATE TABLE `salidas` (
    `idSalida` int(11) NOT NULL AUTO_INCREMENT,
    `FechaSalida` DATE NOT NULL,
    `idProducto` int(11) NOT NULL,
    `Motivo` varchar(250) NOT NULL,
    `Cantidad` int(11) NOT NULL,
    `idCliente` int(11) DEFAULT NULL, -- Opcional, si se relaciona con una venta
    PRIMARY KEY (`idSalida`),
    FOREIGN KEY (`idProducto`) REFERENCES `productos`(`idProducto`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`idCliente`) REFERENCES `clientes`(`idCliente`)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Sirve para cambiar el formato de la fecha de la compra de 'yyyy-mm-dd' a 'dd/mm/yyyy'
SELECT DATE_FORMAT(FechaSalida, '%d/%m/%Y') AS FechaSalidaF FROM salidas;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `empresa`
-- Esta tabla almacenara la informacion de la empresa, como su nombre, logo, slogan, mision, vision y sobre nosotros
CREATE TABLE empresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NombreEmpresa VARCHAR(255),
    LogoEmpresa VARCHAR(255),
    SloganEmpresa VARCHAR(255),
    MisionEmpresa TEXT,
    VisionEmpresa TEXT,
    AboutUsEmpresa TEXT
);

-- --------------------------------------------------------


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
