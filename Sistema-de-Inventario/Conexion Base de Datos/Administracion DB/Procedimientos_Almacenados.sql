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
    IF p_idUsuario IS NOT NULL THEN
        SET @sql = CONCAT(@sql, ' AND idUsuario = ', p_idUsuario);
    END IF;

    IF p_Nombre IS NOT NULL AND p_Nombre != '' THEN
        SET @sql = CONCAT(@sql, ' AND Nombre LIKE ''%', p_Nombre, '%''');
    END IF;

    IF p_Rol IS NOT NULL AND p_Rol != '' THEN
        SET @sql = CONCAT(@sql, ' AND Rol LIKE ''%', p_Rol, '%''');
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

