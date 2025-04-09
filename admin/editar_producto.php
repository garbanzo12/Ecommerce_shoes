<?php
include("db.php");

if (!isset($_GET["id"])) {
    echo "ID de producto no proporcionado.";
    exit;
}

$id = $_GET["id"];
$resultado = $conexion->query("SELECT * FROM productos WHERE id = $id");

if ($resultado->num_rows === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $categoria_id = $_POST["categoria_id"];
    $descripcion = $_POST["descripcion"];
    
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = $_FILES["imagen"]["name"];
        $ruta = "uploads/" . basename($imagen);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
        $conexion->query("UPDATE productos SET nombre='$nombre', precio='$precio', categoria_id='$categoria_id', descripcion='$descripcion', imagen='$ruta' WHERE id=$id");
    } else {
        $conexion->query("UPDATE productos SET nombre='$nombre', precio='$precio', categoria_id='$categoria_id', descripcion='$descripcion' WHERE id=$id");
    }

    header("Location: productos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="admin-container">
  <h2>Editar Producto</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?>" required>
    
    <select name="categoria_id" required>
      <?php
      $categorias = $conexion->query("SELECT * FROM categorias");
      while ($cat = $categorias->fetch_assoc()) {
          $selected = $cat["id"] == $producto["categoria_id"] ? "selected" : "";
          echo "<option value='" . $cat["id"] . "' $selected>" . htmlspecialchars($cat["nombre"]) . "</option>";
      }
      ?>
    </select>

    <textarea name="descripcion" required><?= htmlspecialchars($producto["descripcion"]) ?></textarea>
    
    <p>Imagen actual:</p>
    <img src="<?= $producto["imagen"] ?>" width="100"><br><br>
    <label>Nueva imagen (opcional):</label>
    <input type="file" name="imagen" accept="image/*">
    
    <button type="submit">Guardar Cambios</button>
  </form>
</div>
</body>
</html>
