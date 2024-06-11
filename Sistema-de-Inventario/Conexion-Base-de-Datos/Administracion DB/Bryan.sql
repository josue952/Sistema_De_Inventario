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