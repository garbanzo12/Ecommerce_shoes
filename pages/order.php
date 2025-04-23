<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../includes/conexion.php');
// Calcular el coste total del carrito
$coste = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $coste += $item['precio'] * $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include_once('../includes/head.php'); ?>
		<title>Confirmar Pedido</title>
	</head>
	<body class="font-sans bg-gray-50">
		<?php include_once('../includes/header.php'); ?>
		<main class="flex w-full bg-gray-50 text-black p-2">
			<!-- Sidebar izquierdo -->
			<?php include_once('../includes/sidebar.php'); ?>

			<!-- Contenido principal -->
			<section class="w-2/3 p-8">
				<h1 class="text-2xl font-bold mb-10 text-center">Hacer Pedido</h1>

				<form class="max-w-2xl mx-auto space-y-5" method="post" action="order-confirmed.php">
					<div class="relative">
						<input
							type="text"
							name="provincia"
							placeholder="Provincia"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
					</div>
					<div class="relative">
						<input
							type="text"
							name="localidad"
							placeholder="Localidad"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
					</div>
					<div class="relative">
						<input
							type="text"
							name="direccion"
							placeholder="Dirección"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
					</div>
					<div class="relative">
						<input
							type="text"
							name="ciudad"
							placeholder="Ciudad"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-5 w-5 absolute right-3 top-3 text-gray-500"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
							/>
						</svg>
					</div>

					<div class="relative">
						<input
							type="text"
							name="departamento"
							placeholder="Departamento"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-5 w-5 absolute right-3 top-3 text-gray-500"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
							/>
						</svg>
					</div>

					<div class="relative">
						<input
							type="tel"
							name="telefono"
							placeholder="Numero de Contacto"
							class="w-full p-3 bg-gray-50 border border-gray-700 rounded text-black focus:border-blue-700 focus:outline-none transition-colors"
							required
						/>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-5 w-5 absolute right-3 top-3 text-gray-500"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
							/>
						</svg>
					</div>

					<input type="hidden" name="coste" value="<?php echo $coste; ?>">
					<div class="mt-8">
						<button
							type="submit"
							class="w-full p-3 bg-black hover:bg-gray-800 text-white rounded transition-all"
						>
							Confirmar Pedido ($<?php echo number_format($coste,2); ?>)
						</button>
					</div>
				</form>
			</section>
		</main>
	</body>
</html>
