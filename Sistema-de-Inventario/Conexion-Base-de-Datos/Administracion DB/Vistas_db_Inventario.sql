-- En este apartado crearemos las vistas que se utilizarán en el sistema para mostrar la información de la base de datos
-- de una manera más limpia y ordenada

-- --------------------------------------------------------

-- Vista Entrada de productos, donde se visualiza la información de las entradas de productos
-- los datos son recolectados de las tablas Compras, detalleCompras y entradas.

CREATE VIEW EntradasDeProductos AS
SELECT 
    DATE_FORMAT(c.FechaCompra, '%d-%m-%Y') AS Fecha,
    dc.NombreProducto AS Producto,
    dc.Cantidad AS Cantidad,
    dc.Precio AS PrecioUnitario,
    dc.SubTotal AS SubTotal,
    p.NombreProveedor AS Proveedor,
    'Compra' AS Tipo
FROM 
    compras c
JOIN 
    detalleCompras dc ON c.idCompra = dc.idCompra
JOIN 
    proveedores p ON c.idProveedor = p.idProveedor
UNION
SELECT
    DATE_FORMAT(e.FechaEntrada, '%d-%m-%Y') AS Fecha,
    pr.NombreProducto AS Producto,
    e.Cantidad AS Cantidad,
    pr.Precio AS PrecioUnitario,
    (e.Cantidad * pr.Precio) AS SubTotal,
    COALESCE(p.NombreProveedor, 'N/A') AS Proveedor,
    'Entrada' AS Tipo
FROM
    entradas e
JOIN 
    productos pr ON e.idProducto = pr.idProducto
LEFT JOIN 
    proveedores p ON e.idProveedor = p.idProveedor;


-- --------------------------------------------------------

-- Vista Salida de productos, donde se visualiza la información de las salidas de productos
-- los datos son recolectados de las tablas Ventas, detalleVentas y salidas.

CREATE VIEW SalidasDeProductos AS
SELECT 
    DATE_FORMAT(v.FechaVenta, '%d-%m-%Y') AS Fecha,
    dv.NombreProducto AS Producto,
    dv.Cantidad AS Cantidad,
    dv.Precio AS PrecioUnitario,
    dv.SubTotal AS SubTotal,
    c.NombreCliente AS Cliente,
    'Venta' AS Tipo
FROM 
    ventas v
JOIN 
    detalleVentas dv ON v.idVenta = dv.idVenta
JOIN 
    clientes c ON v.idCliente = c.idCliente
UNION
SELECT
    DATE_FORMAT(s.FechaSalida, '%d-%m-%Y') AS Fecha,
    pr.NombreProducto AS Producto,
    s.Cantidad AS Cantidad,
    pr.Precio AS PrecioUnitario,
    (s.Cantidad * pr.Precio) AS SubTotal,
    COALESCE(c.NombreCliente, 'N/A') AS Cliente,
    'Salida' AS Tipo
FROM
    salidas s
JOIN 
    productos pr ON s.idProducto = pr.idProducto
LEFT JOIN 
    clientes c ON s.idCliente = c.idCliente;


-- --------------------------------------------------------
