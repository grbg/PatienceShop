-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 22 2024 г., 21:52
-- Версия сервера: 5.6.51
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `patienceShop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id`, `created_at`, `updated_at`, `user_id`, `country`, `city`, `street`, `house`, `zip_code`) VALUES
(1, '2024-06-01 01:58:58', '2024-06-01 01:58:58', 25, 'Россия', 'Севастополь', 'ул. Проспект Октябрьской Революции', '56б', '245765'),
(2, '2024-06-01 10:07:56', '2024-06-01 10:09:15', 26, 'Белоруссия', 'Севастополь', 'ул. Проспект Октябрьской Революции', '56б', '234567');

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`, `size_id`) VALUES
(4, 25, 1, 1, '2024-06-01 04:27:22', '2024-06-01 04:27:22', 4),
(15, 25, 2, 1, '2024-06-01 10:22:01', '2024-06-01 10:22:01', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Брюки', NULL, '2024-05-15 14:27:44', '2024-05-15 14:27:44'),
(2, 'Деним', NULL, '2024-05-15 14:27:44', '2024-05-15 14:27:44'),
(3, 'Рубашки', NULL, '2024-05-15 14:27:44', '2024-05-15 14:27:44'),
(4, 'Аксессуары', NULL, '2024-05-15 14:27:44', '2024-05-15 14:27:44'),
(5, 'Джинсы', NULL, '2024-05-15 14:30:14', '2024-05-15 14:30:14'),
(6, 'Футболки', NULL, '2024-05-16 19:21:45', '2024-05-16 19:21:45');

-- --------------------------------------------------------

--
-- Структура таблицы `category_product`
--

CREATE TABLE `category_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category_product`
--

INSERT INTO `category_product` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-05-14 16:29:56', '2024-05-14 16:29:56'),
(2, 4, 5, '2024-05-14 16:29:56', '2024-05-14 16:29:56'),
(3, 3, 1, '2024-05-15 14:27:44', '2024-05-15 14:27:44'),
(7, 6, 6, '2024-05-17 05:54:21', '2024-05-17 05:54:21'),
(8, 7, 6, '2024-05-17 06:00:59', '2024-05-17 06:00:59'),
(9, 8, 6, '2024-05-17 06:04:59', '2024-05-17 06:04:59'),
(10, 9, 3, '2024-05-17 06:07:33', '2024-05-17 06:07:33'),
(12, 1, 3, NULL, NULL),
(13, 10, 1, NULL, NULL),
(14, 11, 4, NULL, NULL),
(15, 12, 5, NULL, NULL),
(16, 12, 2, NULL, NULL),
(17, 13, 4, NULL, NULL),
(19, 15, 1, NULL, NULL),
(20, 15, 2, NULL, NULL),
(21, 16, 4, NULL, NULL),
(25, 14, 1, NULL, NULL),
(26, 11, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `product_id`, `url`, `created_at`, `updated_at`) VALUES
(2, 2, 'assets/products/seA6r1XEcFGBbhQTv4pjYGwgeegZ1XLLslOdTMf3.png', '2024-05-15 14:37:02', '2024-05-19 08:23:39'),
(3, 3, 'assets/products/8bCV2qO20fYFOANW909giyCLUWs1OP9jOhiz00ea.png', '2024-05-15 14:37:02', '2024-05-19 08:22:31'),
(4, 4, 'assets/products/Z6Tdme4BHBlFhCdZR5tX2HcDcyrKg3vavo8Nem1Q.jpg', '2024-05-15 14:46:53', '2024-05-19 08:23:53'),
(6, 6, 'assets/products/h0nCjM0l3YKzopcBvmm3MJuKfJNfGh3QuhtWuJJ3.jpg', '2024-05-17 05:53:27', '2024-05-19 08:26:11'),
(7, 7, 'assets/products/2T2dXL2i9VzFkJQSuinaAzTR0er9SdDbM0DuQAho.jpg', '2024-05-17 06:00:38', '2024-05-19 08:41:42'),
(8, 8, 'assets/products/Y580CmQ7oueHFKKMePmTntS0KKYp5AgKG0i1Z2aE.jpg', '2024-05-17 06:04:11', '2024-05-19 08:41:53'),
(9, 9, 'assets/products/FVUiLfd18zg05qJAIR7Rd6usXHwjAOnwnwZQtl5G.jpg', '2024-05-17 06:08:25', '2024-05-19 08:42:00'),
(10, 1, 'assets/products/6qvtAHADlxJqyZPGT3BXE3uX87Ex9eLD6L8dEhvG.jpg', '2024-05-19 08:08:52', '2024-05-20 03:18:33'),
(11, 10, 'assets/products/EERPN7ecSQYC3CGYikvdlLYOfOZX4DMinJpYO2kl.png', '2024-05-19 15:28:56', '2024-05-19 15:45:26'),
(12, 11, 'assets/products/KX10SexaJwGpiDviDAHHkV3Z1INoewY9N7Wly9nw.jpg', '2024-05-20 03:16:14', '2024-06-01 10:21:02'),
(13, 12, 'assets/products/fzA0fmyNPFcnj0aQgxVUD2CVjMblLFuWuWgi0D7Z.jpg', '2024-05-20 03:16:50', '2024-05-20 03:24:38'),
(14, 13, 'assets/products/z2oYYzpmUQkIym3NvXwObatfvxG9BzojVRMd5hO3.jpg', '2024-05-20 03:17:09', '2024-05-20 03:17:09'),
(15, 14, 'assets/products/7RtaSPLiDcGAjXmzZv9vWrZgu68mqLfBqJ6EejeW.jpg', '2024-05-20 03:26:17', '2024-05-20 03:26:17'),
(16, 15, 'assets/products/nQ9VNbwFj4nGBYNeHFXROx51TlM2WzcJ9LmygGA6.jpg', '2024-05-26 18:00:46', '2024-05-26 18:00:46'),
(17, 16, 'assets/products/rQBVrNXdKPLoxlGvz7P6EcDOLLDr8jV86QCPtVA6.jpg', '2024-05-27 02:23:10', '2024-05-27 02:23:10');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(25, '2014_10_12_000000_create_users_table', 1),
(26, '2014_10_12_100000_create_password_resets_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2024_05_14_133657_create_products_table', 1),
(29, '2024_05_14_133844_create_categories_table', 1),
(30, '2024_05_14_141221_create_sizes_table', 1),
(31, '2024_05_14_141242_create_materials_table', 1),
(32, '2024_05_14_141319_product_sizes', 1),
(33, '2024_05_14_152724_create_images_table', 1),
(34, '2024_05_15_161054_create_category_product_table', 2),
(35, '2024_05_15_173221_add_additional_column_to_users_table', 3),
(36, '2024_05_15_173535_add_additional_column_to_users_table', 4),
(37, '2024_05_24_052940_create_carts_table', 5),
(38, '2024_05_24_063241_add_size_id_to_cart_items_table', 6),
(39, '2024_05_28_230725_create_orders_table', 7),
(40, '2024_05_28_231026_create_order_items_table', 7),
(41, '2024_05_28_232000_add_columns_to_orders_table', 8),
(42, '2024_05_28_233350_add_columns_to_orderitems_table', 9),
(43, '2024_05_31_061137_add_is_admin_to_users_table', 10),
(44, '2024_06_01_040058_create_addresses_table', 11),
(45, '2024_06_01_043322_update_addresses_table', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `updated_at`, `order_country`, `order_city`, `street`, `zip_code`, `house_num`, `delivery_method`) VALUES
(1, 25, 46999, 'pending', '2024-05-29 06:20:15', '2024-05-29 06:20:15', 'Россия', '123123123', '123123123', '123123123', '213123123', 'mail'),
(2, 25, 30000, 'pending', '2024-05-29 17:56:08', '2024-05-29 17:56:08', 'Россия', 'садовое товарищество Ригель', '123456', '123456', '118', 'mail'),
(3, 25, 70998, 'pending', '2024-05-30 13:12:22', '2024-05-30 13:12:22', 'Россия', 'Севастополь', 'Коралловая улица', '123456', '9', 'mail'),
(4, 25, 31999, 'pending', '2024-05-30 16:40:41', '2024-05-30 16:40:41', 'Россия', 'Севастополь', 'улица Рябова', '123456', '9', 'mail'),
(5, 28, 29000, 'pending', '2024-05-31 04:38:07', '2024-05-31 04:38:07', 'Россия', 'Севастополь', 'Фиолентовское шоссе', '123456', '46', 'mail'),
(6, 25, 22000, 'pending', '2024-06-01 04:26:03', '2024-06-01 04:26:03', 'Россия', 'Севастополь', 'ул. Проспект Октябрьской Революции', '245765', '56б', 'mail'),
(7, 29, 15000, 'pending', '2024-06-01 09:24:26', '2024-06-01 09:24:26', 'Россия', 'Севастополь', 'Столетовский проспект', '123456', '17А', 'mail'),
(8, 26, 45000, 'pending', '2024-06-01 10:06:30', '2024-06-01 10:06:30', 'Россия', 'Севастополь', 'улица Тараса Шевченко', '123456', '14', 'mail'),
(9, 26, 45000, 'pending', '2024-06-01 10:14:32', '2024-06-01 10:14:32', 'Россия', 'Севастополь', 'улица Льва Толстого', '234567', '51', 'mail');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`, `size_id`) VALUES
(1, 1, 8, 1, 1999, '2024-05-29 06:20:16', '2024-05-29 06:20:16', 3),
(2, 1, 3, 1, 15000, '2024-05-29 06:20:16', '2024-05-29 06:20:16', 1),
(3, 1, 2, 2, 15000, '2024-05-29 06:20:16', '2024-05-29 06:20:16', 5),
(4, 2, 3, 1, 15000, '2024-05-29 17:56:08', '2024-05-29 17:56:08', 3),
(5, 2, 2, 1, 15000, '2024-05-29 17:56:08', '2024-05-29 17:56:08', 2),
(6, 3, 2, 2, 15000, '2024-05-30 13:12:22', '2024-05-30 13:12:22', 3),
(7, 3, 4, 5, 7000, '2024-05-30 13:12:22', '2024-05-30 13:12:22', 2),
(8, 3, 1, 2, 2999, '2024-05-30 13:12:22', '2024-05-30 13:12:22', 3),
(9, 4, 3, 1, 15000, '2024-05-30 16:40:41', '2024-05-30 16:40:41', 3),
(10, 4, 2, 1, 15000, '2024-05-30 16:40:41', '2024-05-30 16:40:41', 2),
(11, 4, 6, 1, 1999, '2024-05-30 16:40:41', '2024-05-30 16:40:41', 3),
(12, 5, 2, 1, 15000, '2024-05-31 04:38:07', '2024-05-31 04:38:07', 1),
(13, 5, 4, 2, 7000, '2024-05-31 04:38:07', '2024-05-31 04:38:07', 4),
(14, 6, 4, 1, 7000, '2024-06-01 04:26:03', '2024-06-01 04:26:03', 1),
(15, 6, 2, 1, 15000, '2024-06-01 04:26:03', '2024-06-01 04:26:03', 1),
(16, 7, 3, 1, 15000, '2024-06-01 09:24:26', '2024-06-01 09:24:26', 2),
(17, 8, 10, 2, 15000, '2024-06-01 10:06:30', '2024-06-01 10:06:30', 4),
(18, 8, 10, 1, 15000, '2024-06-01 10:06:30', '2024-06-01 10:06:30', 2),
(19, 9, 2, 2, 15000, '2024-06-01 10:14:32', '2024-06-01 10:14:32', 1),
(20, 9, 2, 1, 15000, '2024-06-01 10:14:32', '2024-06-01 10:14:32', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Рубашка из муслина', 'Обновите свой повседневный стиль с этой изысканной рубашкой из муслина. Изготовленная из 100% натурального муслина, эта рубашка обеспечивает не только комфорт на весь день, но и стойкость к износу. Легкий и дышащий материал делает её идеальной для теплых летних дней или как уютный слой под пиджак в прохладную погоду.', '2 999', 'man', '2024-05-15 14:32:13', '2024-05-20 07:05:59'),
(2, 'Бежевые брюки с накладными карманами', 'Брюки наизнанку с карманами наружу с двумя глубокими складками на поясе, уплотнённым поясом и окантовками внутри. Смесовая ткань комфортна в эксплуатации.', '15 000', 'man', '2024-05-15 14:35:30', '2024-05-19 15:34:13'),
(3, 'Серо-черные брюки с накладными карманами', 'Брюки наизнанку с карманами наружу с двумя глубокими складками на поясе, уплотнённым поясом и окантовками внутри. Смесовая ткань комфортна в эксплуатации.', '15 000', 'man', '2024-05-15 14:35:30', '2024-05-19 15:44:21'),
(4, 'Джинсы wide leg со складками', 'Эти джинсы wide leg со складками — это сочетание комфорта и модных тенденций. Идеально подходящие для создания расслабленного, но в то же время стильного образа, они добавят изюминку в ваш повседневный или вечерний наряд.', '7 000', 'woman', '2024-05-15 14:45:44', '2024-05-15 14:45:44'),
(6, 'Футболка мужская', 'Откройте для себя идеальное сочетание стиля и комфорта с мужской футболкой “City Comfort”. Изготовленная из мягкого и дышащего материала, эта футболка обеспечит вам удобство на весь день. Простой, но элегантный дизайн делает её универсальной для любого случая, будь то прогулка по городу или встреча с друзьями. Классический крой и качественный трикотаж гарантируют, что футболка будет выглядеть отлично даже после многократных стирок.', '1 999', 'man', '2024-05-17 05:52:09', '2024-05-17 05:52:09'),
(7, 'Мужская футболка “Maritime Stripe”', 'Футболка с классическими горизонтальными полосами предлагает безупречное сочетание качества и стиля. Изготовленная из 100% натурального хлопка, она обеспечивает максимальный комфорт и долговечность. Полосатый узор придает образу динамичность и является отличным выбором для любого повседневного или кэжуал мероприятия.', '1 999', 'man', '2024-05-17 05:58:01', '2024-05-17 05:58:01'),
(8, 'Футболка “BackTie” с завязкой на спине', 'Футболка “BackTie” с завязкой на спине — это именно то, что добавит изюминку в ваш гардероб. Изготовленная из мягкого и приятного к телу хлопка, эта футболка не только комфортна, но и привлекает внимание уникальным дизайном. Завязки на спине позволяют регулировать посадку по фигуре, а также придают образу оригинальный вид.', '1 999', 'woman', '2024-05-17 06:02:34', '2024-05-17 06:02:34'),
(9, 'Рубашка в фактурную полоску из хлопка', 'Рубашка выполнена из 100% натурального хлопка с фактурным полосатым узором, который добавляет изысканности и глубины вашему образу. Идеально подходит как для офиса, так и для выходных, она сочетает в себе классический стиль и современные модные тенденции. Тонкие полоски на ткани создают утонченный визуальный эффект, который не оставит вас незамеченным.', '3 000', 'woman', '2024-05-17 06:06:28', '2024-05-17 06:06:28'),
(10, 'Голубые брюки с накладными карманами', 'Брюки наизнанку с карманами наружу с двумя глубокими складками на поясе, уплотнённым поясом и окантовками внутри. Смесовая ткань комфортна в эксплуатации.', '15 000', 'man', '2024-05-19 15:28:56', '2024-05-19 15:45:26'),
(11, 'Солнцезащитные очки', 'Солнцезащитные очки — не только стильный аксессуар, но и важный элемент защиты для ваших глаз. Они предназначены для защиты от ультрафиолетовых лучей и яркого солнечного света, что особенно актуально в летний период. Современные модели солнцезащитных очков сочетают в себе функциональность и модные тенденции, предлагая разнообразие форм и цветов.', '20 000', 'woman', '2024-05-20 03:16:14', '2024-05-20 08:03:58'),
(12, 'Джинсы Carpenter', 'Джинсы Carpenter — это классический элемент мужской рабочей одежды, который со временем стал популярным и в повседневной моде. Они отличаются своей универсальностью, долговечностью и комфортом.', '7 000', 'man', '2024-05-20 03:16:50', '2024-05-20 03:24:38'),
(13, 'Ремень женский', 'Этот стильный женский ремень является идеальным аксессуаром для подчеркивания фигуры и добавления изысканности к любому наряду. Изготовленный из качественной кожи, он обеспечивает долговечность и элегантность. Ремень имеет регулируемую длину, что позволяет идеально подогнать его под любой размер. Ширина ремня подходит как для классических брюк, так и для элегантных платьев или юбок. Простая, но элегантная металлическая пряжка добавляет шарм и универсальность, делая этот ремень подходящим как для повседневного, так и для вечернего образа.', '599', 'woman', '2024-05-20 03:17:09', '2024-05-20 03:17:09'),
(14, 'Широкие брюки из вискозы', 'Эти широкие брюки из смесовой вискозы в тонкую вертикальную полоску от Mitica Luna — новинка с высокой посадкой и эластичным поясом. Они обеспечивают комфорт и свободу движений. Мягкая ткань на основе района приятна к телу, а узкая вертикальная полоска делает образ более графичным. Спереди брюки дополнены защипами, создающими небольшие складки.', '11 000', 'woman', '2024-05-20 03:26:17', '2024-05-31 04:47:47'),
(15, 'Джинсы Relaxed', 'Джинсы Relaxed – это надежный элемент гардероба, который всегда будет в тренде и готов подчеркнуть ваш непринужденный стиль. Не забудьте выбрать свой идеальный вариант и наслаждаться комфортом и стилем!', '5 000', 'man', '2024-05-26 18:00:46', '2024-05-26 18:00:46'),
(16, 'Сумка Кросс-боди', 'Сумка кросс-боди – это стильный аксессуар, который носится через плечо, перекрещивая тело. Она обладает длинным ремешком и позволяет полностью освободить руки во время ношения. В отличие от традиционных сумок, кросс-боди может быть разных форм и размеров: от мессенджеров и клатчей до кошельков и торб', '2 599', 'man', '2024-05-27 02:23:10', '2024-05-27 02:23:10');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `created_at`, `updated_at`) VALUES
(1, 'XS', '2024-05-24 07:40:00', '2024-05-24 07:40:00'),
(2, 'S', '2024-05-24 07:40:00', '2024-05-24 07:40:00'),
(3, 'M', '2024-05-24 07:40:35', '2024-05-24 07:40:35'),
(4, 'L', '2024-05-24 07:40:35', '2024-05-24 07:40:35'),
(5, 'XL', '2024-05-24 07:40:55', '2024-05-24 07:40:55');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `phone`, `birthday`, `is_admin`) VALUES
(25, 'Администратор', 'admin@admin.com', '$2y$10$6lIJM3IR8Q86vlcWG0F.JuaCrdpLjbLO9evvxG8OM4D.sjYhE.jem', '2024-05-16 10:37:14', '2024-05-30 13:14:27', '+79782450453', '2004-05-08', 1),
(26, 'Тимур', 'halikov20033@gmail.com', '$2y$10$vOasoGmm5HYFrSngPSSesOO9xuaI1FRvSRfw2lGN7EVvEwcuoyVZO', '2024-05-16 14:04:37', '2024-06-01 10:15:29', '+79782450453', '2004-05-08', 0),
(28, 'Максимка', 'maxim@example.com', '$2y$10$f4FXe45UwYQ7jAM8glsYpexFYy0MAAtf3sGpiPeizu2ssGmNtMmTS', '2024-05-31 04:30:08', '2024-05-31 04:31:13', '+79788929616', '2004-05-08', 0),
(29, 'Максим', 'test@test.com', '$2y$10$bWI6MyXci7yAKrISLrO4EeWmt3FZbxa9qeumiTrAvBgXEr.bmvzJW', '2024-06-01 09:21:12', '2024-06-01 09:21:12', '+79782450453', '2004-05-08', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_size_id_foreign` (`size_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Индексы таблицы `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`),
  ADD KEY `category_product_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_size_id_foreign` (`size_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
