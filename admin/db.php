<?php
$conexion = new mysqli("localhost", "root", "123456", "tienda_sena"); // ⬅️ Conexion a la bd

if ($conexion->connect_error) { // ⬅️ Condicional para el error
    die("Conexión fallida: " . $conexion->connect_error); // ⬅️ mensaje de error
}
?>
