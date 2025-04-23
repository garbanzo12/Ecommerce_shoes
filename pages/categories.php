<?php
if (isset($_SESSION['usuario_email']) && $_SESSION['usuario_email'] !== 'santiago@gmail.com'){
    header('Location: ../Login/index.php');
    exit();
}
if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../Login/index.php');
    exit();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../includes/conexion.php');

// Eliminar categoría solo si no tiene productos asociados
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $res = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE categoria_id = $del_id");
    $row = $res->fetch_assoc();
    if ($row['total'] > 0) {
        header('Location: categories.php?error=productos');
        exit();
    } else {
        $conn->query("DELETE FROM categorias WHERE id = $del_id");
        header('Location: categories.php?deleted=1');
        exit();
    }
}

// Crear categoría
if (isset($_POST['nueva_categoria']) && !empty(trim($_POST['nueva_categoria']))) {
    $nombre = trim($_POST['nueva_categoria']);
    $stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
    $stmt->bind_param('s', $nombre);
    $stmt->execute();
    $stmt->close();
    header('Location: categories.php?created=1');
    exit();
}

// Editar categoría
if (isset($_POST['edit_id'], $_POST['edit_nombre'])) {
    $id = intval($_POST['edit_id']);
    $nombre = trim($_POST['edit_nombre']);
    $stmt = $conn->prepare("UPDATE categorias SET nombre=? WHERE id=?");
    $stmt->bind_param('si', $nombre, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: categories.php?edited=1');
    exit();
}
if (isset($_SESSION['usuario_email']) && $_SESSION['usuario_email'] !== 'santiago@gmail.com'){
    header('Location: ../Login/index.php');
    exit();
}
// Obtener categorías
$categorias = $conn->query("SELECT * FROM categorias ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Gestionar Categorías</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-2/3 p-8">
        <h1 class="text-2xl font-bold mb-10 text-center">Gestionar Categorías</h1>
        <?php if (isset($_GET['created'])): ?>
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">¡Categoría creada correctamente!</div>
        <?php endif; ?>
        <?php if (isset($_GET['edited'])): ?>
            <div class="mb-4 p-2 bg-blue-100 text-blue-800 rounded">¡Categoría editada correctamente!</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">¡Categoría eliminada correctamente!</div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'productos'): ?>
            <div class="mb-4 p-2 bg-yellow-100 text-yellow-800 rounded">No puedes eliminar una categoría que tiene productos asociados.</div>
        <?php endif; ?>
        <form method="post" class="mb-8 flex gap-2 items-center">
            <input type="text" name="nueva_categoria" class="border border-gray-300 rounded px-4 py-2" placeholder="Nueva categoría" required>
            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">Crear</button>
        </form>
        <table class="w-full border-collapse bg-white rounded shadow">
            <thead class="border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <tr class="border-b border-gray-100">
                    <td class="px-4 py-2"><?php echo $cat['id']; ?></td>
                    <td class="px-4 py-2">
                        <form method="post" class="flex gap-2 items-center">
                            <input type="hidden" name="edit_id" value="<?php echo $cat['id']; ?>">
                            <input type="text" name="edit_nombre" value="<?php echo htmlspecialchars($cat['nombre']); ?>" class="border border-gray-300 rounded px-2 py-1" required>
                            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1 rounded transition">Guardar</button>
                        </form>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="categories.php?delete=<?php echo $cat['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
