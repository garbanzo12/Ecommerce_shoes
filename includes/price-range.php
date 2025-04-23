<?php
// Conexión a la base de datos (ajusta la contraseña si es necesario)
$conexion = new mysqli("localhost", "root", "", "tienda_sena");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener el precio mínimo y máximo
$sql = "SELECT MIN(precio) AS min_price, MAX(precio) AS max_price FROM productos";
$result = $conexion->query($sql);
$min_price = 0;
$max_price = 0;
if ($result && $row = $result->fetch_assoc()) {
    $min_price = floor($row['min_price']);
    $max_price = ceil($row['max_price']);
}
$conexion->close();
?>
<!-- Price Range -->
<div class="bg-white p-6 rounded-lg shadow-sm price-range">
    <h2 class="text-lg font-bold mb-4">Price Range</h2>
    <div class="mb-6 flex gap-3 items-center">
        <input 
            type="range" 
            min="<?php echo $min_price; ?>" 
            max="<?php echo $max_price; ?>" 
            value="<?php echo $max_price; ?>" 
            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
            id="price-range">
        <input 
            type="number" 
            min="<?php echo $min_price; ?>" 
            max="<?php echo $max_price; ?>" 
            value="<?php echo $max_price; ?>" 
            id="price-input" 
            class="w-24 border border-gray-300 rounded px-2 py-1 text-right" 
            step="0.01">
    </div>
    <div class="flex justify-between">
        <span id="min-price">$<?php echo $min_price; ?></span>
        <span id="price-value">$<?php echo $max_price; ?></span>
        <span id="max-price">$<?php echo $max_price; ?></span>
    </div>
</div>

<script>
const rangeInput = document.getElementById("price-range");
const priceInput = document.getElementById("price-input");
const priceValue = document.getElementById("price-value");

function updatePriceFilter(val) {
    priceValue.textContent = `$${val}`;
    priceInput.value = val;
    rangeInput.value = val;
    document.querySelectorAll(".product-card").forEach(card => {
        const price = parseFloat(card.dataset.price);
        if (price <= val) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

rangeInput.addEventListener("input", function () {
    updatePriceFilter(this.value);
});
priceInput.addEventListener("input", function () {
    let v = parseFloat(this.value);
    if (!isNaN(v)) updatePriceFilter(v);
});
</script>
