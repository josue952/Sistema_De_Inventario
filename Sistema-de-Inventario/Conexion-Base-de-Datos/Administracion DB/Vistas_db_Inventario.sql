-- En este apartado crearemos las vistas que se utilizarán en el sistema para mostrar la información de la base de datos
-- de una manera más limpia y ordenada

-- --------------------------------------------------------
--
-- Estructura de vista `vista_entradas_inventario`

-- Esta vista nos permitirá ver todas las entradas de inventario con detalles como la fecha de entrada, el nombre del producto, la cantidad y el proveedor.
CREATE VIEW `vista_entradas_inventario` AS
SELECT 
    e.idEntrada,
    e.FechaEntrada,
    p.NombreProducto,
    e.Cantidad,
    COALESCE(pv.NombreProveedor, 'Proveedor no especificado') AS NombreProveedor
FROM 
    entradas e
JOIN 
    productos p ON e.idProducto = p.idProducto
LEFT JOIN 
    proveedores pv ON e.idProveedor = pv.idProveedor;

-- --------------------------------------------------------
--
-- Estructura de vista `vista_salidas_inventario`

-- Esta vista nos mostrará todas las salidas de inventario con información como la fecha de salida, el nombre del producto, la cantidad y el cliente.
CREATE VIEW `vista_salidas_inventario` AS
SELECT 
    s.idSalida,
    s.FechaSalida,
    p.NombreProducto,
    s.Cantidad,
    COALESCE(c.NombreCliente, 'Cliente no especificado') AS NombreCliente
FROM 
    salidas s
JOIN 
    productos p ON s.idProducto = p.idProducto
LEFT JOIN 
    clientes c ON s.idCliente = c.idCliente;

-- --------------------------------------------------------
--
-- Estructura de vista `vista_movimientos_inventario`

-- Estructura de vista `vista_movimientos_inventario`

-- Esta vista te dará una visión general de todos los movimientos de inventario, ya sea entrada o salida, con detalles 
-- como la fecha del movimiento, el nombre del producto, la cantidad, el proveedor (para entradas) o el cliente (para salidas), y el motivo del movimiento.
CREATE VIEW `vista_movimientos_inventario` AS
SELECT 
    e.idEntrada AS idMovimiento,
    e.FechaEntrada AS FechaMovimiento,
    p.NombreProducto,
    e.Cantidad AS Entrada,
    0 AS Salida,
    COALESCE(pv.NombreProveedor, 'Proveedor no especificado') AS Proveedor,
    NULL AS Cliente,
    e.Motivo AS Motivo
FROM 
    entradas e
JOIN 
    productos p ON e.idProducto = p.idProducto
LEFT JOIN 
    proveedores pv ON e.idProveedor = pv.idProveedor
UNION
SELECT 
    s.idSalida AS idMovimiento,
    s.FechaSalida AS FechaMovimiento,
    p.NombreProducto,
    0 AS Entrada,
    s.Cantidad AS Salida,
    NULL AS Proveedor,
    COALESCE(c.NombreCliente, 'Cliente no especificado') AS Cliente,
    s.Motivo AS Motivo
FROM 
    salidas s
JOIN 
    productos p ON s.idProducto = p.idProducto
LEFT JOIN 
    clientes c ON s.idCliente = c.idCliente;
