<?php
require '../../Conexion-Base-de-Datos/dbConnection.php';

class Ventas 
{
    private $idVenta;
    private $Fecha;
    private $idCliente;
    private $Total;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getIdVenta()
    {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta)
    {
        $this->idVenta = $idVenta;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getTotal()
    {
        return $this->Total;
    }

    public function setTotal($Total)
    {
        $this->Total = $Total;
    }

    //metodos crud
    //Metodo para obtener todas las ventas
    public function obtenerVentas(){
        $sql="CALL obtenerVentas();";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //Metodo para crear una venta
    public function crearVenta($fechaVenta, $idCliente){
        $sql="CALL crearVenta('$fechaVenta','$idCliente');";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //Metodo para obtener una venta por idVenta, fecha de venta e id de cliente
    public function obtenerVentaFiltro($idVenta, $fechaVenta, $idCliente){
        $sql="CALL obtenerVentaFiltro('$idVenta','$fechaVenta','$idCliente');";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //Metodo para obtener los detalle venta de una venta
    public function obtenerDetalleVentaFiltro($idVenta){
        $sql="CALL obtenerDetalleVentaFiltro('$idVenta');";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    // Método para buscar productos según el término de búsqueda
    public function buscarProductos($term) {
        $term = "%{$term}%";
        $sql = "SELECT NombreProducto FROM productos WHERE NombreProducto LIKE ? LIMIT 10";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $term);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row['NombreProducto'];
        }

        $stmt->close();
        $this->connection->next_result();
        return $productos;
    }

    //metodo para obtener todos los productos (por nombre) de la tabla productos
    public function obtenerTodosLosProductos() {
        $sql = "SELECT NombreProducto, Precio FROM productos";
        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row['NombreProducto'];
        }
        $this->connection->next_result();
        return $productos;
    }

    // Método para saber si un producto ya existe en la tabla productos
    public function productoExiste($nombreProducto) {
        $sql = "SELECT COUNT(*) AS existe FROM productos WHERE NombreProducto = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $nombreProducto);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $this->connection->next_result();
        return $result->fetch_assoc()['existe'] > 0;
    }

    // Método para obtener los detalles de un producto por su nombre
    public function obtenerProductoPorNombre($nombreProducto) {
        $sql = "SELECT * FROM productos WHERE NombreProducto = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $nombreProducto);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        $this->connection->next_result();
        return $producto;
    }

    //metodo para obtener todas las sucursales (por nombre) de la tabla sucursales
    public function obtenerSucursales() {
        $sql = "SELECT idSucursal, NombreSucursal FROM sucursales";
        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }

        $sucursales = [];
        while ($row = $result->fetch_assoc()) {
            $sucursales[] = $row;
        }
        $this->connection->next_result();
        return $sucursales;
    }

    // Método para actualizar la cantidad de un producto en la tabla productos
    // su funcion dependera de si el producto ya existe en detalleCompras
    public function gestionarProductoVenta($idVenta, $idProducto, $nombreProducto, $cantidad, $precio, $idSucursal) {
        $sql = "CALL gestionarProductoVenta(?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('iisiii', $idVenta, $idProducto, $nombreProducto, $cantidad, $precio, $idSucursal);
        $result = $stmt->execute();
        $stmt->close();
        $this->connection->next_result();
        return $result;
    }

    // Metodo para eliminar un item de la tabla detalleVenta
    public function eliminarItemDetalleVenta($idVenta, $nombreProducto, $cantidad) {
        $sql = "CALL eliminarItemDetalleVenta('$idVenta', '$nombreProducto', '$cantidad')";
        $result = $this->connection->query($sql);
    
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
    
        $this->connection->next_result();
        return $result;
    }

    // Metodo para eliminar una venta y aumentar dicha cantidad de productos en la tabla productos
    public function eliminarVenta($idVenta) {
        // Asegúrate de liberar cualquier resultado previo
        while($this->connection->more_results()) {
            $this->connection->next_result();
        }

        $sql = "CALL eliminarVenta('$idVenta')";
        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }

        // Liberar resultados después de la ejecución
        $this->connection->next_result();

        return $result;
    }

    // Metodo para actualizar una venta
    public function actualizarVenta($idVenta, $fechaVenta, $idCliente) {
        $sql = "CALL actualizarVenta('$idVenta', '$fechaVenta', '$idCliente')";
        $result = $this->connection->query($sql);
    
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
    
        $this->connection->next_result();
        return $result;
    }

}
?>