<?php

define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "inventario");

function conectar()
{
    $conn = new mysqli("localhost", "root", '', "inventario");
    if ($conn->connect_error) {
        die("conexion fallida" . $conn->connect_error);
    }
    return $conn;
}
