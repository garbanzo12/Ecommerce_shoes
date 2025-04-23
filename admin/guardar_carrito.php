<?php
session_start();
require 'conexion.php'; // asegúrate de tener `$conn` definido

// Verifica que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // No autorizado
    echo "Usuario no logueado";
    exit();
}

// Verifica que se recibió el producto
if (isset($_POST['producto_id'], $_POST['cantidad'])) {
    $usuario_id = $_SESSION['user_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Verificar si ya existe ese producto en el carrito
    $check = $conn->prepare("SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $check->bind_param("ii", $usuario_id, $producto_id);
    $check->execute();
    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {
        // Si ya existe, actualizar cantidad
        $update = $conn->prepare("UPDATE carrito SET cantidad = cantidad + ? WHERE usuario_id = ? AND producto_id = ?");
        $update->bind_param("iii", $cantidad, $usuario_id, $producto_id);
        $update->execute();
    } else {
        // Si no existe, insertar nuevo
        $insert = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        $insert->execute();
    }

    echo "Producto guardado en el carrito";
} else {
    http_response_code(400); // Bad request
    echo "Datos incompletos";
}
?>
