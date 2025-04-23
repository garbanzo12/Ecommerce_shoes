<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in'])) {
    header('Location: ./Login/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">
    <!-- Integración del componente header.php -->
    <?php include '../includes/header.php'; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg max-w-3xl mx-auto">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-xl font-bold">Tu Carrito</h2>
            </div>
            <div id="cart-items" class="p-4 overflow-y-auto">
                <!-- Los productos del carrito se mostrarán aquí -->
                <?php
                if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0):
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $item):
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                ?>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium"><?= htmlspecialchars($item['nombre']) ?></h3>
                            <p class="text-gray-500 text-sm">
                                $<?= number_format($item['precio'], 2) ?> × <?= $item['cantidad'] ?>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <span class="font-bold">$<?= number_format($subtotal, 2) ?></span>
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

    <!-- JavaScript eliminado: ahora solo PHP gestiona el carrito -->
</body>
</html>