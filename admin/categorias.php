<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Categorías</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="admin-container">
  <h2>Gestionar Categorías</h2>
  <form action="categorias.php" method="POST">
    <input type="text" name="nueva_categoria" placeholder="Nombre categoría" required>
    <button type="submit">Añadir</button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nueva_categoria"])) {
      $nombre = $_POST["nueva_categoria"];
      $conexion->query("INSERT INTO categorias (nombre) VALUES ('$nombre')");
  }

  $resultado = $conexion->query("SELECT * FROM categorias");
  echo "<ul>";
  while ($row = $resultado->fetch_assoc()) {
      echo "<li>" . htmlspecialchars($row["nombre"]) . "</li>";
  }
  echo "</ul>";
  ?>
</div>
</body>
</html>
