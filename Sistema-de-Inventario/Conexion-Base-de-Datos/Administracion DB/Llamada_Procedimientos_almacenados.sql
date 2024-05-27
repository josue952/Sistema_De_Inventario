-- Este apartado Sirve para crear ejemplos de como se pueden ejecutar los
-- procedimientos almacenados creados anteriormente

-- Procedimientos para la tabla usuarios

-- Llamar al procedimiento crearUsuario
CALL crearUsuario('Juan', 'Perez', 'juan.perez@example.com', 223456789, 'password123', 'Empleado');

-- Llamar al procedimiento obtenerUsuarios (todos los usuarios)
CALL obtenerUsuarios();

-- Llamar al procedimiento obtenerUsuarios (con filtros)
-- Llamar al procedimiento con filtro por ID
CALL obtenerUsuariosFiltro(1, NULL, NULL);

-- Llamar al procedimiento con filtro por Nombre
CALL obtenerUsuariosFiltro(NULL, 'Juan', NULL);

-- Llamar al procedimiento con filtro por Rol
CALL obtenerUsuariosFiltro(NULL, NULL, 'Empleado');

-- Llamar al procedimiento con combinación de filtros
CALL obtenerUsuariosFiltro(1, 'Juan', 'Empleado');

-- Llamar al procedimiento actualizarUsuario
CALL actualizarUsuario(1, 'Juan', 'Perez', 'juan.perez@example.com', 223456789, 'newpassword123', 'Administrador');

-- Llamar al procedimiento eliminarUsuario (por id)
CALL eliminarUsuario(1);

-- -----------------------------------------------------------------