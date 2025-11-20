-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 20-11-2025 a las 12:10:42
-- Versión del servidor: 9.5.0
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hexagonal_pablogarciajc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO `favorites` (`id`, `product_id`, `user_id`) VALUES
(1, 1, 1),
(2, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `stock` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `description`, `price`, `currency`, `stock`, `active`, `created_at`) VALUES
(1, 'LAPTOP-001', 'Laptop HP Pavilion 15', 'Laptop de alto rendimiento con procesador Intel i7, 16GB RAM, 512GB SSD. Pantalla IPS Full HD de 15.6 pulgadas. Ideal para trabajo y entretenimiento.', 899.99, 'USD', 5, 1, '2025-11-16 19:51:28'),
(2, 'MOUSE-001', 'Mouse Logitech MX Master 3', 'Mouse inalámbrico de precisión con tecnología Darkfield. Botones personalizables y batería de larga duración. Compatible con Windows y Mac.', 99.99, 'USD', 12, 1, '2025-11-16 19:51:28'),
(3, 'KEYBOARD-001', 'Teclado Mecánico Corsair K95', 'Teclado mecánico gaming RGB con switches Cherry MX. Estructura de aluminio, reposamuñecas desmontable y programable. Conectividad USB.', 199.99, 'USD', 8, 1, '2025-11-16 19:51:28'),
(4, 'MONITOR-001', 'Monitor LG UltraWide 34\"', 'Monitor ultrapanorámico 34 pulgadas con resolución 3440x1440. Panel IPS, 60Hz, 5ms response time. Perfecta para diseño y productividad.', 599.99, 'USD', 3, 1, '2025-11-16 19:51:28'),
(5, 'HEADPHONES-001', 'Audífonos Sony WH-1000XM5', 'Audífonos con cancelación de ruido activa de clase mundial. Batería de 30 horas, sonido de alta calidad y micrófono integrado.', 399.99, 'USD', 10, 1, '2025-11-16 19:51:28'),
(6, 'WEBCAM-001', 'Webcam Logitech C920 Pro', 'Cámara web Full HD 1080p para videoconferencias y streaming. Micrófono estéreo incorporado, enfoque automático y corrección de luz.', 79.99, 'USD', 15, 1, '2025-11-16 19:51:28'),
(7, 'DESK-001', 'Escritorio Gaming RGB', 'Escritorio gaming con iluminación RGB integrada, superficie de vidrio templado y cable management. Dimensiones 150cm x 60cm.', 299.99, 'USD', 4, 1, '2025-11-16 19:51:28'),
(8, 'CHAIR-001', 'Silla Gaming Ergonómica', 'Silla gaming con soporte lumbar ajustable, brazos 3D, inclinación hasta 170 grados. Tapicería en cuero sintético de alta calidad.', 249.99, 'USD', 7, 1, '2025-11-16 19:51:28'),
(9, 'BOOK-001', 'Libro: El poder de los hábitos', 'Descubre cómo los hábitos influyen en tu vida y cómo cambiarlos para alcanzar el éxito personal y profesional.', 19.99, 'USD', 20, 1, '2025-11-17 12:00:00'),
(10, 'SHOES-001', 'Zapatillas Nike Air Max', 'Zapatillas deportivas Nike Air Max, cómodas y con diseño moderno. Ideales para correr y uso diario.', 129.99, 'USD', 25, 1, '2025-11-17 12:05:00'),
(11, 'COFFEE-001', 'Cafetera Nespresso Vertuo', 'Cafetera automática Nespresso Vertuo, prepara café y espresso con solo pulsar un botón. Incluye 12 cápsulas de regalo.', 149.99, 'USD', 10, 1, '2025-11-17 12:10:00'),
(12, 'TV-001', 'Smart TV Samsung 55\" 4K', 'Televisor inteligente Samsung 4K UHD de 55 pulgadas, HDR, WiFi, apps integradas y control por voz.', 699.99, 'USD', 6, 1, '2025-11-17 12:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'Excelente laptop, muy rápida y ligera.', '2025-11-17 10:00:00'),
(2, 2, 2, 4, 'Buen mouse, aunque algo caro.', '2025-11-17 11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(15, 'Pablo Garcia', 'demo@pablogarciajc.com', '$2y$10$w81Dp/ndvzUm79klnJ67K.exsjOBwvzpwfw5qRRExRezX9B6fJl2u', '2025-11-20 12:08:01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `status` (`status`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
