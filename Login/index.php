<?php
include("/admin/db.php"); // Incluir la conexión a la base de datos

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Consulta al usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $mensaje = "Inicio de sesión exitoso. ¡Bienvenido, " . htmlspecialchars($usuario['email']) . "!";
            header('location: /index.php');
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main class="form-container">
    <h1 class="form-container__title">Login</h1>
    <?php if (!empty($mensaje)): ?>
      <p style="color: red;"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form class="form" method="POST" action="">
      <div class="form__group">
        <label for="email" class="form__label">Email</label>
        <input type="email" id="email" name="email" class="form__input" placeholder="Escribe tu email" required>
      </div>
      <div class="form__group">
        <label for="password" class="form__label">Contraseña</label>
        <input type="password" id="password" name="password" class="form__input" placeholder="Escribe tu contraseña" required>
      </div>
      <button type="submit" class="form__button">Iniciar Sesión</button>
    </form>
  </main>
</body>
</html>
