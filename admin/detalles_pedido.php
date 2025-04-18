<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #f9f9f9;
      color: #333;
    }

    header {
      background-color: #ffffff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    header h1 {
      font-size: 1.5rem;
      color: #111;
    }

    nav {
      margin-top: 1rem;
      display: flex;
      gap: 1.5rem;
      font-size: 0.95rem;
    }

    nav a {
      text-decoration: none;
      color: #555;
    }

    .container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }

    h2 {
      font-size: 1.4rem;
      margin-bottom: 1rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: block;
    }

    select {
      width: 100%;
      padding: 0.6rem;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      padding: 0.6rem 1.5rem;
      background-color: #111;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 0.5rem;
    }

    .shipping-info, .order-info {
      margin-top: 2rem;
    }

    .product {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem;
      border-bottom: 1px solid #eee;
    }

    .product img {
      width: 60px;
      height: 60px;
      border-radius: 6px;
      background-color: #ddd;
      object-fit: cover;
    }

    .product-details {
      flex: 1;
      margin-left: 1rem;
    }

    .product-name {
      font-weight: 600;
    }

    .product-price {
      color: #333;
      margin-top: 0.2rem;
    }

    .out-of-stock {
      color: red;
      font-weight: 600;
    }

    .footer {
      text-align: center;
      font-size: 0.9rem;
      color: #666;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

<header>
  <h1>SENA | Nombre de la tienda</h1>
  <nav>
    <a href="#">Inicio</a>
    <a href="#">Categoría 1</a>
    <a href="#">Categoría 2</a>
    <a href="#">Categoría 3</a>
    <a href="#">Categoría 4</a>
  </nav>
</header>

<div class="container">
  <h2>Detalle del Pedido #2</h2>

  <div class="form-group">
    <label for="estado">Cambiar estado del pedido</label>
    <select id="estado">
      <option>Pendiente</option>
      <option>Enviado</option>
      <option>Cancelado</option>
    </select>
    <button>Cambiar estado</button>
  </div>

  <div class="shipping-info">
    <h3>Dirección de envío</h3>
    <p><strong>Dirección:</strong> Calle Falsa 123</p>
    <p><strong>Ciudad:</strong> Bogotá</p>
    <p><strong>Departamento:</strong> Cundinamarca</p>
    <p><strong>Teléfono:</strong> 3001234567</p>
  </div>

  <div class="order-info">
    <h3>Datos del pedido</h3>
    <p><strong>Total a pagar:</strong> $24.000</p>

    <div class="product">
      <img src="https://via.placeholder.com/60" alt="Foto Producto">
      <div class="product-details">
        <div class="product-name">Camiseta Azul</div>
        <div class="product-price">$20.000</div>
        <div class="out-of-stock">Stock: 0</div>
      </div>
    </div>

    <div class="product">
      <img src="https://via.placeholder.com/60" alt="Foto Producto">
      <div class="product-details">
        <div class="product-name">Camiseta Azul</div>
        <div class="product-price">$20.000</div>
        <div class="out-of-stock">Stock: 0</div>
      </div>
    </div>
  </div>
</div>

<div class="footer">
  Desarrollado por Grupo 1 | SENA CDITI 2025
</div>

</body>
</html>
