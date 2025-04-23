<?php
session_start();
include_once('../includes/conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../Login/index.php');
    exit();
}

// Eliminar producto del carrito
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    if (isset($_SESSION['carrito'][$id_eliminar])) {
        unset($_SESSION['carrito'][$id_eliminar]);
    }
    header('Location: carrito.php');
    exit();
}

// Actualizar cantidad de producto
if (isset($_POST['actualizar_cantidad'], $_POST['key']) && is_numeric($_POST['key'])) {
    $key = intval($_POST['key']);
    $cantidad = max(1, intval($_POST['actualizar_cantidad']));
    if (isset($_SESSION['carrito'][$key])) {
        $_SESSION['carrito'][$key]['cantidad'] = $cantidad;
    }
    header('Location: carrito.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">

<?php include '../includes/header.php'; ?>

<main class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg max-w-3xl mx-auto">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-xl font-bold">Tu Carrito</h2>
        </div>
        <div id="cart-items" class="p-4 overflow-y-auto">
            <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['carrito'] as $key => $item): ?>
                    <?php
                    // Obtener stock actual del producto desde la base de datos
                    $stmtStock = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
                    $stmtStock->bind_param("i", $item['id']);
                    $stmtStock->execute();
                    $resStock = $stmtStock->get_result();
                    $rowStock = $resStock->fetch_assoc();
                    $stock = $rowStock ? (int)$rowStock['stock'] : 99;
                    $stmtStock->close();

                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                    ?>
                    <div class="flex justify-between items-center py-4 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium text-base mb-1 text-gray-900 flex items-center gap-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                                <?= htmlspecialchars($item['nombre']) ?>
                            </h3>
                            <form method="post" class="flex items-center gap-2 mt-2">
                                <input type="hidden" name="key" value="<?= $key ?>">
                                <input type="number" name="actualizar_cantidad" value="<?= $item['cantidad'] ?>" min="1" max="<?= $stock ?>" class="w-16 border border-gray-300 rounded-md px-2 py-1 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm bg-gray-50">
                                <button type="submit" class="bg-black text-white px-3 py-1 rounded-md hover:bg-gray-800 transition text-sm font-semibold shadow focus:ring-2 focus:ring-blue-400 focus:outline-none">Actualizar</button>
                            </form>
                            <p class="text-gray-500 text-xs mt-2">
                                $<?= number_format($item['precio'], 2) ?> × <?= $item['cantidad'] ?> unidad<?= $item['cantidad'] > 1 ? 'es' : '' ?>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-lg text-primary">$<?= number_format($subtotal, 2) ?></span>
                            <a href="carrito.php?eliminar=<?= $key ?>" class="ml-2 text-red-600 hover:text-red-900 font-bold text-xl rounded-full w-8 h-8 flex items-center justify-center border border-red-100 hover:bg-red-50 transition p-0 leading-none" title="Eliminar del carrito" onclick="return confirm('¿Eliminar este producto del carrito?');">
                                <span class="block w-full text-center" style="line-height: 1;">&times;</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="text-right font-bold mt-4">Total: $<?= number_format($total, 2) ?></div>
            <?php else: ?>
                <div id="empty-cart-message" class="text-center text-gray-500 py-8">
                    Tu carrito está vacío.
                </div>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t border-gray-200">
            <button class="w-full bg-black text-white py-2 rounded-md font-medium hover:bg-gray-800 transition">
                <a href="../pages/order.php">Proceder al pago</a>
            </button>
        </div>
    </div>
</main>

</body>
</html>
