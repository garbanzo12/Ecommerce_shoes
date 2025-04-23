<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_sena");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener las categorías
$sql = "SELECT * FROM categorias";
$resultado = $conexion->query($sql);
?>

<!-- Categories -->
<div class="bg-white p-6 rounded-lg shadow-sm mb-6">
    <h2 class="text-lg font-bold mb-4">Categories</h2>
    <ul class="space-y-2">
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <li>
                <button 
                    class="w-full py-2 px-4 hover:bg-gray-100 rounded-md text-left font-medium category-btn" 
                    data-category="<?php echo strtolower($fila['nombre']); ?>">
                    <?php echo htmlspecialchars($fila['nombre']); ?>
                </button>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php
$conexion->close();
?>
