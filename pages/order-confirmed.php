<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../includes/conexion.php');

// Verificar usuario logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

$pedido_exitoso = false;
$error = '';
$pedido_id = null;
$productos_guardados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $usuario_id = $_SESSION['usuario_id'];
    $provincia = $_POST['provincia'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $coste = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $coste += $item['precio'] * $item['cantidad'];
    }
    $estado = 'pendiente';
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    // Insertar pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('isssdsss', $usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);
        if ($stmt->execute()) {
            $pedido_id = $stmt->insert_id;
            // Insertar productos en lineas_pedidos
            $stmt_linea = $conn->prepare("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (?, ?, ?)");
            foreach ($_SESSION['carrito'] as $item) {
                $stmt_linea->bind_param('iii', $pedido_id, $item['id'], $item['cantidad']);
                $stmt_linea->execute();
                $productos_guardados[] = $item;
            }
            $stmt_linea->close();
            $pedido_exitoso = true;
            // Limpiar carrito
            unset($_SESSION['carrito']);
        } else {
            $error = 'No se pudo guardar el pedido.';
        }
        $stmt->close();
    } else {
        $error = 'Error en la base de datos.';
    }
} else {
    $error = 'No hay productos en el carrito o datos incompletos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once('../includes/head.php'); ?>
    <title>Pedido Confirmado</title>
</head>
<body class="font-sans bg-gray-50">
    <?php include_once('../includes/header.php'); ?>
    <main class="flex w-full bg-gray-50 text-black p-2">
        <!-- Sidebar izquierdo -->
        <?php include_once('../includes/sidebar.php'); ?>

        <!-- Contenido principal -->
        <section class="w-2/3 p-8">
            <h1 class="text-2xl font-bold mb-2 text-center">
                <?php if ($pedido_exitoso): ?>
                    Tu Pedido Ha Sido Confirmado
                <?php else: ?>
                    Error al procesar el pedido
                <?php endif; ?>
            </h1>
            <?php if ($pedido_exitoso): ?>
                <p class="text-gray-700 text-sm">Gracias por tu compra. Tu pedido ha sido confirmado y se está procesando.</p>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold mt-4">Detalles del Pedido</h3>
                    <p class="text-gray-700 text-sm">Número de Pedido: <?php echo $pedido_id; ?></p>
                    <p class="text-gray-700 text-sm">Total a Pagar: $<?php echo number_format($coste, 2); ?></p>
                    <p class="text-gray-700 text-sm">Provincia: <?php echo htmlspecialchars($provincia); ?></p>
                    <p class="text-gray-700 text-sm">Localidad: <?php echo htmlspecialchars($localidad); ?></p>
                    <p class="text-gray-700 text-sm">Dirección: <?php echo htmlspecialchars($direccion); ?></p>
                    <p class="text-gray-700 text-sm">Estado: <?php echo htmlspecialchars($estado); ?></p>
                    <p class="text-gray-700 text-sm">Fecha: <?php echo htmlspecialchars($fecha); ?> <?php echo htmlspecialchars($hora); ?></p>
                    <p class="text-gray-700 text-sm font-bold mt-4">Productos:</p>
                    <table class="w-full border-collapse">
                        <thead class="border-b border-gray-200 text-left">
                            <tr>
                                <th class="px-6 py-3">Nombre</th>
                                <th class="px-6 py-3">Cantidad</th>
                                <th class="px-6 py-3">Precio</th>
                                <th class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productos_guardados as $item): ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3"><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td class="px-6 py-3"><?php echo $item['cantidad']; ?></td>
                                <td class="px-6 py-3">$<?php echo number_format($item['precio'], 2); ?></td>
                                <td class="px-6 py-3">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 text-center">
                    <a href="../index.php" class="inline-block px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition-colors">
                        Volver a la tienda
                    </a>
                </div>
            <?php else: ?>
                <div class="text-red-600 font-bold py-8 text-center"><?php echo $error; ?></div>
                <div class="mt-6 text-center">
                    <a href="order.php" class="inline-block px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition-colors">
                        Volver al formulario
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
