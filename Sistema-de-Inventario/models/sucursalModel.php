<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class Sucursal
{
    private $idSucursal;
    private $NombreSucursal;
    private $Ubicacion;
    private $Departamento;
    private $Municipio;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    // esta funcion sirve para obtener datos de la propiedad 
    public function getNombre()
    {
        return $this->NombreSucursal;

    }
    // esta funcion sirve para mandar datos a la propiedad
    public function setNombre($nom)
    {
        $this->NombreSucursal = $nom;
    }



    /**
     * Get the value of idSucursal
     */
    public function getIdSucursal()
    {
        return $this->idSucursal;
    }

    /**
     * Set the value of idSucursal
     *
     * @return  self
     */
    public function setIdSucurdal($idSucursal)
    {
        $this->idSucursal = $idSucursal;

        return $this;
    }

    /**
     * Get the value of Ubicacion
     */
    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    /**
     * Set the value of Ubicacion
     *
     * @return  self
     */
    public function setUbicacion($Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;

        return $this;
    }
    /**
     * Get the value of Departamento
     */
    public function getDepartamento()
    {
        return $this->Departamento;
    }

    /**
     * Set the value of Departamento
     *
     * @return  self
     */
    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;

        return $this;
    }

    /**
     * Get the value of Municipio
     */
    public function getMunicipio()
    {
        return $this->Municipio;
    }

    /**
     * Set the value of Municipio
     *
     * @return  self
     */
    public function setMunicipio($Municipio)
    {
        $this->Municipio = $Municipio;

        return $this;
    }

    
    // metodos crud

    //metodo para obtener todos los datos de todos las Sucursal
    public function obtenerSucursales(){
        $sql="CALL obtenerSucursales();";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        return $datosObtenidos;
    } 

    //metodo para obtener de la Sucursal con un id,nombre o ubicacion especifico
    public function obtenerSucursalesFiltro($idSucursal, $NombreSucursal, $departamento, $Municipio){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL obtenerSucursalFiltro('$idSucursal', '', '', '');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        return $datosObtenidos;
    }

    //metodo para insertar una Sucursal
    public function crearSucursal($NombreSucursal, $Ubicacion, $departamento, $Municipio){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL crearSucursal('$NombreSucursal', '$Ubicacion', '$departamento', '$Municipio');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        return $datosObtenidos;
    }

    //metodo para actualizar una Sucursal
    public function actualizarSucursal($idSucursal, $NombreSucursal, $Ubicacion, $departamento, $Municipio){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL actualizarSucursal('$idSucursal','$NombreSucursal' ,'$Ubicacion', '$departamento', '$Municipio');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        return $datosObtenidos;
    }

    //metodo para eliminar una Sucursal
    public function eliminarSucursal($idSucursal){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL eliminarSucursal('$idSucursal');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        return $datosObtenidos;
    }
}
