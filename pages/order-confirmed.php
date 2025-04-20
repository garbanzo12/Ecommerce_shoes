<?php
/**
 * Página de confirmación de pedido completado
 */

// Aquí podríamos procesar los datos del formulario recibidos por POST
$datosRecibidos = false;
$numeroPedido = "ORD-" . rand(1000, 9999);
$totalPagar = "$" . rand(20, 100) . ".000";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datosRecibidos = true;
    // Aquí se procesarían los datos del formulario
    // $direccion = $_POST['direccion'] ?? '';
    // $ciudad = $_POST['ciudad'] ?? '';
    // $departamento = $_POST['departamento'] ?? '';
    // $telefono = $_POST['telefono'] ?? '';
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
				<h1 class="text-2xl font-bold mb-2 text-center">Tu Pedido Ha Sido Confirmado</h1>
				<p class="text-gray-700 text-sm">Gracias por tu compra. Tu pedido ha sido confirmado y se está procesando. Te enviaremos un correo electrónico con los detalles de tu pedido.</p>
				<div class="space-y-2">
					<h3 class="text-lg font-bold mt-4">Detalles del Pedido</h3>
					<p class="text-gray-700 text-sm">Numero de Pedido: <?php echo $numeroPedido; ?></p>
					<p class="text-gray-700 text-sm">Total a Pagar: <?php echo $totalPagar; ?></p>
					
					<?php if ($datosRecibidos): ?>
					<p class="text-gray-700 text-sm">Dirección de entrega: <?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?></p>
					<p class="text-gray-700 text-sm">Ciudad: <?php echo htmlspecialchars($_POST['ciudad'] ?? ''); ?></p>
					<p class="text-gray-700 text-sm">Departamento: <?php echo htmlspecialchars($_POST['departamento'] ?? ''); ?></p>
					<p class="text-gray-700 text-sm">Teléfono: <?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?></p>
					<?php endif; ?>
					
					<p class="text-gray-700 text-sm">Productos:</p>
					<table class="w-full border-collapse">
						<thead class="border-b border-gray-200 text-left">
							<tr>
								<th class="px-6 py-3">Imagen</th>
								<th class="px-6 py-3">Nombre</th>
								<th class="px-6 py-3">Cantidad</th>
								<th class="px-6 py-3">Precio</th>
							</tr>
						</thead>
						<tbody class="">
							<tr class="border-b border-gray-200">
								<td class="px-6 py-3">
									<img src="https://quest.vtexassets.com/arquivos/ids/457879-800-auto?v=638570342902970000&width=800&height=auto&aspect=true" alt="Producto 1" class="w-20 h-20 object-cover rounded">
								</td>
								<td class="px-6 py-3">Camiseta Blanca</td>
								<td class="px-6 py-3">2</td>
								<td class="px-6 py-3">$20.000</td>
							</tr>
							<tr class="border-b border-gray-200">
								<td class="px-6 py-3">
									<img src="https://quest.vtexassets.com/arquivos/ids/457879-800-auto?v=638570342902970000&width=800&height=auto&aspect=true" alt="Producto 1" class="w-20 h-20 object-cover rounded">
								</td>
								<td class="px-6 py-3">Camiseta Blanca</td>
								<td class="px-6 py-3">2</td>
								<td class="px-6 py-3">$20.000</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="mt-6 text-center">
					<a href="../index.php" class="inline-block px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition-colors">
						Volver a la tienda
					</a>
				</div>
			</section>
		</main>
	</body>
</html>
