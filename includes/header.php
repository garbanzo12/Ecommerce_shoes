

<header class="bg-primary shadow-sm">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span class="text-xl font-bold text-black">Ecommerce shoes</span>
        </div>

   

        <!-- User and Cart -->
        <div class="flex items-center space-x-4">
    <?php if (isset($_SESSION['logged_in'])): ?>
        
   <header class="bg-primary shadow-sm">
    
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      
        <!-- Menú desplegable para usuario logueado -->
        <div class="relative" id="user-menu-container">
            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <span class="text-sm">
                        <?php echo isset($_SESSION['usuario_email']) ? strtoupper(substr($_SESSION['usuario_email'], 0, 1)) : 'U'; ?>
                    </span>
                </div>
                <span class="text-black hover:text-black ">
                    <?php echo isset($_SESSION['usuario_email']) ? htmlspecialchars($_SESSION['usuario_email']) : 'Usuario'; ?>
                </span>
                <svg id="dropdown-arrow" class="w-4 h-4 text-black" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div id="user-menu-dropdown" class="absolute right-0 mt-1 w-40 bg-black rounded-md shadow-lg py-1 z-50 hidden transition-all duration-300">
                <a href="logout.php" class="block px-3 py-2 text-sm text-white ">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Cerrar sesión</span>
                    </div>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('user-menu-button');
    const dropdown = document.getElementById('user-menu-dropdown');
    const dropdownArrow = document.getElementById('dropdown-arrow');
    
    // Toggle menu on button click
    menuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
        dropdownArrow.classList.toggle('rotate-180');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#user-menu-container')) {
            dropdown.classList.add('hidden');
            dropdownArrow.classList.remove('rotate-180');
        }
    });
});
</script>
         

            <!-- Cart Button -->
            <button id="cart-button" class="relative text-white  transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-white text-primary text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
            </button>
        </div>
    </div>
</header>