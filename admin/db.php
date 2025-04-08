<?php
$conexion = new mysqli("localhost", "usuario", "contraseña", "tienda_virtual");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
