<?php
require '../../Conexion-Base-de-Datos/dbConnection.php';

class Ventas 
{
    private $idVenta;
    private $Fecha;
    private $idCliente;
    private $Total;
    private $connection;

    function __construct()
    {
        $this->connection = conectar();
    }

    public function getIdVenta()
    {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta)
    {
        $this->idVenta = $idVenta;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getTotal()
    {
        return $this->Total;
    }

    public function setTotal($Total)
    {
        $this->Total = $Total;
    }

    //metodos crud
    //Metodo para obtener todas las ventas
    public function obtenerVentas(){
        $sql="CALL obtenerVentas();";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

    //Metodo para crear una venta
    public function crearVenta($fechaVenta, $idCliente){
        $sql="CALL crearVenta('$fechaVenta','$idCliente');";
        $datosObtenidos=$this->connection->query($sql);
        if($this->connection->error){
            die ('ERROR SQL: '.$this->connection->error);
        }
        //limpiar la consulta para poder hacer otra
        $this->connection->next_result();
        return $datosObtenidos;
    } 

}
?>