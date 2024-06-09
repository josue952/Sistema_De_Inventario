<?php
require '../../Conexion-Base-de-Datos/dbConnection.php';

Class Compra 
{
    private $idCompra;
    private $Fecha;
    private $idProveedor;
    private $idSucursal;
    private $total;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getIdCompra()
    {
        return $this->idCompra;
    }

    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function getIdProveedor()
    {
        return $this->idProveedor;
    }

    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;
    }

    public function getIdSucursal()
    {
        return $this->idSucursal;
    }

    public function setIdSucursal($idSucursal)
    {
        $this->idSucursal = $idSucursal;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    // metodos crud
    //metodo para obtener todos los datos de todas las compras
    public function obtenerCompras(){
        $sql="CALL obtenerCompras();";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //metodo para obtener todos los datos de todas las compras
    public function crearCompra($fechaCompra, $idProveedor, $idSucursal){
        $sql="CALL crearCompra('$fechaCompra','$idProveedor','$idSucursal');";
        $datosObtenidos=$this->connection->query($sql);

        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

     //metodo para obtener todos los datos de una compra segun su id, fecha, proveedor y sucursal
    public function obtenerCompraFiltro($idCompra, $fechaCompra, $idProveedor, $idSucursal){
        $sql="CALL obtenerCompraFiltro('$idCompra', '$fechaCompra','$idProveedor','$idSucursal');";
        $datosObtenidos=$this->connection->query($sql);

        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //metodo para obtener todos los datos de un detalleCompra segun su idCompra
    public function obtenerDetalleCompraFiltro($idCompra){
        $sql="CALL obtenerDetalleCompraFiltro('$idCompra');";
        $datosObtenidos=$this->connection->query($sql);

        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //metodo para ingresar un producto a la tabla detalleCompra
    public function agregarProductoACompra($idCompra, $NombreProducto, $Cantidad, $Precio, $Subtotal){
        $sql="CALL agregarProductoACompra('$idCompra','$NombreProducto','$Cantidad','$Precio', '$Subtotal');";
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
        $sql = "SELECT NombreProducto FROM productos";
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

    // Método para actualizar la cantidad de un producto en la tabla productos
    // su funcion dependera de si el producto ya existe en detalleCompras
    public function gestionarProductoCompra($idCompra, $nombreProducto, $cantidad, $cantidadAcumulada, $precio) {
        $sql = "CALL gestionarProductoCompra(?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('isidd', $idCompra, $nombreProducto, $cantidad, $cantidadAcumulada, $precio);
        $result = $stmt->execute();
        $stmt->close();
        $this->connection->next_result();
        return $result;
    }

    // Metodo para eliminar un item de la tabla detalleCompra
    public function eliminarItemDetalleCompra($idCompra, $nombreProducto, $cantidad) {
        $sql = "CALL eliminarItemDetalleCompra('$idCompra', '$nombreProducto', '$cantidad')";
        $result = $this->connection->query($sql);
    
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
    
        $this->connection->next_result();
        return $result;
    }

    // Metodo para eliminar una compra y reducir dicha cantidad de productos en la tabla productos
    public function eliminarCompra($idCompra) {
        // Asegúrate de liberar cualquier resultado previo
        while($this->connection->more_results()) {
            $this->connection->next_result();
        }

        $sql = "CALL eliminarCompra('$idCompra')";
        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }

        // Liberar resultados después de la ejecución
        $this->connection->next_result();

        return $result;
    }

    // Metodo para actualizar una compra (el total no se actualiza)
    public function actualizarCompra($idCompra, $fechaCompra, $idProveedor, $idSucursal) {
        $conn = conectar();
        $sql = "CALL actualizarCompra(?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $idCompra, $fechaCompra, $idProveedor, $idSucursal);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }
}