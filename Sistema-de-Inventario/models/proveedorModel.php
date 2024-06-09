<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Proveedor
{
    private $idProveedor;
    private $NombreProveedor;
    private $CorreoProveedor;
    private $TelefonoProveedor;
    private $MetodoDePagoAceptado;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getNombreProveedor()
    {
        return $this->NombreProveedor;
    }

    public function setNombreProveedor($nombre)
    {
        $this->NombreProveedor = $nombre;
    }

    /**
     * Get the value of idProveedor
     */
    public function getIdProveedor()
    {
        return $this->idProveedor;
    }

    /**
     * Set the value of idProveedor
     *
     * @return  self
     */
    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;

        return $this;
    }

    public function getCorreoProveedor()
    {
        return $this->CorreoProveedor;
    }

    public function setCorreoProveedor($correo)
    {
        $this->CorreoProveedor = $correo;
    }

    public function getTelefonoProveedor()
    {
        return $this->TelefonoProveedor;
    }

    public function setTelefonoProveedor($telefono)
    {
        $this->TelefonoProveedor = $telefono;
    }

    public function getMetodoDePagoAceptado()
    {
        return $this->MetodoDePagoAceptado;
    }

    public function setMetodoDePagoAceptado($metodo)
    {
        $this->MetodoDePagoAceptado = $metodo;
    }

    // Métodos CRUD para los proveedores

    public function obtenerProveedores()
    {
        $sql = "CALL obtenerProveedores();";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function obtenerProveedoresFiltro($idProveedor, $nombreProveedor)
    {
        $sql = "CALL obtenerProveedoresFiltro('$idProveedor', '$nombreProveedor');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function agregarProveedor($nombreProveedor, $correoProveedor, $telefonoProveedor, $metodoDePagoAceptado)
    {
        $sql = "CALL crearProveedor('$nombreProveedor', '$correoProveedor', '$telefonoProveedor', '$metodoDePagoAceptado');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function actualizarProveedor($idProveedor, $nombreProveedor, $correoProveedor, $telefonoProveedor, $metodoDePagoAceptado)
    {
        $sql = "CALL actualizarProveedor('$idProveedor', '$nombreProveedor', '$correoProveedor', '$telefonoProveedor', '$metodoDePagoAceptado');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function eliminarProveedor($idProveedor)
    {
        $sql = "CALL eliminarProveedor('$idProveedor');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }
}
