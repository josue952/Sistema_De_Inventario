-- Por el momento solamente se utiliza consultas en vez de procedimientos almacenados
-- Se crean datos predeterminados para la tabla de usuarios -C
INSERT INTO usuarios (Nombre, Apellido, Email, DUI, Contraseña, Rol) VALUES ('Josue','Zelaya', 'josuen@gmail.com', 123456789, 'josue1234', 'Administrador');

-- Se crean datos predeterminados para la tabla de categorias  -C
INSERT INTO categorias (Categoria, Descripcion, MetodoInventario) VALUES ('Electronica', 'Productos electronicos o similares', 'Promedio');

-- Se crean datos predeterminados para la tabla de sucursales -C
INSERT INTO sucursales (NombreSucursal, Ubicacion, Departamento, Municipio) VALUES ('Sucursal 1', 'Colonia Escalon', 'San Salvador', 'San Salvador');

-- Se crean datos predeterminados para la tabla de proveedores -C
INSERT INTO proveedores (NombreProveedor, CorreoProveedor, TelefonoProveedor, MetodoDePagoAceptado) VALUES ('Zona Digital', 'ZonaDigital@gmail.com', 22222222, 'Efectivo');

-- Se crean datos predeterminados para la tabla de compras -C
INSERT INTO compras (FechaCompra, idProveedor, idSucursal, TotalCompra) VALUES ('18/05/2024', 1, 1, 100.00);

-- Se crean datos predeterminados para la tabla de detalleCompras -P
INSERT INTO detalleCompras (idCompra, NombreProducto, Cantidad, Precio, SubTotal) VALUES (1, 'Memoria RAM', 4, 25.00, 100.00);

-- Se crean datos predeterminados para la tabla de productos -P
INSERT INTO productos (NombreProducto, Cantidad, Precio, Foto, idCategoria, idSucursal) VALUES ('Memoria RAM', 4, 25.00, 'Foto', 1, 1);

-- Se crean datos predeterminados para la tabla de clientes -C
INSERT INTO clientes (NombreCliente, Correo, Direccion, MetodoDePago, MetodoEnvio) VALUES ('Juan Perez', 'juanperez@gmail.com', 'Colonia Escalon, San Salvador', 'Efectivo', 'Domicilio');

-- Se crean datos predeterminados para la tabla de ventas -P
INSERT INTO ventas (FechaVenta, idCliente, TotalVenta) VALUES ('18/05/2024', 1, 50.00);

-- Se crean datos predeterminados para la tabla de detalleVentas -P
INSERT INTO detalleVentas (idVenta, idProducto, NombreProducto, Cantidad, Precio, idSucursal, SubTotal) VALUES (1, 1, 'Memoria RAM', 2, 25.00, 1, 50.00);

-- Se crean datos predeterminados para la tabla de entradas -P
INSERT INTO entradas (FechaEntrada, idProducto, Motivo, Cantidad, idProveedor) VALUES ('18/05/2024', 1, 'Por Deposito de la sucursal X', 1, null);

-- Se crean datos predeterminados para la tabla de salidas -P
INSERT INTO salidas (FechaSalida, idProducto, Motivo, Cantidad, idCliente) VALUES ('18/05/2024', 1, 'Por Extravio de mercancia', 1, null);

-- Se crean datos predeterminados para la tabla de empresa -C
INSERT INTO empresa (NombreEmpresa, LogoEmpresa, SloganEmpresa, MisionEmpresa, VisionEmpresa, AboutUsEmpresa) VALUES ('Zona Digital', 'Logo', 'Slogan', 'Mision', 'Vision', 'About Us');


