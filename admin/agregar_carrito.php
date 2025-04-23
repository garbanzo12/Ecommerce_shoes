<?php
session_start();

// Validar datos recibidos
if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    // Estructura del producto
    $producto = [
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];

    // Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Buscar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id) {
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }
    unset($item);

    // Si no está, agregarlo
    if (!$encontrado) {
        $_SESSION['carrito'][] = $producto;
    }
}

// Redirigir de vuelta a la página anterior
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
