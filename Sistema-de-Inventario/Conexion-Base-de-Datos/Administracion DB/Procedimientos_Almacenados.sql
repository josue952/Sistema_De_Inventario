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

DELIMITER //

CREATE PROCEDURE obtenerCategoriaFiltro(
    IN p_idCategoria INT,
    IN p_Categoria VARCHAR(30),
    IN p_MetodoInventario VARCHAR(15)
)
BEGIN
    SET @sql = 'SELECT * FROM categorias WHERE 1=1';
    
    IF p_idCategoria IS NOT NULL AND p_idCategoria != '' THEN
        SET @sql = CONCAT(@sql, ' AND idCategoria = ', p_idCategoria);
    END IF;

    IF p_Categoria IS NOT NULL AND p_Categoria != '' THEN
        SET @sql = CONCAT(@sql, ' AND Categoria = ''', p_Categoria, '''');
    END IF;

    IF p_MetodoInventario IS NOT NULL AND p_MetodoInventario != '' THEN
        SET @sql = CONCAT(@sql, ' AND MetodoInventario = ''', p_MetodoInventario, '''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;


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

DELIMITER //

CREATE PROCEDURE obtenerSucursalFiltro(
    IN p_idSucursal INT,
    IN p_NombreSucursal VARCHAR(30),
    IN p_Departamento VARCHAR(15),
    IN p_Municipio VARCHAR(15)
)
BEGIN
    SET @sql = 'SELECT * FROM sucursales WHERE 1=1';
    
    IF p_idSucursal IS NOT NULL AND p_idSucursal != '' THEN
        SET @sql = CONCAT(@sql, ' AND idSucursal = ', p_idSucursal);
    END IF;

    IF p_NombreSucursal IS NOT NULL AND p_NombreSucursal != '' THEN
        SET @sql = CONCAT(@sql, ' AND NombreSucursal = ''', p_NombreSucursal, '''');
    END IF;

    IF p_Departamento IS NOT NULL AND p_Departamento != '' THEN
        SET @sql = CONCAT(@sql, ' AND Departamento = ''', p_Departamento, '''');
    END IF;

    IF p_Municipio IS NOT NULL AND p_Municipio != '' THEN
        SET @sql = CONCAT(@sql, ' AND Municipio = ''', p_Municipio, '''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

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

-- Procedimientos almacenados de la tabla Compras para su CRUD -- 
-- Procedimiento para inicializar una compra
DELIMITER //

CREATE PROCEDURE crearCompra(
    IN p_FechaCompra DATE, -- Cambiado de DATE a VARCHAR
    IN p_idProveedor INT,
    IN p_idSucursal INT
)
BEGIN
    -- Inicializar la compra con un total de 0.0, este valor cambiará al agregar productos
    DECLARE p_TotalCompra DECIMAL(10,2) DEFAULT 0.0;

    -- Insertar la compra con la fecha convertida
    INSERT INTO compras (FechaCompra, idProveedor, idSucursal, TotalCompra)
    VALUES (p_FechaCompra, p_idProveedor, p_idSucursal, p_TotalCompra);
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) todas las Compras
-- Se obtiene el id de la compra, la fecha de la compra, el nombre del proveedor, el nombre de la sucursal y el total de la compra
DELIMITER //

CREATE PROCEDURE obtenerCompras()
BEGIN
    SELECT 
        c.idCompra,
        DATE_FORMAT(c.FechaCompra, '%d-%m-%y') AS FechaCompra,
        p.NombreProveedor,
        s.NombreSucursal,
        c.TotalCompra
    FROM compras c
    JOIN proveedores p ON c.idProveedor = p.idProveedor
    JOIN sucursales s ON c.idSucursal = s.idSucursal;
END //

DELIMITER ;

-- Procedimiento para Leer (obtener) una Compra por id, fecha de compra, id de proveedor y id de sucursal
-- Se obtiene el id de la compra, la fecha de la compra, el nombre del proveedor, el nombre de la sucursal y el total de la compra
DELIMITER //

CREATE PROCEDURE obtenerCompraFiltro(
    IN p_idCompra INT,
    IN p_FechaCompra DATE,
    IN p_NombreProveedor INT,
    IN p_NombreSucursal INT
)
BEGIN
    SET @sql = 'SELECT 
                    c.idCompra,
                    FechaCompra,
                    idProveedor,
                    idSucursal,
                    c.TotalCompra
                FROM compras c
                WHERE 1=1';
    
    IF p_idCompra IS NOT NULL AND p_idCompra != '' THEN
        SET @sql = CONCAT(@sql, ' AND c.idCompra = ', p_idCompra);
    END IF;

    IF p_FechaCompra IS NOT NULL AND p_FechaCompra != '' THEN
        SET @sql = CONCAT(@sql, ' AND c.FechaCompra = STR_TO_DATE(''', p_FechaCompra, ''', ''%d-%m-%y'')');
    END IF;

    IF p_NombreProveedor IS NOT NULL AND p_NombreProveedor != '' THEN
        SET @sql = CONCAT(@sql, ' AND p.NombreProveedor LIKE ''%', p_NombreProveedor, '%''');
    END IF;

    IF p_NombreSucursal IS NOT NULL AND p_NombreSucursal != '' THEN
        SET @sql = CONCAT(@sql, ' AND s.NombreSucursal LIKE ''%', p_NombreSucursal, '%''');
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

