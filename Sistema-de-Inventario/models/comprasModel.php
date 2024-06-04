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
}