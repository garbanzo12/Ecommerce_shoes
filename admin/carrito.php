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
                <div id="empty-cart-message" class="text-center text-gray-500 py-8">
                    Tu carrito está vacío.
                </div>
            </div>
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between mb-4">
                    <span class="font-medium">Total:</span>
                    <span class="font-bold" id="cart-total">$0.00</span>
                </div>
                <button class="w-full bg-black text-white py-2 rounded-md font-medium hover:bg-gray-800 transition">
                    Proceder al pago
                </button>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        // Función para cargar y mostrar los productos del carrito
        function updateCart() {
            // Recuperar el carrito desde localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Si el carrito está vacío, mostrar mensaje vacío
            const emptyCartMessage = document.getElementById('empty-cart-message');
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            if (cart.length === 0) {
                emptyCartMessage.classList.remove('hidden');
                cartItems.innerHTML = '';
                cartItems.appendChild(emptyCartMessage);
            } else {
                emptyCartMessage.classList.add('hidden');
                cartItems.innerHTML = '';

                let cartHTML = '';
                let total = 0;
                
                cart.forEach(item => {
                    total += item.price * item.quantity;
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

                // Actualizar total
                cartTotal.textContent = `$${total.toFixed(2)}`;

                // Agregar evento de eliminar producto
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        // Filtrar el producto que se quiere eliminar
                        cart = cart.filter(item => item.id !== id);
                        // Guardar el carrito actualizado
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCart();  // Actualizar la interfaz del carrito
                    });
                });
            }
        }

        // Llamar a la función updateCart cuando se cargue la página
        document.addEventListener('DOMContentLoaded', updateCart);
    </script>
</body>
</html>
