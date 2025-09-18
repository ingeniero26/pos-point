-- --------------------------------------------------------
-- Host:                         198.23.187.158
-- Versión del servidor:         10.11.13-MariaDB-0ubuntu0.24.04.1 - Ubuntu 24.04
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para larabooks_dev
CREATE DATABASE IF NOT EXISTS `larabooks_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `larabooks_dev`;

-- Volcando estructura para tabla larabooks_dev.academic_years
CREATE TABLE IF NOT EXISTS `academic_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `enrollment_start_date` date NOT NULL COMMENT 'fecha inicio matriculas',
  `enrollment_end_date` date NOT NULL COMMENT 'fin matriculas',
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_enrollment_open` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Matrícula abierta',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `year` (`year`),
  UNIQUE KEY `uk_academic_year` (`year`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Años académicos';

-- Volcando datos para la tabla larabooks_dev.academic_years: ~1 rows (aproximadamente)
INSERT INTO `academic_years` (`id`, `year`, `name`, `start_date`, `end_date`, `enrollment_start_date`, `enrollment_end_date`, `is_current`, `is_enrollment_open`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(2, '2025', 'Año Académico 2025', '2025-07-12', '2025-12-20', '2025-07-12', '2025-08-12', 1, 1, 1, 0, 1, '2025-07-14 05:51:01', '2025-07-14 22:42:59');

-- Volcando estructura para tabla larabooks_dev.advertising_media
CREATE TABLE IF NOT EXISTS `advertising_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='medios para  publicidad';

-- Volcando datos para la tabla larabooks_dev.advertising_media: ~4 rows (aproximadamente)
INSERT INTO `advertising_media` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Redes Sociales', 'redes educativas', 1, 0, 0, '2024-11-26 02:13:33', '2024-11-26 02:13:34'),
	(2, 'Emisoras', 'Publicidad por  emisoras', 1, 0, 0, '2024-11-26 07:24:37', '2024-11-26 07:24:37'),
	(3, 'Emisoras', 'Publicidad por  emisoras', 1, 0, 1, '2024-11-26 07:26:01', '2024-12-03 01:45:11'),
	(4, 'testtestte', 'test', 1, 0, 1, '2024-11-26 07:26:41', '2024-11-26 07:33:09');

-- Volcando estructura para tabla larabooks_dev.assign_class_teacher
CREATE TABLE IF NOT EXISTS `assign_class_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.assign_class_teacher: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `meta_description` varchar(512) DEFAULT NULL,
  `meta_keywords` varchar(512) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_publish` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='blogs para frontend';

-- Volcando datos para la tabla larabooks_dev.blog: ~5 rows (aproximadamente)
INSERT INTO `blog` (`id`, `title`, `slug`, `category_id`, `image_file`, `description`, `meta_description`, `meta_keywords`, `created_by`, `status`, `is_publish`, `is_delete`, `created_at`, `updated_at`) VALUES
	(16, 'Desarrollo web', 'desarrollo-web', 5, '20240926044724rgdhligy4bh44esjel8a.jpg', '<p>desarrollos&nbsp;<br></p>', 'desarrollos', 'desarrollos', 1, 0, 1, 0, '2024-09-26 14:47:23', '2024-09-26 14:47:24'),
	(17, 'Sistemas hibridos', 'sistemas-hibridos', 5, 'sistemas-hibridos.jpg', 'Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar', 'Sistemas hibridos', 'Sistemas hibridos', 1, 0, 1, 0, '2024-09-26 14:48:52', '2024-09-26 19:11:08'),
	(18, 'Programacion web', 'programacion-web', 2, 'programacion-web.jpg', '<p>hola esto es una prueba</p>', 'hola esto es una prueba', 'hola esto es una prueba', 1, 0, 1, 0, '2024-09-27 11:13:34', '2024-09-27 11:13:34'),
	(19, 'SISTEMAS COMPUTACIONALES', 'sistemas-computacionales', 4, 'sistemas-computacionales.jpg', 'Molestiae cupiditate inventore animi, maxime sapiente optio, illo est nemo veritatis repellat sunt doloribus nesciunt! Minima laborum magni reiciendis qui voluptate quisquam voluptatem soluta illo eum ullam incidunt rem assumenda eveniet eaque sequi delen', 'SISTEMAS', 'Lorem ipsum', 1, 0, 1, 0, '2024-09-27 11:17:00', '2024-09-27 14:16:07'),
	(20, 'desarrollo java junior', 'desarrollo-java-junior', 7, 'desarrollo-java-junior.jpg', '<p>desarrollo de sistemas  en java</p>', 'java', 'test test', 1, 0, 1, 0, '2024-09-27 15:58:44', '2024-09-27 16:43:10');

-- Volcando estructura para tabla larabooks_dev.blog_comment
CREATE TABLE IF NOT EXISTS `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.blog_comment: ~8 rows (aproximadamente)
INSERT INTO `blog_comment` (`id`, `user_id`, `blog_id`, `name`, `email`, `comment`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 1, 18, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?', 1, '2024-09-30 23:44:37', '2024-12-19 21:22:07'),
	(2, 1, 18, NULL, NULL, 'hola este un comentario nuevo', 1, '2024-12-19 20:31:00', '2024-12-19 21:22:55'),
	(3, 1, 18, NULL, NULL, 'otro comentario', 1, '2024-12-19 21:00:01', '2024-12-19 21:23:00'),
	(4, 1, 17, NULL, NULL, 'comentario nuevo', 1, '2024-12-19 21:01:33', '2024-12-23 21:09:08'),
	(5, 1, 17, NULL, NULL, 'HOLA ESTO UN COMENTARIO DE ESTE BLOG', 1, '2024-12-19 21:12:30', '2024-12-23 21:10:32'),
	(6, 1, 17, 'Jerson', 'ingjerson2014@gmail.com', 'otra prueba', 0, '2024-12-19 21:13:57', '2024-12-19 21:13:57'),
	(7, 40, 18, 'test', 'jair@gmail.com', 'deseo saber mas del programa', 1, '2024-12-19 21:16:34', '2024-12-23 21:10:38'),
	(8, NULL, 20, 'Elizabeth', 'daniel123@gmail.com', 'hola', 0, '2024-12-23 20:53:01', '2024-12-23 20:53:01');

-- Volcando estructura para tabla larabooks_dev.blog_tags
CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.blog_tags: ~10 rows (aproximadamente)
INSERT INTO `blog_tags` (`id`, `blog_id`, `name`, `created_at`, `updated_at`) VALUES
	(29, 17, 'POO', '2024-09-26 19:31:18', '2024-09-26 19:31:18'),
	(30, 17, 'JAVA', '2024-09-26 19:31:19', '2024-09-26 19:31:19'),
	(31, 19, 'SISTEMAS', '2024-09-27 14:16:08', '2024-09-27 14:16:08'),
	(32, 19, 'PHP', '2024-09-27 14:16:08', '2024-09-27 14:16:08'),
	(33, 19, 'JAVA', '2024-09-27 14:16:08', '2024-09-27 14:16:08'),
	(34, 19, 'WEB', '2024-09-27 14:16:08', '2024-09-27 14:16:08'),
	(35, 20, 'java', '2024-09-27 16:43:10', '2024-09-27 16:43:10'),
	(36, 20, 'php', '2024-09-27 16:43:10', '2024-09-27 16:43:10'),
	(37, 20, 'db', '2024-09-27 16:43:10', '2024-09-27 16:43:10'),
	(38, 20, 'backend', '2024-09-27 16:43:10', '2024-09-27 16:43:10');

-- Volcando estructura para tabla larabooks_dev.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_menu` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='categorias del blog';

