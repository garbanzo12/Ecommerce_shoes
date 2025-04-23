<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');

// Eliminar producto
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM productos WHERE id = $del_id");
    header('Location: products-manage.php?deleted=1');
    exit();
}

// Obtener productos
$productos = $conn->query("SELECT productos.*, categorias.nombre as categoria FROM productos LEFT JOIN categorias ON productos.categoria_id = categorias.id ORDER BY productos.id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Gestion de Productos</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-2/3 p-8">
        <h1 class="text-3xl font-bold mb-10 text-center">Gestion de Productos</h1>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">¡Producto eliminado correctamente!</div>
        <?php endif; ?>
        <a href="product-edit.php" class="mb-6 inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">Crear producto</a>
        <table class="w-full border-collapse bg-white rounded shadow">
            <thead class="border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">NOMBRE</th>
                    <th class="px-4 py-2">PRECIO</th>
                    <th class="px-4 py-2">STOCK</th>
                    <th class="px-4 py-2">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($prod = $productos->fetch_assoc()): ?>
                <tr class="border-b border-gray-100 text-center">
                    <td class="px-4 py-2"><?php echo $prod['id']; ?></td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($prod['nombre']); ?></td>
                    <td class="px-4 py-2"><?php echo number_format($prod['precio'], 2); ?></td>
                    <td class="px-4 py-2"><?php echo $prod['stock']; ?></td>
                    <td class="px-4 py-2 flex gap-2 justify-center">
                        <a href="product-edit.php?id=<?php echo $prod['id']; ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded transition">Editar</a>
                        <a href="products-manage.php?delete=<?php echo $prod['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded transition" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
