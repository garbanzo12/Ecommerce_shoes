<?php
// Configuración de la base de datos
$host = "localhost"; // Cambia por tu servidor de base de datos
$dbname = "tienda_sena"; // Cambia por tu base de datos
$username = "root"; // Tu usuario de la base de datos
$password = "root"; // Tu contraseña de la base de datos

// Conectar a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Validación simple de campos vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($password) || empty($rol)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Verificar si el correo ya existe en la base de datos
    $check_email = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "El correo ya está registrado.";
        exit;
    }

    // Hashear la contraseña
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Subir imagen
    $imagen = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];
    $ruta_destino = "admin/uploads/" . $imagen;

    if (move_uploaded_file($tmp, $ruta_destino)) {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol, imagen)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $apellidos, $email, $password_hashed, $rol, $ruta_destino);
        
        if ($stmt->execute()) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al subir la imagen.";
    }
}

// Cerrar conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#111827',
            secondary: '#4B5563',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        },
      },
    }
  </script>
</head>
<body class="bg-primary font-sans text-white">
  <!-- Header -->
  <header class="border-b border-gray-200 py-4 bg-black">
    <div class="container mx-auto px-4 flex items-center justify-between text-white">
      <div class="flex items-center space-x-3">
        <h1 class="text-2xl font-bold">SoleStyle</h1>
        <span class="text-sm">Virtual Shoe Shop</span>
      </div>
      <div></div>
      <div class="flex items-center space-x-4">
        <button class="transition">Sign In</button>
      </div>
    </div>
  </header>

  <!-- Formulario -->
  <div class="max-w-4xl mx-auto p-8 bg-[#242424] rounded-lg shadow-lg mt-20">
    <form action="register.php" method="POST" enctype="multipart/form-data" class="space-y-6">
      <h1 class="text-3xl font-bold text-center text-white mb-8">Register</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nombre -->
        <div class="space-y-2">
          <label for="nombre" class="block text-sm font-medium text-white">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tu nombre" required>
        </div>

        <!-- Apellidos -->
        <div class="space-y-2">
          <label for="apellidos" class="block text-sm font-medium text-white">Apellidos</label>
          <input type="text" id="apellidos" name="apellidos" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tus apellidos" required>
        </div>

        <!-- Correo -->
        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-white">Correo</label>
          <input type="email" id="email" name="email" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tu correo" required>
        </div>

        <!-- Contraseña -->
        <div class="space-y-2">
          <label for="password" class="block text-sm font-medium text-white">Contraseña</label>
          <input type="password" id="password" name="password" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tu contraseña" required>
        </div>

        <!-- Rol -->
        <div class="space-y-2">
          <label for="rol" class="block text-sm font-medium text-white">Rol</label>
          <input type="text" id="rol" name="rol" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tu rol" required>
        </div>

        <!-- Imagen -->
        <div class="space-y-2">
          <label for="imagen" class="block text-sm font-medium text-white">Imagen</label>
          <input type="file" id="imagen" name="imagen" class="bg-white text-black w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
      </div>

      <!-- Botón de registro centrado y más pequeño -->
      <div class="flex justify-center">
        <button type="submit" class="w-1/2 md:w-1/3 bg-white text-black p-3 rounded-lg font-semibold hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500">Registrarse</button>
      </div>
    </form>
  </div>
</body>
</html>
