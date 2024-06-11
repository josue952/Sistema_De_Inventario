<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Categoria
{
    private $idCategoria;
    private $NombreCategoria;
    private $Descripcion;
    private $Metodo;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getNombreCategoria()
    {
        return $this->NombreCategoria;
    }

    public function setNombreCategoria($nombre)
    {
        $this->NombreCategoria = $nombre;
    }

    /**
     * Get the value of idCategoria
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Set the value of idCategoria
     *
     * @return  self
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getMetodo()
    {
        return $this->Metodo;
    }

    public function setMetodo($Metodo)
    {
        $this->Metodo = $Metodo;
    }


    // Métodos CRUD para los Categoria

    public function obtenerCategorias()
    {
        $sql = "CALL obtenerCategorias();";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function obtenerCategoriaFiltro($idCategoria, $NombreCategoria)
    {
        $sql = "CALL obtenerCategoriaFiltro('$idCategoria', '', '');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function crearCategoria($NombreCategoria, $Descripcion, $Metodo)
    {
        $sql = "CALL crearCategoria('$NombreCategoria', '$Descripcion', '$Metodo');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }   

    public function actualizarCategoria($idCategoria, $NombreCategoria, $Descripcion, $Metodo)
    {
        $sql = "CALL actualizarCategoria('$idCategoria', '$NombreCategoria', '$Descripcion', '$Metodo');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }

    public function eliminarCategoria($idCategoria)
    {
        $sql = "CALL eliminarCategoria('$idCategoria');";
        $datosObtenidos = $this->connection->query($sql);
        if ($this->connection->error) {
            die('ERROR SQL: ' . $this->connection->error);
        }
        return $datosObtenidos;
    }
}
