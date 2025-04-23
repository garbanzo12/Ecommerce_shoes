<?php
/**
 * Sidebar común para todas las páginas
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = 0;
$total_price = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cart_count += $item['cantidad'];
        $total_price += $item['precio'] * $item['cantidad'];
    }
}
$nombreUsuario = isset($_SESSION['usuario_email']) ? $_SESSION['usuario_email'] : 'Usuario';
?>
<aside class="w-1/4 border-r border-gray-200 p-6 h-[80vh]">
    <!-- Sección Carrito -->
    <div class="mb-8 pb-6 border-b border-gray-200">
        <h2 class="text-lg font-bold mb-4 flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                />
            </svg>
            Carrito
        </h2>
        <ul class="space-y-2 text-sm text-black">
            <li class="flex items-center">
                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                Productos <span class="ml-1"><?php echo $cart_count; ?></span>
            </li>
            <li class="flex items-center">
                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                Total <span class="ml-1">$<?php echo number_format($total_price, 2); ?></span>
            </li>
            <?php if ($cart_count > 0): ?>
            <li class="mt-3">
                <a href="/Ecommerce_shoes/admin/carrito.php" class="inline-flex items-center text-blue-600 hover:text-blue-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Ver Carrito
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <?php if ($cart_count > 0): ?>
        <div class="mt-4">
            <ul class="divide-y divide-gray-200">
                <?php foreach ($_SESSION['carrito'] as $item): ?>
                <li class="py-2 flex justify-between items-center">
                    <div>
                        <div class="font-medium"><?php echo htmlspecialchars($item['nombre']); ?></div>
                        <div class="text-xs text-gray-500">$<?php echo number_format($item['precio'], 2); ?> x <?php echo $item['cantidad']; ?></div>
                    </div>
                    <div class="font-bold">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sección Usuario -->
    <div class="mb-6">
        <h2 class="text-lg font-bold mb-4 flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
            </svg>
            <?php echo htmlspecialchars($nombreUsuario); ?>
        </h2>
        <ul class="space-y-3 text-sm">
            <li>
                <a
                    href="/Ecommerce_shoes/pages/categories.php"
                    class="flex items-center text-gray-600 hover:text-blue-500 transition-colors group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Gestionar categorías
                </a>
            </li>
            <li>
                <a
                    href="/Ecommerce_shoes/pages/products-manage.php"
                    class="flex items-center text-gray-600 hover:text-blue-500 transition-colors group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h6M9 7v2a4 4 0 014 4h6M3 7h6M3 17h6" />
                    </svg>
                    Gestionar productos
                </a>
            </li>
            <li>
                <a
                    href="/Ecommerce_shoes/pages/orders-list.php"
                    class="flex items-center text-gray-600 hover:text-blue-500 transition-colors group"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mr-2 text-gray-500 group-hover:text-blue-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                        />
                    </svg>
                    Mis pedidos
                </a>
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center text-gray-600 hover:text-blue-500 transition-colors group"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mr-2 text-gray-500 group-hover:text-blue-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>
                    Cerrar sesión
                </a>
            </li>
        </ul>
    </div>
</aside>
