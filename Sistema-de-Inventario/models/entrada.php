<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Entradas
{
    private $idEntrada;
    private $FechaEntrada;
    private $idProducto;
    private $Motivo;
    private $Cantidad;
    private $idProveedor;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getIdEntrada()
    {
        return $this->idEntrada;
    }

    public function setIdEntrada($idEntrada)
    {
        $this->idEntrada = $idEntrada;
    }

    public function getFechaEntrada()
    {
        return $this->FechaEntrada;
    }

    public function setFechaEntrada($fechaEntrada)
    {
        $this->FechaEntrada = $fechaEntrada;
    }

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function getMotivo()
    {
        return $this->Motivo;
    }

    public function setMotivo($motivo)
    {
        $this->Motivo = $motivo;
    }

    public function getCantidad()
    {
        return $this->Cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->Cantidad = $cantidad;
    }

    public function getIdProveedor()
    {
        return $this->idProveedor;
    }

    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;
    }

    // Métodos CRUD para las entradas

    public function obtenerEntradas()
    {
        $sql = "CALL obtenerEntradas();";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function obtenerEntradasFiltro($idEntrada, $idProducto) {
        // Preparar la llamada al procedimiento almacenado con los parámetros
        // Se utilizan comillas simples para encerrar las variables que se pasan como parámetros
        $sql = "CALL obtenerEntradasFiltro('$idEntrada', '$idProducto');";
    
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
    
        // Verificar si hubo un error en la ejecución de la consulta
        if($this->connection->error){
            die('ERROR SQL: ' . $this->connection->error);
        }
    
        // Retornar los datos obtenidos de la consulta
        return $datosObtenidos;
    }

        public function crearEntrada($FechaEntrada, $idProducto, $motivo, $cantidad, $idProveedor)
    {
        $sql = "CALL crearEntrada('$FechaEntrada', '$idProducto', '$motivo', '$cantidad', '$idProveedor');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function actualizarEntrada($idEntrada, $fechaEntrada, $idProducto, $motivo, $cantidad, $idProveedor)
    {
        $sql = "CALL actualizarEntrada('$idEntrada', '$fechaEntrada', '$idProducto', '$motivo', '$cantidad', '$idProveedor');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function eliminarEntrada($idEntrada)
    {
        $sql = "CALL eliminarEntrada('$idEntrada');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }
}
?>
