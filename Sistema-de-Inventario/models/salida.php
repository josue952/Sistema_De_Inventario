<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Salidas
{
    private $idSalida;
    private $FechaSalida;
    private $idProducto;
    private $Motivo;
    private $Cantidad;
    private $idCliente;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getIdSalida()
    {
        return $this->idSalida;
    }

    public function setIdEntrada($idSalida)
    {
        $this->idSalida = $idSalida;
    }

    public function getFechaSalida()
    {
        return $this->FechaSalida;
    }

    public function setFechaSalida($fechaSalida)
    {
        $this->FechaSalida = $fechaSalida;
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

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    // Métodos CRUD para las entradas

    public function obtenerSalidas()
    {
        $sql = "CALL obtenerSalidas();";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function obtenerSalidasFiltro($idSalida, $idProducto) {
        // Preparar la llamada al procedimiento almacenado con los parámetros
        // Se utilizan comillas simples para encerrar las variables que se pasan como parámetros
        $sql = "CALL obtenerSalidasFiltro('$idSalida', '$idProducto');";
    
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
    
        // Verificar si hubo un error en la ejecución de la consulta
        if($this->connection->error){
            die('ERROR SQL: ' . $this->connection->error);
        }
    
        // Retornar los datos obtenidos de la consulta
        return $datosObtenidos;
    }

        public function crearSalida($FechaSalida, $idProducto, $motivo, $cantidad, $idCliente)
    {
        $sql = "CALL crearSalida('$FechaSalida', '$idProducto', '$motivo', '$cantidad', '$idCliente');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function actualizarSalida($idSalida, $fechaSalida, $idProducto, $motivo, $cantidad, $idCliente)
    {
        $sql = "CALL actualizarSalida('$idSalida', '$fechaSalida', '$idProducto', '$motivo', '$cantidad', '$idCliente');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function eliminarSalida($idSalida)
    {
        $sql = "CALL eliminarSalida('$idSalida');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    //metodo para obtener todas las sucursales (por nombre) de la tabla sucursales
    public function obtenerTodosLosProductos() {
        $sql = "SELECT idProducto, NombreProducto FROM productos";
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

    //metodo para obtener todas las sucursales (por nombre) de la tabla sucursales
    public function obtenerClientes() {
        $sql = "SELECT idCliente, NombreCliente FROM clientes";
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
}
?>
