<?php

require '../../Conexion-Base-de-Datos/dbConnection.php';

class productoModel {
    private $idProducto;
    private $Nombreproducto;
    private $Cantidad;
    private $Precio;
    private $Foto;
    private $idCategoria;
    private $idSucursal;
    private $connection;

    // constructor para iniciar la conexion
    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }

    // Set
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setNombreproducto($Nombreproducto) {
        $this->Nombreproducto = $Nombreproducto;
    }

    public function setCantidad($Cantidad) {
        $this->Cantidad = $Cantidad;
    }

    public function setPrecio($Precio) {
        $this->Precio = $Precio;
    }

    public function setFoto($Foto) {
        $this->Foto = $Foto;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }
    
    //get
    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getNombreproducto() {
        return $this->Nombreproducto;
    }

    public function getCantidad() {
        return $this->Cantidad;
    }

    public function getPrecio() {
        return $this->Precio;
    }

    public function getFoto() {
        return $this->Foto;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getIdSucursal() {
        return $this->idSucursal;
    }
   
    
        // Método para crear un nuevo
    

        public function agregar($Nombreproducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal) {
            $sql = "INSERT INTO productos (Nombreproducto, Cantidad, Precio, Foto, idCategoria, idSucursal)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sidsii", $Nombreproducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal);
                return $stmt->execute();
    }
    
        // Método para leer 
        public function mostrar() {
            $sql = "SELECT * FROM productos WHERE idProducto = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $this->idProducto);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->Nombreproducto = $row['Nombreproducto'];
                $this->Cantidad = $row['Cantidad'];
                $this->Precio = $row['Precio'];
                $this->Foto = $row['Foto'];
                $this->idCategoria = $row['idCategoria'];
                $this->idSucursal = $row['idSucursal'];
                return true;
            } else {
                return false;
            }
        }
    
        // Método para actualizar
        public function actualizar() {
            $sql = "UPDATE productos SET Nombreproducto = ?, Cantidad = ?, Precio = ?, Foto = ?, idCategoria = ?, idSucursal = ?
                    WHERE idProducto = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sidsiii", $this->Nombreproducto, $this->Cantidad, $this->Precio, $this->Foto, $this->idCategoria, $this->idSucursal, $this->idProducto);
    
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    
        // Método para eliminar
        public function eliminar($idProducto) {
            $sql = "DELETE FROM productos WHERE idProducto = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $idProducto);
            return $stmt->execute();
        }
    
    
}
