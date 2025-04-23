<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT productos.*, categorias.nombre AS categoria FROM productos INNER JOIN categorias ON productos.categoria_id = categorias.id WHERE productos.id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if (!$res || $res->num_rows === 0) {
    echo '<div class="p-8 text-center">Producto no encontrado.</div>';
    exit();
}
$producto = $res->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title><?= htmlspecialchars($producto['nombre']) ?> | SoleStyle</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-full mx-auto p-6 flex flex-col gap-8 bg-white rounded shadow">
        <a href="../index.php" class="inline-block mb-2 text-blue-600 hover:underline font-semibold text-sm">← Volver al inicio</a>
        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="flex-shrink-0 w-full md:w-56 flex justify-center items-center">
                <img src="../uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="rounded-lg shadow border w-56 h-56 object-cover">
            </div>
            <div class="flex-1 flex flex-col justify-between w-full gap-4">
                <h1 class="text-2xl font-bold mb-2 border-b pb-2"><?= htmlspecialchars($producto['nombre']) ?></h1>
                <div class="flex flex-col gap-2 mb-2">
                    <p class="text-gray-500 text-sm">Categoría: <span class="font-semibold text-black"><?= htmlspecialchars($producto['categoria']) ?></span></p>
                    <p class="text-gray-700 text-sm">Stock: <span class="font-semibold"><?= (int)$producto['stock'] ?></span></p>
                    <p class="text-gray-400 text-sm">Descripción:</p>
                    <p class="text-gray-600 text-base bg-gray-100 rounded p-3 mb-2"><?= htmlspecialchars($producto['descripcion']) ?></p>
                </div>
                <p class="text-xl font-bold mb-4">$<?= number_format($producto['precio'], 2) ?></p>
                <form method="POST" action="../admin/agregar_carrito.php" class="flex gap-2 items-center mt-2">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                    <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                    <input type="number" name="cantidad" value="1" min="1" max="<?= (int)$producto['stock'] ?>" class="w-20 border border-gray-300 rounded px-3 py-2 text-center">
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded-md font-semibold hover:bg-gray-800 transition flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Agregar al carrito
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
</body>
</html>
