<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cart_count += $item['cantidad'];
    }
}
?>
<header class="bg-black shadow-sm">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div>
            <a href="/Ecommerce_shoes/index.php" class="text-white font-bold text-lg mr-6">SoleStyle</a>
            <a href="/Ecommerce_shoes/index.php" class="text-white hover:underline mr-4">Inicio</a>
            <?php if (isset($_SESSION['logged_in'])): ?>
                <a href="/Ecommerce_shoes/logout.php" class="text-white hover:underline mr-4">Cerrar sesión</a>
                <a href="/Ecommerce_shoes/pages/products-manage.php" class="text-white hover:underline mr-4">Gestionar productos</a>
                <a href="/Ecommerce_shoes/pages/categories.php" class="text-white hover:underline mr-4">Gestionar categorías</a>
                <a href="/Ecommerce_shoes/pages/orders-list.php" class="text-white hover:underline mr-4">Gestionar pedidos</a>
                <a href="/Ecommerce_shoes/pages/order.php" class="text-white hover:underline mr-4">Mis pedidos</a>
            <?php endif; ?>
        </div>
        <div class="relative">
            <a href="/Ecommerce_shoes/admin/carrito.php" class="text-white hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-white text-black text-xs rounded-full h-5 w-5 flex items-center justify-center border border-black">
                    <?php echo $cart_count; ?>
                </span>
            </a>
        </div>
    </nav>
</header>