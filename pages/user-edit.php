<?php

if (session_status() === PHP_SESSION_NONE) session_start();
include_once('../includes/conexion.php');


$usuario_id = $_SESSION['usuario_id'];

// Obtener datos actuales
$stmt = $conn->prepare("SELECT nombre, apellidos, email FROM usuarios WHERE id = ?");
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$stmt->bind_result($nombre, $apellidos, $email);
$stmt->fetch();
$stmt->close();

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevos_apellidos = trim($_POST['apellidos']);
    $nuevo_email = trim($_POST['email']);
    
    if ($nuevo_nombre && $nuevos_apellidos && filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellidos=?, email=? WHERE id=?");
        $stmt->bind_param('sssi', $nuevo_nombre, $nuevos_apellidos, $nuevo_email, $usuario_id);
        if ($stmt->execute()) {
            $mensaje = '<div class=\'mb-4 p-2 bg-green-100 text-green-800 rounded\'>Datos actualizados correctamente.</div>';
            $nombre = $nuevo_nombre;
            $apellidos = $nuevos_apellidos;
            $email = $nuevo_email;
        } else {
            $mensaje = '<div class=\'mb-4 p-2 bg-red-100 text-red-800 rounded\'>Error al actualizar.</div>';
        }
        $stmt->close();
    } else {
        $mensaje = '<div class=\'mb-4 p-2 bg-yellow-100 text-yellow-800 rounded\'>Datos inválidos.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Editar perfil | SoleStyle</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-full max-w-md mx-auto p-8 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Editar datos de usuario</h1>
        <?= $mensaje ?>
        <form method="POST" class="flex flex-col gap-4">
            <label class="block font-semibold">Nombre
                <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
            </label>
            <label class="block font-semibold">Apellidos
                <input type="text" name="apellidos" value="<?= htmlspecialchars($apellidos) ?>" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
            </label>
            <label class="block font-semibold">Email
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
            </label>
            <button type="submit" class="bg-black text-white px-6 py-2 rounded font-semibold hover:bg-gray-800 transition">Guardar cambios</button>
        </form>
    </section>
</main>
</body>
</html>
