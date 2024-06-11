<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class productoModel
{
    private $idProducto;
    private $NombreProducto;
    private $Cantidad;
    private $Precio;
    private $Foto;
    private $idCategoria;
    private $idSucursal;
    private $connection;

    // constructor para iniciar la conexion
    public function __construct()
    {
        $this->connection = conectar();
    }

    // Set
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setNombreproducto($Nombreproducto)
    {
        $this->Nombreproducto = $Nombreproducto;
    }

    public function setCantidad($Cantidad)
    {
        $this->Cantidad = $Cantidad;
    }

    public function setPrecio($Precio)
    {
        $this->Precio = $Precio;
    }

    public function setFoto($Foto)
    {
        $this->Foto = $Foto;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    public function setIdSucursal($idSucursal)
    {
        $this->idSucursal = $idSucursal;
    }

    //get
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getNombreproducto()
    {
        return $this->NombreProducto;
    }

    public function getCantidad()
    {
        return $this->Cantidad;
    }

    public function getPrecio()
    {
        return $this->Precio;
    }

    public function getFoto()
    {
        return $this->Foto;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function getIdSucursal()
    {
        return $this->idSucursal;
    }


    // Método para obtener todos los productos
    public function obtenerProductos(){
        $sql = "CALL obtenerProductos();";
        $datosObtenidos = $this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        // Limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    // Método para obtener productos con filtros específicos
    public function obtenerProductosFiltro($idProducto, $Nombreproducto){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL obtenerProductosFiltro('$idProducto', '$Nombreproducto');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        // Limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    // Método para insertar un producto
    public function crearProducto($Nombreproducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL crearProducto('$Nombreproducto', '$Cantidad', '$Precio', '$Foto', '$idCategoria', '$idSucursal');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        // Limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    // Método para actualizar un producto
    public function actualizarProducto($NombreProducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL actualizarProducto('$NombreProducto', '$Cantidad', '$Precio', '$Foto', '$idCategoria', '$idSucursal');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        // Limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    // Método para eliminar un producto
    public function eliminarProducto($idProducto){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL eliminarProducto('$idProducto');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        // Limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }


}
