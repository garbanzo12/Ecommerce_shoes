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
                <img
                    src="https://storage.googleapis.com/a1aa/image/96f2770c-040a-4a97-cfc9-10b3e75e54e7.jpg"
                    alt="Main product image"
                    class="max-w-full max-h-full object-contain rounded"
                />
                </div>
                <div class="flex space-x-3 overflow-x-auto scrollbar-hide">
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/3993226b-b11d-4da9-9928-6aecf9a44eae.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/141ce359-dbbc-470e-55f8-eb121ef90f59.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/13f0925c-8e81-45c3-3c0c-cc4d4c7f2e94.jpg" />
                <img class="w-40 h-40 p-2 object-contain bg-[#ffffff] rounded" src="https://storage.googleapis.com/a1aa/image/f001bc9a-406d-405f-d6a6-d85f8c4dba96.jpg" />
                </div>
            </div>

        <div class="flex-1">
          <span class="inline-block bg-[#1a1a1a] text-white text-[10px] font-semibold rounded px-2 py-[2px] mb-2">New Arrival</span>
          <h1 class="text-xl font-bold mb-1">Air Runner Pro</h1>

          <div class="flex items-center text-yellow-400 text-xs mb-1">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <span class="text-gray-500 ml-2">(24 reviews)</span>
          </div>

          <p class="text-lg font-bold mb-3">$129.99</p>
          <p class="text-sm text-gray-700 mb-4">
            The Air Runner Pro is designed for maximum comfort and style. Featuring advanced cushioning technology and breathable materials, these shoes are perfect for all-day wear.
          </p>

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
        <div class="mt-4 text-sm max-w-prose">
          <strong>Features</strong>
          <ul class="list-disc list-inside mt-1 space-y-1">
            <li>Breathable mesh upper</li>
            <li>Cushioned insole for all-day comfort</li>
            <li>Durable rubber outsole</li>
            <li>Lightweight design</li>
            <li>Available in multiple colors</li>
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
