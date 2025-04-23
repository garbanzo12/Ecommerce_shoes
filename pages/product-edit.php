<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');

// Obtener categorías para el select
$categorias = $conn->query("SELECT * FROM categorias ORDER BY nombre ASC");

// Inicializar variables
$nombre = $descripcion = $precio = $stock = $categoria_id = $imagen = '';
$editando = false;

// Si hay id, cargar datos para editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $editando = true;
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM productos WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $prod = $res->fetch_assoc();
        $nombre = $prod['nombre'];
        $descripcion = $prod['descripcion'];
        $precio = $prod['precio'];
        $stock = $prod['stock'];
        $categoria_id = $prod['categoria_id'];
        $imagen = $prod['imagen'];
    }
}

// Guardar cambios o crear
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);
    $imagen_nueva = $imagen;

    // Manejo de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['imagen']['tmp_name'];
        $filename = uniqid().basename($_FILES['imagen']['name']);
        $dest = '../admin/'.$filename;
        if (move_uploaded_file($tmp, $dest)) {
            $imagen_nueva = $filename;
        }
    }

    if ($editando) {
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, imagen=? WHERE id=?");
        $stmt->bind_param('ssdisii', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen_nueva, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdisi', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen_nueva);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: products-manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title><?php echo $editando ? 'Editar Producto' : 'Crear Producto'; ?></title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-2/3 p-8 flex flex-col items-center">
        <h1 class="text-3xl font-bold mb-8 text-center"><?php echo $editando ? 'Editar Producto '.htmlspecialchars($nombre) : 'Crear Producto'; ?></h1>
        <form method="post" enctype="multipart/form-data" class="bg-white shadow rounded p-8 w-full max-w-xl space-y-4">
            <label class="block font-semibold mb-1">Nombre
                <input type="text" name="nombre" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </label>
            <label class="block font-semibold mb-1">Descripción
                <textarea name="descripcion" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required><?php echo htmlspecialchars($descripcion); ?></textarea>
            </label>
            <label class="block font-semibold mb-1">Precio
                <input type="number" name="precio" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" value="<?php echo htmlspecialchars($precio); ?>" min="0" step="0.01" required>
            </label>
            <label class="block font-semibold mb-1">Stock
                <input type="number" name="stock" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" value="<?php echo htmlspecialchars($stock); ?>" min="0" required>
            </label>
            <label class="block font-semibold mb-1">Categoría
                <select name="categoria_id" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                    <option value="">Selecciona una categoría</option>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $categoria_id) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label class="block font-semibold mb-1">Imagen
                <?php if ($editando && $imagen): ?>
                    <div class="mb-2"><img src="../admin/<?php echo htmlspecialchars($imagen); ?>" alt="Imagen actual" class="w-24 h-24 object-cover rounded border"></div>
                <?php endif; ?>
                <input type="file" name="imagen" accept="image/*">
            </label>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded font-semibold">Guardar</button>
        </form>
    </section>
</main>
</body>
</html>
