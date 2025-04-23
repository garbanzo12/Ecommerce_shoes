<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../includes/conexion.php');

// Solo permitir acceso a usuarios con rol admin o el usuario logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

// Eliminar pedido si se solicita
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    // Primero eliminar las líneas de pedido
    $conn->query("DELETE FROM lineas_pedidos WHERE pedido_id = $del_id");
    // Luego eliminar el pedido
    $conn->query("DELETE FROM pedidos WHERE id = $del_id");
    header('Location: orders-list.php?deleted=1');
    exit();
}

// Cambiar estado si se solicita
if (isset($_POST['pedido_id'], $_POST['nuevo_estado'])) {
    $pid = intval($_POST['pedido_id']);
    $estado = $_POST['nuevo_estado'];
    $stmt = $conn->prepare("UPDATE pedidos SET estado=? WHERE id=?");
    $stmt->bind_param('si', $estado, $pid);
    $stmt->execute();
    $stmt->close();
}

// Obtener pedidos del usuario (o todos si admin)
$usuario_id = $_SESSION['usuario_id'];
$is_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');
$sql = $is_admin ? "SELECT * FROM pedidos ORDER BY fecha DESC, hora DESC" : "SELECT * FROM pedidos WHERE usuario_id=$usuario_id ORDER BY fecha DESC, hora DESC";
$pedidos = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Mis Pedidos</title>
</head>
<body class="font-sans bg-gray-50 text-black">
<?php include_once('../includes/header.php'); ?>
<main class="flex w-full bg-gray-50 text-black p-2 min-h-screen">
    <?php include_once('../includes/sidebar.php'); ?>
    <section class="w-2/3 p-8">
        <h1 class="text-2xl font-bold mb-10 text-center">Listado de Pedidos</h1>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">¡Pedido eliminado correctamente!</div>
        <?php endif; ?>
        <?php while ($pedido = $pedidos->fetch_assoc()): ?>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8 border border-gray-200">
                <h2 class="text-lg font-bold mb-4">Detalle del Pedido #<?php echo $pedido['id']; ?></h2>
                <form method="post" class="mb-4 flex flex-wrap gap-2 items-center">
                    <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                    <select name="nuevo_estado" class="border border-gray-300 rounded p-1 text-black">
                        <?php foreach (["pendiente", "procesando", "enviado", "entregado", "cancelado"] as $estado): ?>
                        <option value="<?php echo $estado; ?>" <?php if ($pedido['estado'] == $estado) echo 'selected'; ?>><?php echo ucfirst($estado); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition btn-edit">Cambiar estado</button>
                    <a href="orders-list.php?delete=<?php echo $pedido['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition btn-delete ml-2" onclick="return confirm('¿Seguro que deseas eliminar este pedido?');">Eliminar</a>
                </form>
                <div class="mb-2 text-sm">
                    <strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['direccion']); ?>
                    <br><strong>Provincia:</strong> <?php echo htmlspecialchars($pedido['provincia']); ?>
                    <br><strong>Localidad:</strong> <?php echo htmlspecialchars($pedido['localidad']); ?>
                    <br><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['fecha']); ?> <?php echo htmlspecialchars($pedido['hora']); ?>
                    <br><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estado']); ?>
                    <br><strong>Total:</strong> $<?php echo number_format($pedido['coste'], 2); ?>
                </div>
                <div>
                    <table class="w-full border-collapse mt-4">
                        <thead class="border-b border-gray-200 text-left">
                            <tr>
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2">Precio</th>
                                <th class="px-4 py-2">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $conn->query("SELECT lp.unidades, p.nombre, p.precio FROM lineas_pedidos lp JOIN productos p ON lp.producto_id=p.id WHERE lp.pedido_id=" . $pedido['id']);
                        while ($prod = $res->fetch_assoc()): ?>
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($prod['nombre']); ?></td>
                                <td class="px-4 py-2">$<?php echo number_format($prod['precio'],2); ?></td>
                                <td class="px-4 py-2"><?php echo $prod['unidades']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endwhile; ?>
        <?php if ($pedidos->num_rows == 0): ?>
            <div class="text-center text-gray-400">No tienes pedidos registrados.</div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
