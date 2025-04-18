<?php
include("db.php");

if (!isset($_GET["id"])) {
    echo "ID de producto no proporcionado.";
    exit;
}

$id = $_GET["id"];

// Opcional: eliminar imagen del servidor
$consulta = $conexion->query("SELECT imagen FROM productos WHERE id = $id");
if ($consulta->num_rows > 0) {
    $img = $consulta->fetch_assoc()["imagen"];
    if (file_exists($img)) {
        unlink($img); // elimina la imagen del servidor
    }
}

$conexion->query("DELETE FROM productos WHERE id = $id");

header("Location: productos.php");
exit;
?>
