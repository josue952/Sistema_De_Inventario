<?php
require '../../Conexion-Base-de-Datos/dbConnection.php';

class Usuario
{
    private $idUsuario;
    private $Nombre;
    private $Apellido;
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

    //metodo para obtener todos los datos de todos los usuarios
    public function obtenerUsuarios(){
        $sql="CALL obtenerUsuarios();";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //metodo para obtener a un usuario con un id,nombre o rol especifico
    public function obtenerUsuariosFiltro($idUsuario, $Nombre, $Rol){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL obtenerUsuariosFiltro('$idUsuario', '$Nombre', '$Rol');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    //metodo para insertar un usuario
    public function crearUsuario($Nombre, $Apellido, $Email, $DUI, $Contraseña, $Rol){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL crearUsuario('$Nombre', '$Apellido', '$Email', '$DUI', '$Contraseña', '$Rol');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    //metodo para actualizar un usuario
    public function actualizarUsuario($idUsuario, $Nombre, $Apellido, $Email, $DUI, $Contraseña, $Rol){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL actualizarUsuario('$idUsuario','$Nombre', '$Apellido', '$Email', '$DUI', '$Contraseña', '$Rol');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }

    //metodo para eliminar un usuario
    public function eliminarUsuario($idUsuario){
        // Preparar la llamada al procedimiento almacenado con los parámetros
        $sql = "CALL eliminarUsuario('$idUsuario');";
        
        // Ejecutar la consulta
        $datosObtenidos = $this->connection->query($sql);
        
        // Verificar errores
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    }
}
