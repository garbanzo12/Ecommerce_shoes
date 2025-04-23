<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');

// Obtener categorías
$categorias = $conn->query("SELECT * FROM categorias ORDER BY nombre ASC");

// Inicializar variables
$nombre = $descripcion = $precio = $stock = $categoria_id = $imagen = '';
$error = '';

// Guardar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);
    $imagen_nueva = '';

    // Validar imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['imagen']['tmp_name'];
        $mime = mime_content_type($tmp);
        $permitidas = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($mime, $permitidas)) {
            if (!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }
            $filename = uniqid().basename($_FILES['imagen']['name']);
            $dest = '../uploads/'.$filename;
            if (move_uploaded_file($tmp, $dest)) {
                $imagen_nueva = $filename;
            }
        } else {
            $error = 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.';
        }
    }

    if (!$error && $nombre && $descripcion && $precio > 0 && $stock >= 0 && $categoria_id) {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdisi', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen_nueva);
        $stmt->execute();
        $stmt->close();
        header('Location: products-manage.php?success=1');
        exit();
    } elseif (!$error) {
        $error = 'Por favor completa todos los campos correctamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Agregar Producto</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-2/3 p-8 flex flex-col items-center">
        <h1 class="text-3xl font-bold mb-8 text-center">Agregar Producto</h1>
        <?php if ($error): ?>
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded"><?php echo $error; ?></div>
        <?php endif; ?>
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
                <input type="file" name="imagen" accept="image/*">
            </label>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded font-semibold">Guardar</button>
        </form>
    </section>
</main>
</body>
</html>
