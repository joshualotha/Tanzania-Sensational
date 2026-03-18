-- MySQL dump 10.13  Distrib 9.6.0, for macos26.2 (arm64)
--
-- Host: localhost    Database: TSS
-- ------------------------------------------------------
-- Server version	9.6.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'c4ed345e-1d05-11f1-b0ec-6d813db0bc9b:1-2902';

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_notifications_type_index` (`type`),
  KEY `admin_notifications_read_at_index` (`read_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_notifications`
--

LOCK TABLES `admin_notifications` WRITE;
/*!40000 ALTER TABLE `admin_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `content_html` longtext COLLATE utf8mb4_unicode_ci,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'kilimanjaro-packing-list-what-actually-matters','Kilimanjaro Packing List: What Actually Matters','Kilimanjaro Packing List: What Actually Matters | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Kilimanjaro Packing List: What Actually Matters</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Preparation','2025-12-22 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'lemosho-vs-machame-choosing-your-route','Lemosho vs Machame: Choosing Your Route','Lemosho vs Machame: Choosing Your Route | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Lemosho vs Machame: Choosing Your Route</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Routes','2025-12-12 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'altitude-acclimatization-a-practical-guide','Altitude Acclimatization: A Practical Guide','Altitude Acclimatization: A Practical Guide | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Altitude Acclimatization: A Practical Guide</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Health & Safety','2025-11-02 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,'what-a-kilimanjaro-day-looks-like-on-the-mountain','What a Kilimanjaro Day Looks Like on the Mountain','What a Kilimanjaro Day Looks Like on the Mountain | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>What a Kilimanjaro Day Looks Like on the Mountain</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','On the Trek','2026-03-14 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,'safari-after-the-summit-best-pairings','Safari After the Summit: Best Pairings','Safari After the Summit: Best Pairings | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Safari After the Summit: Best Pairings</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1508672019048-805c876b67e2?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Safari','2026-01-20 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,'zanzibar-the-perfect-recovery-itinerary','Zanzibar: The Perfect Recovery Itinerary','Zanzibar: The Perfect Recovery Itinerary | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Zanzibar: The Perfect Recovery Itinerary</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Zanzibar','2025-09-19 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,'training-for-kilimanjaro-8-weeks-no-guesswork','Training for Kilimanjaro: 8 Weeks, No Guesswork','Training for Kilimanjaro: 8 Weeks, No Guesswork | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Training for Kilimanjaro: 8 Weeks, No Guesswork</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Preparation','2026-02-09 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,'how-to-tip-on-kilimanjaro-simple-breakdown','How to Tip on Kilimanjaro (Simple Breakdown)','How to Tip on Kilimanjaro (Simple Breakdown) | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>How to Tip on Kilimanjaro (Simple Breakdown)</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1520975958225-3f61d2c4ca0b?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Preparation','2025-10-05 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,'the-5-ecological-zones-of-kilimanjaro','The 5 Ecological Zones of Kilimanjaro','The 5 Ecological Zones of Kilimanjaro | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>The 5 Ecological Zones of Kilimanjaro</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Kilimanjaro','2025-12-29 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,'why-group-departures-work-and-when-they-dont','Why Group Departures Work (and When They Don’t)','Why Group Departures Work (and When They Don’t) | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Why Group Departures Work (and When They Don’t)</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Planning','2025-11-25 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,'moshi-arrival-hotels-and-what-to-expect','Moshi: Arrival, Hotels, and What to Expect','Moshi: Arrival, Hotels, and What to Expect | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Moshi: Arrival, Hotels, and What to Expect</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Planning','2026-01-15 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,'common-mistakes-first-time-trekkers-make','Common Mistakes First-Time Trekkers Make','Common Mistakes First-Time Trekkers Make | Tanzania Sensational','A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.','Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',NULL,'<p><strong>Common Mistakes First-Time Trekkers Make</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>','https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1600&q=80','Tanzania Sensational','Health & Safety','2026-02-12 12:39:44','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'departure',
  `departure_id` bigint unsigned DEFAULT NULL,
  `safari_package_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_size` int NOT NULL,
  `held_seats` int NOT NULL DEFAULT '0',
  `hold_expires_at` timestamp NULL DEFAULT NULL,
  `last_contacted_at` timestamp NULL DEFAULT NULL,
  `adults` int NOT NULL DEFAULT '1',
  `children` int NOT NULL DEFAULT '0',
  `total_price_cents` int NOT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `preferred_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_ref_unique` (`booking_ref`),
  KEY `bookings_departure_id_foreign` (`departure_id`),
  KEY `bookings_safari_package_id_foreign` (`safari_package_id`),
  CONSTRAINT `bookings_departure_id_foreign` FOREIGN KEY (`departure_id`) REFERENCES `departures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_safari_package_id_foreign` FOREIGN KEY (`safari_package_id`) REFERENCES `safari_packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba','i:10;',1773848734),('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1773848734;',1773848734);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departures`
--

DROP TABLE IF EXISTS `departures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trekking_route_id` bigint unsigned NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `price_cents` int NOT NULL,
  `total_seats` int NOT NULL DEFAULT '12',
  `available_seats` int NOT NULL DEFAULT '12',
  `booked_seats` int NOT NULL DEFAULT '0',
  `held_seats` int NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Available',
  `summit_night` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_point` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `briefing_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `inclusions` json DEFAULT NULL,
  `exclusions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departures_trekking_route_id_foreign` (`trekking_route_id`),
  CONSTRAINT `departures_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departures`
--