-- Volcando datos para la tabla larabooks_dev.categories: ~6 rows (aproximadamente)
INSERT INTO `categories` (`id`, `name`, `slug`, `title`, `meta_title`, `meta_description`, `meta_keywords`, `created_by`, `status`, `is_menu`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Lorem Ipsum', 'lorem-ipsum', 'Desarrollo web', 'Desarrollo web', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.', 'test test', 1, 0, 0, 1, '2024-09-15 13:14:21', '2024-09-25 23:48:42'),
	(2, 'Diseño Mobile', 'test2-test2', 'test', 'Desarrollo', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.', 'Lorem ipsum', 1, 0, 0, 0, '2024-09-15 20:23:50', '2024-09-15 22:36:10'),
	(4, 'Desarrollo web', 'desarrollo-web', 'Desarrollo web', 'Desarrollo web', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.', 'Desarrollo web', 1, 0, 0, 0, '2024-09-17 13:30:12', '2024-09-17 13:30:12'),
	(5, 'Servidores AWS', 'servidores-aws', 'Servidores', 'Servidores', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.', 'Servidores', 1, 0, 0, 0, '2024-09-17 19:15:34', '2024-09-17 19:15:34'),
	(6, 'SERVICIOS PROFESIONALES', 'servicios-profesionales', 'SERVICIOS PROFESIONALES', 'SERVICIOS PROFESIONALES', 'SERVICIOS PROFESIONALES', 'SERVICIOS PROFESIONALES', 1, 0, 0, 0, '2024-09-19 14:20:31', '2024-09-19 14:20:31'),
	(7, 'DESARROLLO BACKEND', 'desarrollo-backend', 'DESARROLLO BACKEND', 'DESARROLLO BACKEND', 'DESARROLLO BACKEND', 'DESARROLLO BACKEND', 1, 0, 0, 0, '2024-09-27 15:55:18', '2024-09-27 15:55:18');

-- Volcando estructura para tabla larabooks_dev.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_date` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.chat: ~34 rows (aproximadamente)
INSERT INTO `chat` (`id`, `sender_id`, `receiver_id`, `message`, `file`, `status`, `created_date`, `created_at`, `updated_at`) VALUES
	(1, 1, 14, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker', NULL, 0, NULL, '2024-07-15 22:16:09', '2024-07-15 22:16:09'),
	(2, 1, 14, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ej', NULL, 0, 1721089244, '2024-07-15 22:20:44', '2024-07-15 22:20:44'),
	(3, 1, 21, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', NULL, 0, 1721089324, '2024-07-15 22:22:04', '2024-07-22 17:35:55'),
	(4, 1, 21, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus Pag', NULL, 0, 1721242961, '2024-07-17 17:02:41', '2024-07-22 17:35:55'),
	(5, 1, 21, 'otra prueba para ver la hora exacta', NULL, 0, 1721248988, '2024-07-17 18:43:08', '2024-07-22 17:35:55'),
	(6, 21, 1, 'testeando el chat', NULL, 0, NULL, NULL, '2024-07-22 17:35:08'),
	(7, 1, 21, 'hola', NULL, 0, 1721255294, '2024-07-17 20:28:14', '2024-07-22 17:35:55'),
	(8, 1, 21, 'hola', NULL, 0, 1721255392, '2024-07-17 20:29:52', '2024-07-22 17:35:55'),
	(9, 1, 21, 'hola dos', NULL, 0, 1721258581, '2024-07-17 21:23:01', '2024-07-22 17:35:55'),
	(10, 1, 21, 'hola', NULL, 0, 1721258802, '2024-07-17 21:26:42', '2024-07-22 17:35:55'),
	(11, 1, 21, 'hola', NULL, 0, 1721259055, '2024-07-17 21:30:55', '2024-07-22 17:35:55'),
	(12, 1, 14, 'test', NULL, 0, 1721307555, '2024-07-18 10:59:15', '2024-07-18 10:59:15'),
	(13, 1, 23, 'test', NULL, 0, 1721307688, '2024-07-18 11:01:28', '2024-07-18 11:01:28'),
	(14, 1, 22, 'pruebas del sistema', NULL, 0, 1721314583, '2024-07-18 12:56:23', '2024-07-22 17:37:16'),
	(15, 1, 22, 'test', NULL, 0, 1721664001, '2024-07-22 14:00:01', '2024-07-22 17:37:16'),
	(16, 1, 20, 'test de pruebas', NULL, 0, 1721664741, '2024-07-22 14:12:21', '2024-07-22 14:12:21'),
	(17, 1, 14, 'hola', NULL, 0, 1721668114, '2024-07-22 15:08:34', '2024-07-22 15:08:34'),
	(18, 22, 1, 'desde otro modulo', NULL, 1, 1721668419, '2024-07-22 15:13:39', '2024-09-18 23:32:07'),
	(19, 1, 22, 'hola esto es  una prueba', NULL, 0, 1721677104, '2024-07-22 17:38:24', '2024-07-22 17:38:33'),
	(20, 1, 21, 'hols', NULL, 0, 1721766851, '2024-07-23 18:34:11', '2024-07-23 18:34:11'),
	(21, 1, 14, 'hola', NULL, 0, 1721766872, '2024-07-23 18:34:32', '2024-07-23 18:34:32'),
	(22, 1, 30, 'test', NULL, 0, 1726696485, '2024-09-18 19:54:45', '2024-09-18 19:55:17'),
	(23, 30, 1, 'test 2', NULL, 1, 1726696524, '2024-09-18 19:55:24', '2024-09-18 23:31:57'),
	(24, 30, 1, 'test', NULL, 1, 1726696918, '2024-09-18 20:01:58', '2024-09-18 23:31:57'),
	(25, 30, 1, 'test', NULL, 1, 1726697020, '2024-09-18 20:03:40', '2024-09-18 23:31:57'),
	(26, 1, 30, 'test', NULL, 0, 1726697783, '2024-09-18 20:16:23', '2024-09-18 20:17:17'),
	(27, 30, 1, 'test', NULL, 1, 1726697794, '2024-09-18 20:16:34', '2024-09-18 23:31:57'),
	(28, 1, 30, 'hola', '20240919120558m0sespzuqvdviovkvkav.pdf', 0, 1726704358, '2024-09-18 22:05:58', '2024-09-18 22:05:58'),
	(29, 1, 30, 'holaaaa', '202409191222497b0abpi7p4a2d1okh23o.jpeg', 0, 1726705369, '2024-09-18 22:22:49', '2024-09-18 22:22:49'),
	(30, 1, 23, '??', NULL, 0, 1726748641, '2024-09-19 10:24:01', '2024-09-19 10:24:01'),
	(31, 1, 23, '? ddfffd?eee', NULL, 0, 1726748706, '2024-09-19 10:25:06', '2024-09-19 10:25:06'),
	(32, 1, 23, '?sdsds', NULL, 0, 1726748804, '2024-09-19 10:26:44', '2024-09-19 10:26:44'),
	(33, 1, 23, '?ddd', NULL, 0, 1726749001, '2024-09-19 10:30:01', '2024-09-19 10:30:01'),
	(34, 1, 23, 'ddd', NULL, 0, 1726749016, '2024-09-19 10:30:16', '2024-09-19 10:30:16');

-- Volcando estructura para tabla larabooks_dev.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ciudades';

-- Volcando datos para la tabla larabooks_dev.cities: ~4 rows (aproximadamente)
INSERT INTO `cities` (`id`, `name`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'EL CARMEN DE BOLIVAR', 1, 0, 0, '2024-11-04 19:13:31', '2024-11-04 19:13:33'),
	(2, 'MAHATES', 1, 0, 0, '2024-11-04 19:13:50', '2024-11-04 19:13:51'),
	(3, 'San Juan Nepomuceno', 1, 0, 0, '2024-11-04 18:32:31', '2024-11-04 18:32:31'),
	(4, 'San Juan Nepomuceno', 1, 0, 1, '2024-11-04 18:34:08', '2024-11-04 18:36:44');

-- Volcando estructura para tabla larabooks_dev.class
CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headquater_id` int(11) DEFAULT NULL COMMENT 'codigo sede',
  `name` varchar(250) DEFAULT NULL,
  `program_type` enum('1','2','3') DEFAULT NULL,
  `amount` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0 COMMENT '0,no, 1:si',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='programas';

-- Volcando datos para la tabla larabooks_dev.class: ~11 rows (aproximadamente)
INSERT INTO `class` (`id`, `headquater_id`, `name`, `program_type`, `amount`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(11, 3, 'Auxiliar Contable', '3', 450000, 1, 0, 1, '2024-03-01 10:28:04', '2024-04-28 08:01:09'),
	(12, 3, 'Auxiliar Administrativo', '3', 450000, 1, 0, 1, '2024-03-01 10:28:16', '2024-04-28 08:01:18'),
	(13, 3, 'Caja Registradora', '2', 350000, 1, 0, 1, '2024-03-01 10:28:32', '2024-04-28 08:00:46'),
	(14, 3, 'Mercadeo  y Ventas', '2', 500000, 1, 0, 1, '2024-03-01 10:28:45', '2024-04-28 08:00:24'),
	(15, 3, 'Auxiliar de Enfermeria', '3', 500000, 1, 0, 1, '2024-03-01 10:29:04', '2024-04-28 08:08:17'),
	(16, 1, 'Ingles', '2', 450000, 1, 0, 1, '2024-03-01 10:29:13', '2024-04-28 08:08:00'),
	(17, 3, 'Mecanica de Motos', '2', 350000, 1, 0, 1, '2024-04-28 07:59:36', '2024-04-28 08:07:49'),
	(18, 3, 'Auxiliar Psicología infantil', '3', 450000, 1, 0, 1, '2024-06-09 13:59:22', '2024-06-09 13:59:22'),
	(19, 3, 'Belleza Integral', '2', 600000, 1, 0, 1, '2024-09-23 11:48:11', '2024-09-23 11:48:11'),
	(20, 3, 'Auxiliar  Salud Ocupacional', '3', 500000, 1, 0, 1, '2024-10-25 19:51:16', '2024-10-25 19:51:16'),
	(21, 1, 'Validación Bachillerato(10 y 11)', '1', 450000, 1, 0, 1, '2025-08-05 01:05:10', '2025-08-05 01:18:48');

-- Volcando estructura para tabla larabooks_dev.class_subject
CREATE TABLE IF NOT EXISTS `class_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `headquarter_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.class_subject: ~20 rows (aproximadamente)
INSERT INTO `class_subject` (`id`, `class_id`, `exam_id`, `subject_id`, `headquarter_id`, `created_by`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
	(61, 21, 7, 50, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(62, 21, 7, 52, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(63, 21, 7, 25, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(64, 21, 7, 53, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(65, 21, 7, 26, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(66, 21, 7, 49, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(67, 21, 7, 51, 1, 1, 0, 1, '2025-08-05 01:41:21', '2025-08-05 01:41:21'),
	(68, 12, 2, 44, 3, 1, 0, 1, '2025-09-06 17:15:37', '2025-09-06 17:15:37'),
	(69, 12, 2, 36, 3, 1, 0, 1, '2025-09-06 17:15:37', '2025-09-06 17:15:37'),
	(70, 12, 2, 33, 3, 1, 0, 1, '2025-09-06 17:15:37', '2025-09-06 17:15:37'),
	(71, 12, 2, 48, 3, 1, 0, 1, '2025-09-06 17:15:37', '2025-09-06 17:15:37'),
	(72, 12, 2, 39, 3, 1, 0, 1, '2025-09-06 17:15:37', '2025-09-06 17:15:37'),
	(73, 11, 2, 44, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(74, 11, 2, 36, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(75, 11, 2, 32, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(76, 11, 2, 33, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(77, 11, 2, 48, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(78, 11, 2, 39, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(79, 11, 2, 34, 3, 1, 0, 1, '2025-09-06 17:23:47', '2025-09-06 17:23:47'),
	(80, 21, 7, 54, 1, 1, 0, 1, '2025-09-09 14:24:55', '2025-09-09 14:24:55');

-- Volcando estructura para tabla larabooks_dev.class_subject_timetable
CREATE TABLE IF NOT EXISTS `class_subject_timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `week_id` int(11) DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.class_subject_timetable: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.contacts: ~1 rows (aproximadamente)
INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
	(2, 'Jerson', 'besasam327@binafex.com', 'Introduccion a la contabilidad', 'Deseo conocer mas sobre el modulo contabilidad', '2025-09-15 12:53:43', '2025-09-15 12:53:43');

-- Volcando estructura para tabla larabooks_dev.enrollment_applications
CREATE TABLE IF NOT EXISTS `enrollment_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_number` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `period_academic_id` int(11) NOT NULL,
  `headquarter_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `journey_id` int(11) NOT NULL,
  `application_date` timestamp NULL DEFAULT current_timestamp(),
  `application_status` enum('draft','submitted','under_review','approved','rejected','cancelled') DEFAULT 'draft',
  `priority_level` enum('normal','high','urgent') DEFAULT 'normal',
  `is_transfer_student` tinyint(1) DEFAULT 0,
  `previous_institution` varchar(255) DEFAULT NULL,
  `transfer_reason` text DEFAULT NULL,
  `documents_complete` tinyint(1) DEFAULT 0,
  `documents_verified` tinyint(1) DEFAULT 0,
  `payment_complete` tinyint(1) DEFAULT 0,
  `interview_required` tinyint(1) DEFAULT 0,
  `interview_date` datetime DEFAULT NULL,
  `interview_status` enum('pending','scheduled','completed','cancelled') DEFAULT 'pending',
  `interview_notes` text DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `rejection_date` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `special_notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_application_number` (`application_number`),
  KEY `idx_student_period` (`student_id`,`period_academic_id`),
  KEY `idx_status` (`application_status`),
  KEY `idx_class_headquarter` (`class_id`,`headquarter_id`),
  KEY `idx_application_date` (`application_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Solicitudes de matrícula';

-- Volcando datos para la tabla larabooks_dev.enrollment_applications: ~2 rows (aproximadamente)
INSERT INTO `enrollment_applications` (`id`, `application_number`, `student_id`, `academic_year_id`, `period_academic_id`, `headquarter_id`, `class_id`, `journey_id`, `application_date`, `application_status`, `priority_level`, `is_transfer_student`, `previous_institution`, `transfer_reason`, `documents_complete`, `documents_verified`, `payment_complete`, `interview_required`, `interview_date`, `interview_status`, `interview_notes`, `approval_date`, `approved_by`, `rejection_date`, `rejection_reason`, `rejected_by`, `special_notes`, `created_by`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'APP-2025-0001', 51, 2, 1, 3, 12, 6, '2025-07-16 01:12:48', 'draft', 'normal', 0, NULL, NULL, 0, 0, 0, 0, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'pruebas del sistema', 1, 0, '2025-07-16 06:12:48', '2025-07-16 06:12:48'),
	(2, 'APP-2025-0002', 24, 2, 1, 3, 12, 6, '2025-07-16 02:33:29', 'draft', 'normal', 0, NULL, NULL, 0, 0, 0, 0, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-07-16 07:33:29', '2025-07-16 07:33:29');

-- Volcando estructura para tabla larabooks_dev.enrollment_requirements
CREATE TABLE IF NOT EXISTS `enrollment_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `document_type` enum('academic','personal','medical','financial','legal','other') DEFAULT 'other',
  `is_required` tinyint(1) DEFAULT 1,
  `applies_to_user_type` tinyint(1) DEFAULT 3 COMMENT '3=estudiante, 2=docente, etc.',
  `applies_to_class_id` int(11) DEFAULT NULL COMMENT 'NULL = aplica a todas las clases',
  `applies_to_headquarter_id` int(11) DEFAULT NULL COMMENT 'NULL = aplica a todas las sedes',
  `file_extensions_allowed` varchar(100) DEFAULT 'pdf,jpg,jpeg,png,doc,docx',
  `max_file_size_mb` int(3) DEFAULT 5,
  `display_order` int(3) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `applies_to_headquarter_id` (`applies_to_headquarter_id`),
  KEY `idx_user_type` (`applies_to_user_type`),
  KEY `idx_class_headquarter` (`applies_to_class_id`,`applies_to_headquarter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Requisitos para matrícula';

-- Volcando datos para la tabla larabooks_dev.enrollment_requirements: ~4 rows (aproximadamente)
INSERT INTO `enrollment_requirements` (`id`, `name`, `description`, `document_type`, `is_required`, `applies_to_user_type`, `applies_to_class_id`, `applies_to_headquarter_id`, `file_extensions_allowed`, `max_file_size_mb`, `display_order`, `status`, `is_active`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Registro de Matricula', 'Es el  formulario de llenado de matricula', 'academic', 0, 3, NULL, NULL, 'pdf', 5, 0, 1, 1, 0, 1, '2025-07-15 17:52:27', '2025-07-15 17:52:27'),
	(2, 'Cedula de Ciudadania', 'Documento de identidad', 'personal', 0, 3, NULL, NULL, 'pdf', 5, 0, 1, 1, 0, 1, '2025-07-15 19:02:01', '2025-07-15 19:02:01'),
	(3, 'Certificado de notas', 'si es estudiante de otra entidad', 'academic', 0, 3, NULL, NULL, 'pdf', 5, 0, 1, 1, 0, 1, '2025-07-17 21:58:59', '2025-07-17 21:58:59'),
	(4, 'Acta de grado', 'Para estudiantes graduados', 'academic', 0, 3, NULL, NULL, 'pdf,jpg,jpeg,png,doc,docx', 5, 0, 1, 1, 0, 1, '2025-07-19 19:43:46', '2025-07-19 19:43:46');

-- Volcando estructura para tabla larabooks_dev.exam
CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 1,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.exam: ~6 rows (aproximadamente)
INSERT INTO `exam` (`id`, `name`, `note`, `start_date`, `end_date`, `created_by`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Quinto Ciclo 2024', 'Ciclo No 5 Semestre 1', NULL, NULL, 1, 0, 1, '2024-01-31 06:47:13', '2024-02-29 11:43:19'),
	(2, 'Cuarto Semestre', 'Ciclo No 4 Semestre 1', NULL, NULL, 1, 0, 1, '2024-02-02 10:41:00', '2024-03-01 10:16:05'),
	(3, 'Tercer Semestre', 'Ciclo N3 -Semestre I', NULL, NULL, 1, 0, 1, '2024-02-02 11:54:47', '2024-03-01 10:15:54'),
	(4, 'Segundo Semestre', 'Ciclo No 2  Primer Semestre', NULL, NULL, 1, 0, 1, '2024-02-02 15:50:21', '2024-03-01 10:15:41'),
	(6, 'Primer Semestre', 'Ciclo No -Semestre I', NULL, NULL, 1, 0, 1, '2024-02-12 06:17:34', '2024-03-01 10:15:28'),
	(7, 'Ciclo-Validacion', 'ciclo especial bachillerato', NULL, NULL, 1, 0, 1, '2025-08-05 01:38:50', '2025-08-05 01:38:50');

-- Volcando estructura para tabla larabooks_dev.exam_schedule
CREATE TABLE IF NOT EXISTS `exam_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `full_marks` varchar(50) DEFAULT NULL,
  `passing_mark` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.exam_schedule: ~19 rows (aproximadamente)
INSERT INTO `exam_schedule` (`id`, `exam_id`, `class_id`, `subject_id`, `exam_date`, `start_time`, `end_time`, `room_number`, `full_marks`, `passing_mark`, `created_by`, `created_at`, `updated_at`) VALUES
	(10, 2, 12, 39, '2025-12-20', '20:00', '12:17', '1', '5', '3.2', 1, '2025-09-06 17:20:16', '2025-09-06 17:20:16'),
	(11, 2, 12, 48, '2025-12-20', '20:00', '12:19', '1', '5', '3.2', 1, '2025-09-06 17:20:16', '2025-09-06 17:20:16'),
	(12, 2, 12, 33, '2025-12-20', '20:01', '12:20', '1', '5', '3.2', 1, '2025-09-06 17:20:16', '2025-09-06 17:20:16'),
	(13, 2, 12, 36, '2025-12-20', '20:00', '12:18', '1', '5', '3.2', 1, '2025-09-06 17:20:16', '2025-09-06 17:20:16'),
	(14, 2, 12, 44, '2025-12-20', '20:00', '12:17', '1', '5', '3.2', 1, '2025-09-06 17:20:16', '2025-09-06 17:20:16'),
	(15, 2, 11, 34, '2025-12-20', '20:00', '12:28', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(16, 2, 11, 39, '2025-12-20', '20:00', '12:26', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(17, 2, 11, 48, '2025-12-20', '20:00', '12:24', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(18, 2, 11, 33, '2025-12-20', '20:00', '12:27', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(19, 2, 11, 32, '2025-12-20', '20:00', '12:26', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(20, 2, 11, 36, '2025-09-06', '20:00', '12:28', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(21, 2, 11, 44, '2025-12-20', '20:00', '12:25', '1', '5', '3.2', 1, '2025-09-06 17:28:50', '2025-09-06 17:28:50'),
	(38, 7, 21, 54, '2025-10-30', '08:00', '12:00', '1', '20', '3.2', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(39, 7, 21, 51, '2025-10-31', '08:00', '12:00', '1', '20', '3.2', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(40, 7, 21, 49, '2025-10-31', '08:00', '10:00', '1', '20', '3.5', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(41, 7, 21, 26, '2025-10-31', '08:00', '10:00', '1', '20', '3.5', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(42, 7, 21, 53, '2025-10-31', '08:00', '10:00', '1', '20', '3.5', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(43, 7, 21, 25, '2025-10-31', '08:00', '10:00', '1', '20', '3.5', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03'),
	(44, 7, 21, 52, '2025-10-31', '08:00', '10:00', '1', '20', '3.5', 1, '2025-09-09 18:41:03', '2025-09-09 18:41:03');

-- Volcando estructura para tabla larabooks_dev.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.headquarters
CREATE TABLE IF NOT EXISTS `headquarters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.headquarters: ~3 rows (aproximadamente)
INSERT INTO `headquarters` (`id`, `name`, `address`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'SEDE PRINCIPAL', 'EL CARMEN DE BOLIVAR', 1, 0, 1, '2023-12-30 09:45:13', '2023-12-30 09:45:13'),
	(2, 'SEDE DOS', 'SAN JACINTO BOLIVAR', 1, 0, 1, '2023-12-30 10:09:00', '2023-12-30 10:16:43'),
	(3, 'Mahates', 'Municipio de Mahates Bolivar', 1, 0, 1, '2024-01-09 07:30:47', '2024-01-09 07:34:50');

-- Volcando estructura para tabla larabooks_dev.homework
CREATE TABLE IF NOT EXISTS `homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `homework_date` date DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `document_file` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.homework: ~12 rows (aproximadamente)
INSERT INTO `homework` (`id`, `class_id`, `subject_id`, `homework_date`, `submission_date`, `document_file`, `description`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 12, 20, '2024-03-30', '2024-04-06', NULL, 'prueba de tarea', 1, 1, '2024-03-30 08:11:06', '2024-03-30 10:50:29'),
	(2, 12, 20, '2024-03-31', '2024-04-07', '202403300316192pu4mukjfd3wdbig1tzv.pdf', '&nbsp;testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', 1, 1, '2024-03-30 08:16:19', '2025-08-05 17:06:01'),
	(3, 11, 21, '2024-03-31', '2024-04-07', '20240331071902imbbqlqkij4rfglyl95a.pdf', 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', 1, 1, '2024-03-31 10:19:02', '2025-08-05 17:06:08'),
	(4, 12, 31, '2024-04-01', '2024-04-09', '202404010402499bipzgoflaigmt2irsfs.pdf', 'test&nbsp;', 1, 1, '2024-04-01 07:02:49', '2025-08-05 17:06:13'),
	(5, 12, 27, '2024-04-05', '2024-04-06', '20240405110722lmnfyinb6lz1kxslckxe.pdf', 'test&nbsp;', 0, 3, '2024-04-05 09:35:41', '2024-04-05 14:07:22'),
	(6, 12, 19, '2024-04-05', '2024-04-06', NULL, 'test', 1, 3, '2024-04-05 09:37:08', '2024-04-05 13:53:06'),
	(7, 12, 25, '2024-04-05', '2024-04-12', NULL, 'Taller 01', 1, 3, '2024-04-05 13:42:07', '2024-04-05 13:53:01'),
	(8, 12, 36, '2024-07-30', '2024-08-06', NULL, 'tarea de ejemplo', 1, 1, '2024-07-30 13:42:44', '2025-08-05 17:06:18'),
	(9, 21, 49, '2025-08-05', '2025-08-12', '20250805051329tqlfir51g7wv0xsdbxto.pdf', 'Actividad de algebra&nbsp;', 1, 1, '2025-08-05 17:13:29', '2025-08-11 16:36:39'),
	(10, 21, 49, '2025-08-05', '2025-08-15', '20250811043752qcpjllawy6smnw6dyu1z.pdf', 'Tarea de algebra', 0, 1, '2025-08-11 16:37:52', '2025-08-11 16:37:52'),
	(11, 21, 52, '2025-09-09', '2025-09-09', NULL, 'Investigrar&nbsp;<ul jscontroller="M2ABbc" jsaction="jZtoLb:SaHfyb" data-hveid="CB4QAQ" data-ved="2ahUKEwiJtPTnqsyPAxULSjABHaSEOMkQm_YKegQIHhAB" style="margin: 10px 0px 20px; padding: 0px; line-height: 24px; padding-inline-start: 24px; color: rgb(238, 240, 255); font-family: &quot;Google Sans&quot;, Arial, sans-serif; background-color: rgb(31, 31, 31);"><li style="margin: 0px 0px 8px; padding: 0px 0px 0px 4px; list-style: inherit;"><div class="zMgcWd dSKvsb" data-il="" style="padding-bottom: 0px; padding-top: 0px; border-bottom: none;"><div data-crb-p=""><div class="xFTqob" style="flex: 1 1 0%; min-width: 0px;"><div class="Gur8Ad" style="line-height: 24px; overflow: hidden; padding-bottom: 4px; transition: transform 200ms cubic-bezier(0.2, 0, 0, 1); display: inline;"><span data-huuid="1006454400225816354"><strong>El Estado y la Economía, y como el estado interviene en la economía&nbsp;</strong></span></div></div></div></div></li></ul>', 1, 1, '2025-09-09 18:45:36', '2025-09-09 18:46:20'),
	(12, 21, 52, '2025-09-09', '2025-09-16', NULL, '<p>Investigar que es la economía y el estado</p><p>como se relaciona economía con la política&nbsp;</p>', 0, 1, '2025-09-09 18:49:08', '2025-09-09 18:49:08');

-- Volcando estructura para tabla larabooks_dev.homework_submit
CREATE TABLE IF NOT EXISTS `homework_submit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `homework_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `document_file` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.homework_submit: ~2 rows (aproximadamente)
INSERT INTO `homework_submit` (`id`, `homework_id`, `student_id`, `description`, `document_file`, `created_at`, `updated_at`) VALUES
	(8, 9, 56, '', '20250810062602vgyumg6kntolaeepi6cd.pdf', '2025-08-10 18:26:02', '2025-08-10 18:26:02'),
	(9, 10, 56, '', '20250812124308hfqmb9elgigjpjqlj5ou.pdf', '2025-08-12 00:43:08', '2025-08-12 00:43:08');

-- Volcando estructura para tabla larabooks_dev.institutions
CREATE TABLE IF NOT EXISTS `institutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(250) DEFAULT NULL,
  `exam_description` varchar(250) DEFAULT NULL,
  `operating_license` varchar(250) DEFAULT NULL,
  `legal_representative` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `paypal_email` varchar(250) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon_icon` varchar(255) DEFAULT NULL COMMENT '1:activa,2:inactiva',
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='configuraciones pasarelas de pagos';

-- Volcando datos para la tabla larabooks_dev.institutions: ~1 rows (aproximadamente)
INSERT INTO `institutions` (`id`, `school_name`, `exam_description`, `operating_license`, `legal_representative`, `address`, `phone`, `paypal_email`, `logo`, `favicon_icon`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'UNITEC', 'Comprometidos con la educacion', '0113', 'Franklin Fernandez', 'EL CARMEN DE BOLIVAR', NULL, 'ingjerson2014@gmail.com', '20241024044800ggarhaqowt1tnrg0ctfd.jfif', '20241024044800gau9olcatwusqnfkbaye.jfif', 1, '2024-12-22 20:54:46', '2024-12-22 20:54:48');

-- Volcando estructura para tabla larabooks_dev.journeys
CREATE TABLE IF NOT EXISTS `journeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `abbreviation` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.journeys: ~6 rows (aproximadamente)
INSERT INTO `journeys` (`id`, `name`, `abbreviation`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Lunes Mañana', 'LM', 0, 0, 1, '2023-12-14 07:19:51', '2023-12-14 07:19:51'),
	(2, 'Sabado Tarde', 'ST', 0, 0, 1, '2023-12-14 11:37:17', '2023-12-14 11:37:17'),
	(3, 'eliminar antes editar', NULL, 0, 1, 1, '2023-12-14 11:37:29', '2023-12-14 11:37:46'),
	(4, 'Viernes Mañana', 'VM', 0, 0, 1, '2023-12-14 18:03:03', '2023-12-14 18:06:05'),
	(5, 'Domingo Mañana', 'DM', 0, 0, 1, '2023-12-31 11:52:15', '2023-12-31 11:52:15'),
	(6, 'Sabado Mañana', 'SM', 0, 0, 1, '2024-09-23 14:55:09', '2024-09-23 14:55:09');

-- Volcando estructura para tabla larabooks_dev.marks_grade
CREATE TABLE IF NOT EXISTS `marks_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `percent_from` int(11) DEFAULT NULL,
  `percent_to` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.marks_grade: ~7 rows (aproximadamente)
INSERT INTO `marks_grade` (`id`, `name`, `percent_from`, `percent_to`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'A', 90, 100, 0, 1, '2024-03-05 11:28:44', '2024-03-06 16:49:12'),
	(2, 'B', 80, 89, 0, 1, '2024-03-05 11:30:07', '2024-03-06 16:49:28'),
	(3, 'C', 70, 79, 0, 1, '2024-03-05 14:12:07', '2024-03-06 16:49:40'),
	(4, 'nombre', 50, 50, 1, 1, '2024-03-06 09:39:20', '2024-03-06 09:39:23'),
	(5, 'D', 60, 69, 0, 1, '2024-03-06 09:53:39', '2024-03-06 16:50:03'),
	(6, 'E', 50, 59, 0, 1, '2024-03-06 16:50:32', '2024-03-06 16:50:32'),
	(7, 'F', 0, 58, 0, 1, '2024-03-06 16:50:56', '2024-03-06 16:50:56');

-- Volcando estructura para tabla larabooks_dev.marks_register
CREATE TABLE IF NOT EXISTS `marks_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `class_work` double NOT NULL DEFAULT 0,
  `home_work` double NOT NULL DEFAULT 0,
  `test_work` double NOT NULL DEFAULT 0,
  `exam` double NOT NULL DEFAULT 0,
  `full_marks` double NOT NULL DEFAULT 0,
  `passing_mark` double NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.marks_register: ~38 rows (aproximadamente)
INSERT INTO `marks_register` (`id`, `student_id`, `exam_id`, `class_id`, `subject_id`, `class_work`, `home_work`, `test_work`, `exam`, `full_marks`, `passing_mark`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 58, 7, 21, 51, 0, 0, 0, 0, 20, 3.2, 1, '2025-08-12 16:13:29', '2025-09-09 18:25:33'),
	(2, 58, 7, 21, 49, 3.9, 4.3, 4, 3.5, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-09 18:35:37'),
	(3, 58, 7, 21, 26, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-09 18:25:33'),
	(4, 58, 7, 21, 53, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-09 18:25:33'),
	(5, 58, 7, 21, 25, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-09 18:25:33'),
	(6, 58, 7, 21, 52, 4, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-16 14:32:40'),
	(7, 58, 7, 21, 50, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:29', '2025-09-09 18:25:33'),
	(8, 57, 7, 21, 49, 4, 4.3, 4, 3.8, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-09-09 18:36:20'),
	(9, 57, 7, 21, 51, 0, 0, 0, 0, 20, 3.2, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(10, 57, 7, 21, 26, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(11, 57, 7, 21, 53, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(12, 57, 7, 21, 25, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(13, 57, 7, 21, 52, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(14, 57, 7, 21, 50, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:38', '2025-08-12 16:13:38'),
	(15, 56, 7, 21, 49, 3.5, 3.2, 3.8, 3.8, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-09-09 18:37:06'),
	(16, 56, 7, 21, 51, 0, 0, 0, 0, 20, 3.2, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(17, 56, 7, 21, 26, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(18, 56, 7, 21, 53, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(19, 56, 7, 21, 25, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(20, 56, 7, 21, 52, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(21, 56, 7, 21, 50, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:13:47', '2025-08-12 16:13:47'),
	(22, 55, 7, 21, 49, 3.5, 4.3, 3.8, 3.9, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-09-09 18:37:26'),
	(23, 55, 7, 21, 51, 0, 0, 0, 0, 20, 3.2, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(24, 55, 7, 21, 26, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(25, 55, 7, 21, 53, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(26, 55, 7, 21, 25, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(27, 55, 7, 21, 52, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(28, 55, 7, 21, 50, 0, 0, 0, 0, 20, 3.5, 1, '2025-08-12 16:14:00', '2025-08-12 16:14:00'),
	(29, 30, 2, 12, 48, 4, 0, 0, 0, 20, 3.2, 1, '2025-09-06 17:21:15', '2025-09-06 17:21:15'),
	(30, 30, 2, 12, 39, 0, 0, 0, 0, 20, 3.2, 1, '2025-09-06 17:21:15', '2025-09-06 17:21:15'),
	(31, 30, 2, 12, 33, 3.8, 0, 0, 0, 20, 3.2, 1, '2025-09-06 17:21:15', '2025-09-06 17:22:30'),
	(32, 30, 2, 12, 36, 0, 0, 0, 0, 20, 3.2, 1, '2025-09-06 17:21:15', '2025-09-06 17:21:15'),
	(33, 30, 2, 12, 44, 0, 0, 0, 0, 20, 3.2, 1, '2025-09-06 17:21:15', '2025-09-06 17:21:15'),
	(34, 58, 7, 21, 54, 4.9, 0, 0, 0, 20, 3.2, 1, '2025-09-09 14:34:51', '2025-09-09 18:25:33'),
	(35, 55, 7, 21, 54, 4.8, 0, 0, 0, 20, 3.2, 1, '2025-09-09 14:35:05', '2025-09-09 18:37:27'),
	(36, 55, 7, 21, 54, 4.8, 0, 0, 0, 20, 3.2, 1, '2025-09-09 14:35:05', '2025-09-09 14:35:05'),
	(37, 57, 7, 21, 54, 4.8, 0, 0, 0, 20, 3.2, 1, '2025-09-09 15:00:38', '2025-09-09 18:36:20'),
	(38, 56, 7, 21, 54, 3.4, 0, 0, 0, 20, 3.2, 1, '2025-09-09 18:36:43', '2025-09-09 18:37:48');

-- Volcando estructura para tabla larabooks_dev.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.migrations: ~4 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- Volcando estructura para tabla larabooks_dev.notice_board
CREATE TABLE IF NOT EXISTS `notice_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `notice_date` date DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `message` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.notice_board: ~4 rows (aproximadamente)
INSERT INTO `notice_board` (`id`, `title`, `notice_date`, `publish_date`, `message`, `created_by`, `created_at`, `updated_at`) VALUES
	(2, 'test', '2024-03-21', '2024-03-21', 'lorem Ipsum  lorem Ipsum lorem Ipsum lorem Ipsum', 1, '2024-03-21 12:28:46', '2024-03-25 15:43:11'),
	(6, 'prueba editada', '2024-03-25', '2024-03-25', 'esto es una prueba editada', 1, '2024-03-21 15:20:46', '2024-03-25 15:29:50'),
	(7, 'test', '2024-03-21', '2024-03-21', 'test', 1, '2024-03-21 15:48:13', '2024-03-21 15:48:13'),
	(8, 'Taller contabilidad 1', '2024-03-22', '2024-03-21', 'Realizar taller No 1', 1, '2024-03-21 15:57:43', '2024-03-21 15:57:43');

-- Volcando estructura para tabla larabooks_dev.notice_board_message
CREATE TABLE IF NOT EXISTS `notice_board_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_board_id` int(11) DEFAULT NULL,
  `message_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.notice_board_message: ~8 rows (aproximadamente)
INSERT INTO `notice_board_message` (`id`, `notice_board_id`, `message_to`, `created_at`, `updated_at`) VALUES
	(3, 7, 3, '2024-03-21 15:48:13', '2024-03-21 15:48:13'),
	(4, 7, 4, '2024-03-21 15:48:14', '2024-03-21 15:48:14'),
	(5, 7, 2, '2024-03-21 15:48:14', '2024-03-21 15:48:14'),
	(6, 8, 3, '2024-03-21 15:57:44', '2024-03-21 15:57:44'),
	(7, 8, 4, '2024-03-21 15:57:44', '2024-03-21 15:57:44'),
	(8, 6, 4, '2024-03-25 15:29:52', '2024-03-25 15:29:52'),
	(9, 2, 3, '2024-03-25 15:43:11', '2024-03-25 15:43:11'),
	(10, 2, 2, '2024-03-25 15:43:11', '2024-03-25 15:43:11');

-- Volcando estructura para tabla larabooks_dev.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.period_academic
CREATE TABLE IF NOT EXISTS `period_academic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `academic_year_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `period_number` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `enrollment_start_date` date DEFAULT NULL,
  `enrollment_end_date` date DEFAULT NULL,
  `classes_start_date` date DEFAULT NULL,
  `classes_end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `is_enrollment_open` tinyint(1) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='periodo academico';

-- Volcando datos para la tabla larabooks_dev.period_academic: ~2 rows (aproximadamente)
INSERT INTO `period_academic` (`id`, `academic_year_id`, `name`, `period_number`, `start_date`, `end_date`, `enrollment_start_date`, `enrollment_end_date`, `classes_start_date`, `classes_end_date`, `is_current`, `is_enrollment_open`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Segundo Periodo', '2', '2024-07-01', '2024-12-21', '2025-07-12', '2025-12-20', '2025-07-12', '2025-12-20', 1, 1, 1, 0, 1, '2024-10-28 13:04:27', '2025-07-15 01:48:41'),
	(2, NULL, '2025-I', NULL, '2025-01-12', '2025-06-29', NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, '2024-12-20 02:20:33', '2024-12-20 02:20:33');

-- Volcando estructura para tabla larabooks_dev.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.professions
CREATE TABLE IF NOT EXISTS `professions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='profesiones de los docentes';

-- Volcando datos para la tabla larabooks_dev.professions: ~4 rows (aproximadamente)
INSERT INTO `professions` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Ingeniero de sistemas', 'ingenieria', 1, 0, 0, '2024-11-04 20:37:32', '2024-11-04 20:37:34'),
	(2, 'Enfermero Profesional', 'enfermeria', 1, 0, 0, '2024-11-04 19:45:31', '2024-11-04 19:45:31'),
	(3, 'eliminar', 'eliminar', 1, 0, 1, '2024-11-04 19:46:30', '2024-11-04 19:50:42'),
	(4, 'Mecanico', 'Tallerista', 1, 0, 0, '2024-11-04 19:49:06', '2024-11-04 19:55:01');

-- Volcando estructura para tabla larabooks_dev.registration
CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_number` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_application_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) NOT NULL,
  `period_academic_id` int(11) NOT NULL,
  `headquarter_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `journey_id` int(11) NOT NULL,
  `enrollment_date` date NOT NULL,
  `status` enum('pre_registered','enrolled','active','graduated','withdrawn','cancelled','expelled','suspended') DEFAULT 'pre_registered',
  `enrollment_type` enum('new','continuing','transfer','readmission') DEFAULT 'new',
  `date_of_entry` date DEFAULT NULL,
  `withdrawal_date` date DEFAULT NULL,
  `withdrawal_reason` text DEFAULT NULL,
  `graduation_date` date DEFAULT NULL,
  `is_scholarship` tinyint(1) DEFAULT 0,
  `scholarship_percentage` decimal(5,2) DEFAULT 0.00,
  `scholarship_type` varchar(100) DEFAULT NULL,
  `is_international` tinyint(1) DEFAULT 0,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `emergency_contact_relationship` varchar(50) DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `special_needs` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_enrollment_number` (`enrollment_number`),
  UNIQUE KEY `uk_student_period` (`student_id`,`period_academic_id`),
  KEY `idx_status` (`status`),
  KEY `idx_enrollment_date` (`enrollment_date`),
  KEY `idx_class_headquarter` (`class_id`,`headquarter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Registro de matrículas';

-- Volcando datos para la tabla larabooks_dev.registration: ~9 rows (aproximadamente)
INSERT INTO `registration` (`id`, `enrollment_number`, `student_id`, `enrollment_application_id`, `academic_year_id`, `period_academic_id`, `headquarter_id`, `class_id`, `journey_id`, `enrollment_date`, `status`, `enrollment_type`, `date_of_entry`, `withdrawal_date`, `withdrawal_reason`, `graduation_date`, `is_scholarship`, `scholarship_percentage`, `scholarship_type`, `is_international`, `emergency_contact_name`, `emergency_contact_phone`, `emergency_contact_relationship`, `medical_conditions`, `special_needs`, `notes`, `approved_by`, `approved_date`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'MAT-2025-0001', 24, NULL, 2, 1, 3, 12, 6, '2025-07-17', 'enrolled', 'continuing', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-17 19:54:17', 0, 1, '2025-07-18 00:54:17', '2025-07-18 00:54:17'),
	(2, 'MAT-2025-0002', 26, NULL, 2, 1, 3, 12, 6, '2025-07-17', 'enrolled', 'continuing', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-17 21:20:14', 0, 1, '2025-07-18 02:20:14', '2025-07-18 02:20:14'),
	(3, 'MAT-2025-0003', 54, NULL, 2, 1, 3, 13, 6, '2025-07-17', 'withdrawn', 'new', '2025-07-18', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-07-18 07:11:34', '2025-07-19 03:07:17'),
	(4, 'MAT-2025-0004', 27, NULL, 2, 1, 3, 12, 6, '2025-07-18', 'enrolled', 'continuing', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'probando el sistema de matriculas', NULL, 1, '2025-07-18 22:11:35', 0, 1, '2025-07-19 03:11:35', '2025-07-19 03:11:35'),
	(5, 'MAT-2025-0005', 55, NULL, 2, 1, 1, 21, 1, '2025-08-05', 'pre_registered', 'new', '2025-08-05', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-08-05 16:47:46', '2025-08-05 16:47:46'),
	(6, 'MAT-2025-0006', 56, NULL, 2, 1, 1, 21, 1, '2025-08-05', 'pre_registered', 'new', '2025-08-05', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-08-05 16:54:27', '2025-08-05 16:54:27'),
	(7, 'MAT-2025-0007', 57, NULL, 2, 1, 1, 21, 1, '2025-08-05', 'pre_registered', 'new', '2025-08-05', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-08-05 16:58:43', '2025-08-05 16:58:43'),
	(8, 'MAT-2025-0008', 58, NULL, 2, 1, 1, 21, 1, '2025-08-05', 'pre_registered', 'new', '2025-08-05', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-08-05 17:17:52', '2025-08-05 17:17:52'),
	(9, 'MAT-2025-0009', 59, NULL, 2, 1, 3, 12, 6, '2025-08-11', 'pre_registered', 'new', '2025-08-11', NULL, NULL, NULL, 0, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, '2025-08-11 16:55:59', '2025-08-11 16:55:59');

-- Volcando estructura para tabla larabooks_dev.setting
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(250) DEFAULT NULL,
  `exam_description` varchar(250) DEFAULT NULL,
  `operating_license` varchar(250) DEFAULT NULL,
  `legal_representative` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `paypal_email` varchar(250) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon_icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='configuraciones pasarelas de pagos';

-- Volcando datos para la tabla larabooks_dev.setting: ~1 rows (aproximadamente)
INSERT INTO `setting` (`id`, `school_name`, `exam_description`, `operating_license`, `legal_representative`, `address`, `phone`, `paypal_email`, `logo`, `favicon_icon`, `created_at`, `updated_at`) VALUES
	(1, 'UNITEC', 'TEST', 'TEST', NULL, NULL, NULL, NULL, '20241024044800ggarhaqowt1tnrg0ctfd.jfif', NULL, NULL, NULL);

-- Volcando estructura para tabla larabooks_dev.student_add_fees
CREATE TABLE IF NOT EXISTS `student_add_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT 0 COMMENT 'valor total',
  `paid_amount` float DEFAULT 0 COMMENT 'valor pagado',
  `remaning_amount` float DEFAULT 0 COMMENT 'cantidad restante',
  `payment_date` datetime DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL COMMENT 'tipo de pagos',
  `remark` text DEFAULT NULL,
  `receipt_number` text DEFAULT NULL,
  `is_payment` tinyint(4) DEFAULT 0,
  `payment_data` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='tabla para pagos de semestres';

-- Volcando datos para la tabla larabooks_dev.student_add_fees: ~0 rows (aproximadamente)

-- Volcando estructura para tabla larabooks_dev.student_attendance
CREATE TABLE IF NOT EXISTS `student_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `attendance_type` int(11) DEFAULT NULL COMMENT '1:Present, 2:Late, 3:Ausent, 4:hALF dAY',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.student_attendance: ~15 rows (aproximadamente)
INSERT INTO `student_attendance` (`id`, `class_id`, `attendance_date`, `student_id`, `attendance_type`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 12, '2024-03-11', 21, 1, 1, '2024-03-15 15:44:36', '2024-03-15 15:44:36'),
	(5, 12, '2024-03-11', 17, 3, 1, '2024-03-15 15:50:46', '2024-03-15 16:37:05'),
	(6, 12, '2024-03-11', 15, 1, 1, '2024-03-15 15:50:49', '2024-03-15 15:50:49'),
	(7, 12, '2024-03-11', 14, 1, 1, '2024-03-15 15:50:53', '2024-03-15 15:50:53'),
	(8, 12, '2024-03-15', 21, 3, 1, '2024-03-17 10:55:46', '2024-03-17 10:55:46'),
	(9, 12, '2024-03-17', 21, 4, 3, '2024-03-17 20:02:11', '2024-03-18 09:53:05'),
	(10, 12, '2024-03-17', 17, 3, 3, '2024-03-17 20:02:17', '2024-03-17 20:02:17'),
	(11, 12, '2024-03-17', 15, 3, 3, '2024-03-17 20:02:19', '2024-03-17 20:02:19'),
	(12, 12, '2024-03-17', 14, 3, 3, '2024-03-17 20:02:22', '2024-03-17 20:02:22'),
	(13, 12, '2024-04-03', 21, 1, 3, '2024-04-03 08:13:07', '2024-04-03 08:13:07'),
	(14, 12, '2024-04-03', 17, 2, 3, '2024-04-03 08:13:55', '2024-04-03 08:13:55'),
	(15, 21, '2025-08-12', 58, 1, 1, '2025-08-12 15:04:44', '2025-08-12 15:04:44'),
	(16, 21, '2025-08-12', 57, 1, 1, '2025-08-12 15:04:47', '2025-08-12 15:04:47'),
	(17, 21, '2025-08-12', 56, 1, 1, '2025-08-12 15:04:51', '2025-08-12 15:04:51'),
	(18, 21, '2025-08-12', 55, 1, 1, '2025-08-12 15:04:54', '2025-08-12 15:04:54');

-- Volcando estructura para tabla larabooks_dev.student_documents
CREATE TABLE IF NOT EXISTS `student_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `enrollment_application_id` int(11) DEFAULT NULL,
  `requirement_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL COMMENT 'Tamaño en bytes',
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `verification_status` enum('pending','verified','rejected','requires_resubmission') DEFAULT 'pending',
  `verified_by` int(11) DEFAULT NULL,
  `verification_date` timestamp NULL DEFAULT NULL,
  `verification_notes` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `expiration_date` date DEFAULT NULL COMMENT 'Para documentos que expiran',
  `version` int(3) DEFAULT 1 COMMENT 'Versión del documento',
  `is_current` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_student_requirement` (`student_id`,`requirement_id`),
  KEY `idx_application` (`enrollment_application_id`),
  KEY `idx_verification_status` (`verification_status`),
  KEY `idx_current_version` (`is_current`,`version`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Documentos de estudiantes';

-- Volcando datos para la tabla larabooks_dev.student_documents: ~1 rows (aproximadamente)
INSERT INTO `student_documents` (`id`, `student_id`, `enrollment_application_id`, `requirement_id`, `document_name`, `original_filename`, `file_path`, `file_type`, `file_size`, `upload_date`, `verification_status`, `verified_by`, `verification_date`, `verification_notes`, `tags`, `rejection_reason`, `notes`, `is_required`, `expiration_date`, `version`, `is_current`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 24, 2, 1, 'Registro matricula', 'planilla pastor.pdf', 'student_documents/24/1752760252_registro-matricula.pdf', 'application/pdf', 182038, '2025-07-17 18:50:52', 'pending', NULL, NULL, NULL, 'original', 'pruebas', 'pruebas', 1, '2025-07-24', 1, 1, 1, 0, '2025-07-17 18:50:52', '2025-07-17 18:50:52');

-- Volcando estructura para tabla larabooks_dev.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `type` enum('core','elective','optional','prerequisite') DEFAULT 'core',
  `credits` int(3) DEFAULT NULL,
  `hours_per_week` int(3) DEFAULT NULL,
  `total_hours` int(4) DEFAULT NULL,
  `theoretical_hours` int(4) DEFAULT NULL,
  `practical_hours` int(4) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `min_passing_grade` varchar(50) DEFAULT NULL,
  `max_grade` varchar(50) DEFAULT NULL,
  `allows_recovery_exam` tinyint(1) DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.subject: ~39 rows (aproximadamente)
INSERT INTO `subject` (`id`, `code`, `name`, `description`, `type`, `credits`, `hours_per_week`, `total_hours`, `theoretical_hours`, `practical_hours`, `academic_year_id`, `min_passing_grade`, `max_grade`, `allows_recovery_exam`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(16, NULL, 'Administracion I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:30:58', '2024-03-01 10:30:58'),
	(17, NULL, 'Contabilidad I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:31:11', '2024-03-01 10:31:11'),
	(18, NULL, 'Economia I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:31:26', '2024-03-01 10:31:26'),
	(19, NULL, 'Etica', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:31:40', '2024-03-01 10:31:40'),
	(20, NULL, 'Matematicas I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:31:53', '2024-03-01 10:31:53'),
	(21, NULL, 'Metodología Educación', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:32:07', '2024-03-01 10:32:07'),
	(22, NULL, 'Constitucional', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:32:23', '2024-03-01 10:32:23'),
	(23, NULL, 'Contabilidad II', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:32:36', '2024-03-01 10:32:36'),
	(24, NULL, 'Derecho Laboral', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:32:50', '2024-03-01 10:32:50'),
	(25, NULL, 'Estadistica', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:33:04', '2024-03-01 10:33:04'),
	(26, NULL, 'Informatica I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:33:18', '2024-03-01 10:33:18'),
	(27, NULL, 'Matematicas Financieras', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:33:31', '2024-03-01 10:33:31'),
	(28, NULL, 'Analisis Financiero', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:33:48', '2024-03-01 10:33:48'),
	(29, NULL, 'Costos', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:00', '2024-03-01 10:34:00'),
	(30, NULL, 'Derecho Tributario', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:13', '2024-03-01 10:34:13'),
	(31, NULL, 'Informatica II', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:24', '2024-03-01 10:34:24'),
	(32, NULL, 'Practicas Empresariales', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:37', '2024-03-01 10:34:37'),
	(33, NULL, 'Presupuesto', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:48', '2024-03-01 10:34:48'),
	(34, NULL, 'Proyecto I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:34:59', '2024-03-01 10:34:59'),
	(35, NULL, 'Auditoria', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:35:18', '2024-03-01 10:35:18'),
	(36, NULL, 'Contabilidad IV', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:35:31', '2024-03-01 10:35:31'),
	(37, NULL, 'Derecho Tributario II', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:35:45', '2024-03-01 10:35:45'),
	(38, NULL, 'Informatica III', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:36:04', '2024-03-01 10:36:04'),
	(39, 'TAPG001', 'Proyecto de grado', 'Proyectos de grados', 'core', 8, 2, 180, 30, 150, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:36:18', '2025-07-14 20:42:41'),
	(40, NULL, 'Ingles I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-03-01 10:37:11', '2024-03-01 10:37:11'),
	(41, NULL, 'Ingles II', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-06-09 13:58:22', '2024-06-09 13:58:22'),
	(42, NULL, 'Contabilidad III', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 19:02:04', '2024-09-11 19:02:04'),
	(43, NULL, 'Administracion Financiera', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 19:02:24', '2024-09-11 19:02:24'),
	(44, NULL, 'Administracion II Y III', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 19:02:37', '2024-09-11 19:02:45'),
	(45, NULL, 'Finanzas I', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 20:13:34', '2024-09-11 20:13:34'),
	(46, NULL, 'Gestion Financiera', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 20:14:39', '2024-09-11 20:14:39'),
	(47, NULL, 'Etica Empresarial', NULL, 'core', NULL, NULL, NULL, NULL, NULL, 2, '3.20', '5.00', 1, 1, 0, 1, '2024-09-11 20:27:27', '2024-09-11 20:27:27'),
	(48, 'P001', 'Profundización I', 'Asignatura de  analisis', 'elective', 5, 2, 8, 4, 4, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-07-14 19:08:49', '2025-07-14 19:08:49'),
	(49, 'MTA01', 'MATEMATICAS Grado 10', 'Matematicas grado 10', 'core', 5, 4, 20, 15, 5, 2, '3', '20', 1, 1, 0, 1, '2025-08-05 01:20:12', '2025-09-09 14:53:50'),
	(50, 'CP01', 'Castellano y Lectura Critica', 'Castellano', 'core', 10, 4, 20, 15, 5, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-08-05 01:30:44', '2025-08-05 01:30:44'),
	(51, 'Q01', 'Química 10-11', 'química 10 y 11', 'core', 10, 4, 20, 1, 5, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-08-05 01:32:39', '2025-08-05 01:32:39'),
	(52, 'CP01', 'Ciencias Políticas y Economía', 'Ciencias', 'elective', 10, 2, 8, 6, 2, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-08-05 01:33:37', '2025-08-05 01:33:37'),
	(53, 'FT01', 'Fisica 10 y 11', 'Física grado 10 y 11', 'core', 10, 4, 20, 15, 5, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-08-05 01:34:38', '2025-08-05 01:34:38'),
	(54, 'ESP', 'Español y compresion lectora', 'en español', 'core', 10, 4, 20, 15, 5, 2, '3.00', '5.00', 1, 1, 0, 1, '2025-09-09 14:24:21', '2025-09-09 14:24:21');

-- Volcando estructura para tabla larabooks_dev.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `document_type` enum('CEDULA','TI','REGISTRO_CIVIL','PASAPORTE','OTRO') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `admission_number` varchar(50) DEFAULT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `headquarter_id` int(11) DEFAULT NULL,
  `journey_id` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `caste` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `social_stratum` int(11) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `eps` varchar(50) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `permanent_address` varchar(50) DEFAULT NULL,
  `qualification` varchar(50) DEFAULT NULL,
  `work_experiencie` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_type` tinyint(4) DEFAULT 3 COMMENT '0: pre-registered, 1, admin, 3:student , 2:teacher, 4:parent, 5: coordinator, 6:visitante',
  `is_delete` tinyint(4) DEFAULT 0 COMMENT '0, no eliminado, 1: eliminado',
  `institution_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.users: ~25 rows (aproximadamente)
INSERT INTO `users` (`id`, `parent_id`, `name`, `last_name`, `document_type`, `email`, `email_verified_at`, `password`, `remember_token`, `admission_number`, `roll_number`, `class_id`, `headquarter_id`, `journey_id`, `gender`, `city_id`, `date_of_birth`, `caste`, `religion`, `social_stratum`, `mobile_number`, `occupation`, `admission_date`, `profile_pic`, `blood_group`, `eps`, `height`, `weight`, `address`, `profession_id`, `marital_status`, `permanent_address`, `qualification`, `work_experiencie`, `notes`, `user_type`, `is_delete`, `institution_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Jerson Batista Vega', 'batista', 'CEDULA', 'ingjerson2014@gmail.com', '2023-12-03 09:11:02', '$2y$12$N6UMi3P79UUaPyC.LnALJOD3jiWZ8cAaRsrAnd6lQ74iGigPfGu7S', 'nTlwvgKjNaqaf9OU8tugUxbEpAjyfx4dHmIWKIZUrOYUqWZj7Rvcfh6LOXWm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20240618124924h1svjyh2uuemr510rx1x.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, 0, '2023-12-03 09:11:10', '2025-09-16 14:32:40'),
	(2, NULL, 'student', '', NULL, 'student@gmail.com', NULL, '$2y$10$Bbe0sR00N7js3DNcolmHBe52hdxsxSE47gxzWBjJonWgOeDufN2VW', '6AhJK4foGDkX4ZE4wKTdOY4lfCqzQ86xFuBcTKcnPh08hecezEkD7Y5S00t3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, 0, '2023-12-04 00:41:19', '2024-01-02 10:02:07'),
	(5, NULL, 'parent', 'vega', 'CEDULA', 'parent@gmail.com', NULL, '$2y$10$Bbe0sR00N7js3DNcolmHBe52hdxsxSE47gxzWBjJonWgOeDufN2VW', 'N9A8bxzxDTTk7kpp0qr4VwFi6VZBaRfaMHa1k77jJOQhnc2ckzRTTXjF62xM', NULL, '45345345', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '988978989', NULL, NULL, NULL, NULL, NULL, NULL, '6', 'CARMEN DE BOLIVAR', 0, NULL, NULL, NULL, NULL, NULL, 4, 1, NULL, 0, '2023-12-04 00:43:40', '2024-01-05 15:59:42'),
	(6, NULL, 'prueba', '', NULL, 'prueba@gmail.com', NULL, '$2y$12$w4TeF8qxs6Zvi0YirqkWN.yXRlYGUeGOxnq86JX31ufFf7jqEn45i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, 0, '2023-12-07 06:06:57', '2024-01-02 10:01:15'),
	(7, NULL, 'prueba222', '', NULL, 'prueba22222@gmail.com', NULL, '$2y$12$Dt7H7SicqF7RmvSEZKAdaercl9nR2BCaFmERR3E7o9sgp1k0jghqe', 'QQTwjxOef5j1DCfu2nzTQXeHuran4uzTuXjOUaHbmWFd64qT9pVbcG1XwfNd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, '2023-12-07 06:18:19', '2023-12-07 10:55:30'),
	(10, NULL, 'juan pedro', '', NULL, 'juanito2333333@gmail.com', NULL, '$2y$12$pxH7VK/IVrJmJkwuwinJCe04WjjuDOyHGzIusM7m/qu1mO7QBf.12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20240617115045u5qguxc8fqp5wxwcieqv.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, 0, '2023-12-10 11:54:11', '2024-06-17 14:50:45'),
	(13, NULL, 'juanito', 'Batista', NULL, 'juanito021@gmail.com', NULL, '$2y$12$BTZsCZFCjeQDrn15YxMRQuTPD0CQhElZ8wpSZbGlN7xg.rbI4VVDC', NULL, '6756', '78', 12, 2, 1, 'Male', NULL, '2023-12-31', 'raizal', NULL, 3, '6756756767', NULL, '2023-12-31', '20231231102210uofehecbr4tjxnvwligm.jpg', '', 'MUTUAL', NULL, '77', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, 0, '2023-12-31 15:22:10', '2024-01-02 10:22:02'),
	(16, NULL, 'Jerson Batista', 'Hernandez Torres', 'CEDULA', 'sistemas_pruebas777@gmail.com', NULL, '$2y$12$SIJdpgXxNvfGPDiptN43T.Es4FXp3yNPaCzm.gYdN7e6fIl0J3UYO', 'osKLjInLfFgut8FANbK17oJEjLI7KqA68Atnw8GiHsY9kqj5zk4MeymSD1iP', NULL, '677777777777777777', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, '6756756767', NULL, NULL, '20240105111113yqaahya2yuzvzk40enps.jpg', 'O+', 'test', NULL, NULL, 'EL CARMEN DE BOLIVAR', 0, NULL, NULL, NULL, NULL, NULL, 4, 0, NULL, 0, '2024-01-03 10:24:43', '2024-02-13 05:55:49'),
	(24, NULL, 'Endry Manuel', 'Pájaro  Bolaño', 'TI', 'endryepbg@gmail.com', NULL, '$2y$12$rgC3QnizNkGQtFVc4CZNRORk6PVtQ8SDqiFjz2.8bVelufKc.mS/K', NULL, '1047513331', '1047513331', 11, 3, 2, 'Male', NULL, '2000-02-25', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2024-09-11 19:38:04', '2024-09-11 19:38:04'),
	(26, NULL, 'Victor Manuel', 'Torres Marrugo', 'CEDULA', 'torresmarrugov@gmail.com', NULL, '$2y$12$.efi0Y6V/JaSDfPXfnbe1.BKOOENvrjA26m4V4BuFMIms28ralBTq', NULL, '1048942797', '1048942797', 12, 3, 2, 'Male', NULL, '2000-10-11', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2024-09-11 19:50:51', '2024-09-11 19:50:51'),
	(27, NULL, 'Eder Luis', 'Herrera Ospino', 'TI', 'ederherreraospino@gmail.com', NULL, '$2y$12$./3/bpwFgMJuOFoYW0o7degAY3uMWG9sjn052wWwkQdH3B4AoQ2mC', NULL, '1045306866', '1045306866', 12, 3, 2, 'Male', NULL, '2003-10-28', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2024-09-11 19:52:38', '2024-09-11 19:52:38'),
	(28, NULL, 'Natasha', 'Torres Rodelo', 'CEDULA', 'sinemail@gmail.com', NULL, '$2y$12$9t/5PPlHl1V/gCCvF0crgu5iR5oe1qA1pU43EyNFPSh12lZOoE8Vy', NULL, '1048936899', '1048936899', 12, 3, 2, 'Female', NULL, '2000-02-10', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-11 19:55:11', '2024-09-11 19:55:11'),
	(30, NULL, 'Erika Maria', 'Machado Sarabia', 'CEDULA', 'erikamariamachado10@gmail.com', NULL, '$2y$12$TCrMzoql2xk.teZrFYgKx.L15WDxXwoJwUYoKmbOChRscsQbJpavS', NULL, '1038933904', '1038933904', 12, 3, 2, 'Male', NULL, '2024-09-11', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-11 19:58:04', '2024-09-18 20:17:17'),
	(33, NULL, 'Yulieth Paola', 'Guardo Lopez', 'CEDULA', 'yuliethpaola@gmail.com', NULL, '$2y$12$bDy3OQ51/rFMiGImg10ToecIZ3maPEWvzdQU/S4rRSMXQOgUboeMi', NULL, '1048937063', '1048937063', 12, 3, 2, 'Male', NULL, '2024-09-11', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-11 20:02:37', '2024-09-11 20:02:37'),
	(34, NULL, 'Leidys del Carmen', 'Altahona Ospino', 'CEDULA', 'altahonaospinoleidysdelcarmen@gmail.com', NULL, '$2y$12$JevDWyp1xhEMHDlo1sL4C.pj9IYw.RjIPPIzcV4c0UKt8haG/T/Fe', NULL, '1048933006', '1048933006', 12, 3, 2, 'Female', NULL, '2024-09-11', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-11 20:03:33', '2025-07-14 21:05:00'),
	(36, NULL, 'Dayana', 'Pantoja Mendoza', 'CEDULA', 'dayanapaolapantojamendoza@gmail.com', NULL, '$2y$12$xJIAaNh1wuj607MqHm9ppe/q5SEKF4.LgoVvXfFEFlrvjCQlNpNJS', NULL, '1048933888', '1048933888', 12, 3, 2, 'Female', NULL, '2024-09-11', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-11 22:58:52', '2024-09-11 22:58:52'),
	(37, NULL, 'Carlos Mario', 'Navarro Martinez', 'CEDULA', 'carlosmarionavarromartinez@gmail.com', NULL, '$2y$12$IZmoTgSiluBPVZdk55iTS.bnzIQbf6jgQ0FJ7wly9joRNTPGipQ5.', NULL, '1048934596', '1048934596', 11, 3, 5, 'Male', NULL, '2024-09-12', '', '', 1, '', NULL, '2024-09-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 1, 0, '2024-09-12 10:41:45', '2024-09-12 10:41:45'),
	(40, NULL, 'Jair', 'Fernandez', 'CEDULA', 'jair@gmail.com', NULL, '$2y$12$eqPWi6gOepZsUsyUrsl.EOrI3SexzW5Srn5eCRpCLHR5w23zGo2..', NULL, NULL, '5645645645', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, '5456666777', NULL, NULL, NULL, 'o', 'no', NULL, NULL, 'El Carmen de Bolivar', 0, NULL, NULL, NULL, NULL, NULL, 5, 0, 1, 0, '2024-09-18 14:24:52', '2024-12-19 21:16:34'),
	(52, NULL, 'Docente depruebas', 'pruebas', 'CEDULA', 'docentedepruebas@gmail.com', NULL, '$2y$12$8hvMUfv7xqIwRysGEKGRG.UEdtAoPkJqh/EIiLn8e7EUJotkpSdgy', NULL, '', '00001', NULL, NULL, NULL, 'Male', 3, '2025-01-15', NULL, NULL, NULL, '21321321213', '', '2025-01-15', NULL, '0+', 'MUTUAL SER', NULL, NULL, 'Kra 45', 4, 'Casado', '', NULL, '', '', 2, 0, NULL, 0, '2025-01-15 20:49:10', '2025-09-04 01:00:21'),
	(53, NULL, 'Coordinador de pruebas', 'pruebas', 'CEDULA', 'coordinadorfinal@gmail.com', NULL, '$2y$12$9j/fv/rTP5cHxmjagPrXnemw6qX5R7SqBAcv43j4UCiD.MX9vdZ.y', NULL, NULL, '001111111111', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, '21321321213', 'INDEPENDIENTE', NULL, NULL, '', 'MUTUAL SER', NULL, NULL, 'BARRIO CENTrO', NULL, NULL, NULL, NULL, NULL, NULL, 5, 0, NULL, 0, '2025-01-15 21:40:33', '2025-01-15 22:31:51'),
	(55, NULL, 'Sebastian  Antonio', 'Torres Canoles', 'TI', 'elycanoles@gmail.com', NULL, '$2y$12$0kVYNOC80669aySrEL0d.OH3DpJouJlnWc.oqHhCQ.CGjqEg27jfO', NULL, '1052079311', '1052079311', 21, 1, 1, 'Male', 1, '2025-08-05', '', '', 1, '', NULL, '2025-08-05', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2025-08-05 16:47:46', '2025-09-09 18:53:17'),
	(56, NULL, 'Keiner Julio', 'Sami Simancas', 'CEDULA', 'keinersimanca71@gmail.com', NULL, '$2y$12$GYTRy/jYVSlfQEK5FT3U/.L5UP3QHwuF.g2aMzdTaH89jn.KhvtEu', NULL, '1052071877', '1052071877', 21, 1, 1, 'Male', 1, '2025-08-05', '', '', 2, '', NULL, '2025-08-05', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2025-08-05 16:54:27', '2025-09-09 19:43:35'),
	(57, NULL, 'Angie Paola', 'Gamarra Yanez', 'CEDULA', 'angiegamarrayanez@gmail.com', NULL, '$2y$12$IluP8mNY.ve.qzEnPc8PGu4Uh96OOy5eEDDkM7FsbdZURqVfpx6BW', NULL, '1043966768', '1043966768', 21, 1, 1, 'Female', 1, '2025-08-05', '', '', 1, '', NULL, '2025-08-05', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2025-08-05 16:58:43', '2025-09-09 18:53:00'),
	(58, NULL, 'Karolay', 'Mejía Barrios', 'CEDULA', 'karolaymejiabarrios@gmail.com', NULL, '$2y$12$pPwoKGiZaITgTrx8CwC0xuM.iIZOVtS4HeHrvhzGGYtbMhkqMM/D6', NULL, '1079658055', '1079658055', 21, 1, 1, 'Female', 1, '2025-08-05', '', '', 1, '', NULL, '2025-08-05', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2025-08-05 17:17:52', '2025-08-05 17:17:52'),
	(59, NULL, 'Viany Patricia', 'Becerra Hernandez', 'CEDULA', 'vianisbecerra@gmail.com', NULL, '$2y$12$lV8XFgShmAZ/Sk8ecwRD/eUsUGvmmss2FJ0S0XDFrCTXXhVPAKYM2', NULL, '1045308186', '1045308186', 12, 3, 6, 'Female', 2, '2025-08-11', '', '', 1, '3209340370', NULL, '2025-08-11', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, 0, '2025-08-11 16:55:59', '2025-08-11 16:55:59');

-- Volcando estructura para tabla larabooks_dev.week
CREATE TABLE IF NOT EXISTS `week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `fullcalendar_day` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla larabooks_dev.week: ~7 rows (aproximadamente)
INSERT INTO `week` (`id`, `name`, `fullcalendar_day`, `created_at`, `updated_at`) VALUES
	(1, 'Lunes', 1, '2024-01-11 13:39:18', '2024-01-11 13:39:19'),
	(2, 'Martes', 2, '2024-01-11 13:40:18', '2024-01-11 13:40:19'),
	(3, 'Miercoles', 3, '2024-01-11 13:40:38', '2024-01-11 13:40:39'),
	(4, 'Jueves', 4, '2024-01-11 13:40:51', '2024-01-11 13:40:52'),
	(5, 'Viernes', 5, '2024-01-11 13:41:03', '2024-01-11 13:41:04'),
	(6, 'Sabado', 6, '2024-01-11 13:41:14', '2024-01-11 13:41:15'),
	(7, 'Domingo', 7, '2024-01-11 13:41:28', '2024-01-11 13:41:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
