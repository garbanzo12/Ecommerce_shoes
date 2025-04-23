<?php
session_start(); // Inicia la sesión
// Simulación de datos de productos
$products = [
    1 => [
        'name' => 'Nike Structure 25',
        'price' => '829.950',
        'description' => 'Running shoes with great support.',
        'image' => 'img/nikeStructure25-1.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
    2 => [
        'name' => 'Nike Interact Run',
        'price' => '489.450',
        'description' => 'Lightweight running shoes.',
        'image' => 'img/nikeInteractRun-2.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
    3 => [
        'name' => 'Tenis Superstart 2',
        'price' => '549.950',
        'description' => 'Casual shoes for everyday wear.',
        'image' => 'img/tenisSuperstart2Adidas-1.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
    4 => [
        'name' => 'Devia Nitro 3',
        'price' => '160.000',
        'description' => 'Athletic shoes for performance.',
        'image' => 'img/tenisDeviateNitro3Puma-1.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
    5 => [
        'name' => 'Wave Trainer',
        'price' => '130.000',
        'description' => 'Comfortable casual shoes.',
        'image' => 'img/waveTrainerConverse-1.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
    6 => [
        'name' => 'Parson Ralven',
        'price' => '150.000',
        'description' => 'Running shoes with a stylish design.',
        'image' => 'img/parsonRalvenSkechers-1.png',
        'features' => ['Feature 1', 'Feature 2', 'Feature 3']
    ],
];

// Captura el ID del producto de la URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 1; // Por defecto, muestra el producto 1

// Obtiene el producto correspondiente
$product = $products[$product_id] ?? $products[1]; // Si no se encuentra, muestra el producto 1
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>SoleStyle Product Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      .scrollbar-hide::-webkit-scrollbar {
        display: none;
      }
      .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
  </head>
  <body class="bg-[#f7f7f8] text-[#1a1a1a] font-sans text-sm leading-relaxed">
    <!-- Integración del componente header.php -->
    <?php include 'includes/header.php';?>

    <main class="container mx-auto px-4 py-6">
      <a class="inline-flex items-center text-xs text-[#1a1a1a] mb-3 hover:underline" href="index.php">
        <i class="fas fa-caret-left mr-2"></i>
        Back to Shop
      </a>

      <section class="flex flex-col lg:flex-row gap-6">
            <div class="flex flex-col w-full lg:w-1/2">
                <div class="w-full max-h-[500px] rounded-md bg-[#ffffff] flex items-center justify-center mb-3 overflow-hidden p-4">
                <img src="<?php echo $product['image']; ?>" alt="Main product image" class="max-w-full max-h-full object-contain rounded" />
                </div>
                <div class="flex space-x-3 overflow-x-auto scrollbar-hide">
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/3993226b-b11d-4da9-9928-6aecf9a44eae.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/141ce359-dbbc-470e-55f8-eb121ef90f59.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/13f0925c-8e81-45c3-3c0c-cc4d4c7f2e94.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/f001bc9a-406d-405f-d6a6-d85f8c4dba96.jpg" />
                </div>
            </div>

        <div class="flex-1">
            <div class="flex flex-col w-full lg:w-1/2">
                <h1 class="text-2xl font-bold mb-2"><?php echo $product['name']; ?></h1>
                <p class="text-lg text-[#ff5722] font-semibold mb-2">$<?php echo $product['price']; ?></p>
                <p class="mb-4"><?php echo $product['description']; ?></p>
            </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Select Size</label>
            <div class="grid grid-cols-3 gap-2">
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 7</button>
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 8</button>
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 9</button>
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 10</button>
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 11</button>
              <button class="border border-[#d9d9d9] rounded py-1 hover:bg-[#e5e5e5]">US 12</button>
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Quantity</label>
            <div class="inline-flex items-center border border-[#d9d9d9] rounded select-none">
              <button id="decrement" class="px-3 py-1 hover:bg-[#e5e5e5]">−</button>
              <span id="quantityValue" class="px-4 py-1">1</span>
              <button id="increment" class="px-3 py-1 hover:bg-[#e5e5e5]">+</button>
            </div>
          </div>

          <div class="flex items-center space-x-3">
            <button class="bg-[#1a1a1a] text-white text-sm font-semibold rounded px-5 py-2 w-full max-w-xs hover:bg-black">
              <i class="fas fa-shopping-bag mr-2"></i>
              Add to Cart
            </button>
            <button class="border border-[#d9d9d9] p-2 rounded hover:bg-[#e5e5e5]">
              <i class="far fa-heart text-sm"></i>
            </button>
          </div>
        </div>
      </section>

      <section class="mt-8">
      <div class="flex flex-col w-full lg:w-1/2">
                <h2 class="text-lg font-semibold mb-2">Características:</h2>
                <ul class="list-disc list-inside mb-4">
                    <?php foreach ($product['features'] as $feature): ?>
                        <li><?php echo $feature; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
      </section>

      <section class="mt-10 flex gap-6">
        <div>
        <h2 class="text-sm font-semibold mb-3">You May Also Like</h2>
            <div class="max-w-sm bg-[#e5e5e5] rounded-md">
                <img
                    class="w-full h-56 object-cover rounded-t-md"
                    src="https://storage.googleapis.com/a1aa/image/c0f69e2d-399e-43a3-45f9-967dd71d4c7d.jpg"
                    alt="Trail Blazer Shoe"
                />
                <div class="px-3 py-2 text-sm font-semibold text-[#1a1a1a] leading-tight">
                    Trail Blazer
                </div>
                <div class="px-3 text-[12px] text-[#8c8c8c] lowercase mb-2">running</div>
                <div class="flex justify-between items-center px-3 pb-3">
                    <span class="text-sm font-semibold">$159.99</span>
                    <button class="bg-[#1a1a1a] text-white text-[11px] font-semibold rounded px-4 py-2 hover:bg-black">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        <div>
            <h2 >.</h2>
            <div class="max-w-sm bg-[#e5e5e5] rounded-md">
                <img
                    class="w-full h-56 object-cover rounded-t-md"
                    src="https://storage.googleapis.com/a1aa/image/c0f69e2d-399e-43a3-45f9-967dd71d4c7d.jpg"
                    alt="Trail Blazer Shoe"
                />
                <div class="px-3 py-2 text-sm font-semibold text-[#1a1a1a] leading-tight">
                    Trail Blazer
                </div>
                <div class="px-3 text-[12px] text-[#8c8c8c] lowercase mb-2">running</div>
                <div class="flex justify-between items-center px-3 pb-3">
                    <span class="text-sm font-semibold">$159.99</span>
                    <button class="bg-[#1a1a1a] text-white text-[11px] font-semibold rounded px-4 py-2 hover:bg-black">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        </section>

    </main>
  </body>
</html>
