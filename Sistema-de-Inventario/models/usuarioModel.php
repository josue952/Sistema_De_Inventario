<?php

require '../../Conexion-Base-de-Datos /dbConnection.php';


class Usuario
{
    private $idUsuario;
    private $Nombre;
    private $Apellido;
    private $Edad;
    private $Email;
    private $DUI;
    private $Contraseña;
    private $Rol;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    // esta funcion sirve para obtener datos de la propiedad 
    public function getNombre()
    {
        return $this->Nombre;

    }
    // esta funcion sirve para mandar datos a la propiedad
    public function setNombre($nom)
    {
        $this->Nombre = $nom;
    }



    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of Apellido
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * Set the value of Apellido
     *
     * @return  self
     */
    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;

        return $this;
    }

    /**
     * Get the value of Edad
     */
    public function getEdad()
    {
        return $this->Edad;
    }

    /**
     * Set the value of Edad
     *
     * @return  self
     */
    public function setEdad($Edad)
    {
        $this->Edad = $Edad;

        return $this;
    }

    /**
     * Get the value of DUI
     */
    public function getDUI()
    {
        return $this->DUI;
    }

    /**
     * Set the value of DUI
     *
     * @return  self
     */
    public function setDUI($DUI)
    {
        $this->DUI = $DUI;

        return $this;
    }

    /**
     * Get the value of Email
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set the value of Email
     *
     * @return  self
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * Get the value of Contraseña
     */
    public function getContraseña()
    {
        return $this->Contraseña;
    }

    /**
     * Set the value of Contraseña
     *
     * @return  self
     */
    public function setContraseña($Contraseña)
    {
        $this->Contraseña = $Contraseña;

        return $this;
    }

    /**
     * Get the value of Rol
     */
    public function getRol()
    {
        return $this->Rol;
    }

    /**
     * Set the value of Rol
     *
     * @return  self
     */
    public function setRol($Rol)
    {
        $this->Rol = $Rol;

        return $this;
    }
    // metodos crud

    // el metodo retorna los datos
    public function obtenerUsuarios(){
        $sql='CALL obtenerUsuarios();';
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        return $datosObtenidos;
    } 

}
