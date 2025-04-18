<!-- Price Range -->
<div class="bg-white p-6 rounded-lg shadow-sm price-range">
    <h2 class="text-lg font-bold mb-4">Price Range</h2>
    <div class="mb-6">
        <input 
            type="range" 
            min="0" 
            max="300" 
            value="150" 
            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
            id="price-range">
    </div>
    <div class="flex justify-between">
        <span>$0</span>
        <span id="price-value">$10000</span>
        <span>$300000</span>
    </div>
</div>

<script>
    console.log('sdfnsfdn')
// Actualiza el texto mostrado
const rangeInput = document.getElementById("price-range");
const priceValue = document.getElementById("price-value");

rangeInput.addEventListener("input", function () {
    priceValue.textContent = `$${this.value}`;

    // Filtrar productos visibles por precio
    document.querySelectorAll(".product-card").forEach(card => {
        const price = parseFloat(card.dataset.price); // asegúrate de tener data-price
        if (price <= this.value) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
});
</script>