-- Procedimiento para Actualizar una Compra
DELIMITER //

CREATE PROCEDURE actualizarCompra(
    IN p_idCompra INT,
    IN p_FechaCompra DATE,
    IN p_idProveedor INT,
    IN p_idSucursal INT
)
BEGIN
    UPDATE compras
    SET FechaCompra = p_FechaCompra,
        idProveedor = p_idProveedor,
        idSucursal = p_idSucursal
    WHERE idCompra = p_idCompra;
END //

DELIMITER ;

-- --------------------------------------------------------

-- En esta parte, se comenzara con la logica que conlleva comprar productos
-- Procedimiento para agregar un producto a una compra (en detalleCompras)

DELIMITER //

CREATE PROCEDURE agregarProductoACompra(
    IN p_idCompra INT,
    IN p_NombreProducto VARCHAR(50),
    IN p_cantidad INT,
    IN p_precioProducto DECIMAL(10,2),
    IN p_subTotalProducto DECIMAL(10,2)
)
BEGIN
    -- Insertar el producto en detalleCompras
    INSERT INTO detalleCompras (idCompra, NombreProducto, Cantidad, Precio, SubTotal)
    VALUES (p_idCompra, p_NombreProducto, p_cantidad, p_precioProducto, p_subTotalProducto);
    
    -- Insertar el producto en la tabla de productos, si no existe, o actualizar su cantidad si ya existe
    INSERT INTO productos (NombreProducto, Cantidad, Precio)
    VALUES (p_NombreProducto, p_cantidad, p_precioProducto)
    ON DUPLICATE KEY UPDATE
    Cantidad = Cantidad + VALUES(Cantidad),
    Precio = VALUES(Precio);

    -- Recalcular el total de la compra basado en los detalles de la compra
    UPDATE compras c
    JOIN (
        SELECT idCompra, SUM(SubTotal) as TotalCompra
        FROM detalleCompras
        WHERE idCompra = p_idCompra
        GROUP BY idCompra
    ) dc ON c.idCompra = dc.idCompra
    SET c.TotalCompra = dc.TotalCompra
    WHERE c.idCompra = p_idCompra;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimientos almacenados de la tabla DetalleCompras para su CRUD -- 
-- Procedimiento para Leer (obtener) todos los DetallesCompras con idCompra
DELIMITER //

CREATE PROCEDURE obtenerDetalleCompraFiltro(
    IN p_idCompra INT
)
BEGIN
    SET @sql = 'SELECT * FROM detallecompras WHERE 1=1';
    
    IF p_idCompra IS NOT NULL AND p_idCompra != '' THEN
        SET @sql = CONCAT(@sql, ' AND idCompra = ', p_idCompra);
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

-- --------------------------------------------------------
-- Procedimiento para que, si el producto ya existe este verifique que exista, y en caso
-- que el producto ya exista, en vez de agregarlo, se actualice la cantidad y el subtotal
-- para evitar duplicados en la tabla detalleCompras.

DELIMITER //

CREATE PROCEDURE gestionarProductoCompra(
    IN p_idCompra INT,
    IN p_nombreProducto VARCHAR(255),
    IN p_cantidad INT,
    IN p_cantidadAcumulada INT,
    IN p_precio DECIMAL(10,2)
)
BEGIN
    DECLARE v_cantidadActual INT;
    DECLARE v_productoExiste INT;

    -- Actualizar la cantidad en productos
    UPDATE productos
    SET Cantidad = p_cantidadAcumulada
    WHERE NombreProducto = p_nombreProducto;

    -- Verificar si el producto ya existe en detalleCompras para esta compra
    SELECT COUNT(*), Cantidad INTO v_productoExiste, v_cantidadActual
    FROM detalleCompras
    WHERE IdCompra = p_idCompra AND NombreProducto = p_nombreProducto
    GROUP BY Cantidad;

    IF v_productoExiste > 0 THEN
        -- Actualizar la cantidad y subtotal en detalleCompras
        UPDATE detalleCompras
        SET Cantidad = v_cantidadActual + p_cantidad,
            Subtotal = (v_cantidadActual + p_cantidad) * p_precio
        WHERE IdCompra = p_idCompra AND NombreProducto = p_nombreProducto;
    ELSE
        -- Insertar el producto en detalleCompras si no existe
        INSERT INTO detalleCompras (IdCompra, NombreProducto, Cantidad, Precio, Subtotal)
        VALUES (p_idCompra, p_nombreProducto, p_cantidad, p_precio, p_cantidad * p_precio);
    END IF;

    -- Recalcular el total en compras
    UPDATE compras
    SET TotalCompra = (SELECT SUM(Subtotal) FROM detalleCompras WHERE IdCompra = p_idCompra)
    WHERE IdCompra = p_idCompra;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimiento para eliminar un item en detalleCompras, si la cantidad de el item es menor a la q
