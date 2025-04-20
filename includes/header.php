<?php
/**
 * Header común para todas las páginas
 */
?>
<header class="border-b border-gray-200 py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold text-primary">SoleStyle</h1>
            <span class="text-gray-500 text-sm">Virtual Shoe Shop</span>
        </div>

        <!-- Navigation -->
        <nav class="hidden md:flex space-x-8">
            <a href="../index.php" class="text-gray-700 hover:text-black transition" data-category="new">Inicio</a>
            <a href="#" class="text-gray-700 hover:text-black transition" data-category="men">Hombres</a>
            <a href="#" class="text-gray-700 hover:text-black transition" data-category="women">Mujeres</a>
            <a href="#" class="text-gray-700 hover:text-black transition" data-category="kids">Niños</a>
            <a href="#" class="text-gray-700 hover:text-black transition" data-category="sale">Recién Llegados</a>
        </nav>

        <div class="flex items-center space-x-4">
            <button class="text-gray-700 hover:text-black transition">
                Iniciar Sesión
            </button>
            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700 hover:text-black transition">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>
        </div>
    </div>
</header>
