<?php
// Archivo: includes/conexion.php
// Conexión a la base de datos MySQL

$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'tienda_sena';

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conn->connect_error) {
    die('Error de conexión a la base de datos: ' . $conn->connect_error);
}
// Recuerda cerrar la conexión cuando termines: $conn->close();
?>
