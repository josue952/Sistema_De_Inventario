-- Procedimientos almacenados para el sistema de inventario
-- Procedimientos almacenados de la tabla Usuarios para su CRUD --

-- Procedimiento para Crear un Usuario
DELIMITER //

CREATE PROCEDURE `crearUsuario`(
    IN p_Nombre VARCHAR(30),
    IN p_Apellido VARCHAR(30),
    IN p_Email VARCHAR(40),
    IN p_DUI INT(9),
    IN p_Contraseña VARCHAR(30),
    IN p_Rol VARCHAR(15)
)
BEGIN
    INSERT INTO usuarios (Nombre, Apellido, Email, DUI, Contraseña, Rol)
    VALUES (p_Nombre, p_Apellido, p_Email, p_DUI, p_Contraseña, p_Rol);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todos los Usuarios

DELIMITER //

CREATE PROCEDURE `obtenerUsuarios`()
BEGIN
    SELECT * FROM usuarios;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) un Usuario por id, nombre y rol

DELIMITER //

CREATE PROCEDURE obtenerUsuariosFiltro(
    IN p_idUsuario INT,
    IN p_Nombre VARCHAR(30),
    IN p_Rol VARCHAR(15)
)
BEGIN
    SET @sql = 'SELECT * FROM usuarios WHERE 1=1';
    
    IF p_idUsuario IS NOT NULL AND p_idUsuario != '' THEN
        SET @sql = CONCAT(@sql, ' AND idUsuario = ', p_idUsuario);
    END IF;

    IF p_Nombre IS NOT NULL AND p_Nombre != '' THEN
        SET @sql = CONCAT(@sql, ' AND Nombre = ''', p_Nombre, '''');
    END IF;

    IF p_Rol IS NOT NULL AND p_Rol != '' THEN
        SET @sql = CONCAT(@sql, ' AND Rol = ''', p_Rol, '''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

-- Procedimiento para Actualizar un Usuario

DELIMITER //

CREATE PROCEDURE `actualizarUsuario`(
    IN p_idUsuario INT,
    IN p_Nombre VARCHAR(30),
    IN p_Apellido VARCHAR(30),
    IN p_Email VARCHAR(40),
    IN p_DUI INT(9),
    IN p_Contraseña VARCHAR(30),
    IN p_Rol VARCHAR(15)
)
BEGIN
    UPDATE usuarios
    SET Nombre = p_Nombre,
        Apellido = p_Apellido,
        Email = p_Email,
        DUI = p_DUI,
        Contraseña = p_Contraseña,
        Rol = p_Rol
    WHERE idUsuario = p_idUsuario;
END //

DELIMITER ;

-- Procedimiento para Eliminar un Usuario

DELIMITER //

CREATE PROCEDURE `eliminarUsuario`(
    IN p_idUsuario INT
)
BEGIN
    DELETE FROM usuarios WHERE idUsuario = p_idUsuario;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimientos almacenados de la tabla Categorias para su CRUD --

-- Procedimiento para Crear una Categoria
DELIMITER //

CREATE PROCEDURE crearCategoria(
    IN p_Categoria VARCHAR(30),
    IN p_Descripcion VARCHAR(150),
    IN p_MetodoInventario VARCHAR(30)
)
BEGIN
    INSERT INTO categorias (Categoria, Descripcion, MetodoInventario)
    VALUES (p_Categoria, p_Descripcion, p_MetodoInventario);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todas las Categorias
DELIMITER //

CREATE PROCEDURE obtenerCategorias()
BEGIN
    SELECT * FROM categorias;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) una Categoria por id, nombre de categoria y Metodo de inventario



-- Procedimiento para Actualizar una Categoria
DELIMITER //

CREATE PROCEDURE actualizarCategoria(
    IN p_idCategoria INT,
    IN p_Categoria VARCHAR(30),
    IN p_Descripcion VARCHAR(150),
    IN p_MetodoInventario VARCHAR(30)
)
BEGIN
    UPDATE categorias
    SET Categoria = p_Categoria,
        Descripcion = p_Descripcion,
        MetodoInventario = p_MetodoInventario
    WHERE idCategoria = p_idCategoria;
END //

DELIMITER ;

-- Procedimiento para Eliminar una Categoria
DELIMITER //

CREATE PROCEDURE eliminarCategoria(
    IN p_idCategoria INT
)
BEGIN
    DELETE FROM categorias WHERE idCategoria = p_idCategoria;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimientos almacenados de la tabla Sucursales para su CRUD --

-- Procedimiento para Crear una Sucursal
DELIMITER //

CREATE PROCEDURE crearSucursal(
    IN p_NombreSucursal VARCHAR(50),
    IN p_Ubicacion VARCHAR(250),
    IN p_Departamento VARCHAR(30),
    IN p_Municipio VARCHAR(30)
)
BEGIN
    INSERT INTO sucursales (NombreSucursal, Ubicacion, Departamento, Municipio)
    VALUES (p_NombreSucursal, p_Ubicacion, p_Departamento, p_Municipio);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todas las Sucursales
DELIMITER //

CREATE PROCEDURE obtenerSucursales()
BEGIN
    SELECT * FROM sucursales;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) una Sucursal por id, nombre de sucursal, departamento y municipio



-- Procedimiento para Actualizar una Sucursal
DELIMITER //

CREATE PROCEDURE actualizarSucursal(
    IN p_idSucursal INT,
    IN p_NombreSucursal VARCHAR(50),
    IN p_Ubicacion VARCHAR(250),
    IN p_Departamento VARCHAR(30),
    IN p_Municipio VARCHAR(30)
)
BEGIN
    UPDATE sucursales
    SET NombreSucursal = p_NombreSucursal,
        Ubicacion = p_Ubicacion,
        Departamento = p_Departamento,
        Municipio = p_Municipio
    WHERE idSucursal = p_idSucursal;
END //

DELIMITER ;

-- Procedimiento para Eliminar una Sucursal
DELIMITER //

CREATE PROCEDURE eliminarSucursal(
    IN p_idSucursal INT
)
BEGIN
    DELETE FROM sucursales WHERE idSucursal = p_idSucursal;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimientos almacenados de la tabla Proveedores para su CRUD --
-- Procedimiento para Crear un Proveedor
DELIMITER //

CREATE PROCEDURE crearProveedor(
    IN p_NombreProveedor VARCHAR(30),
    IN p_CorreoProveedor VARCHAR(40),
    IN p_TelefonoProveedor INT,
    IN p_MetodoDePagoAceptado VARCHAR(30)
)
BEGIN
    INSERT INTO proveedores (NombreProveedor, CorreoProveedor, TelefonoProveedor, MetodoDePagoAceptado)
    VALUES (p_NombreProveedor, p_CorreoProveedor, p_TelefonoProveedor, p_MetodoDePagoAceptado);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todos los Proveedores
DELIMITER //

CREATE PROCEDURE obtenerProveedores()
BEGIN
    SELECT * FROM proveedores;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) un Proveedor por id, nombre de proveedor y metodo de pago aceptado

DELIMITER //

CREATE PROCEDURE obtenerProveedoresFiltro(
    IN p_idProveedor INT,
    IN p_NombreProveedor VARCHAR(30)
)
BEGIN
    SET @sql = 'SELECT * FROM proveedores WHERE 1=1';
    
    IF p_idProveedor IS NOT NULL AND p_idProveedor != '' THEN
        SET @sql = CONCAT(@sql, ' AND idProveedor = ', p_idProveedor);
    END IF;

    IF p_NombreProveedor IS NOT NULL AND p_NombreProveedor != '' THEN
        SET @sql = CONCAT(@sql, ' AND NombreProveedor = ''', p_NombreProveedor, '''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

-- Procedimiento para Actualizar un Proveedor
DELIMITER //

CREATE PROCEDURE actualizarProveedor(
    IN p_idProveedor INT,
    IN p_NombreProveedor VARCHAR(30),
    IN p_CorreoProveedor VARCHAR(40),
    IN p_TelefonoProveedor INT,
    IN p_MetodoDePagoAceptado VARCHAR(30)
)
BEGIN
    UPDATE proveedores
    SET NombreProveedor = p_NombreProveedor,
        CorreoProveedor = p_CorreoProveedor,
        TelefonoProveedor = p_TelefonoProveedor,
        MetodoDePagoAceptado = p_MetodoDePagoAceptado
    WHERE idProveedor = p_idProveedor;
END //

DELIMITER ;

-- Procedimiento para Eliminar un Proveedor
DELIMITER //

CREATE PROCEDURE eliminarProveedor(
    IN p_idProveedor INT
)
BEGIN
    DELETE FROM proveedores WHERE idProveedor = p_idProveedor;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimiento para Crear un Cliente
DELIMITER //

CREATE PROCEDURE crearCliente(
    IN p_NombreCliente VARCHAR(30),
    IN p_EmailCliente VARCHAR(40),
    IN p_DireccionCliente VARCHAR(100),
    IN p_MetodoDePago VARCHAR(30),
    IN p_MetodoEnvio VARCHAR(30)
)
BEGIN
    INSERT INTO clientes (NombreCliente, Correo, Direccion, MetodoDePago, MetodoEnvio)
    VALUES (p_NombreCliente, p_EmailCliente, p_DireccionCliente, p_MetodoDePago, p_MetodoEnvio);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todos los clientes
DELIMITER //

CREATE PROCEDURE obtenerClientes()
BEGIN
    SELECT * FROM clientes;
END //

DELIMITER ;

DELIMITER //

-- Procedimiento para Leer (obtener) un cliente por id y nombre de cliente
CREATE PROCEDURE obtenerClientesFiltro(
    IN p_idCliente INT,
    IN p_NombreCliente VARCHAR(30)
)
BEGIN
    SET @sql = 'SELECT * FROM clientes WHERE 1=1';
    
    IF p_idCliente IS NOT NULL AND p_idCliente != '' THEN
        SET @sql = CONCAT(@sql, ' AND idCliente = ', p_idCliente);
    END IF;

    IF p_NombreCliente IS NOT NULL AND p_NombreCliente != '' THEN
        SET @sql = CONCAT(@sql, ' AND NombreCliente = ''', p_NombreCliente, '''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

-- Procedimiento para Actualizar un Cliente
DELIMITER //

CREATE PROCEDURE actualizarCliente(
    IN p_idCliente INT,
    IN p_NombreCliente VARCHAR(30),
    IN p_EmailCliente VARCHAR(40),
    IN p_DireccionCliente VARCHAR(100),
    IN p_MetodoDePago VARCHAR(30),
    IN p_MetodoEnvio VARCHAR(30)
)
BEGIN
    UPDATE clientes
    SET NombreCliente = p_NombreCliente,
        Correo = p_EmailCliente,
        Direccion = p_DireccionCliente,
        MetodoDePago = p_MetodoDePago,
        MetodoEnvio = p_MetodoEnvio
    WHERE idCliente = p_idCliente;
END //

DELIMITER ;

-- Procedimiento para Eliminar un Cliente
DELIMITER //

CREATE PROCEDURE eliminarCliente(
    IN p_idCliente INT
)
BEGIN
    DELETE FROM clientes WHERE idCliente = p_idCliente;
END //

DELIMITER ;

---------------------------------------------------------------

-- Procedimientos almacenados de la tabla Compras para su CRUD -- 
-- Procedimiento para inicializar una compra
DELIMITER //

CREATE PROCEDURE crearCompra(
    IN p_FechaCompra DATE,
    IN p_idProveedor INT,
    IN p_idSucursal INT
)
BEGIN
    -- Inicializar la compra con un total de 0.0, este valo cambiará al agregar productoss
    DECLARE p_TotalCompra DECIMAL(10,2) DEFAULT 0.0;
    INSERT INTO compras (FechaCompra, idProveedor, idSucursal, TotalCompra)
    VALUES (p_FechaCompra, p_idProveedor, p_idSucursal, p_TotalCompra);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todas las Compras
DELIMITER //

CREATE PROCEDURE obtenerCompras()
BEGIN
    SELECT * FROM compras;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) una Compra por id, fecha de compra, id de proveedor y id de sucursal



-- Procedimiento para Actualizar una Compra
DELIMITER //

CREATE PROCEDURE actualizarCompra(
    IN p_idCompra INT,
    IN p_FechaCompra DATE,
    IN p_idProveedor INT,
    IN p_idSucursal INT,
    IN p_TotalCompra DECIMAL(10,2)
)
BEGIN
    UPDATE compras
    SET FechaCompra = p_FechaCompra,
        idProveedor = p_idProveedor,
        idSucursal = p_idSucursal,
        TotalCompra = p_TotalCompra
    WHERE idCompra = p_idCompra;
END //

DELIMITER ;

-- Procedimiento para Eliminar una Compra
DELIMITER //

CREATE PROCEDURE eliminarCompra(
    IN p_idCompra INT
)
BEGIN
    DELETE FROM compras WHERE idCompra = p_idCompra;
END //

DELIMITER ;

-- En esta parte, se comenzara con la logica que conlleva comprar productos
-- Procedimiento para agregar un producto a una compra (en detalleCompras)
DELIMITER //

CREATE PROCEDURE agregarProductoACompra(
    IN idCompra INT,
    IN idProducto INT,
    IN cantidad INT,
    IN precioProducto DECIMAL(10,2),
    OUT subTotalProducto DECIMAL(10,2)
)
BEGIN
    -- Obtener el precio del producto
    SELECT Precio, Precio * cantidad AS subTotalProducto
    INTO precioProducto, subTotalProducto
    FROM productos
    WHERE idProducto = idProducto;

    -- Si el producto existe, agregarlo al detalle de la compra
    IF precioProducto IS NOT NULL THEN
        INSERT INTO detalleCompras (idCompra, NombreProducto, Cantidad, Precio, SubTotal)
        VALUES (idCompra, (SELECT NombreProducto FROM productos WHERE idProducto = idProducto), cantidad, precioProducto, subTotalProducto);

        -- Actualizar el total de la compra
        UPDATE compras
        SET TotalCompra = TotalCompra + subTotalProducto
        WHERE idCompra = idCompra;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Producto no encontrado.';
    END IF;
END //

DELIMITER ;
