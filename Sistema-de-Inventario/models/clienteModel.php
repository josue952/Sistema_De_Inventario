<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Cliente
{
    private $idCliente;
    private $NombreCliente;
    private $Correo;
    private $Direccion;
    private $MetodoDePago;
    private $MetodoEnvio;
    private $connection;

    public function __construct()
    {
        $this->connection = conectar();
    }

    // Métodos getter y setter

    public function getNombreCliente()
    {
        return $this->NombreCliente;
    }

    public function setNombreCliente($nombre)
    {
        $this->NombreCliente = $nombre;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getCorreo()
    {
        return $this->Correo;
    }

    public function setCorreo($correo)
    {
        $this->Correo = $correo;
    }

    public function getDireccion()
    {
        return $this->Direccion;
    }

    public function setDireccion($direccion)
    {
        $this->Direccion = $direccion;
    }

    public function getMetodoDePago()
    {
        return $this->MetodoDePago;
    }

    public function setMetodoDePago($metodoDePago)
    {
        $this->MetodoDePago = $metodoDePago;
    }

    public function getMetodoEnvio()
    {
        return $this->MetodoEnvio;
    }

    public function setMetodoEnvio($metodoEnvio)
    {
        $this->MetodoEnvio = $metodoEnvio;
    }

    // Métodos CRUD para los clientes

    public function obtenerClientes()
    {
        $sql = "CALL obtenerClientes();";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function obtenerClientesFiltro($idCliente, $nombreCliente)
    {
        $sql = "CALL obtenerClientesFiltro('$idCliente', '$nombreCliente');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function crearCliente($nombreCliente, $correo, $direccion, $metodoDePago, $metodoEnvio)
    {
        $sql = "CALL crearCliente('$nombreCliente', '$correo', '$direccion', '$metodoDePago', '$metodoEnvio');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function actualizarCliente($idCliente, $nombreCliente, $correo, $direccion, $metodoDePago, $metodoEnvio)
    {
        $sql = "CALL actualizarCliente('$idCliente', '$nombreCliente', '$correo', '$direccion', '$metodoDePago', '$metodoEnvio');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function eliminarCliente($idCliente)
    {
        $sql = "CALL eliminarCliente('$idCliente');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }
}
?>
