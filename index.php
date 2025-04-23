<?php
session_start(); // Iniciar sesión al principio del script

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
    <title>SoleStyle - Virtual Shoe Shop</title>

    <!-- Scripts y links -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#111827',
                        secondary: '#4B5563',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script> <!-- configuracion tailwind -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- enlace tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">
    <!-- Integración del componente header.php -->
    <?php include 'includes/header.php';?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="md:w-1/4 lg:w-1/5">
                <!-- Integración de los componentes categories.php y price-range.php -->
                <?php include 'includes/categories.php';?>
                <?php include 'includes/price-range.php';?>
            </div>
            <!-- Products Grid -->
            <div class="md:w-3/4 lg:w-4/5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="products-grid">
                <?php
// Conexión a la base de datos centralizada
include 'includes/conexion.php';

// Consulta para obtener productos con su categoría
$categoriaWhere = '';
if (isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
    $categoria_id = intval($_GET['categoria']);
    $categoriaWhere = " WHERE productos.categoria_id = $categoria_id ";
}
$sql = "SELECT productos.*, categorias.nombre AS categoria 
        FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.id" . $categoriaWhere;

$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0):
    while ($producto = $resultado->fetch_assoc()):
        // Convertimos el precio al formato con punto decimal
        $precio_formateado = number_format($producto['precio'], 3, '.', '');
?>
    <!-- Product Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card cursor-pointer" data-category="<?= strtolower($producto['categoria']) ?>" data-price="<?= $precio_formateado ?>" onclick="window.location.href='pages/product-view.php?id=<?= $producto['id'] ?>'">
        <div class="relative">
        <img src="uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="w-full h-64 object-cover">
        <div class="absolute top-4 left-4">
                <?php if ($producto['oferta'] === '1'): ?>
                    <span class="bg-black text-white text-xs px-2 py-1 rounded-md">New</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="p-4">
            <h3 class="text-lg font-medium"><?= $producto['nombre'] ?></h3>
            <p class="text-gray-500 text-sm mb-2"><?= $producto['categoria'] ?></p>
            <p class="text-gray-400 text-sm mb-2"><?= $producto['descripcion'] ?></p>
            <div class="flex justify-between items-center">
                <span class="font-bold" id="">$<?= $precio_formateado ?></span>
                <form method="POST" action="admin/agregar_carrito.php" onclick="event.stopPropagation();">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                    <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                    <button type="submit" class="bg-black text-white px-3 py-2 rounded-md flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Agregar al carrito</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php
    endwhile;
else:
    echo "<p>No hay productos disponibles.</p>";
endif;

// Cerrar conexión
$conn->close();
?>

                        </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Cart Modal -->
    <div id="cart-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-[80vh] flex flex-col">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold">Your Cart</h2>
                <button id="close-cart" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 overflow-y-auto flex-grow" id="cart-items">
                <!-- Cart items will be added here dynamically -->
                <div class="text-center text-gray-500 py-8" id="empty-cart-message">
                    Your cart is empty
                </div>
            </div>
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between mb-4">
                    <span class="font-medium">Total:</span>
                    <span class="font-bold" id="cart-total">$0.00</span>
                </div>
                <button class="w-full bg-black text-white py-2 rounded-md font-medium hover:bg-gray-800 transition">
                    Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Cart functionality
        let cart = [];
        const cartButton = document.getElementById('cart-button');
        const cartModal = document.getElementById('cart-modal');
        const closeCart = document.getElementById('close-cart');
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartCount = document.getElementById('cart-count');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        
        // Add to cart
        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = parseFloat(button.getAttribute('data-price'));
                
                // Check if item is already in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        quantity: 1
                    });
                }
                
                updateCart();
                
                // Guardar el carrito en localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                // No redireccionar ni mostrar modal
            });
        });
        
        // Open cart modal
        cartButton.addEventListener('click', () => {
            cartModal.classList.remove('hidden');
        });
        
        // Close cart modal
        closeCart.addEventListener('click', () => {
            cartModal.classList.add('hidden');
        });
        
        // Close cart when clicking outside
        cartModal.addEventListener('click', (e) => {
            if (e.target === cartModal) {
                cartModal.classList.add('hidden');
            }
        });
        
        // Update cart UI
        function updateCart() {
            // Update cart count
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            cartCount.textContent = totalItems;
            
            // Update cart items
            if (cart.length === 0) {
                emptyCartMessage.classList.remove('hidden');
                cartItems.innerHTML = '';
                cartItems.appendChild(emptyCartMessage);
            } else {
                emptyCartMessage.classList.add('hidden');
                
                let cartHTML = '';
                cart.forEach(item => {
                    cartHTML += `
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <div>
                                <h3 class="font-medium">${item.name}</h3>
                                <p class="text-gray-500 text-sm">$${item.price} × ${item.quantity}</p>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium mr-4">$${(item.price * item.quantity).toFixed(2)}</span>
                                <button class="text-gray-500 hover:text-red-500 remove-item" data-id="${item.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                });
                
                cartItems.innerHTML = cartHTML;
                
                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        cart = cart.filter(item => item.id !== id);
                        updateCart();
                    });
                });
            }
            
            // Update total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `$${total.toFixed(2)}`;
        }
        
        // Category filtering
        const categoryButtons = document.querySelectorAll('.category-btn');
        const productCards = document.querySelectorAll('.product-card');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => {
                    btn.classList.remove('bg-black', 'text-white');
                    btn.classList.add('hover:bg-gray-100');
                });
                
                // Add active class to clicked button
                button.classList.add('bg-black', 'text-white');
                button.classList.remove('hover:bg-gray-100');
                
                const category = button.getAttribute('data-category');
                
                // Filter products
                productCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
        
    
        // Navigation category filtering
        const navLinks = document.querySelectorAll('nav a');
        
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                const category = link.getAttribute('data-category');
                
                // Reset category buttons
                categoryButtons.forEach(btn => {
                    btn.classList.remove('bg-black', 'text-white');
                    btn.classList.add('hover:bg-gray-100');
                    
                    if (btn.getAttribute('data-category') === 'all') {
                        btn.classList.add('bg-black', 'text-white');
                    }
                });
                
                // Filter products
                if (category === 'new') {
                    productCards.forEach(card => {
                        const hasNewTag = card.querySelector('.bg-black.text-white.text-xs');
                        if (hasNewTag) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                } else if (category === 'sale') {
                    productCards.forEach(card => {
                        const hasSaleTag = card.querySelector('.bg-red-600.text-white.text-xs');
                        if (hasSaleTag) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                } else {
                    // For men, women, kids - in a real app, these would have their own data attributes
                    // For this demo, we'll just show all products
                    productCards.forEach(card => {
                        card.classList.remove('hidden');
                    });
                }
            });
        });
    </script>
</body>
</html>