LOCK TABLES `departures` WRITE;
/*!40000 ALTER TABLE `departures` DISABLE KEYS */;
INSERT INTO `departures` VALUES (1,3,'2026-07-12',NULL,285000,12,12,5,0,'Available','July 19, 2026','Kilimanjaro International Airport (JRO)','July 11, 2026 — 6:00 PM','Join our most popular group departure via the scenic Lemosho Route. This 8-day expedition offers exceptional acclimatization through diverse ecological zones — from lush rainforest to alpine desert. Summit under the stars of mid-July when the skies are clearest.','[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]','[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$200-300 pp)\", \"Alcoholic beverages\", \"Visa fees\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,3,'2026-08-04',NULL,285000,12,12,9,0,'Limited','August 11, 2026','Kilimanjaro International Airport (JRO)','August 3, 2026 — 6:00 PM','Our August Lemosho departure coincides with peak dry season — expect crystal-clear summit views and optimal trail conditions. This is our best-selling departure and fills quickly. Only 3 spots remain.','[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]','[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$200-300 pp)\", \"Alcoholic beverages\", \"Visa fees\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,12,'2026-09-15',NULL,330000,12,12,2,0,'Available','September 22, 2026','Kilimanjaro International Airport (JRO)','September 14, 2026 — 6:00 PM','The Northern Circuit is Kilimanjaro\'s longest and most remote route, circling the entire northern slopes with unmatched views and virtually zero crowd encounters. This 9-day schedule provides the best acclimatization profile of any route.','[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and Gamow bag\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]','[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$250-350 pp)\", \"Alcoholic beverages\", \"Visa fees\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,7,'2026-10-02',NULL,245000,12,12,12,0,'Full','October 07, 2026','Kilimanjaro International Airport (JRO)','October 1, 2026 — 6:00 PM','Known as the \'Whiskey Route\' for its challenging terrain, the Machame delivers a dramatic ascent through five distinct climate zones. This departure is fully booked — join our waitlist for cancellation spots.','[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain\", \"Emergency oxygen kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]','[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew\", \"Visa fees\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,1,'2027-12-28',NULL,295000,12,12,8,0,'Limited','January 3, 2027 (NYE on mountain!)','Kilimanjaro International Airport (JRO)','December 27, 2026 — 6:00 PM','Ring in the New Year at 5,895 meters — the Roof of Africa. This special NYE departure includes a midnight celebration at high camp and a New Year\'s Day summit bid. An absolutely unforgettable way to start the year.','[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day + NYE celebration dinner\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\", \"Summit photo & video package\"]','[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$200-300 pp)\", \"Alcoholic beverages (except NYE champagne)\", \"Visa fees\"]','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `departures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci,
  `meta_quote` text COLLATE utf8mb4_unicode_ci,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_coordinates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_elevation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `best_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_encounter_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_tier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_tracking` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlights` json DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `atmosphere_vitals` json DEFAULT NULL,
  `atmosphere_footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wildlife_vitals` json DEFAULT NULL,
  `wildlife_footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `destinations_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (1,'serengeti','Serengeti','The Infinite Plains','THE GREAT MIGRATION','The Serengeti is arguably the most famous wildlife sanctuary in the world, unequalled in its natural beauty and scientific value. Encompassing over 14,000 square kilometers, it is a vast, seemingly endless ocean of golden grasses, dotted with acacia trees and dramatic rocky outcrops known as kopjes. Here, the ancient rhythm of the Great Migration dictates life, as millions of hooves pound the earth in a relentless search for fresh grazing.','Walking through this landscape is like reading a forgotten manuscript of the earth—every shadow tells a secret, and every sunrise is a revelation.','https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop','2.3333° S, 34.8333° E','920m – 1,850m','June to October (River Crossings) / Jan to March (Calving)','95.8%','Prestige Tier 01','Satellite GPS Tracking','[\"The Great Migration\", \"River Crossings\", \"Big Five Territory\", \"Endless Horizons\", \"Hot Air Ballooning\"]','[\"https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80\", \"https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80\", \"https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80\", \"https://images.unsplash.com/photo-1521651201144-634f700b36ef?w=800&q=80\", \"https://images.unsplash.com/photo-1511497584788-876760111969?w=800&q=80\", \"https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=800&q=80\"]','[{\"text\": \"Charged with raw, ancient energy.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Distant predator calls & thrum of millions of hooves.\", \"label\": \"Audio Profile\"}, {\"text\": \"Endless horizons with golden morning mist.\", \"label\": \"Visibility\"}, {\"text\": \"Crisp 14°C at dawn to 28°C at meridian.\", \"label\": \"Ambient Temp\"}]','A place that makes you feel both small and connected.','[{\"text\": \"Highest density of lions and cheetahs in Africa.\", \"label\": \"Predator Stat\"}, {\"text\": \"The Big Five + 2 Million migrating ungulates.\", \"label\": \"Key Species\"}, {\"text\": \"Primal theatre of masterclass survival.\", \"label\": \"Bio Profile\"}, {\"text\": \"95.8% (Historical Data Archive)\", \"label\": \"Encounter Prob\"}]','Satellite GPS integration for active pride tracking.','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'ngorongoro','Ngorongoro Crater','The Lost World','UNESCO CALDERA','Often referred to as the \'Eighth Wonder of the World,\' the Ngorongoro Crater is a breathtaking natural amphitheater. Formed millions of years ago when a giant volcano exploded and collapsed on itself, the 600-meter deep caldera now harbors a unique microclimate and an incredibly dense population of wildlife.','To stand on the rim and gaze into the depths is to witness nature\'s most perfect amphitheater—a world enclosed, eternal, and utterly alive.','https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=2000&q=85&auto=format&fit=crop','3.2000° S, 35.5000° E','2,286m (Rim)','Year-Round (Wildlife does not migrate out)','98.2%','Prestige Tier 01','Crater Floor GPS Grid','[\"Endangered Black Rhino\", \"Crater Floor Drives\", \"Maasai Coexistence\", \"Dense Lion Population\", \"Lake Magadi Flamingos\"]','[\"https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80\", \"https://images.unsplash.com/photo-1493246507139-91e8fad9978e?w=800&q=80\", \"https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800&q=80\", \"https://images.unsplash.com/photo-1589308454676-e1af9491a670?w=800&q=80\", \"https://images.unsplash.com/photo-1520114878144-6123749968dd?w=800&q=80\", \"https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80\"]','[{\"text\": \"Prehistoric calm within volcanic walls.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Sacred silence broken by flamingo calls.\", \"label\": \"Audio Profile\"}, {\"text\": \"600m deep caldera with panoramic rim views.\", \"label\": \"Visibility\"}, {\"text\": \"Cool 10°C at rim to 24°C on crater floor.\", \"label\": \"Ambient Temp\"}]','A world apart, enclosed and eternal.','[{\"text\": \"Highest lion density per square km in Africa.\", \"label\": \"Predator Stat\"}, {\"text\": \"Big Five including critically endangered black rhino.\", \"label\": \"Key Species\"}, {\"text\": \"Self-contained Eden — a microcosm of East Africa.\", \"label\": \"Bio Profile\"}, {\"text\": \"98.2% (Enclosed ecosystem)\", \"label\": \"Encounter Prob\"}]','UNESCO World Heritage Site — protected since 1979.','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'tarangire','Tarangire','Land of Giants','ELEPHANT REALM','Tarangire is the quiet giant of the northern circuit. Dominated by the serpentine path of the Tarangire River and punctuated by massive, ancient baobab trees, the landscape feels primal and untouched. During the dry season, it becomes a crucial refuge for wildlife.','In the shade of a thousand-year baobab, with the river whispering below and elephants drifting like grey clouds—this is Africa at its most honest.','https://images.unsplash.com/photo-1581852015102-142a2c317022?w=2000&q=85&auto=format&fit=crop','3.8500° S, 36.0000° E','1,100m','July to October (Dry Season Congregation)','94.5%','Heritage Tier 02','River System GPS Tracking','[\"Massive Elephant Herds\", \"Ancient Baobabs\", \"Silvery Landscapes\", \"Tree-Climbing Pythons\", \"Incredible Birding\"]','[\"https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80\", \"https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800&q=80\", \"https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80\", \"https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=800&q=80\", \"https://images.unsplash.com/photo-1521651201144-634f700b36ef?w=800&q=80\", \"https://images.unsplash.com/photo-1541018867375-7f311c63ec94?w=800&q=80\"]','[{\"text\": \"Rugged tranquility beneath ancient baobabs.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Elephant rumbles and 550+ bird species.\", \"label\": \"Audio Profile\"}, {\"text\": \"Silvery landscapes cut by the winding river.\", \"label\": \"Visibility\"}, {\"text\": \"Warm 18°C mornings to 32°C at midday.\", \"label\": \"Ambient Temp\"}]','Where the pace of life follows the river\'s flow.','[{\"text\": \"Tree-climbing lions and leopards in residence.\", \"label\": \"Predator Stat\"}, {\"text\": \"Largest elephant herds in Tanzania (3,000+).\", \"label\": \"Key Species\"}, {\"text\": \"Dry season refuge — extraordinary animal concentration.\", \"label\": \"Bio Profile\"}, {\"text\": \"94.5% (Dry Season Peak)\", \"label\": \"Encounter Prob\"}]','Home to over 550 bird species — a birder\'s paradise.','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gear_items`
--

DROP TABLE IF EXISTS `gear_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gear_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gear_items`
--

LOCK TABLES `gear_items` WRITE;
/*!40000 ALTER TABLE `gear_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `gear_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gear_rental_requests`
--

DROP TABLE IF EXISTS `gear_rental_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gear_rental_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` json NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gear_rental_requests_booking_id_foreign` (`booking_id`),
  CONSTRAINT `gear_rental_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gear_rental_requests`
--

LOCK TABLES `gear_rental_requests` WRITE;
/*!40000 ALTER TABLE `gear_rental_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `gear_rental_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_16_130753_create_trekking_routes_table',1),(5,'2026_03_16_130754_create_departures_table',1),(6,'2026_03_16_130754_create_route_itinerary_days_table',1),(7,'2026_03_16_130755_create_bookings_table',1),(8,'2026_03_16_130755_create_gear_items_table',1),(9,'2026_03_16_130756_create_gear_rental_requests_table',1),(10,'2026_03_16_130757_create_blog_posts_table',1),(11,'2026_03_16_130757_create_pages_table',1),(12,'2026_03_16_130758_create_destinations_table',1),(13,'2026_03_16_130758_create_safari_packages_table',1),(14,'2026_03_16_130759_create_pricing_rules_table',1),(15,'2026_03_16_132240_create_personal_access_tokens_table',1),(16,'2026_03_16_220350_create_contact_submissions_table',1),(17,'2026_03_16_221356_add_safari_booking_fields_to_bookings_table',1),(18,'2026_03_17_053228_add_category_to_blog_posts_table',1),(19,'2026_03_17_063142_create_visual_assets_table',1),(20,'2026_03_17_120000_add_role_to_users_table',1),(21,'2026_03_17_120100_create_site_settings_table',1),(22,'2026_03_17_130000_add_capacity_and_holds_to_departures_table',1),(23,'2026_03_17_130100_extend_bookings_for_request_workflow',1),(24,'2026_03_17_150000_add_content_html_and_seo_to_blog_posts_table',1),(25,'2026_03_17_200000_create_admin_notifications_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'home','Home','<p>Welcome to Tanzania Sensational. You can edit this homepage introduction in the dashboard CMS.</p>','Tanzania Sensational — Kilimanjaro, Safari & Zanzibar','Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Submit a booking request and we’ll confirm by email.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'about','About','<p>About page content can be managed in the dashboard CMS.</p>','About Us | Tanzania Sensational','Learn about our team, our approach, and how we run premium trekking and safari experiences in Tanzania.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'contact','Contact','<p>Contact page content can be managed in the dashboard CMS.</p>','Contact | Tanzania Sensational','Send an inquiry or booking request. We’ll reply by email to confirm details and arrange payment offline.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,'routes-overview','Routes Overview','<p>This is a CMS-managed page intended for a routes overview or landing page.</p>','Routes Overview | Tanzania Sensational','Explore Kilimanjaro route options and choose the right trek for your schedule and experience level.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,'company-our-guides','Our Guides','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Our Guides</h2>\n<ul><li>Deep local knowledge and professional training</li><li>Safety-first leadership on every departure</li><li>Clear communication before, during, and after your trip</li></ul>','Our Guides | Tanzania Sensational','Meet the mountain and safari professionals behind Tanzania Sensational. Experienced, safety-first, and deeply local.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,'company-safety-protocols','Safety Protocols','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Safety Protocols</h2>\n<ul><li>Pre-trek briefings and gear checks</li><li>Altitude awareness and conservative pacing</li><li>Reliable communications and evacuation planning</li></ul>','Safety Protocols | Tanzania Sensational','Our safety standards for trekking and safari operations, including briefings, altitude monitoring, and contingency planning.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,'safari-guide-local-custom','Local Custom','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Local Custom</h2>\n<ul><li>Greetings and respectful interaction</li><li>Photography etiquette</li><li>Tipping norms and expectations</li></ul>','Safari Guide: Local Custom | Tanzania Sensational','Helpful cultural notes and etiquette for traveling in Tanzania—simple, respectful, and practical.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,'safari-guide-what-to-wear','What to Wear','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>What to Wear</h2>\n<ul><li>Light layers and neutral colors</li><li>A warm layer for early mornings</li><li>Comfortable shoes and sun protection</li></ul>','Safari Guide: What to Wear | Tanzania Sensational','What to wear on safari for comfort, style, and practicality—from game drives to lodges.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,'safari-guide-packing-guide','Packing Guide','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Packing Guide</h2>\n<ul><li>Daypack essentials</li><li>Camera and charging basics</li><li>Documents and travel insurance</li></ul>','Safari Guide: Packing Guide | Tanzania Sensational','A clear safari packing checklist—what to bring, what to skip, and how to pack efficiently.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,'safari-guide-accommodation-style','Accommodation Style','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Accommodation Style</h2>\n<ul><li>Lodges vs tented camps</li><li>What “mid-range” and “luxury” typically mean</li><li>Power, hot water, and Wi‑Fi expectations</li></ul>','Safari Guide: Accommodation Style | Tanzania Sensational','Understand safari accommodation types—from lodges to camps—so you can choose the right comfort level.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,'safari-guide-visa-guide','Visa Guide','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Visa Guide</h2>\n<ul><li>Passport validity requirements</li><li>Entry visa overview</li><li>Arrival timing and common checkpoints</li></ul>','Safari Guide: Visa Guide | Tanzania Sensational','Visa basics for Tanzania: what you’ll need and how to prepare before arrival.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,'safari-guide-health-and-safety','Health and Safety','<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>\n<h2>Health and Safety</h2>\n<ul><li>Sun protection and hydration</li><li>Insect bite prevention</li><li>Basic travel health preparation</li></ul>','Safari Guide: Health and Safety | Tanzania Sensational','Health and safety guidance for safari travel, including hydration, sun care, and general precautions.',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricing_rules`
--

DROP TABLE IF EXISTS `pricing_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pricing_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trekking_route_id` bigint unsigned NOT NULL,
  `min_group_size` int DEFAULT NULL,
  `max_group_size` int DEFAULT NULL,
  `season` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_person_cents` int NOT NULL,
  `add_on_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_on_price_cents` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pricing_rules_trekking_route_id_foreign` (`trekking_route_id`),
  CONSTRAINT `pricing_rules_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing_rules`
--

LOCK TABLES `pricing_rules` WRITE;
/*!40000 ALTER TABLE `pricing_rules` DISABLE KEYS */;
INSERT INTO `pricing_rules` VALUES (1,1,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,1,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,1,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,1,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,1,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,1,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,1,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,1,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,1,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,2,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,2,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,2,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(13,2,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(14,2,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(15,2,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(16,2,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(17,2,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(18,2,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(19,3,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(20,3,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(21,3,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(22,3,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(23,3,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(24,3,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(25,3,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(26,3,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(27,3,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(28,4,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(29,4,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(30,4,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(31,4,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(32,4,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(33,4,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(34,4,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(35,4,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(36,4,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(37,5,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(38,5,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(39,5,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(40,5,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(41,5,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(42,5,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(43,5,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(44,5,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(45,5,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(46,6,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(47,6,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(48,6,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(49,6,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(50,6,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(51,6,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(52,6,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(53,6,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(54,6,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(55,7,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(56,7,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(57,7,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(58,7,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(59,7,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(60,7,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(61,7,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(62,7,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(63,7,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(64,8,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(65,8,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(66,8,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(67,8,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(68,8,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(69,8,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(70,8,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(71,8,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(72,8,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(73,9,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(74,9,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(75,9,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(76,9,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(77,9,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(78,9,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(79,9,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(80,9,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(81,9,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(82,10,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(83,10,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(84,10,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(85,10,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(86,10,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(87,10,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(88,10,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(89,10,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(90,10,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(91,11,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(92,11,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(93,11,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(94,11,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(95,11,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(96,11,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(97,11,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(98,11,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(99,11,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(100,12,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(101,12,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(102,12,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(103,12,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(104,12,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(105,12,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(106,12,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(107,12,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(108,12,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(109,13,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(110,13,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(111,13,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(112,13,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(113,13,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(114,13,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(115,13,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(116,13,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(117,13,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(118,14,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(119,14,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(120,14,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(121,14,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(122,14,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(123,14,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(124,14,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(125,14,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(126,14,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(127,15,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(128,15,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(129,15,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(130,15,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(131,15,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(132,15,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(133,15,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(134,15,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(135,15,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(136,16,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(137,16,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(138,16,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(139,16,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(140,16,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(141,16,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(142,16,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(143,16,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(144,16,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(145,17,1,2,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(146,17,3,5,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(147,17,6,20,'peak',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(148,17,1,2,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(149,17,3,5,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(150,17,6,20,'shoulder',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(151,17,1,2,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(152,17,3,5,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44'),(153,17,6,20,'low',0,NULL,NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `pricing_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route_itinerary_days`
--

DROP TABLE IF EXISTS `route_itinerary_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route_itinerary_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trekking_route_id` bigint unsigned NOT NULL,
  `day_number` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `elevation` int DEFAULT NULL,
  `distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hiking_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `habitat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accommodation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meals` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `route_itinerary_days_trekking_route_id_foreign` (`trekking_route_id`),
  CONSTRAINT `route_itinerary_days_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route_itinerary_days`
--

LOCK TABLES `route_itinerary_days` WRITE;
/*!40000 ALTER TABLE `route_itinerary_days` DISABLE KEYS */;
INSERT INTO `route_itinerary_days` VALUES (1,1,1,'Londorossi Gate to Shira 1 Camp','A long trek beginning in the rainforest and punching through to the Shira Plateau.',3500,NULL,NULL,NULL,'Shira 1 Camp (3,500m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,1,2,'Shira 1 Camp to Moir Hut','Trek eastward across the caldera, arriving at the isolated Moir Hut nestled beneath the striking Lent Hills.',4200,NULL,NULL,NULL,'Moir Hut (4,200m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,1,3,'Moir Hut to Barranco Camp via Lava Tower','Crucial acclimatization day. Ascend to Lava Tower (4,600m) before descending to the spectacular Barranco Valley.',3900,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,1,4,'Barranco Camp to Barafu Camp','Conquer the Barranco Wall and traverse the ridges, pushing straight past Karanga to Barafu base camp.',4680,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,1,5,'Barafu Camp to Uhuru Peak to Mweka Camp','Summit night. A grueling midnight ascent to the roof of Africa, followed by a massive descent.',5895,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,1,6,'Mweka Camp to Gate','A final descent through the montane forest. Collect your certificates at the gate.',1640,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,2,1,'Londorossi Gate to Mti Mkubwa','Begin the expedition in the dense, silent beauty of the western montane forest.',2810,NULL,NULL,NULL,'Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,2,2,'Mti Mkubwa to Shira 1 Camp','Break out of the forest canopy and onto the vast, windswept expanse of the Shira Plateau.',3500,NULL,NULL,NULL,'Shira 1 Camp (3,500m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,2,3,'Shira 1 Camp to Shira 2 Camp','A gentle trek across the caldera to the higher Shira 2 camp, offering stunning views of Kibo.',3850,NULL,NULL,NULL,'Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,2,4,'Shira 2 Camp to Barranco Camp','A critical acclimatization day. Ascend to the imposing Lava Tower at 4,600m before descending into the Barranco Valley.',3900,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,2,5,'Barranco Camp to Karanga Camp','Conquer the vertical scramble of the famous Barranco Wall, followed by a short traverse to Karanga Valley.',3995,NULL,NULL,NULL,'Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,2,6,'Karanga Camp to Barafu Camp','Leave the final water source behind as you ascend into the stark alpine desert to base camp.',4680,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(13,2,7,'Ascent to Uhuru Peak to Mweka Camp','Summit Night. A frigid, majestic climb to the roof of Africa. Descend all the way to Mweka Camp.',5895,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(14,2,8,'Mweka Camp to Gate','A final, triumphant descent through the montane forest to collect your summit certificates.',1640,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(15,3,1,'Londorossi Gate to Mti Mkubwa','Begin the expedition in the dense, silent beauty of the western montane forest.',2810,'6 km','3-4 hours','Rain Forest','Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(16,3,2,'Mti Mkubwa to Shira 1 Camp','Break out of the forest canopy and onto the vast, windswept expanse of the Shira Plateau.',3500,'8 km','5-6 hours','Moorland','Shira 1 Camp (3,500m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(17,3,3,'Shira 1 to Shira 2 Camp','A relaxed day crossing the plateau, allowing absolute adaptation to the altitude.',3850,'7 km','3-4 hours','Moorland','Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(18,3,4,'Shira 2 Camp to Barranco Camp','A critical acclimatization day. Ascend to Lava Tower at 4,600m before descending into the surreal Barranco Valley.',3900,'10 km','6-7 hours','Semi-Desert','Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(19,3,5,'Barranco Camp to Karanga Camp','Conquer the vertical scramble of the famous Barranco Wall, followed by an acclimatization hike above Karanga.',3995,'5 km','4-5 hours','Alpine Desert','Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(20,3,6,'Karanga Camp to Barafu Camp','A short, steep trek through the stark alpine desert. Arrive early at base camp to rest for the summit.',4680,'4 km','4-5 hours','Alpine Desert','Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(21,3,7,'Ascent to Uhuru Peak to Mweka Camp','Summit Night. A frigid, majestic climb to the roof of Africa. Descend all the way to Mweka Camp.',5895,'5 km ascent / 12 km descent','7-8 hours ascent / 4-6 hours descent','Arctic','Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(22,3,8,'Mweka Camp to Gate','A final, triumphant descent through the montane forest to collect your summit certificates.',1640,'10 km','3-4 hours','Rain Forest','Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(23,4,1,'Londorossi Gate to Mti Mkubwa','Begin the expedition in the dense, silent beauty of the western montane forest.',NULL,NULL,NULL,NULL,'Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(24,4,2,'Mti Mkubwa to Shira 2 Camp','A rapid push across the Shira Plateau directly to camp 2.',NULL,NULL,NULL,NULL,'Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(25,4,3,'Shira 2 Camp to Barranco Camp','Climb high to Lava Tower (4,600m), sleep low in the Barranco Valley.',NULL,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(26,4,4,'Barranco Camp to Karanga Camp','Conquer the Barranco Wall before settling in the Karanga Valley.',NULL,NULL,NULL,NULL,'Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(27,4,5,'Karanga Camp to Barafu Camp','Trek into the stark alpine desert to the primary base camp.',NULL,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(28,4,6,'Barafu Camp to Crater Camp','A unique daytime ascent to Stella Point, continuing past glaciers to sleep inside the ancient crater itself.',NULL,NULL,NULL,NULL,'Crater Camp (5,730m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(29,4,7,'Crater to Uhuru Peak to Mweka Camp','A brief one-hour sunrise hike to the absolute summit, followed by a massive, grueling descent.',NULL,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(30,4,8,'Mweka Camp to Gate','A heroic descent through the forest to the exit gate.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(31,5,1,'Londorossi Gate to Mti Mkubwa','Forest trek.',2810,NULL,NULL,NULL,'Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(32,5,2,'Mti Mkubwa to Shira 1 Camp','Emerging onto the plateau.',3500,NULL,NULL,NULL,'Shira 1 Camp (3,500m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(33,5,3,'Shira 1 to Shira 2 Camp','Plateau crossing.',3850,NULL,NULL,NULL,'Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(34,5,4,'Shira 2 to Barranco Camp','Acclimatization via Lava Tower.',3900,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(35,5,5,'Barranco to Karanga Camp','Wall scramble and valley traverse.',3995,NULL,NULL,NULL,'Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(36,5,6,'Karanga Camp to Barafu Camp','Arrive at base camp.',4680,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(37,5,7,'Barafu Camp to Crater Camp','Daytime ascent to sleep next to Furtwängler Glacier.',5730,NULL,NULL,NULL,'Crater Camp (5,730m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(38,5,8,'Crater to Uhuru Peak to Mweka Camp','Sunrise at the peak, then the long descent.',5895,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(39,5,9,'Mweka Camp to Gate','Final exit.',1640,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(40,6,1,'Machame Gate to Machame Camp','Begin your adventure on the lush southern slopes, winding through dense rainforest.',2835,'11 km','5-7 hours','Rain Forest','Machame Camp (2,835m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(41,6,2,'Machame Camp to Shira Cave Camp','Leave the forest canopy behind as you ascend onto the rugged moorland.',3750,'5 km','4-6 hours','Moorland','Shira Cave Camp (3,750m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(42,6,3,'Shira Cave to Barranco Camp','Ascend to the Lava Tower (4,600m) before descending into the surreal Barranco Valley.',3900,'10 km','6-8 hours','Semi-Desert','Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(43,6,4,'Barranco Camp to Barafu Camp','A relentless push climbing the Barranco Wall and bypassing Karanga to reach base camp directly.',4680,'9 km','8-10 hours','Alpine Desert','Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(44,6,5,'Barafu to Uhuru Peak to Mweka','Midnight summit assault, followed by a dramatic descent down the mountain.',5895,'5 km ascent / 12 km descent','7-8 hours ascent / 4-6 hours descent','Arctic','Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(45,6,6,'Mweka Camp to Gate','Final hike out through the rainforest.',1640,'10 km','3-4 hours','Rain Forest','Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(46,7,1,'Machame Gate to Machame Camp','Trek through the dense rainforest.',2835,'11 km','5-7 hours','Rain Forest','Machame Camp (2,835m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(47,7,2,'Machame Camp to Shira Cave','Ascend into the moorland zones.',3750,'5 km','4-6 hours','Moorland','Shira Cave Camp (3,750m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(48,7,3,'Shira Cave to Barranco Camp','Crucial climb high, sleep low day via Lava Tower.',3900,'10 km','6-8 hours','Semi-Desert','Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(49,7,4,'Barranco Camp to Karanga Camp','Scale the Barranco Wall, resting in the Karanga Valley.',3995,'5 km','4-5 hours','Alpine Desert','Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(50,7,5,'Karanga Camp to Barafu Camp','A short, steep hike to base camp.',4680,'4 km','4-5 hours','Alpine Desert','Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(51,7,6,'Barafu to Uhuru Peak to Mweka','Summit night. Push to the peak and descend.',5895,'5 km ascent / 12 km descent','7-8 hours ascent / 4-6 hours descent','Arctic','Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(52,7,7,'Mweka Camp to Gate','Final descent to the exit.',1640,'10 km','3-4 hours','Rain Forest','Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(53,8,1,'Rongai Gate to Simba Camp','Trek through pine forests on the northern slopes.',2600,NULL,NULL,NULL,'Simba Camp (2,600m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(54,8,2,'Simba Camp to Second Cave','Ascend into moorland with views over Kenya.',3450,NULL,NULL,NULL,'Second Cave (3,450m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(55,8,3,'Second Cave to Third Cave','A steady trek across the northern flank.',3870,NULL,NULL,NULL,'Third Cave (3,870m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(56,8,4,'Third Cave to Kibo Hut','Cross the lunar saddle desert to base camp.',4720,NULL,NULL,NULL,'Kibo Hut (4,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(57,8,5,'Kibo Hut to Uhuru Peak to Horombo','Midnight summit assault, descending to Horombo.',5895,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(58,8,6,'Horombo Hut to Marangu Gate','Exit via the southern Marangu trail.',1860,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(59,9,1,'Rongai Gate to Simba Camp','Trek through pine forests on the northern slopes.',NULL,NULL,NULL,NULL,'Simba Camp (2,600m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(60,9,2,'Simba Camp to Second Cave','Ascend into moorland.',NULL,NULL,NULL,NULL,'Second Cave (3,450m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(61,9,3,'Second Cave to Kikelewa Cave','Trek towards the jagged peaks of Mawenzi.',NULL,NULL,NULL,NULL,'Kikelewa Cave (3,600m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(62,9,4,'Kikelewa Cave to Mawenzi Tarn','A steep, rewarding climb into the striking Mawenzi cirque.',NULL,NULL,NULL,NULL,'Mawenzi Tarn (4,315m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(63,9,5,'Mawenzi Tarn to Kibo Hut','Cross the Alpine desert saddle connecting Mawenzi to Kibo.',NULL,NULL,NULL,NULL,'Kibo Hut (4,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(64,9,6,'Kibo Hut to Uhuru Peak to Horombo','Summit Night.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(65,9,7,'Horombo Hut to Marangu Gate','Descent through the rainforest.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(66,10,1,'Marangu Gate to Mandara Hut','A steady climb through the lower rainforest.',NULL,NULL,NULL,NULL,'Mandara Hut (2,700m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(67,10,2,'Mandara Hut to Horombo Hut','Emerge into the heath and moorland zones.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(68,10,3,'Horombo Hut to Kibo Hut','Trek across the saddle directly to base camp.',NULL,NULL,NULL,NULL,'Kibo Hut (4,700m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(69,10,4,'Kibo Hut to Uhuru Peak to Horombo','Midnight ascent to the peak and descend.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(70,10,5,'Horombo Hut to Gate','Final exit.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(71,11,1,'Marangu Gate to Mandara Hut','A steady climb through the lower rainforest.',NULL,NULL,NULL,NULL,'Mandara Hut (2,700m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(72,11,2,'Mandara Hut to Horombo Hut','Emerge into the heath and moorland zones.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(73,11,3,'Horombo Hut (Acclimatization)','A hike to Zebra Rocks to acclimatize before returning to the same hut.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(74,11,4,'Horombo Hut to Kibo Hut','Trek across the saddle directly to base camp.',NULL,NULL,NULL,NULL,'Kibo Hut (4,700m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(75,11,5,'Kibo Hut to Uhuru Peak to Horombo','Midnight ascent to the peak and descend.',NULL,NULL,NULL,NULL,'Horombo Hut (3,720m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(76,11,6,'Horombo Hut to Gate','Final exit.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(77,12,1,'Londorossi Gate to Mti Mkubwa','Forest trek.',NULL,NULL,NULL,NULL,'Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(78,12,2,'Mti Mkubwa to Shira 1 Camp','Emerging onto the plateau.',NULL,NULL,NULL,NULL,'Shira 1 Camp (3,500m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(79,12,3,'Shira 1 to Shira 2 Camp','Trek eastward across the caldera.',NULL,NULL,NULL,NULL,'Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(80,12,4,'Shira 2 to Moir Hut','Hike to the isolated Moir Hut beneath the Lent Hills.',NULL,NULL,NULL,NULL,'Moir Hut (4,200m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(81,12,5,'Moir Hut to Buffalo Camp','Begin the true northern traverse through the high-altitude desert.',NULL,NULL,NULL,NULL,'Buffalo Camp (4,020m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(82,12,6,'Buffalo Camp to Third Cave','Sweep across the northern flank with views of Kenya.',NULL,NULL,NULL,NULL,'Third Cave (3,870m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(83,12,7,'Third Cave to School Hut','Ascend to the Saddle and prepare for the summit.',NULL,NULL,NULL,NULL,'School Hut (4,750m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(84,12,8,'School Hut to Uhuru Peak to Mweka','Extremely long summit night, arriving at dawn, descending south.',NULL,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(85,12,9,'Mweka Camp to Gate','Final exit through the forest.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(86,13,1,'Londorossi Gate to Mti Mkubwa','Forest trek.',NULL,NULL,NULL,NULL,'Mti Mkubwa Camp (2,810m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(87,13,2,'Mti Mkubwa to Shira 1','Onto the plateau.',NULL,NULL,NULL,NULL,'Shira 1 Camp (3,500m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(88,13,3,'Shira 1 to Shira 2','Plateau crossing.',NULL,NULL,NULL,NULL,'Shira 2 Camp (3,850m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(89,13,4,'Shira 2 to Moir Hut','Lent Hills.',NULL,NULL,NULL,NULL,'Moir Hut (4,200m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(90,13,5,'Moir Hut to Buffalo Camp','Northern traverse begins.',NULL,NULL,NULL,NULL,'Buffalo Camp (4,020m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(91,13,6,'Buffalo Camp to Third Cave','Northern slopes.',NULL,NULL,NULL,NULL,'Third Cave (3,870m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(92,13,7,'Third Cave to School Hut','Base camp.',NULL,NULL,NULL,NULL,'School Hut (4,750m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(93,13,8,'School Hut to Crater Camp','Daytime ascent to the caldera. Sleep next to glaciers.',NULL,NULL,NULL,NULL,'Crater Camp (5,730m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(94,13,9,'Crater to Uhuru Peak to Mweka','Short walk to summit, massive descent.',NULL,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(95,13,10,'Mweka Camp to Gate','Exit.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(96,14,1,'Umbwe Gate to Umbwe Cave','Severe vertical ascent through rainforest.',NULL,NULL,NULL,NULL,'Umbwe Cave Camp (2,850m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(97,14,2,'Umbwe Cave to Barranco Camp','Ridge scrambling to beneath the Barranco Wall.',NULL,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(98,14,3,'Barranco Camp to Lava Tower to Barranco','Acclimatize high at Lava Tower, sleep back at Barranco.',NULL,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(99,14,4,'Barranco to Barafu Camp','Climb the wall and bypass Karanga directly to base camp.',NULL,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(100,14,5,'Barafu to Uhuru Peak to Mweka','Summit night.',NULL,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(101,14,6,'Mweka Camp to Gate','Exit.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(102,15,1,'Umbwe Gate to Umbwe Cave','Severe vertical ascent through rainforest.',NULL,NULL,NULL,NULL,'Umbwe Cave Camp (2,850m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(103,15,2,'Umbwe Cave to Barranco Camp','Ridge scrambling to beneath the Barranco Wall.',NULL,NULL,NULL,NULL,'Barranco Camp (3,900m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(104,15,3,'Barranco Camp to Karanga Camp','Scale the Great Barranco Wall.',NULL,NULL,NULL,NULL,'Karanga Camp (3,995m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(105,15,4,'Karanga Camp to Barafu Camp','Hike through alpine desert to base camp.',NULL,NULL,NULL,NULL,'Barafu Camp (4,680m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(106,15,5,'Barafu to Uhuru Peak to Mweka','Summit night.',NULL,NULL,NULL,NULL,'Mweka Camp (3,100m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(107,15,6,'Mweka Camp to Gate','Exit.',NULL,NULL,NULL,NULL,'Hotel in Moshi','B','2026-03-18 12:39:44','2026-03-18 12:39:44'),(108,16,1,'Momella Gate to Miriakamba Hut','A beautiful walking safari start through the lower slopes of Arusha National Park.',2514,'10 km','4-5 hours','Montane Forest','Miriakamba Hut (2,514m)','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(109,16,2,'Miriakamba Hut to Saddle Hut','A steep climb through the forest and heather zone with views of the Ash Cone.',3570,'4 km','3-5 hours','Heather/Moorland','Saddle Hut (3,570m)','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(110,16,3,'Saddle Hut to Socialist Peak to Gate','Midnight summit push along the crater rim, followed by a long descent to the gate.',4562,'5 km up / 14 km down','4-6 hours up / 5-7 hours down','Alpine Desert/Arctic','Hotel in Arusha','B, L','2026-03-18 12:39:44','2026-03-18 12:39:44'),(111,17,1,'Momella Gate to Miriakamba Hut','Spot wildlife on the way to the first hut.',2514,NULL,NULL,NULL,'Miriakamba Hut','L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(112,17,2,'Miriakamba Hut to Saddle Hut','Climb through the lush forest zone.',3570,NULL,NULL,NULL,'Saddle Hut','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(113,17,3,'Saddle Hut (Acclimatization) & Little Meru','Hike to Little Meru for stunning views and better adaptation.',3820,NULL,NULL,NULL,'Saddle Hut','B, L, D','2026-03-18 12:39:44','2026-03-18 12:39:44'),(114,17,4,'Socialist Peak to Gate','The final push and descent.',4562,NULL,NULL,NULL,'Hotel in Arusha','B, L','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `route_itinerary_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `safari_packages`
--

DROP TABLE IF EXISTS `safari_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `safari_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL,
  `inclusions` json DEFAULT NULL,
  `exclusions` json DEFAULT NULL,
  `itinerary` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `safari_packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `safari_packages`
--

LOCK TABLES `safari_packages` WRITE;
/*!40000 ALTER TABLE `safari_packages` DISABLE KEYS */;
INSERT INTO `safari_packages` VALUES (1,'great-migration-edition','The Great Migration Edition','SIGNATURE','10 Days · Serengeti • Ngorongoro • Manyara',10,'A definitive 10-day expedition tracking the Great Wildebeest Migration across the Serengeti plains. This signature safari offers front-row seats to nature\'s most dramatic spectacle, complemented by luxury tented camps and exclusive wilderness access.','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop',8400.00,'[\"Private Custom 4x4 Safari Cruiser with pop-up roof\", \"Elite Multi-lingual Driver-Guide\", \"Ultra-Luxury Tented Camps inside the National Parks\", \"All Park Entry, Concession, and Crater Fees\", \"Exclusive Serengeti Bush Dinner Experience\", \"Internal Bush Flights (if applicable to itinerary)\", \"All Chef-Prepared Meals on Safari (B, L, D)\", \"Unlimited Bottled Water, Coffee, and Tea\", \"Flying Doctors Emergency Evacuation Cover\"]','[\"International Flights and Visas\", \"Premium Alcoholic Beverages\", \"Gratuities for Guide and Camp Staff\", \"Optional Hot Air Balloon Safari ($599 pp)\", \"Travel Insurance\"]','[{\"day\": 1, \"desc\": \"Touch down at Kilimanjaro International Airport. Your private chauffeur will transfer you to a serene coffee lodge on the outskirts of Arusha for rest and briefing.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Arusha\", \"accommodation\": \"Legendary Lodge\"}, {\"day\": 2, \"desc\": \"Descend into the Great Rift Valley for a game drive amidst the groundwater forests of Lake Manyara, seeking tree-climbing lions and vast flocks of flamingos.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Lake Manyara National Park\", \"accommodation\": \"Lake Manyara Tree Lodge\"}, {\"day\": 3, \"desc\": \"Ascend to the rim of the Ngorongoro Crater. Enjoy an afternoon guided walk along the crater rim or visit a traditional Maasai Boma in the afternoon light.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Highlands\", \"accommodation\": \"Ngorongoro Crater Lodge\"}, {\"day\": 4, \"desc\": \"A dawn descent into the caldera. This UNESCO World Heritage site is a haven for the Big Five, including the critically endangered black rhino. Enjoy a picnic lunch by the hippo pool.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Crater Descent\", \"accommodation\": \"Ngorongoro Crater Lodge\"}, {\"day\": 5, \"desc\": \"Depart the highlands and traverse the rolling plains into the Serengeti. The afternoon is dedicated to following the migrating herds and observing predator activity.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Enter the Serengeti\", \"accommodation\": \"Singita Sasakwa Lodge\"}, {\"day\": 6, \"desc\": \"Drive to the extreme north of the park. Position yourself along the Mara River, waiting for the dramatic, chaotic spectacle of wildebeest crossing crocodile-infested waters.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Northern Serengeti - The Mara River\", \"accommodation\": \"Sayari Camp\"}, {\"day\": 7, \"desc\": \"A full day dedicated to the river. Nature dictates the schedule here, demanding patience that is often rewarded with unparalleled wildlife theater.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Full Day River Crossings\", \"accommodation\": \"Sayari Camp\"}, {\"day\": 8, \"desc\": \"Head south to the Seronera valley, famous for its resident leopards lounging in sausage trees and vast lion prides surveying the golden grasses.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Central Serengeti - Seronera\", \"accommodation\": \"Four Seasons Safari Lodge\"}, {\"day\": 9, \"desc\": \"Optional dawn hot air balloon safari over the plains, concluding with a champagne breakfast. Spend your final afternoon tracking cheetahs on the open savanna.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Plains at Dawn\", \"accommodation\": \"Four Seasons Safari Lodge\"}, {\"day\": 10, \"desc\": \"A final morning game drive en route to the Seronera airstrip. Fly back to Arusha over the crater highlands for an evening departure flight.\", \"meals\": \"Breakfast, Lunch\", \"title\": \"Serengeti to Arusha\", \"accommodation\": \"Day Room in Arusha\"}]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'pioneers-route','The Pioneer\'s Route','CLASSIC','7 Days · Tarangire • Manyara • Ngorongoro',7,'A profound 7-day immersion into the lesser-traveled paths of the Northern Circuit. Focused on massive elephant herds, ancient baobabs, and the geological wonder of the Rift Valley.','https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=2000&q=85&auto=format&fit=crop',5200.00,'[\"Private Custom 4x4 Safari Cruiser\", \"Elite Head Guide & Tracker\", \"Premium Lodge Accommodation throughout\", \"Guided Walking Safaris in Tarangire\", \"All Park, Concession, and Crater Fees\", \"All Chef-Prepared Meals (B, L, D)\", \"Sundowner experiences\"]','[\"International Flights\", \"Gratuities\", \"Visas\", \"Travel Insurance\"]','[{\"day\": 1, \"desc\": \"Arrive at Kilimanjaro Airport where our guide will meet you. Transfer to your boutique hotel in Arusha to unwind.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Tanzania\", \"accommodation\": \"Arusha Coffee Lodge\"}, {\"day\": 2, \"desc\": \"Drive to Tarangire, a landscape dominated by ancient baobab trees and the twisting Tarangire River. Spend the afternoon observing the massive elephant herds.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Tarangire National Park\", \"accommodation\": \"Oliver\'s Camp\"}, {\"day\": 3, \"desc\": \"A morning walking safari with an armed ranger. Experience the bush intimately—tracking footprints, identifying flora, and feeling the wild pulse of the land.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Walking Safari in Tarangire\", \"accommodation\": \"Oliver\'s Camp\"}, {\"day\": 4, \"desc\": \"A short drive to the escarpment of the Great Rift Valley. After a standard afternoon game drive, embark on a rare night safari to seek out leopards, genets, and porcupines.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Lake Manyara Night Drive\", \"accommodation\": \"Escarpment Luxury Lodge\"}, {\"day\": 5, \"desc\": \"Climb through the rich agricultural lands of Karatu up to the Ngorongoro Highlands. The afternoon is spent relaxing by the fire as the mountain air cools.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Journey to the Crater\", \"accommodation\": \"Gibb\'s Farm\"}, {\"day\": 6, \"desc\": \"An extended, full-day game drive on the crater floor. This enclosed microcosm is the best place in East Africa to spot the Big Five in a single day.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Caldera Ecosystem\", \"accommodation\": \"Gibb\'s Farm\"}, {\"day\": 7, \"desc\": \"Enjoy a final, leisurely farm-to-table breakfast before returning to Arusha. Browse the Cultural Heritage Center before your onward flight.\", \"meals\": \"Breakfast, Lunch\", \"title\": \"Return to Arusha\", \"accommodation\": \"None\"}]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'grand-canvas','The Grand Canvas','EXCLUSIVE','14 Days · Northern Parks • Zanzibar',14,'The ultimate bush-to-beach odyssey. Two weeks combining the raw, visceral thrill of the deep Serengeti with the languid, spice-scented luxury of a secluded Zanzibar retreat.','https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=2000&q=85&auto=format&fit=crop',14500.00,'[\"Internal Bush Flights (Serengeti, Zanzibar, Arusha)\", \"Private Custom 4x4 Safari Cruiser with pop-up roof\", \"Private Chef & Butler in select camps\", \"Ultra-Luxury Accommodation\", \"All Park and Concession Fees\", \"All Meals and Premium Beverages on Safari\", \"Zanzibar Recovery Retreat (Half Board or All-Inclusive)\", \"Private Dhow Sunset Cruise in Zanzibar\"]','[\"International Flights\", \"Vintage Wines and Champagnes\", \"Spa Treatments\", \"Gratuities for Guides and Staff\"]','[{\"day\": 1, \"desc\": \"Private VIP transfer from Kilimanjaro Airport to a secluded estate.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Arusha\", \"accommodation\": \"Legendary Lodge\"}, {\"day\": 2, \"desc\": \"Drive to Tarangire. Afternoon game drive focusing on elephant encounters.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Tarangire Wilderness\", \"accommodation\": \"Kuro Tarangire\"}, {\"day\": 3, \"desc\": \"Traverse the Rift Valley to the highlands. Afternoon at leisure.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Highlands\", \"accommodation\": \"The Highlands\"}, {\"day\": 4, \"desc\": \"Dawn descent into the Ngorongoro Crater for premier big game viewing.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Crater Floor\", \"accommodation\": \"The Highlands\"}, {\"day\": 5, \"desc\": \"Fly or drive into the Serengeti. Encounter the vast lion prides of the Seronera valley.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Central Serengeti\", \"accommodation\": \"Namiri Plains\"}, {\"day\": 6, \"desc\": \"A full day exploring the eastern Serengeti, a territory renowned for cheetah and leopard.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Predator Tracking\", \"accommodation\": \"Namiri Plains\"}, {\"day\": 7, \"desc\": \"Game drive north towards the Mara River. The landscape changes from plains to rolling hills.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Northern Serengeti\", \"accommodation\": \"Singita Mara River Tented Camp\"}, {\"day\": 8, \"desc\": \"A day spent along the riverbanks, seeking the elusive and dramatic river crossings.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Mara River\", \"accommodation\": \"Singita Mara River Tented Camp\"}, {\"day\": 9, \"desc\": \"Board a light aircraft from the Serengeti bush directly to the spice island of Zanzibar.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Bush to Beach\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 10, \"desc\": \"A day of absolute recovery. White sands, turquoise waters, and ocean breezes.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Zanzibar Coast\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 11, \"desc\": \"Explore the labyrinthine alleys of historic Stone Town and visit a local spice farm.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Stone Town & Spice Tour\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 12, \"desc\": \"Sail on a traditional wooden dhow, snorkeling the vibrant coral reefs.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Indian Ocean Excursion\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 13, \"desc\": \"Your final full day to bask in the sun or indulge in world-class spa treatments.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Barefoot Luxury\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 14, \"desc\": \"Private transfer to Zanzibar Airport for your international flight home.\", \"meals\": \"Breakfast\", \"title\": \"Departure\", \"accommodation\": \"None\"}]','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `safari_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('64JXczStnkKsVdQfc2Cit5iBhRChJlA5XNSHPxfQ',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUhFQzdRWlRveWdRQmtnQk44dFdWMVBZNmZUQ1JlSHlDTlJhbjhpeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMS9hcGkvYWRtaW4vbm90aWZpY2F0aW9ucz9wZXJfcGFnZT0xMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1773852571),('gG5lcv95LunwJY6WM6bLtA5w1AcUjbdeLGdK1WxS',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTE92UThOSVRVUDZxazAxYXVJV0V3OEsxdGRuZXFQbFlIS1kyZ2NyRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9hcGkvdXNlciI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1773848522);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`),
  KEY `site_settings_group_index` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trekking_routes`
--

DROP TABLE IF EXISTS `trekking_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trekking_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `difficulty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elevation_gain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL,
  `max_group_size` int DEFAULT NULL,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlights` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trekking_routes_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trekking_routes`
--

LOCK TABLES `trekking_routes` WRITE;
/*!40000 ALTER TABLE `trekking_routes` DISABLE KEYS */;
INSERT INTO `trekking_routes` VALUES (1,'6 Days Lemosho Route','lemosho-6-days',NULL,'A rapid, direct ascent crafted for the experienced or pre-acclimatized climber. This itinerary skips the Shira 1 camp and combines days to reach the summit faster.','High',6,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','75%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'7 Days Lemosho Route','lemosho-7-days',NULL,'A highly popular itinerary that introduces a critical acclimatization stop in the Karanga Valley before the final summit push.','Moderate-High',7,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','85%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'8 Days Lemosho Route','lemosho-8-days',NULL,'The gold standard for Kilimanjaro. This extended itinerary provides the absolute optimal acclimatization profile, maximizing both summit success and enjoyment.','Moderate',8,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','95%+','[\"Optimum Acclimatization: Features the absolute ideal ascent profile to minimize altitude sickness.\", \"High Success Rate: Enjoy a 95%+ success rate due to the gentle pace.\", \"Scenic Variety: Trek through every ecological zone, from montane forest to the arctic summit.\", \"Crowd Avoidance: Approaches from the remote west, avoiding the heavy traffic of the Machame route until day 4.\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,'8 Days Lemosho with Crater Camp','lemosho-8-days-crater',NULL,'An elite expedition for the deeply adventurous. Sleep within the ancient volcanic caldera of Kilimanjaro at Crater Camp, surrounded by sheer ice glaciers.','Extreme',8,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','80%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,'9 Days Lemosho with Crater Camp','lemosho-9-days-crater',NULL,'The most luxurious and comprehensively acclimatized Crater Camp itinerary available. Experience the wonders of the caldera with minimized risk of severe altitude sickness.','High',9,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','90%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,'6 Days Machame Route','machame-6-days',NULL,'A rigorous, fast-paced ascent along the \'Whiskey Route\' for the exceptionally fit. An aggressive acclimatization profile that rewards determined climbers.','High',6,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522163182402-834f871fd851?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','70%','[\"The Whiskey Route: Kilimanjaro\'s most legendary and scenically diverse path.\", \"Visual Spectacle: Offers breathtaking views of the Shira Plateau and the southern glaciers.\", \"Technical Challenge: Features the thrilling scramble up the Great Barranco Wall.\", \"High Elevation Profile: Rapid ascent that rewards the physically prepared trekker.\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,'7 Days Machame Route','machame-7-days',NULL,'The recommended Machame expedition. An essential extra day is added in the Karanga Valley to vastly improve acclimatization and summit success.','Moderate-High',7,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','85%','[\"Optimal Acclimatization: Includes an extra day at Karanga Valley to maximize summit success.\", \"The Great Barranco Wall: An unforgettable scramble offering the best views on the mountain.\", \"Lava Tower: Spend high-altitude time at 4,600m to trigger physiological adaptation.\", \"Five Ecological Zones: Experience everything from tropical jungle to glacial moonscapes.\"]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,'6 Days Rongai Route','rongai-6-days',NULL,'A direct ascent via the less-traveled, drier northern slopes. Offers a steady incline and unique wilderness before descending via Marangu.','Moderate',6,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','80%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,'7 Days Rongai Route','rongai-7-days',NULL,'Our recommended Rongai expedition. An extra acclimatization day at the spectacular Mawenzi Tarn ensures a vastly stronger summit bid.','Moderate',7,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','90%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,'5 Days Marangu Route','marangu-5-days',NULL,'A fast, direct ascent along the historic original route, utilizing comfortable A-frame huts instead of tents. For the highly experienced trekker only due to brutal acclimatization.','High',5,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','60%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,'6 Days Marangu Route','marangu-6-days',NULL,'Our recommended Marangu itinerary. An essential extra acclimatization day safely spent at Horombo Hut maximizes your summit success while enjoying the comforts of the huts.','Moderate',6,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','80%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,'9 Days Northern Circuit','northern-circuit-9-days',NULL,'The magnificent grand traverse. Our longest and most exclusive expedition, offering unparalleled acclimatization and breathtaking absolute solitude via the remote northern slopes.','High',9,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','95%+','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(13,'10 Days Northern Circuit with Crater','northern-circuit-10-days-crater',NULL,'The absolute pinnacle of Kilimanjaro expeditions. A slow, majestic 360-degree traverse concluding with a rare and exclusive overnight stay within the ancient volcanic caldera.','Extreme',10,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','90%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(14,'6 Days Umbwe Route','umbwe-6-days',NULL,'A steep, uncompromising vertical climb straight to the roof of Africa. Reserved exclusively for highly experienced, pre-acclimatized mountaineers.','Extreme',6,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1522163182402-834f871fd851?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','60%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(15,'7 Days Umbwe Route','umbwe-7-days',NULL,'Our recommended Umbwe itinerary. Incorporates a vital acclimatization day in the Karanga Valley to temper the route\'s extreme verticality.','High',7,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','75%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(16,'3 Days Mount Meru Trek','mt-meru-3-days',NULL,'A focused, high-paced ascent of Tanzania\'s second highest peak. Ideal for fit climbers using Meru as a final acclimatization push before Kilimanjaro.','Moderate-High',3,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','90%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44'),(17,'4 Days Mount Meru Trek','mt-meru-4-days',NULL,'The classic Meru experience. This extra day allows for optimal acclimatization and a side trip to Little Meru, significantly enhancing the enjoyment of the summit rim walk.','Moderate',4,NULL,NULL,0.00,12,'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','95%','[]','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `trekking_routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@tanzaniasensational.com',NULL,'$2y$12$ZJcYuL.fXBnUeZVCNOBQV.zL6tyGPqCx0BqK5OsZW4sf6uDIImZZ.','admin',NULL,'2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visual_assets`
--

DROP TABLE IF EXISTS `visual_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visual_assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visual_assets_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visual_assets`
--

LOCK TABLES `visual_assets` WRITE;
/*!40000 ALTER TABLE `visual_assets` DISABLE KEYS */;
INSERT INTO `visual_assets` VALUES (1,'branding.logo','branding_logo_logo','/logo.png','image','{\"alt\": \"branding / logo\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(2,'branding.favicon','branding_favicon_favicon','/favicon.ico','image','{\"alt\": \"branding / favicon\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(3,'common.bentoPattern','common_bentopattern_stardust','https://www.transparenttextures.com/patterns/stardust.png','image','{\"alt\": \"common / bento Pattern\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(4,'common.placeholderHero','common_placeholderhero_photo_1547970810_dc1eac37d174','https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"common / placeholder Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(5,'home.hero','home_hero_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2400&q=90','image','{\"alt\": \"home / hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(6,'home.experienceMain','home_experiencemain_photo_1516026672322_bc52d61a55d5','https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=85&auto=format&fit=crop','image','{\"alt\": \"home / experience Main\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(7,'home.experienceSecondary','home_experiencesecondary_photo_1544735716_392fe2489ffa','https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=85&auto=format&fit=crop','image','{\"alt\": \"home / experience Secondary\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(8,'home.extensionSerengeti','home_extensionserengeti_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"home / extension Serengeti\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(9,'home.extensionZanzibar','home_extensionzanzibar_photo_1537996194471_e657df975ab4','https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"home / extension Zanzibar\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(10,'home.testimonial1','home_testimonial1_photo_1507003211169_0a1dd7228f2d','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80&auto=format&fit=crop','image','{\"alt\": \"home / testimonial1\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(11,'home.testimonial2','home_testimonial2_photo_1544367567_0f2fcb009e0b','https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop','image','{\"alt\": \"home / testimonial2\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(12,'home.testimonial3','home_testimonial3_photo_1549366021_9f761d450615','https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=800&auto=format&fit=crop','image','{\"alt\": \"home / testimonial3\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(13,'home.ctaBg','home_ctabg_photo_1516026672322_bc52d61a55d5','https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"home / cta Bg\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(14,'about.hero','about_hero_photo_1621414050946_1b936a78490b','https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"about / hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(15,'about.legacy','about_legacy_photo_1631646109206_4919df38eb68','https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop','image','{\"alt\": \"about / legacy\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(16,'about.experienceBand','about_experienceband_photo_1650668302197_7f556c34cb91','https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"about / experience Band\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(17,'zanzibar.hero','zanzibar_hero_photo_1586861635167_e5223aadc9fe','https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80','image','{\"alt\": \"zanzibar / hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(18,'zanzibar.regionStoneTown','zanzibar_regionstonetown_photo_1580979878201_1e9d1a3eb64f','https://images.unsplash.com/photo-1580979878201-1e9d1a3eb64f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"zanzibar / region Stone Town\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(19,'zanzibar.regionNungwi','zanzibar_regionnungwi_photo_1621845184551_bb5e7141ecf4','https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"zanzibar / region Nungwi\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(20,'zanzibar.regionPaje','zanzibar_regionpaje_photo_1579471923053_ec4f6762edbc','https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"zanzibar / region Paje\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(21,'zanzibar.expSpice','zanzibar_expspice_photo_1606041008023_472dfb5e530f','https://images.unsplash.com/photo-1606041008023-472dfb5e530f?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80','image','{\"alt\": \"zanzibar / exp Spice\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(22,'zanzibar.expSafariBlue','zanzibar_expsafariblue_photo_1533221375330_84c6af70ce9b','https://images.unsplash.com/photo-1533221375330-84c6af70ce9b?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80','image','{\"alt\": \"zanzibar / exp Safari Blue\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(23,'zanzibar.expPrisonIsland','zanzibar_expprisonisland_photo_1437622368342_7a3d73a40cfa','https://images.unsplash.com/photo-1437622368342-7a3d73a40cfa?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80','image','{\"alt\": \"zanzibar / exp Prison Island\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(24,'planning.meruHero','planning_meruhero_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"planning / meru Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(25,'planning.gearHero','planning_gearhero_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"planning / gear Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(26,'planning.trainingHero','planning_traininghero_photo_1551698618_1dfe5d97d256','https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"planning / training Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(27,'planning.faqHero','planning_faqhero_photo_1589308454676_e1af9491a670','https://images.unsplash.com/photo-1589308454676-e1af9491a670?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"planning / faq Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(28,'planning.addonsHero','planning_addonshero_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"planning / addons Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(29,'planning.addonsCrater','planning_addonscrater_photo_1534177616072_ef7dc120449d','https://images.unsplash.com/photo-1534177616072-ef7dc120449d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80','image','{\"alt\": \"planning / addons Crater\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(30,'planning.addonsZanzibar','planning_addonszanzibar_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80','image','{\"alt\": \"planning / addons Zanzibar\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(31,'trekking.routes.lemosho','trekking_routes_lemosho_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / lemosho\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(32,'trekking.routes.lemoshoEditorial','trekking_routes_lemoshoeditorial_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / lemosho Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(33,'trekking.routes.machame','trekking_routes_machame_photo_1522163182402_834f871fd851','https://images.unsplash.com/photo-1522163182402-834f871fd851?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / machame\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(34,'trekking.routes.machameEditorial','trekking_routes_machameeditorial_photo_1544367567_0f2fcb009e0b','https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / machame Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(35,'trekking.routes.marangu','trekking_routes_marangu_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / marangu\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(36,'trekking.routes.maranguEditorial','trekking_routes_marangueditorial_photo_1544367567_0f2fcb009e0b','https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / marangu Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(37,'trekking.routes.northern','trekking_routes_northern_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / northern\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(38,'trekking.routes.northernEditorial','trekking_routes_northerneditorial_photo_1542332213_9b5a5a3fad35','https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / northern Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(39,'trekking.routes.umbwe','trekking_routes_umbwe_photo_1522163182402_834f871fd851','https://images.unsplash.com/photo-1522163182402-834f871fd851?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / umbwe\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(40,'trekking.routes.umbweEditorial','trekking_routes_umbweeditorial_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / umbwe Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(41,'trekking.routes.rongai','trekking_routes_rongai_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / routes / rongai\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(42,'trekking.routes.rongaiEditorial','trekking_routes_rongaieditorial_photo_1542332213_9b5a5a3fad35','https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / routes / rongai Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(43,'trekking.common.fullBleed','trekking_common_fullbleed_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / common / full Bleed\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(44,'trekking.common.trailLandscape','trekking_common_traillandscape_photo_1522163182402_834f871fd851','https://images.unsplash.com/photo-1522163182402-834f871fd851?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / common / trail Landscape\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(45,'trekking.prep.bestTime','trekking_prep_besttime_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / best Time\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(46,'trekking.prep.bestTimeEditorial','trekking_prep_besttimeeditorial_photo_1621414050946_1b936a78490b','https://images.unsplash.com/photo-1621414050946-1b936a78490b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80','image','{\"alt\": \"trekking / prep / best Time Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(47,'trekking.prep.bestRoutes','trekking_prep_bestroutes_photo_1589182397057_b82b16867e7c','https://images.unsplash.com/photo-1589182397057-b82b16867e7c?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / best Routes\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(48,'trekking.prep.bestRoutesEditorial','trekking_prep_bestrouteseditorial_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80','image','{\"alt\": \"trekking / prep / best Routes Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(49,'trekking.prep.whyUs','trekking_prep_whyus_photo_1650668302197_7f556c34cb91','https://images.unsplash.com/photo-1650668302197-7f556c34cb91?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / why Us\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(50,'trekking.prep.whyUsEditorial','trekking_prep_whyuseditorial_photo_1631646109206_4919df38eb68','https://images.unsplash.com/photo-1631646109206-4919df38eb68?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / prep / why Us Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(51,'trekking.prep.tippingHero','trekking_prep_tippinghero_photo_1579471923053_ec4f6762edbc','https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / tipping Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(52,'trekking.prep.tippingEditorial','trekking_prep_tippingeditorial_photo_1621414050946_1b936a78490b','https://images.unsplash.com/photo-1621414050946-1b936a78490b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80','image','{\"alt\": \"trekking / prep / tipping Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(53,'trekking.prep.parkFeesHero','trekking_prep_parkfeeshero_photo_1621414050946_1b936a78490b','https://images.unsplash.com/photo-1621414050946-1b936a78490b?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / park Fees Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(54,'trekking.prep.parkFeesEditorial','trekking_prep_parkfeeseditorial_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80','image','{\"alt\": \"trekking / prep / park Fees Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(55,'trekking.prep.toiletsHero','trekking_prep_toiletshero_photo_1580979878201_1e9d1a3eb64f','https://images.unsplash.com/photo-1580979878201-1e9d1a3eb64f?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / prep / toilets Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(56,'trekking.prep.toiletsEditorial','trekking_prep_toiletseditorial_photo_1518173335487_347a0e39129d','https://images.unsplash.com/photo-1518173335487-347a0e39129d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80','image','{\"alt\": \"trekking / prep / toilets Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(57,'trekking.health.vaccinations','trekking_health_vaccinations_photo_1518173335487_347a0e39129d','https://images.unsplash.com/photo-1518173335487-347a0e39129d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / health / vaccinations\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(58,'trekking.health.vaccinationsEditorial','trekking_health_vaccinationseditorial_photo_1584036561566_baf8f5f1b144','https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / health / vaccinations Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(59,'trekking.health.altitudeSickness','trekking_health_altitudesickness_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / health / altitude Sickness\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(60,'trekking.health.altitudeEditorial','trekking_health_altitudeeditorial_photo_1579471923053_ec4f6762edbc','https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / health / altitude Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(61,'trekking.health.oxygen','trekking_health_oxygen_photo_1580979878201_1e9d1a3eb64f','https://images.unsplash.com/photo-1580979878201-1e9d1a3eb64f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / health / oxygen\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(62,'trekking.health.oxygenEditorial','trekking_health_oxygeneditorial_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / health / oxygen Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(63,'trekking.health.diamox','trekking_health_diamox_photo_1621414050946_1b936a78490b','https://images.unsplash.com/photo-1621414050946-1b936a78490b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / health / diamox\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(64,'trekking.health.diamoxEditorial','trekking_health_diamoxeditorial_photo_1606041008023_472dfb5e530f','https://images.unsplash.com/photo-1606041008023-472dfb5e530f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / health / diamox Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(65,'trekking.during.packDaypack','trekking_during_packdaypack_photo_1542224566_6e85f2e6772f','https://images.unsplash.com/photo-1542224566-6e85f2e6772f?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / during / pack Daypack\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(66,'trekking.during.packDaypackEditorial','trekking_during_packdaypackeditorial_photo_1544367567_0f2fcb009e0b','https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / during / pack Daypack Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(67,'trekking.during.food','trekking_during_food_photo_1544025162_d76694265947','https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / during / food\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(68,'trekking.during.foodEditorial','trekking_during_foodeditorial_photo_1541830109_173620392948','https://images.unsplash.com/photo-1541830109-173620392948?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / during / food Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(69,'trekking.during.connectivity','trekking_during_connectivity_photo_1542332213_9b5a5a3fad35','https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / during / connectivity\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(70,'trekking.during.connectivityEditorial','trekking_during_connectivityeditorial_photo_1510100768407_3ce94de8d5c4','https://images.unsplash.com/photo-1510100768407-3ce94de8d5c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / during / connectivity Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(71,'trekking.during.routine','trekking_during_routine_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / during / routine\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(72,'trekking.during.routineEditorial','trekking_during_routineeditorial_photo_1464822759023_fed622ff2c3b','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / during / routine Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(73,'trekking.after.visa','trekking_after_visa_photo_1469854523086_cc02fe5d8800','https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / after / visa\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(74,'trekking.after.visaEditorial','trekking_after_visaeditorial_photo_1589330273594_4289218d80f8','https://images.unsplash.com/photo-1589330273594-4289218d80f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / after / visa Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(75,'trekking.after.training','trekking_after_training_photo_1544367567_0f2fcb009e0b','https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / after / training\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(76,'trekking.after.trainingEditorial','trekking_after_trainingeditorial_photo_1551632811_561732d1e306','https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / after / training Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(77,'trekking.after.gettingThere','trekking_after_gettingthere_photo_1516496636080_14fb876e029d','https://images.unsplash.com/photo-1516496636080-14fb876e029d?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / after / getting There\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(78,'trekking.after.gettingThereEditorial','trekking_after_gettingthereeditorial_photo_1569154941061_e231b47cb8f0','https://images.unsplash.com/photo-1569154941061-e231b47cb8f0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / after / getting There Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(79,'trekking.after.gearList','trekking_after_gearlist_photo_1542282088_fe8426682b8f','https://images.unsplash.com/photo-1542282088-fe8426682b8f?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"trekking / after / gear List\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(80,'trekking.after.gearListEditorial','trekking_after_gearlisteditorial_photo_1536882240095_0379873feb4e','https://images.unsplash.com/photo-1536882240095-0379873feb4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80','image','{\"alt\": \"trekking / after / gear List Editorial\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(81,'safaris.listHero','safaris_listhero_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / list Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(82,'safaris.migrationHero','safaris_migrationhero_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / migration Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(83,'safaris.pioneerHero','safaris_pioneerhero_photo_1523805081730_6144a778afd0','https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / pioneer Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(84,'safaris.canvasHero','safaris_canvashero_photo_1493020256266_db09d97bd02d','https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / canvas Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(85,'safaris.pkgMigration','safaris_pkgmigration_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / pkg Migration\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(86,'safaris.pkgPioneer','safaris_pkgpioneer_photo_1523805081730_6144a778afd0','https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / pkg Pioneer\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(87,'safaris.pkgCanvas','safaris_pkgcanvas_photo_1493020256266_db09d97bd02d','https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"safaris / pkg Canvas\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(88,'contact.hero','contact_hero_photo_1547970810_dc1eac37d174','https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"contact / hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(89,'contact.v2Bg','contact_v2bg_photo_1547970810_dc1eac37d174','https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2500&auto=format&fit=crop','image','{\"alt\": \"contact / v2Bg\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(90,'contact.v2Footer','contact_v2footer_photo_1549400813_f8753239a250','https://images.unsplash.com/photo-1549400813-f8753239a250?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"contact / v2Footer\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(91,'contact.luxuryBg','contact_luxurybg_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop','image','{\"alt\": \"contact / luxury Bg\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(92,'blogs.timeToClimb','blogs_timetoclimb_photo_1549488344_1f9b8d2bd1f3','https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"blogs / time To Climb\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(93,'blogs.clearSkies','blogs_clearskies_photo_1589412225893_ec8c7df768f0','https://images.unsplash.com/photo-1589412225893-ec8c7df768f0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"blogs / clear Skies\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(94,'blogs.migrationGuide','blogs_migrationguide_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"blogs / migration Guide\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(95,'blogs.migrationHerd','blogs_migrationherd_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"blogs / migration Herd\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(96,'blogs.gearGuide','blogs_gearguide_photo_1522814300958_f584e27fdf00','https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80','image','{\"alt\": \"blogs / gear Guide\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(97,'blogs.summitGear','blogs_summitgear_photo_1510100768407_3ce94de8d5c4','https://images.unsplash.com/photo-1510100768407-3ce94de8d5c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80','image','{\"alt\": \"blogs / summit Gear\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(98,'destinations.serengetiHero','destinations_serengetihero_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"destinations / serengeti Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(99,'destinations.serengetiGallery','destinations_serengetigallery_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(100,'destinations.serengetiGallery','destinations_serengetigallery_photo_1534177616072_ef7dc120449d','https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(101,'destinations.serengetiGallery','destinations_serengetigallery_photo_1581852015102_142a2c317022','https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(102,'destinations.serengetiGallery','destinations_serengetigallery_photo_1521651201144_634f700b36ef','https://images.unsplash.com/photo-1521651201144-634f700b36ef?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(103,'destinations.serengetiGallery','destinations_serengetigallery_photo_1511497584788_876760111969','https://images.unsplash.com/photo-1511497584788-876760111969?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(104,'destinations.serengetiGallery','destinations_serengetigallery_photo_1523805081730_6144a778afd0','https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=800&q=80','image','{\"alt\": \"destinations / serengeti Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(105,'destinations.ngorongoroHero','destinations_ngorongorohero_photo_1518173335487_347a0e39129d','https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"destinations / ngorongoro Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(106,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1534177616072_ef7dc120449d','https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(107,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1493246507139_91e8fad9978e','https://images.unsplash.com/photo-1493246507139-91e8fad9978e?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(108,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1516426122078_c23e76319801','https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(109,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1589308454676_e1af9491a670','https://images.unsplash.com/photo-1589308454676-e1af9491a670?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(110,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1520114878144_6123749968dd','https://images.unsplash.com/photo-1520114878144-6123749968dd?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(111,'destinations.ngorongoroGallery','destinations_ngorongorogallery_photo_1549366021_9f761d450615','https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80','image','{\"alt\": \"destinations / ngorongoro Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(112,'destinations.tarangireHero','destinations_tarangirehero_photo_1581852015102_142a2c317022','https://images.unsplash.com/photo-1581852015102-142a2c317022?w=2000&q=85&auto=format&fit=crop','image','{\"alt\": \"destinations / tarangire Hero\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(113,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1581852015102_142a2c317022','https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(114,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1551698618_1dfe5d97d256','https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(115,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1547471080_7cc2caa01a7e','https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(116,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1518173335487_347a0e39129d','https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(117,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1521651201144_634f700b36ef','https://images.unsplash.com/photo-1521651201144-634f700b36ef?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44'),(118,'destinations.tarangireGallery','destinations_tarangiregallery_photo_1541018867375_7f311c63ec94','https://images.unsplash.com/photo-1541018867375-7f311c63ec94?w=800&q=80','image','{\"alt\": \"destinations / tarangire Gallery\"}','2026-03-18 12:39:44','2026-03-18 12:39:44');
/*!40000 ALTER TABLE `visual_assets` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-18 19:49:55