-- total del producto en la tabla productos simplemente se reducira dicha cantidad, en caso contrario
-- su cantidad se reducira a 0 sin eliminar el producto de la tabla productos pero si eliminando el
-- producto en detalleCompras.

DELIMITER //

CREATE PROCEDURE eliminarItemDetalleCompra(
    IN p_idCompra INT,
    IN p_nombreProducto VARCHAR(255),
    IN p_cantidadEliminar INT
)
BEGIN
    DECLARE v_cantidadProducto INT;
    DECLARE v_cantidadEnDetalle INT;

    -- Obtener la cantidad actual del producto en la tabla productos
    SELECT Cantidad INTO v_cantidadProducto
    FROM productos
    WHERE NombreProducto = p_nombreProducto;

    -- Obtener la cantidad actual del producto en detalleCompras para la compra específica
    SELECT Cantidad INTO v_cantidadEnDetalle
    FROM detalleCompras
    WHERE IdCompra = p_idCompra AND NombreProducto = p_nombreProducto;

    -- Verificar si la cantidad a eliminar es mayor o igual a la cantidad en detalleCompras
    IF p_cantidadEliminar >= v_cantidadProducto THEN
        -- Eliminar el producto de detalleCompras
        DELETE FROM detalleCompras
        WHERE IdCompra = p_idCompra AND NombreProducto = p_nombreProducto;

        -- Actualizar la cantidad en la tabla productos a 0
        UPDATE productos
        SET Cantidad = 0
        WHERE NombreProducto = p_nombreProducto;
    ELSE -- Cuando la cantidad en productos es mayor a la cantidad a eliminar
        -- Eliminar el producto de detalleCompras
        DELETE FROM detalleCompras
        WHERE IdCompra = p_idCompra AND NombreProducto = p_nombreProducto;

        -- Reducir la cantidad en la tabla productos
        UPDATE productos
        SET Cantidad = v_cantidadProducto - p_cantidadEliminar
        WHERE NombreProducto = p_nombreProducto;
    END IF;

    -- Recalcular el total en compras
    UPDATE compras
    SET TotalCompra = (SELECT SUM(Subtotal) FROM detalleCompras WHERE IdCompra = p_idCompra)
    WHERE IdCompra = p_idCompra;
END //

DELIMITER ;

-- --------------------------------------------------------

-- Procedimiento para eliminar una compra y a raiz de dicha compra, eliminar todos los detallesCompas
-- que esten relacionados con la compra a eliminar, asi como tambien reducir la cantidad de los productos

DELIMITER //

CREATE PROCEDURE eliminarCompra(IN compra_id INT)
BEGIN
    DECLARE productoNombre VARCHAR(255);
    DECLARE productoCantidad INT;
    DECLARE done INT DEFAULT FALSE;

    -- Declarar el cursor
    DECLARE cur_detcompras CURSOR FOR
        SELECT NombreProducto, Cantidad
        FROM detalleCompras
        WHERE idCompra = compra_id;

    -- Declarar el handler para el fin de los datos del cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN cur_detcompras;

    -- Iterar sobre los detalles de compra
    detalle_compras_loop: LOOP
        FETCH cur_detcompras INTO productoNombre, productoCantidad;
        IF done THEN
            LEAVE detalle_compras_loop;
        END IF;

        -- Restar la cantidad de productos en la tabla productos
        UPDATE productos
        SET Cantidad = Cantidad - productoCantidad
        WHERE NombreProducto = productoNombre;
    END LOOP detalle_compras_loop;

    -- Cerrar el cursor
    CLOSE cur_detcompras;

    -- Eliminar los detalles de compra
    DELETE FROM detalleCompras WHERE idCompra = compra_id;

    -- Eliminar la compra
    DELETE FROM compras WHERE idCompra = compra_id;

END //

DELIMITER ;

