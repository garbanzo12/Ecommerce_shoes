-- Crear base de datos
CREAR BASE DE DATOS SI NO EXISTE zxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxO utf8mb4 INTERCOLACIONAR utf8mb4_general_ci;
USAR bd_ecommerce_shoes;

-- Tabla de categorías
CREAR TABLA categorías (
id INT AUTO_INCREMENT CLAVE PRIMARIA,
nombre VARCHAR(100) NO NULO
);

-- Insertar algunas categorías de ejemplo
INSERTAR EN categorias (nombre) VALORES
('Zapatillas'),
('Botas'),
('Sandalias'),
('Zapatos de vestir');

-- Tabla de productos
CREAR TABLA productos (
id INT AUTO_INCREMENT CLAVE PRIMARIA,
categoria_id INT NO NULO,
nombre VARCHAR(255) NO NULO,
descripcion TEXTO NO NULO,
precio DECIMAL(10,2) NO NULL,
stock INT NO NULO,
oferta INT DEFAULT 0,
fecha DATETIME NO NULL,
imagen VARCHAR(255) NO NULL,
CLAVE EXTERNA (categoria_id) REFERENCIAS categorias(id)
);