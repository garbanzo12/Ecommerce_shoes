<?php
$conexion = new mysqli("localhost", "root", "123456", "tienda_sena");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
