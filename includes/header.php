<!-- Minimal Header -->
<header class="border-b border-gray-200 py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold text-primary">ShoesShop</h1>
            <span class="text-gray-500 text-sm">Virtual Shoe Shop</span>
        </div>
        
     
        
        <div class="flex items-center space-x-4">
            <button class="text-gray-700 hover:text-black transition">Sign In</button>
            <button id="cart-button" class="text-gray-700 hover:text-black transition relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-black text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
            </button>
            
            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</header>