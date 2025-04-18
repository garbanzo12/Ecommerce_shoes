<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="admin-container">
<a href="index.php">
<?php include ("../includes/arrowSVG.php") ?>
</a>

  <h2>Gestionar Productos</h2>
  <form action="productos.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Marca" required>
    <input type="number" name="precio" step="0.01" placeholder="Precio" required>
    
    <select name="categoria_id" required>
      <option value="">Categoría</option>
      <?php
      $categorias = $conexion->query("SELECT * FROM categorias");
      while ($cat = $categorias->fetch_assoc()) {
          echo "<option value='" . $cat["id"] . "'>" . htmlspecialchars($cat["nombre"]) . "</option>";
      }
      ?>
    </select>

    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="file" name="imagen" accept="image/*" required>

    <input type="number" name="stock" placeholder="Stock" required>
    <input type="number" name="oferta" placeholder="Oferta (%)" min="0" max="100" required>

    <button type="submit">Crear Producto</button>

  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $nombre = $_POST["nombre"];
      $precio = $_POST["precio"];
      $categoria_id = $_POST["categoria_id"];
      $descripcion = $_POST["descripcion"];
      $stock = $_POST["stock"];
      $oferta = isset($_POST["oferta"]) ? $_POST["oferta"] : 0;
      $fecha = date("Y-m-d H:i:s");

      $imagen = $_FILES["imagen"]["name"];
      $ruta = "uploads/" . basename($imagen);

      if (!file_exists("uploads")) {
          mkdir("uploads", 0777, true);
      }

      if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta)) {
          $sql = "INSERT INTO productos (nombre, precio, categoria_id, descripcion, stock, oferta, fecha, imagen) 
                  VALUES ('$nombre', '$precio', '$categoria_id', '$descripcion', '$stock', '$oferta', '$fecha', '$ruta')";
          
          if ($conexion->query($sql)) {
              echo "<p style='color: green;'>Producto creado con éxito.</p>";
              // Redirigir a la misma página después de insertar para evitar resubmit
              header("Location: productos.php");
              exit; // Termina el script después de la redirección
          } else {
              echo "<p style='color: red;'>Error al insertar producto: " . $conexion->error . "</p>";
          }
      } else {
          echo "<p style='color: red;'>Error al subir la imagen.</p>";
      }
  }

  $maxDescripcionLength = 20; // Establece el número máximo de caracteres que deseas mostrar

  $productos = $conexion->query("SELECT p.*, c.nombre AS categoria FROM productos p JOIN categorias c ON p.categoria_id = c.id");
  
  echo "<table><tr><th>Imagen</th><th>Marca</th><th>Precio</th><th>Oferta</th><th>Categoría</th><th>Descripción</th><th>Stock</th><th>Acciones</th></tr>";
  
  while ($prod = $productos->fetch_assoc()) {
      // Truncar descripción si excede el límite de caracteres
      $descripcion = htmlspecialchars($prod["descripcion"]);
      if (strlen($descripcion) > $maxDescripcionLength) {
          $descripcion = substr($descripcion, 0, $maxDescripcionLength) . '...'; // Agregar '...' si excede el límite
      }
      
      echo "<tr>
              <td><img src='" . $prod["imagen"] . "' width='50'></td>
              <td>" . htmlspecialchars($prod["nombre"]) . "</td>
              <td>$" . $prod["precio"] . "</td>
              <td>" . $prod["oferta"] . "%</td>
              <td>" . htmlspecialchars($prod["categoria"]) . "</td>
              <td>" . $descripcion . "</td>  <!-- Mostrar descripción truncada aquí -->
              <td>" . $prod["stock"] . "</td>
              <td>
                <a href='editar_producto.php?id=" . $prod["id"] . "'>Editar</a>
                <a href='eliminar_producto.php?id=" . $prod["id"] . "' onclick='return confirm(\"¿Eliminar producto?\")'>Eliminar</a>
              </td>
            </tr>";
  }
  
  echo "</table>";
  
  ?>
</div>
</body>
</html>
