<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_sena");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener las categorías
$sql = "SELECT * FROM categorias";
$resultado = $conexion->query($sql);
$selected = isset($_GET['categoria']) ? intval($_GET['categoria']) : null;
?>

<!-- Categories -->
<div class="bg-white p-6 rounded-lg shadow-sm mb-6">
    <h2 class="text-lg font-bold mb-4">Categorías</h2>
    <ul class="flex flex-col gap-4">
        <li>
            <a href="/Ecommerce_shoes/index.php" class="w-full py-2 px-4 hover:bg-gray-100 rounded-md text-left font-medium transition-all <?php if(!$selected) echo 'bg-gray-200'; ?>">Todas</a>
        </li>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <li>
                <a href="/Ecommerce_shoes/index.php?categoria=<?php echo $fila['id']; ?>"
                   class="w-full py-2 px-4 hover:bg-gray-100 rounded-md text-left font-medium transition-all <?php if($selected === (int)$fila['id']) echo 'bg-gray-200'; ?>">
                    <?php echo htmlspecialchars($fila['nombre']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php
$conexion->close();
?>
