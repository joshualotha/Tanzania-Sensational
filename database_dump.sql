-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 07, 2026 at 04:35 AM
-- Server version: 10.11.16-MariaDB-cll-lve
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tanzan14_tanzania_sensetional`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `severity` varchar(255) NOT NULL DEFAULT 'info',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `content_html` longtext DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `slug`, `title`, `meta_title`, `excerpt`, `meta_description`, `content`, `content_html`, `hero_image`, `author`, `category`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'kilimanjaro-packing-list-what-actually-matters', 'Kilimanjaro Packing List: What Actually Matters', 'Kilimanjaro Packing List: What Actually Matters | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Kilimanjaro Packing List: What Actually Matters</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Preparation', '2025-10-29 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 'lemosho-vs-machame-choosing-your-route', 'Lemosho vs Machame: Choosing Your Route', 'Lemosho vs Machame: Choosing Your Route | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Lemosho vs Machame: Choosing Your Route</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Routes', '2025-11-25 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 'altitude-acclimatization-a-practical-guide', 'Altitude Acclimatization: A Practical Guide', 'Altitude Acclimatization: A Practical Guide | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Altitude Acclimatization: A Practical Guide</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Health & Safety', '2026-04-05 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(4, 'what-a-kilimanjaro-day-looks-like-on-the-mountain', 'What a Kilimanjaro Day Looks Like on the Mountain', 'What a Kilimanjaro Day Looks Like on the Mountain | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>What a Kilimanjaro Day Looks Like on the Mountain</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'On the Trek', '2026-03-04 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(5, 'safari-after-the-summit-best-pairings', 'Safari After the Summit: Best Pairings', 'Safari After the Summit: Best Pairings | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Safari After the Summit: Best Pairings</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1508672019048-805c876b67e2?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Safari', '2026-03-10 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(6, 'zanzibar-the-perfect-recovery-itinerary', 'Zanzibar: The Perfect Recovery Itinerary', 'Zanzibar: The Perfect Recovery Itinerary | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Zanzibar: The Perfect Recovery Itinerary</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Zanzibar', '2026-02-01 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(7, 'training-for-kilimanjaro-8-weeks-no-guesswork', 'Training for Kilimanjaro: 8 Weeks, No Guesswork', 'Training for Kilimanjaro: 8 Weeks, No Guesswork | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Training for Kilimanjaro: 8 Weeks, No Guesswork</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Preparation', '2026-03-09 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(8, 'how-to-tip-on-kilimanjaro-simple-breakdown', 'How to Tip on Kilimanjaro (Simple Breakdown)', 'How to Tip on Kilimanjaro (Simple Breakdown) | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>How to Tip on Kilimanjaro (Simple Breakdown)</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1520975958225-3f61d2c4ca0b?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Preparation', '2025-11-09 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(9, 'the-5-ecological-zones-of-kilimanjaro', 'The 5 Ecological Zones of Kilimanjaro', 'The 5 Ecological Zones of Kilimanjaro | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>The 5 Ecological Zones of Kilimanjaro</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Kilimanjaro', '2026-02-27 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(10, 'why-group-departures-work-and-when-they-dont', 'Why Group Departures Work (and When They Don’t)', 'Why Group Departures Work (and When They Don’t) | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Why Group Departures Work (and When They Don’t)</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Planning', '2026-02-20 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(11, 'moshi-arrival-hotels-and-what-to-expect', 'Moshi: Arrival, Hotels, and What to Expect', 'Moshi: Arrival, Hotels, and What to Expect | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Moshi: Arrival, Hotels, and What to Expect</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Planning', '2025-12-28 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(12, 'common-mistakes-first-time-trekkers-make', 'Common Mistakes First-Time Trekkers Make', 'Common Mistakes First-Time Trekkers Make | Tanzania Sensational', 'A practical, field-tested guide from our team in Tanzania — designed to help you plan with confidence.', 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.', NULL, '<p><strong>Common Mistakes First-Time Trekkers Make</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>\n<h2>Quick takeaways</h2>\n<ul>\n  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>\n  <li>Prioritize fit and layering over brand names.</li>\n  <li>Slow is smooth, smooth is fast — acclimatization is everything.</li>\n</ul>\n<h2>What we recommend</h2>\n<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>\n<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>\n<p>If you’d like help choosing a route and date, send a booking request — we’ll confirm details and arrange payment offline by email.</p>', 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1600&q=80', 'Tanzania Sensational', 'Health & Safety', '2025-12-22 06:51:26', '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_ref` varchar(255) DEFAULT NULL,
  `booking_type` varchar(255) NOT NULL DEFAULT 'departure',
  `departure_id` bigint(20) UNSIGNED DEFAULT NULL,
  `safari_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `group_size` int(11) NOT NULL,
  `held_seats` int(11) NOT NULL DEFAULT 0,
  `hold_expires_at` timestamp NULL DEFAULT NULL,
  `last_contacted_at` timestamp NULL DEFAULT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `total_price_cents` int(11) NOT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `preferred_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-165868719c19b6986b164108260b982937c732aa', 'i:1;', 1777982471),
('laravel-cache-165868719c19b6986b164108260b982937c732aa:timer', 'i:1777982471;', 1777982471),
('laravel-cache-2b437625f64affd758f782a67757123dd3e99ec5', 'i:1;', 1777982837),
('laravel-cache-2b437625f64affd758f782a67757123dd3e99ec5:timer', 'i:1777982837;', 1777982837),
('laravel-cache-3043a9006d32dee52c61355e97a8b612f36d9bce', 'i:1;', 1777982470),
('laravel-cache-3043a9006d32dee52c61355e97a8b612f36d9bce:timer', 'i:1777982470;', 1777982470),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:11;', 1777975043),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1777975043;', 1777975043),
('laravel-cache-895e53ab7ae1b6b401d75118204f4f83fc4ace05', 'i:1;', 1777982473),
('laravel-cache-895e53ab7ae1b6b401d75118204f4f83fc4ace05:timer', 'i:1777982473;', 1777982473),
('laravel-cache-9bf68adfdf84febceb3263feb1d7668af2c90864', 'i:1;', 1777982836),
('laravel-cache-9bf68adfdf84febceb3263feb1d7668af2c90864:timer', 'i:1777982836;', 1777982836),
('laravel-cache-afcd36b5845d7d2f133de0d5515209ccbf62c2f8', 'i:2;', 1777979418),
('laravel-cache-afcd36b5845d7d2f133de0d5515209ccbf62c2f8:timer', 'i:1777979418;', 1777979418),
('laravel-cache-bba36fb02f2b6b398c374fe1f2b1594fbd0c0007', 'i:2;', 1777979418),
('laravel-cache-bba36fb02f2b6b398c374fe1f2b1594fbd0c0007:timer', 'i:1777979418;', 1777979418),
('laravel-cache-c5703b35ab365d0f6f94b8dc0c6f67a89b29442f', 'i:1;', 1777979419),
('laravel-cache-c5703b35ab365d0f6f94b8dc0c6f67a89b29442f:timer', 'i:1777979419;', 1777979419),
('laravel-cache-d151d47c7b8adea0086b52a59e79d5bd50b9e970', 'i:6;', 1777981609),
('laravel-cache-d151d47c7b8adea0086b52a59e79d5bd50b9e970:timer', 'i:1777981609;', 1777981609),
('laravel-cache-d252abe6f6ba587e5ad1ae76c0ced28e230e7019', 'i:1;', 1777982472),
('laravel-cache-d252abe6f6ba587e5ad1ae76c0ced28e230e7019:timer', 'i:1777982472;', 1777982472),
('laravel-cache-e2ccf9f41831ed3b0d013a33c8f1fa1e88fde5f4', 'i:1;', 1777982834),
('laravel-cache-e2ccf9f41831ed3b0d013a33c8f1fa1e88fde5f4:timer', 'i:1777982834;', 1777982834),
('laravel-cache-e50fcce0b915815e38bbaaab2d650ee1a7c99c9a', 'i:1;', 1777982835),
('laravel-cache-e50fcce0b915815e38bbaaab2d650ee1a7c99c9a:timer', 'i:1777982835;', 1777982835),
('laravel-cache-fa3dc3fc8ba68a22b713846d3f7fb4943094827d', 'i:1;', 1777979418),
('laravel-cache-fa3dc3fc8ba68a22b713846d3f7fb4943094827d:timer', 'i:1777979418;', 1777979418);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `objective` varchar(255) DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'NEW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departures`
--

CREATE TABLE `departures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trekking_route_id` bigint(20) UNSIGNED NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `price_cents` int(11) NOT NULL,
  `total_seats` int(11) NOT NULL DEFAULT 12,
  `available_seats` int(11) NOT NULL DEFAULT 12,
  `booked_seats` int(11) NOT NULL DEFAULT 0,
  `held_seats` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Available',
  `summit_night` varchar(255) DEFAULT NULL,
  `meeting_point` varchar(255) DEFAULT NULL,
  `briefing_date` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `inclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`inclusions`)),
  `exclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`exclusions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departures`
--

INSERT INTO `departures` (`id`, `trekking_route_id`, `departure_date`, `return_date`, `price_cents`, `total_seats`, `available_seats`, `booked_seats`, `held_seats`, `status`, `summit_night`, `meeting_point`, `briefing_date`, `description`, `inclusions`, `exclusions`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-07-12', '2026-07-20', 285000, 12, 7, 5, 0, 'Available', 'July 19, 2026', 'Kilimanjaro International Airport (JRO)', 'July 11, 2026 — 6:00 PM', 'Join our most popular group departure via the scenic Lemosho Route. This 8-day expedition offers exceptional acclimatization through diverse ecological zones — from lush rainforest to alpine desert. Summit under the stars of mid-July when the skies are clearest.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]', '[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$200-300 pp)\", \"Alcoholic beverages\", \"Visa fees\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 2, '2026-08-04', '2026-08-12', 285000, 12, 3, 9, 0, 'Limited', 'August 11, 2026', 'Kilimanjaro International Airport (JRO)', 'August 3, 2026 — 6:00 PM', 'Our August Lemosho departure coincides with peak dry season — expect crystal-clear summit views and optimal trail conditions. This is our best-selling departure and fills quickly. Only 3 spots remain.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]', '[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$200-300 pp)\", \"Alcoholic beverages\", \"Visa fees\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 10, '2026-09-15', '2026-09-24', 330000, 12, 10, 2, 0, 'Available', 'September 22, 2026', 'Kilimanjaro International Airport (JRO)', 'September 14, 2026 — 6:00 PM', 'The Northern Circuit is Kilimanjaro\'s longest and most remote route, circling the entire northern slopes with unmatched views and virtually zero crowd encounters. This 9-day schedule provides the best acclimatization profile of any route.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and Gamow bag\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\", \"Post-climb hotel day room & lunch\"]', '[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew (~$250-350 pp)\", \"Alcoholic beverages\", \"Visa fees\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(4, 4, '2026-10-02', '2026-10-09', 245000, 12, 0, 12, 0, 'Full', 'October 07, 2026', 'Kilimanjaro International Airport (JRO)', 'October 1, 2026 — 6:00 PM', 'Known as the \'Whiskey Route\' for its challenging terrain, the Machame delivers a dramatic ascent through five distinct climate zones. This departure is fully booked — join our waitlist for cancellation spots.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain\", \"Emergency oxygen kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance (mandatory)\", \"Personal trekking gear\", \"Gratuities for mountain crew\", \"Visa fees\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(5, 1, '2026-07-06', '2026-07-13', 190000, 12, 10, 2, 0, 'Available', 'July 12, 2026', 'Kilimanjaro International Airport (JRO)', 'July 5, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 7 Days Lemosho Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(6, 1, '2026-08-18', '2026-08-25', 190000, 12, 10, 2, 0, 'Available', 'August 24, 2026', 'Kilimanjaro International Airport (JRO)', 'August 17, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 7 Days Lemosho Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(7, 3, '2026-07-05', '2026-07-11', 165000, 12, 9, 3, 0, 'Available', 'July 10, 2026', 'Kilimanjaro International Airport (JRO)', 'July 4, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 6 Days Machame Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(8, 3, '2026-08-30', '2026-09-05', 165000, 12, 9, 3, 0, 'Available', 'September 4, 2026', 'Kilimanjaro International Airport (JRO)', 'August 29, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 6 Days Machame Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(9, 5, '2026-06-26', '2026-07-01', 140000, 12, 7, 5, 0, 'Available', 'June 30, 2026', 'Kilimanjaro International Airport (JRO)', 'June 25, 2026 — 6:00 +00:00Jun', 'An exclusive group departure for the 5 Days Marangu Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(10, 5, '2026-09-05', '2026-09-10', 140000, 12, 10, 2, 0, 'Available', 'September 9, 2026', 'Kilimanjaro International Airport (JRO)', 'September 4, 2026 — 6:00 +00:00Sep', 'An exclusive group departure for the 5 Days Marangu Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(11, 6, '2026-06-27', '2026-07-03', 165000, 12, 4, 8, 0, 'Available', 'July 2, 2026', 'Kilimanjaro International Airport (JRO)', 'June 26, 2026 — 6:00 +00:00Jun', 'An exclusive group departure for the 6 Days Marangu Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(12, 6, '2026-08-12', '2026-08-18', 165000, 12, 7, 5, 0, 'Available', 'August 17, 2026', 'Kilimanjaro International Airport (JRO)', 'August 11, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 6 Days Marangu Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(13, 7, '2026-06-14', '2026-06-20', 165000, 12, 10, 2, 0, 'Available', 'June 19, 2026', 'Kilimanjaro International Airport (JRO)', 'June 13, 2026 — 6:00 +00:00Jun', 'An exclusive group departure for the 6 Days Rongai Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(14, 7, '2026-08-24', '2026-08-30', 165000, 12, 8, 4, 0, 'Available', 'August 29, 2026', 'Kilimanjaro International Airport (JRO)', 'August 23, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 6 Days Rongai Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(15, 8, '2026-07-03', '2026-07-10', 190000, 12, 6, 6, 0, 'Available', 'July 9, 2026', 'Kilimanjaro International Airport (JRO)', 'July 2, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 7 Days Rongai Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(16, 8, '2026-09-05', '2026-09-12', 190000, 12, 5, 7, 0, 'Available', 'September 11, 2026', 'Kilimanjaro International Airport (JRO)', 'September 4, 2026 — 6:00 +00:00Sep', 'An exclusive group departure for the 7 Days Rongai Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(17, 9, '2026-07-04', '2026-07-12', 225000, 12, 9, 3, 0, 'Available', 'July 11, 2026', 'Kilimanjaro International Airport (JRO)', 'July 3, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 8 Days Northern Circuit. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(18, 9, '2026-08-21', '2026-08-29', 225000, 12, 6, 6, 0, 'Available', 'August 28, 2026', 'Kilimanjaro International Airport (JRO)', 'August 20, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 8 Days Northern Circuit. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(19, 11, '2026-07-07', '2026-07-13', 165000, 12, 9, 3, 0, 'Available', 'July 12, 2026', 'Kilimanjaro International Airport (JRO)', 'July 6, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 6 Days Umbwe Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(20, 11, '2026-08-31', '2026-09-06', 165000, 12, 10, 2, 0, 'Available', 'September 5, 2026', 'Kilimanjaro International Airport (JRO)', 'August 30, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 6 Days Umbwe Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(21, 12, '2026-06-30', '2026-07-07', 190000, 12, 6, 6, 0, 'Available', 'July 6, 2026', 'Kilimanjaro International Airport (JRO)', 'June 29, 2026 — 6:00 +00:00Jun', 'An exclusive group departure for the 7 Days Umbwe Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(22, 12, '2026-09-03', '2026-09-10', 190000, 12, 4, 8, 0, 'Available', 'September 9, 2026', 'Kilimanjaro International Airport (JRO)', 'September 2, 2026 — 6:00 +00:00Sep', 'An exclusive group departure for the 7 Days Umbwe Route. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(23, 13, '2026-07-02', '2026-07-10', 275000, 12, 6, 6, 0, 'Available', 'July 9, 2026', 'Kilimanjaro International Airport (JRO)', 'July 1, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 8 Days Lemosho with Crater Camp. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(24, 13, '2026-08-17', '2026-08-25', 275000, 12, 10, 2, 0, 'Available', 'August 24, 2026', 'Kilimanjaro International Airport (JRO)', 'August 16, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 8 Days Lemosho with Crater Camp. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(25, 14, '2026-07-06', '2026-07-15', 300000, 12, 4, 8, 0, 'Available', 'July 14, 2026', 'Kilimanjaro International Airport (JRO)', 'July 5, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 9 Days Northern Circuit & Crater. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(26, 14, '2026-08-23', '2026-09-01', 300000, 12, 8, 4, 0, 'Available', 'August 31, 2026', 'Kilimanjaro International Airport (JRO)', 'August 22, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 9 Days Northern Circuit & Crater. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(27, 15, '2026-07-06', '2026-07-09', 85000, 12, 9, 3, 0, 'Available', 'July 8, 2026', 'Kilimanjaro International Airport (JRO)', 'July 5, 2026 — 6:00 +00:00Jul', 'An exclusive group departure for the 3 Days Mount Meru Climb. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(28, 15, '2026-09-03', '2026-09-06', 85000, 12, 10, 2, 0, 'Available', 'September 5, 2026', 'Kilimanjaro International Airport (JRO)', 'September 2, 2026 — 6:00 +00:00Sep', 'An exclusive group departure for the 3 Days Mount Meru Climb. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(29, 16, '2026-06-29', '2026-07-03', 95000, 12, 5, 7, 0, 'Available', 'July 2, 2026', 'Kilimanjaro International Airport (JRO)', 'June 28, 2026 — 6:00 +00:00Jun', 'An exclusive group departure for the 4 Days Mount Meru Climb. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(30, 16, '2026-08-12', '2026-08-16', 95000, 12, 5, 7, 0, 'Available', 'August 15, 2026', 'Kilimanjaro International Airport (JRO)', 'August 11, 2026 — 6:00 +00:00Aug', 'An exclusive group departure for the 4 Days Mount Meru Climb. Experience premium service on the roof of Africa.', '[\"All park entry and camping fees\", \"Professional mountain guides & porters\", \"3 meals per day on mountain + snacks\", \"Private portable toilet\", \"Emergency oxygen and first aid kit\", \"Airport transfers (JRO)\", \"Pre-climb hotel night in Moshi\"]', '[\"International flights\", \"Travel insurance\", \"Personal trekking gear\", \"Gratuities (~$200-300 pp)\"]', '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `meta_subtitle` varchar(255) DEFAULT NULL,
  `meta_tag` varchar(255) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `meta_quote` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `meta_coordinates` varchar(255) DEFAULT NULL,
  `meta_elevation` varchar(255) DEFAULT NULL,
  `best_time` varchar(255) DEFAULT NULL,
  `meta_encounter_rate` varchar(255) DEFAULT NULL,
  `meta_tier` varchar(255) DEFAULT NULL,
  `meta_tracking` varchar(255) DEFAULT NULL,
  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights`)),
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `atmosphere_vitals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`atmosphere_vitals`)),
  `atmosphere_footer` varchar(255) DEFAULT NULL,
  `wildlife_vitals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`wildlife_vitals`)),
  `wildlife_footer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `slug`, `name`, `meta_subtitle`, `meta_tag`, `overview`, `meta_quote`, `hero_image`, `meta_coordinates`, `meta_elevation`, `best_time`, `meta_encounter_rate`, `meta_tier`, `meta_tracking`, `highlights`, `gallery`, `atmosphere_vitals`, `atmosphere_footer`, `wildlife_vitals`, `wildlife_footer`, `created_at`, `updated_at`) VALUES
(1, 'serengeti', 'Serengeti', 'The Infinite Plains', 'THE GREAT MIGRATION', 'The Serengeti is arguably the most famous wildlife sanctuary in the world, unequalled in its natural beauty and scientific value. Encompassing over 14,000 square kilometers, it is a vast, seemingly endless ocean of golden grasses, dotted with acacia trees and dramatic rocky outcrops known as kopjes. Here, the ancient rhythm of the Great Migration dictates life, as millions of hooves pound the earth in a relentless search for fresh grazing.', 'Walking through this landscape is like reading a forgotten manuscript of the earth—every shadow tells a secret, and every sunrise is a revelation.', '/storage/destinations/iN2AJLH6qGrXROyPpNDmVDH56nw6fn5Z7di3BReU.jpg', '2.3333° S, 34.8333° E', '920m – 1,850m', 'June to October (River Crossings) / Jan to March (Calving)', '95.8%', 'Prestige Tier 01', 'Satellite GPS Tracking', '[\"The Great Migration\", \"River Crossings\", \"Big Five Territory\", \"Endless Horizons\", \"Hot Air Ballooning\"]', '[\"/storage/destinations/gallery/uRccxadPEZLpjPcnkSk0GKoOw2lUz9I6bDQIY170.jpg\", \"/storage/destinations/gallery/ekUcCxyX2tcpPepGcw0uK6rO0U8FDe8jx0wUY4Pu.jpg\", \"/storage/destinations/gallery/pMca4YFDuCdoVlddXOF4ixLCfHATHBE3LehtPSac.jpg\"]', '[{\"text\": \"Charged with raw, ancient energy.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Distant predator calls & thrum of millions of hooves.\", \"label\": \"Audio Profile\"}, {\"text\": \"Endless horizons with golden morning mist.\", \"label\": \"Visibility\"}, {\"text\": \"Crisp 14°C at dawn to 28°C at meridian.\", \"label\": \"Ambient Temp\"}]', 'A place that makes you feel both small and connected.', '[{\"text\": \"Highest density of lions and cheetahs in Africa.\", \"label\": \"Predator Stat\"}, {\"text\": \"The Big Five + 2 Million migrating ungulates.\", \"label\": \"Key Species\"}, {\"text\": \"Primal theatre of masterclass survival.\", \"label\": \"Bio Profile\"}, {\"text\": \"95.8% (Historical Data Archive)\", \"label\": \"Encounter Prob\"}]', 'Satellite GPS integration for active pride tracking.', '2026-04-09 06:51:25', '2026-04-12 01:47:55'),
(2, 'ngorongoro', 'Ngorongoro Crater', 'The Lost World', 'UNESCO CALDERA', 'Often referred to as the \'Eighth Wonder of the World,\' the Ngorongoro Crater is a breathtaking natural amphitheater. Formed millions of years ago when a giant volcano exploded and collapsed on itself, the 600-meter deep caldera now harbors a unique microclimate and an incredibly dense population of wildlife.', 'To stand on the rim and gaze into the depths is to witness nature\'s most perfect amphitheater—a world enclosed, eternal, and utterly alive.', '/storage/destinations/uM0eELO7KmOhaNpXL5imJmlduSCJP8DdOt448BZt.jpg', '3.2000° S, 35.5000° E', '2,286m (Rim)', 'Year-Round (Wildlife does not migrate out)', '98.2%', 'Prestige Tier 01', 'Crater Floor GPS Grid', '[\"Endangered Black Rhino\", \"Crater Floor Drives\", \"Maasai Coexistence\", \"Dense Lion Population\", \"Lake Magadi Flamingos\"]', '[\"/storage/destinations/gallery/5bGGIiYzwhm4mXsZUErehq5N41G4ZuhIR98GHtFH.jpg\", \"/storage/destinations/gallery/pxs7sm70PM3QkBonpp7JN1erz4EmLlH3paTsVc6Z.jpg\", \"/storage/destinations/gallery/C9zzGCHRYIijBOCWDFtoxYR95ZL1k7bdpJ0FkQUs.jpg\"]', '[{\"text\": \"Prehistoric calm within volcanic walls.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Sacred silence broken by flamingo calls.\", \"label\": \"Audio Profile\"}, {\"text\": \"600m deep caldera with panoramic rim views.\", \"label\": \"Visibility\"}, {\"text\": \"Cool 10°C at rim to 24°C on crater floor.\", \"label\": \"Ambient Temp\"}]', 'A world apart, enclosed and eternal.', '[{\"text\": \"Highest lion density per square km in Africa.\", \"label\": \"Predator Stat\"}, {\"text\": \"Big Five including critically endangered black rhino.\", \"label\": \"Key Species\"}, {\"text\": \"Self-contained Eden — a microcosm of East Africa.\", \"label\": \"Bio Profile\"}, {\"text\": \"98.2% (Enclosed ecosystem)\", \"label\": \"Encounter Prob\"}]', 'UNESCO World Heritage Site — protected since 1979.', '2026-04-09 06:51:25', '2026-04-12 01:50:35'),
(3, 'tarangire', 'Tarangire', 'Land of Giants', 'ELEPHANT REALM', 'Tarangire is the quiet giant of the northern circuit. Dominated by the serpentine path of the Tarangire River and punctuated by massive, ancient baobab trees, the landscape feels primal and untouched. During the dry season, it becomes a crucial refuge for wildlife.', 'In the shade of a thousand-year baobab, with the river whispering below and elephants drifting like grey clouds—this is Africa at its most honest.', '/storage/destinations/7JLk0EEMPmSPMNrMXQxwmmIN43ruF7HoAWUlzRzA.jpg', '3.8500° S, 36.0000° E', '1,100m', 'July to October (Dry Season Congregation)', '94.5%', 'Heritage Tier 02', 'River System GPS Tracking', '[\"Massive Elephant Herds\", \"Ancient Baobabs\", \"Silvery Landscapes\", \"Tree-Climbing Pythons\", \"Incredible Birding\"]', '[\"/storage/destinations/gallery/mQxMokEXKiTGcGsizVSQIvaI1fcjgdcvuYWpc6UH.jpg\", \"/storage/destinations/gallery/ZFk9jtrtAmCGVrsXsPqis7R5iIK2Pm8vV72BYfPZ.jpg\", \"/storage/destinations/gallery/5rhpbMxEcEwnRfTEfgTB7uhnfOLiFXtRFpamLN9P.jpg\"]', '[{\"text\": \"Rugged tranquility beneath ancient baobabs.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Elephant rumbles and 550+ bird species.\", \"label\": \"Audio Profile\"}, {\"text\": \"Silvery landscapes cut by the winding river.\", \"label\": \"Visibility\"}, {\"text\": \"Warm 18°C mornings to 32°C at midday.\", \"label\": \"Ambient Temp\"}]', 'Where the pace of life follows the river\'s flow.', '[{\"text\": \"Tree-climbing lions and leopards in residence.\", \"label\": \"Predator Stat\"}, {\"text\": \"Largest elephant herds in Tanzania (3,000+).\", \"label\": \"Key Species\"}, {\"text\": \"Dry season refuge — extraordinary animal concentration.\", \"label\": \"Bio Profile\"}, {\"text\": \"94.5% (Dry Season Peak)\", \"label\": \"Encounter Prob\"}]', 'Home to over 550 bird species — a birder\'s paradise.', '2026-04-09 06:51:25', '2026-04-12 01:52:37'),
(4, 'kilimanjaro', 'Mount Kilimanjaro', 'The Roof of Africa', 'ALPINE MAJESTY', 'Rising majestically from the African plains, Mount Kilimanjaro is a dormant volcano and the highest peak on the continent at 5,895 meters. It stands as a beacon for adventurers, offering a multi-day trek through incredibly diverse ecosystems—starting in dense, primate-filled forests and ending in the surreal, icy silence of the arctic summit zone.', 'To climb Kilimanjaro is to walk from the equator to the North Pole in a matter of days—a journey not just of elevation, but of the spirit.', '/storage/destinations/1RFdWTsjKoD6DMO0WsTQIO0JTKxSDKrAzB6Jpygq.jpg', '3.0674° S, 37.3556° E', '5,895m (Uhuru Peak)', 'Jan to March & June to October', '100%', 'Summit Tier 01', 'Guided Alpine Ascent', '[\"Uhuru Peak Summit\", \"Five Climate Zones\", \"Giant Groundsel Forest\", \"Rebmann Glacier\", \"Sunrise above the clouds\"]', '[\"/storage/destinations/gallery/6nTAyiCxlUjHCpSOsyH7RImRkhpj4gXg9kNxAOzO.jpg\", \"/storage/destinations/gallery/NeH5ECUUPYfOMTGwTVjs0otUFT4M7VwseHp722Zf.jpg\", \"/storage/destinations/gallery/XOxkTYswN4z10bDS77yMEX19biJtKu4Wqgx67PZm.jpg\"]', '[{\"text\": \"Stark, shifting extremes from jungle to ice.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Forest canopy calls fading into alpine wind.\", \"label\": \"Audio Profile\"}, {\"text\": \"Above the clouds with infinite horizons.\", \"label\": \"Visibility\"}, {\"text\": \"25°C at base dropping to -15°C at summit.\", \"label\": \"Ambient Temp\"}]', 'Five climate zones compressed into one mountain.', '[{\"text\": \"Unique afro-alpine gigantism species.\", \"label\": \"Flora Stat\"}, {\"text\": \"Colobus monkeys, endemic birds, Giant Lobelia.\", \"label\": \"Key Species\"}, {\"text\": \"Sky island ecosystem isolated by altitude.\", \"label\": \"Bio Profile\"}, {\"text\": \"85-95% (Route dependent)\", \"label\": \"Success Rate\"}]', 'A botanical wonderland leading to eternal ice.', '2026-04-09 06:51:25', '2026-04-12 01:54:36'),
(5, 'lake-manyara', 'Lake Manyara', 'The Pink Lake', 'RIFT VALLEY JEWEL', 'Described by Ernest Hemingway as \'the loveliest I had seen in Africa,\' Lake Manyara National Park is a compact, breathtakingly beautiful reserve. The alkaline lake takes up much of the park, creating a vibrant ecosystem where dense groundwater forests give way to open grassy floodplains and the steep, dramatic cliffs of the Rift Valley.', 'It is a pocket-sized Serengeti—a lush, concentrated burst of life where the escarpment meets the water.', '/storage/destinations/aB8lrVjgmbOEMsNOiMTzraKZBASmvVx1OcC0VXSC.jpg', '3.5833° S, 35.8333° E', '960m', 'June to October (Large Mammals) / Nov to April (Birding & Waterfalls)', '92.0%', 'Heritage Tier 02', 'Lakeside Guided Patrol', '[\"Tree-Climbing Lions\", \"Huge Baboon Troops\", \"Thousands of Flamingos\", \"Groundwater Forest\", \"Rift Valley Escarpment\"]', '[\"/storage/destinations/gallery/zJkrchv6jRyKalBeQkAOI1SgA4zQMHaGpL93rEAw.jpg\", \"/storage/destinations/gallery/pN2OV1oddwPmelbp3MrhQSIQ50uIClKjeJsNXJ7T.jpg\", \"/storage/destinations/gallery/RwQsgLpKGtWXwBHYdYuxvXc9yBFnjXpW0k2Xnool.jpg\"]', '[{\"text\": \"Lush, jungle-like density opening to water.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Baboon barks and the murmur of flamingos.\", \"label\": \"Audio Profile\"}, {\"text\": \"Dramatic Rift Valley escarpment backdrop.\", \"label\": \"Visibility\"}, {\"text\": \"Pleasant 15°C mornings to 29°C afternoons.\", \"label\": \"Ambient Temp\"}]', 'Where the Rift Valley wall meets a shimmering lake.', '[{\"text\": \"Famous tree-climbing lion populations.\", \"label\": \"Predator Stat\"}, {\"text\": \"Flamingos, Elephants, Baboons, Tree Lions.\", \"label\": \"Key Species\"}, {\"text\": \"Groundwater forest meeting alkaline lake.\", \"label\": \"Bio Profile\"}, {\"text\": \"92.0% (Lakeside Grazers)\", \"label\": \"Encounter Prob\"}]', 'Over 400 bird species recorded — unparalleled avian diversity.', '2026-04-09 06:51:25', '2026-04-12 01:56:08'),
(6, 'zanzibar', 'Zanzibar', 'The Spice Island', 'SWAHILI PARADISE', 'Floating off the coast of mainland Tanzania, the Zanzibar Archipelago is a tropical paradise steeped in a rich, complex history. Known globally for its spice plantations and Swahili culture, the main island of Unguja offers a breathtaking contrast between the vibrant, historical labyrinth of Stone Town and the quiet, luxurious seclusion of its palm-fringed eastern shores.', 'Where the scent of cloves meets the salt of the Indian Ocean, time slows to the rhythm of dhow sails on the horizon.', '/storage/destinations/0VQX7YKtWYPc96KCmuaV6MAaaAv0kdQ6PUuPPDI0.jpg', '6.1659° S, 39.2026° E', 'Sea Level', 'June to October & Dec to Feb', '98.5%', 'Retreat Tier 01', 'Dhow Sailing & Dive Tech', '[\"Pristine White Beaches\", \"Historic Stone Town\", \"Spice Farm Tours\", \"Mnemba Atoll Snorkeling\", \"Sunset Dhow Cruises\"]', '[\"/storage/destinations/gallery/gNIXFmaJ2OWe44FsjGHyxB3kbEdEp9j1zZupVxDq.jpg\", \"/storage/destinations/gallery/oXuVl8sGQlzdTrjo46Iz1wqjMEgUoxhBoT4IL02g.jpg\", \"/storage/destinations/gallery/qCN1CpNspqdz5CEe1od5gJvMBqnWoWG3quHjAnt9.jpg\"]', '[{\"text\": \"Barefoot luxury wrapped in spiced sea breezes.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Lapping waves, rustling palms & distant calls to prayer.\", \"label\": \"Audio Profile\"}, {\"text\": \"Crystal clear turquoise water over white coral sand.\", \"label\": \"Visibility\"}, {\"text\": \"Tropical 25°C to 32°C year-round.\", \"label\": \"Ambient Temp\"}]', 'A rhythmic slow-down on the shores of the Indian Ocean.', '[{\"text\": \"Pristine coral atolls with exceptional visibility.\", \"label\": \"Marine Stat\"}, {\"text\": \"Green Turtles, Bottlenose Dolphins, Red Colobus.\", \"label\": \"Key Species\"}, {\"text\": \"Vibrant Indian Ocean reef ecosystems.\", \"label\": \"Bio Profile\"}, {\"text\": \"98.5% (Marine & Reef Dives)\", \"label\": \"Encounter Prob\"}]', 'World-class diving around Mnemba Atoll.', '2026-04-09 06:51:25', '2026-04-12 01:58:06'),
(7, 'ruaha', 'Ruaha National Park', 'The Untamed South', 'SOUTHERN WILDERNESS', 'Ruaha National Park is a massive, untamed stretch of wilderness in Southern Tanzania. It is renowned for its harsh, rugged beauty, characterized by rolling hills, rocky escarpments, and the life-giving Great Ruaha River. Because it is less accessible than the northern parks, Ruaha offers a deeply exclusive and spectacular safari experience, completely void of crowds.', 'There is a quiet violence to Ruaha\'s beauty. It is an ancient, unyielding earth where survival is earned every single day.', '/storage/destinations/1aSUmPG8kM1sshnOiuo5x2LlBzRxiNjxO0RvkXvo.jpg', '7.6167° S, 34.8833° E', '750m – 1,868m', 'June to November (River bed congregations)', '88.0%', 'Frontier Tier 03', 'Deep Bush Walking & 4x4', '[\"Huge Lion Prides\", \"African Wild Dogs\", \"Vast Baobab Forests\", \"Walking Safaris\", \"Zero Crowd Density\"]', '[\"/storage/destinations/gallery/lSNNCohd0nuwGdtLBGlDQNNSIcoJxGSkakSmYaXZ.jpg\", \"/storage/destinations/gallery/aDrZxKmlvVHPY6gjsAUiSs6mrVXEgnhPNkSM4qpE.jpg\", \"/storage/destinations/gallery/BKxfi3tWuq4iRzJWnLgFdgmWhVFT5ir8reyN1Egj.jpg\"]', '[{\"text\": \"Raw wilderness, baked earth, and ancient silence.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Lion roars echoing far across the sand rivers.\", \"label\": \"Audio Profile\"}, {\"text\": \"Vast sweeps of rugged baobab-studded plains.\", \"label\": \"Visibility\"}, {\"text\": \"Scorching up to 35°C in dry season.\", \"label\": \"Ambient Temp\"}]', 'A harsh, majestic landscape demanding absolute respect.', '[{\"text\": \"10% of the world\'s remaining lion population.\", \"label\": \"Predator Stat\"}, {\"text\": \"Lions, Wild Dogs, Elephants, Greater Kudu.\", \"label\": \"Key Species\"}, {\"text\": \"Convergence zone of eastern and southern flora/fauna.\", \"label\": \"Bio Profile\"}, {\"text\": \"88.0% (High predator activity during dry season)\", \"label\": \"Encounter Prob\"}]', 'One of the last strongholds for the African Wild Dog.', '2026-04-09 06:51:25', '2026-04-12 02:02:01'),
(8, 'nyerere', 'Nyerere National Park', 'The Great River', 'RIVERINE MIGHT', 'Formerly the northern part of the Selous Game Reserve, Nyerere National Park is spectacularly expansive, larger than Switzerland. Its lifeblood is the massive Rufiji River, which carves a complex network of channels, lakes, and swamps through the wilderness. This aquatic environment allows for uniquely varied safari experiences, shifting seamlessly from dusty game drives to silent, gliding boat safaris.', 'Drifting down the Rufiji as crocodiles slip into the dark water and elephants drink on the banks—it is the continent perfectly distilled.', '/storage/destinations/Kytt2WqUUHpFiT935Zty4gRFhBorHsXXi3JUEyBJ.jpg', '8.8000° S, 37.8333° E', '100m – 400m', 'June to October (Dry Season)', '91.5%', 'Frontier Tier 03', 'Boat Safari & Bush Walk', '[\"Boat Safaris on Rufiji\", \"Huge Hippo Pods\", \"African Wild Dogs\", \"Lush Lakes and Swamps\", \"Fly Camping\"]', '[\"/storage/destinations/gallery/YFKRs8Mpk2AWSFsgwaVSoNM39M8Dmh60vqDYfMAu.jpg\", \"/storage/destinations/gallery/V8RKQsRxmjre69jMildayShUlso7OkonUlO09oTp.jpg\", \"/storage/destinations/gallery/dKAJveIQSo9jkBZQrM6jFkUM10L0xa4REBmntuVV.jpg\"]', '[{\"text\": \"Humid riverine lushness meeting dry bush.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Hippo grunts and the cry of the Fish Eagle.\", \"label\": \"Audio Profile\"}, {\"text\": \"Vast waterways winding through palm forests.\", \"label\": \"Visibility\"}, {\"text\": \"Hot and humid 22°C to 36°C.\", \"label\": \"Ambient Temp\"}]', 'Life orchestrated by the flow of the mighty Rufiji.', '[{\"text\": \"Dense populations of hippos and huge crocodiles.\", \"label\": \"Marine Stat\"}, {\"text\": \"Wild Dogs, Hippos, Crocs, Buffalo, Elephants.\", \"label\": \"Key Species\"}, {\"text\": \"Aquatic labyrinth within a massive dry reserve.\", \"label\": \"Bio Profile\"}, {\"text\": \"91.5% (Riverine zones)\", \"label\": \"Encounter Prob\"}]', 'Superb aquatic birding with over 440 species.', '2026-04-09 06:51:25', '2026-04-12 02:04:31'),
(9, 'mahale', 'Mahale Mountains', 'The Primate Peaks', 'CHIMPANZEE SANCTUARY', 'Tucked away in the far west of Tanzania, Mahale Mountains National Park is breathtakingly isolated. Accessible only by boat across the massive, deep blue expanse of Lake Tanganyika, or by light aircraft, there are no roads here. Dense, pristine rainforest cascades straight down the mountain slopes to white sandy beaches along the lake shore, creating a truly otherworldly environment.', 'To sit quietly in the dappled forest light at Mahale, watching a chimpanzee hold the hand of its young, is to look directly into the mirror of our own evolution.', 'https://images.unsplash.com/photo-1520114878144-6123749968dd?w=2000&q=85&auto=format&fit=crop', '6.1167° S, 29.7333° E', '773m – 2,462m', 'July to October (Drier paths for trekking)', '90.0%', 'Exclusive Tier 04', 'Deep Forest Trekking', '[\"Chimpanzee Trekking\", \"Lake Tanganyika Beaches\", \"Zero Vehicles\", \"Pristine Jungle\", \"Endemic Cichlid Snorkeling\"]', '[\"https://images.unsplash.com/photo-1520114878144-6123749968dd?w=800&q=80\", \"https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=800&q=80\", \"https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80\", \"https://images.unsplash.com/photo-1589553416260-f586c8f1514f?w=800&q=80\", \"https://images.unsplash.com/photo-1498426002933-72797e5510b6?w=800&q=80\", \"https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800&q=80\"]', '[{\"text\": \"Steep, humid jungle meeting crystal fresh water.\", \"label\": \"Sensory Vibe\"}, {\"text\": \"Echoing chimpanzee pant-hoots in deep forest.\", \"label\": \"Audio Profile\"}, {\"text\": \"Dappled forest light & endless lake blue.\", \"label\": \"Visibility\"}, {\"text\": \"Warm and humid 20°C to 28°C.\", \"label\": \"Ambient Temp\"}]', 'A roadless paradise accessible only by boat or air.', '[{\"text\": \"Home to about 1,000 wild chimpanzees.\", \"label\": \"Primate Stat\"}, {\"text\": \"Chimpanzees, Red Colobus, Forest Birds, Cichlids.\", \"label\": \"Key Species\"}, {\"text\": \"Afromontane forest bordering a rift valley lake.\", \"label\": \"Bio Profile\"}, {\"text\": \"90.0% (With experienced trackers)\", \"label\": \"Encounter Prob\"}]', 'Researchers have studied the chimps here since 1965.', '2026-04-09 06:51:25', '2026-04-09 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gear_items`
--

CREATE TABLE `gear_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gear_items`
--

INSERT INTO `gear_items` (`id`, `name`, `category`, `is_required`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Moisture-wicking base layers (top & bottom)', 'clothing', 1, 'Synthetic or merino wool. Avoid cotton.', 10, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 'Insulating mid-layer (fleece or down jacket)', 'clothing', 1, 'For cold conditions at higher altitudes.', 20, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 'Waterproof & windproof shell jacket', 'clothing', 1, 'Gore-Tex or equivalent with hood.', 30, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(4, 'Waterproof pants', 'clothing', 1, 'Full side zips recommended for easy layering.', 40, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(5, 'Trekking pants (convertible or softshell)', 'clothing', 1, '2-3 pairs for rotation.', 50, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(6, 'Warm hat (beanie)', 'clothing', 1, 'For cold mornings and summit night.', 60, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(7, 'Sun hat or cap with neck cover', 'clothing', 1, 'Essential for sun protection at lower altitudes.', 70, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(8, 'Gloves (liner + insulated waterproof)', 'clothing', 1, 'Two-pair system for varying conditions.', 80, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(9, 'Warm socks (wool or synthetic)', 'clothing', 1, '4-5 pairs, plus one dedicated summit pair.', 90, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(10, 'Waterproof hiking boots (broken in)', 'footwear', 1, 'Mid-weight, ankle support, worn-in before trip.', 100, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(11, 'Camp shoes or sandals', 'footwear', 0, 'For relaxing at camp after hiking.', 110, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(12, 'Gaiters', 'footwear', 0, 'Useful for dusty or muddy trails.', 120, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(13, 'Backpack (30-40L for day hikes)', 'equipment', 1, 'With rain cover. Porters carry main duffel.', 130, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(14, 'Duffel bag (90-120L, waterproof)', 'equipment', 1, 'For porter carry, max 15kg including sleeping bag.', 140, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(15, 'Sleeping bag (rated -10°C / 14°F or lower)', 'equipment', 1, 'Down or synthetic. Can be rented.', 150, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(16, 'Sleeping pad (inflatable or foam)', 'equipment', 1, 'Provided by us, but you may bring your own.', 160, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(17, 'Trekking poles (collapsible)', 'equipment', 0, 'Highly recommended for descent.', 170, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(18, 'Headlamp with extra batteries', 'equipment', 1, 'Essential for summit night and camp.', 180, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(19, 'Water bottles or hydration bladder (3L total)', 'equipment', 1, 'Nalgene or similar, no single-use plastic.', 190, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(20, 'Sunglasses (UV400, category 3-4)', 'personal', 1, 'Essential for glacier/snow glare.', 200, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(21, 'Sunscreen (SPF 50+) and lip balm', 'personal', 1, 'High altitude = intense UV exposure.', 210, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(22, 'Personal first aid kit', 'personal', 1, 'Blister care, pain relievers, personal meds.', 220, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(23, 'Toiletries & wet wipes', 'personal', 1, 'Biodegradable soap, toothbrush, etc.', 230, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(24, 'Quick-dry towel', 'personal', 0, 'Small pack towel for washing.', 240, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(25, 'Camera / phone & power bank', 'personal', 0, 'With waterproof case or bag.', 250, '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `gear_rental_requests`
--

CREATE TABLE `gear_rental_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_16_130753_create_trekking_routes_table', 1),
(5, '2026_03_16_130754_create_departures_table', 1),
(6, '2026_03_16_130754_create_route_itinerary_days_table', 1),
(7, '2026_03_16_130755_create_bookings_table', 1),
(8, '2026_03_16_130755_create_gear_items_table', 1),
(9, '2026_03_16_130756_create_gear_rental_requests_table', 1),
(10, '2026_03_16_130757_create_blog_posts_table', 1),
(11, '2026_03_16_130757_create_pages_table', 1),
(12, '2026_03_16_130758_create_destinations_table', 1),
(13, '2026_03_16_130758_create_safari_packages_table', 1),
(14, '2026_03_16_130759_create_pricing_rules_table', 1),
(15, '2026_03_16_132240_create_personal_access_tokens_table', 1),
(16, '2026_03_16_220350_create_contact_submissions_table', 1),
(17, '2026_03_16_221356_add_safari_booking_fields_to_bookings_table', 1),
(18, '2026_03_17_053228_add_category_to_blog_posts_table', 1),
(19, '2026_03_17_063142_create_visual_assets_table', 1),
(20, '2026_03_17_120000_add_role_to_users_table', 1),
(21, '2026_03_17_120100_create_site_settings_table', 1),
(22, '2026_03_17_130000_add_capacity_and_holds_to_departures_table', 1),
(23, '2026_03_17_130100_extend_bookings_for_request_workflow', 1),
(24, '2026_03_17_150000_add_content_html_and_seo_to_blog_posts_table', 1),
(25, '2026_03_17_200000_create_admin_notifications_table', 1),
(26, '2026_03_23_150800_add_details_to_trekking_routes_table', 1),
(27, '2026_04_12_133122_add_editorial_image_to_trekking_routes_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `meta_title`, `meta_description`, `og_image`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Home', NULL, 'Tanzania Sensational — Kilimanjaro, Safari & Zanzibar', 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Submit a booking request and we’ll confirm by email.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 'about', 'About', '<p class=\"cms-note\">This page has a dedicated design component. Content is managed through the component code, not the CMS.</p>', 'About Us | Tanzania Sensational', 'Learn about our team, our approach, and how we run premium trekking and safari experiences in Tanzania.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 'contact', 'Contact', '<p>Contact page content can be managed in the dashboard CMS.</p>', 'Contact | Tanzania Sensational', 'Send an inquiry or booking request. We’ll reply by email to confirm details and arrange payment offline.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(4, 'routes-overview', 'Routes Overview', '<p>This is a CMS-managed page intended for a routes overview or landing page.</p>', 'Routes Overview | Tanzania Sensational', 'Explore Kilimanjaro route options and choose the right trek for your schedule and experience level.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(5, 'company-our-guides', 'Our Guides', '<h1>Our Guides</h1>\n<p>At Tanzania Sensational, our guides are the heart of every expedition. Each member of our team is a certified professional with extensive local knowledge, advanced wilderness first aid training, and years of experience leading trekkers to the summit of Kilimanjaro and through Tanzania\'s most spectacular safari regions.</p>\n                    \n                    <h3>Guide Qualifications & Training</h3>\n                    <ul>\n                        <li><strong>Kilimanjaro National Park Certification:</strong> All guides hold valid KINAPA guiding licenses</li>\n                        <li><strong>Wilderness First Responder (WFR) or equivalent:</strong> Advanced medical training for remote environments</li>\n                        <li><strong>Altitude Medicine Certification:</strong> Specialized training in altitude sickness recognition and treatment</li>\n                        <li><strong>Language Proficiency:</strong> Fluent in English, Swahili, and often additional local languages</li>\n                        <li><strong>Minimum 5 Years Experience:</strong> Most guides have 10+ years leading expeditions</li>\n                    </ul>\n                    \n                    <h3>Our Leadership Philosophy</h3>\n                    <p>We believe in proactive, transparent leadership. Your guide will:</p>\n                    <ul>\n                        <li>Conduct daily health checks and altitude assessments</li>\n                        <li>Maintain clear communication about daily plans and weather conditions</li>\n                        <li>Set a sustainable pace that prioritizes acclimatization</li>\n                        <li>Foster a supportive team environment among all expedition members</li>\n                        <li>Share cultural and natural history insights throughout your journey</li>\n                    </ul>\n                    \n                    <h3>Meet Some of Our Lead Guides</h3>\n                    <div class=\"guide-profiles\">\n                        <div class=\"guide-profile\">\n                            <h4>Joseph M.</h4>\n                            <p><em>Lead Guide & Expedition Manager</em><br>\n                            12 years experience, 200+ summits. Specializes in technical routes and altitude medicine.</p>\n                        </div>\n                        <div class=\"guide-profile\">\n                            <h4>Sarah K.</h4>\n                            <p><em>Safari Specialist & Cultural Guide</em><br>\n                            8 years experience in Northern Circuit parks. Expert in wildlife behavior and photography.</p>\n                        </div>\n                        <div class=\"guide-profile\">\n                            <h4>Michael T.</h4>\n                            <p><em>Senior Kilimanjaro Guide</em><br>\n                            15 years experience, fluent in 4 languages. Known for exceptional client care and summit success rates.</p>\n                        </div>\n                    </div>', 'Our Guides | Tanzania Sensational', 'Meet the mountain and safari professionals behind Tanzania Sensational. Experienced, safety-first, and deeply local.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(6, 'company-safety-protocols', 'Safety Protocols', '<h1>Safety Protocols</h1>\n<p>Safety is our highest priority. We implement comprehensive protocols developed over decades of experience in high-altitude trekking and wilderness travel. Our systems are designed to prevent issues before they arise and to respond effectively if challenges occur.</p>\n                    \n                    <h3>Pre-Trek Safety Measures</h3>\n                    <ul>\n                        <li><strong>Comprehensive Medical Screening:</strong> All participants complete health questionnaires reviewed by our team</li>\n                        <li><strong>Detailed Gear Check:</strong> Mandatory inspection of all essential equipment before departure</li>\n                        <li><strong>Thorough Briefings:</strong> Day-by-day itinerary review, altitude awareness training, and emergency procedures</li>\n                        <li><strong>Weather Monitoring:</strong> Daily consultation with meteorological services and park authorities</li>\n                        <li><strong>Equipment Verification:</strong> All group safety equipment (oxygen, medical kits, communications) tested and certified</li>\n                    </ul>\n                    \n                    <h3>On-Mountain Safety Systems</h3>\n                    <ul>\n                        <li><strong>Daily Health Assessments:</strong> Morning and evening pulse oximetry checks, symptom monitoring</li>\n                        <li><strong>Conservative Acclimatization:</strong> \"Climb high, sleep low\" routing, extra acclimatization days on key routes</li>\n                        <li><strong>Guide-to-Client Ratios:</strong> Maximum 1:3 ratio on summit day, 1:4 during regular trekking days</li>\n                        <li><strong>Communications Network:</strong> Satellite phones at guide level, VHF radios throughout team</li>\n                        <li><strong>Emergency Oxygen:</strong> Carried on all climbs above 4,000m, guides trained in administration</li>\n                    </ul>\n                    \n                    <h3>Emergency Response & Evacuation</h3>\n                    <ul>\n                        <li><strong>24/7 Operations Center:</strong> Dedicated team monitoring all expeditions</li>\n                        <li><strong>Helicopter Evacuation Protocol:</strong> Pre-arranged agreements with emergency services</li>\n                        <li><strong>Medical Kits:</strong> Comprehensive wilderness first aid supplies including medications for altitude illness</li>\n                        <li><strong>Contingency Planning:</strong> Alternate routes and descent plans for changing conditions</li>\n                        <li><strong>Local Hospital Partnerships:</strong> Relationships with facilities in Moshi and Arusha for rapid transfer</li>\n                    </ul>\n                    \n                    <h3>Safari Safety Standards</h3>\n                    <ul>\n                        <li><strong>Vehicle Safety:</strong> Regularly maintained 4x4 vehicles with safety equipment</li>\n                        <li><strong>Wildlife Protocols:</strong> Strict adherence to park regulations and safe viewing distances</li>\n                        <li><strong>Guide Training:</strong> Specialized training in animal behavior and emergency response</li>\n                        <li><strong>Communication:</strong> Radio contact between vehicles and with park authorities</li>\n                        <li><strong>Health Precautions:</strong> Water purification, food safety standards, and malaria prevention guidance</li>\n                    </ul>', 'Safety Protocols | Tanzania Sensational', 'Our safety standards for trekking and safari operations, including briefings, altitude monitoring, and contingency planning.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(7, 'safari-guide-local-custom', 'Local Custom', '<h2>Local Custom</h2>\n<ul><li>Greetings and respectful interaction</li><li>Photography etiquette</li><li>Tipping norms and expectations</li></ul>', 'Safari Guide: Local Custom | Tanzania Sensational', 'Helpful cultural notes and etiquette for traveling in Tanzania—simple, respectful, and practical.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(8, 'safari-guide-what-to-wear', 'What to Wear', '<h2>What to Wear</h2>\n<ul><li>Light layers and neutral colors</li><li>A warm layer for early mornings</li><li>Comfortable shoes and sun protection</li></ul>', 'Safari Guide: What to Wear | Tanzania Sensational', 'What to wear on safari for comfort, style, and practicality—from game drives to lodges.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(9, 'safari-guide-packing-guide', 'Packing Guide', '<h2>Packing Guide</h2>\n<ul><li>Daypack essentials</li><li>Camera and charging basics</li><li>Documents and travel insurance</li></ul>', 'Safari Guide: Packing Guide | Tanzania Sensational', 'A clear safari packing checklist—what to bring, what to skip, and how to pack efficiently.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(10, 'safari-guide-accommodation-style', 'Accommodation Style', '<h2>Accommodation Style</h2>\n<ul><li>Lodges vs tented camps</li><li>What “mid-range” and “luxury” typically mean</li><li>Power, hot water, and Wi‑Fi expectations</li></ul>', 'Safari Guide: Accommodation Style | Tanzania Sensational', 'Understand safari accommodation types—from lodges to camps—so you can choose the right comfort level.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(11, 'safari-guide-visa-guide', 'Visa Guide', '<h2>Visa Guide</h2>\n<ul><li>Passport validity requirements</li><li>Entry visa overview</li><li>Arrival timing and common checkpoints</li></ul>', 'Safari Guide: Visa Guide | Tanzania Sensational', 'Visa basics for Tanzania: what you’ll need and how to prepare before arrival.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(12, 'safari-guide-health-and-safety', 'Health and Safety', '<h2>Health and Safety</h2>\n<ul><li>Sun protection and hydration</li><li>Insect bite prevention</li><li>Basic travel health preparation</li></ul>', 'Safari Guide: Health and Safety | Tanzania Sensational', 'Health and safety guidance for safari travel, including hydration, sun care, and general precautions.', NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing_rules`
--

CREATE TABLE `pricing_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trekking_route_id` bigint(20) UNSIGNED NOT NULL,
  `min_group_size` int(11) DEFAULT NULL,
  `max_group_size` int(11) DEFAULT NULL,
  `season` varchar(255) DEFAULT NULL,
  `price_per_person_cents` int(11) NOT NULL,
  `add_on_name` varchar(255) DEFAULT NULL,
  `add_on_price_cents` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_rules`
--

INSERT INTO `pricing_rules` (`id`, `trekking_route_id`, `min_group_size`, `max_group_size`, `season`, `price_per_person_cents`, `add_on_name`, `add_on_price_cents`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'peak', 262200, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(2, 1, 3, 5, 'peak', 218500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(3, 1, 6, 20, 'peak', 196650, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(4, 1, 1, 2, 'shoulder', 239400, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(5, 1, 3, 5, 'shoulder', 199500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(6, 1, 6, 20, 'shoulder', 179550, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(7, 1, 1, 2, 'low', 228000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(8, 1, 3, 5, 'low', 190000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(9, 1, 6, 20, 'low', 171000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(10, 2, 1, 2, 'peak', 310500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(11, 2, 3, 5, 'peak', 258750, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(12, 2, 6, 20, 'peak', 232875, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(13, 2, 1, 2, 'shoulder', 283500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(14, 2, 3, 5, 'shoulder', 236250, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(15, 2, 6, 20, 'shoulder', 212625, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(16, 2, 1, 2, 'low', 270000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(17, 2, 3, 5, 'low', 225000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(18, 2, 6, 20, 'low', 202500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(19, 3, 1, 2, 'peak', 227700, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(20, 3, 3, 5, 'peak', 189750, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(21, 3, 6, 20, 'peak', 170775, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(22, 3, 1, 2, 'shoulder', 207900, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(23, 3, 3, 5, 'shoulder', 173250, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(24, 3, 6, 20, 'shoulder', 155925, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(25, 3, 1, 2, 'low', 198000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(26, 3, 3, 5, 'low', 165000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(27, 3, 6, 20, 'low', 148500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(28, 4, 1, 2, 'peak', 262200, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(29, 4, 3, 5, 'peak', 218500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(30, 4, 6, 20, 'peak', 196650, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(31, 4, 1, 2, 'shoulder', 239400, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(32, 4, 3, 5, 'shoulder', 199500, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(33, 4, 6, 20, 'shoulder', 179550, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(34, 4, 1, 2, 'low', 228000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(35, 4, 3, 5, 'low', 190000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(36, 4, 6, 20, 'low', 171000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(37, 5, 1, 2, 'peak', 193200, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(38, 5, 3, 5, 'peak', 161000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(39, 5, 6, 20, 'peak', 144900, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(40, 5, 1, 2, 'shoulder', 176400, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(41, 5, 3, 5, 'shoulder', 147000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(42, 5, 6, 20, 'shoulder', 132300, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(43, 5, 1, 2, 'low', 168000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(44, 5, 3, 5, 'low', 140000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(45, 5, 6, 20, 'low', 126000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(46, 6, 1, 2, 'peak', 227700, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(47, 6, 3, 5, 'peak', 189750, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(48, 6, 6, 20, 'peak', 170775, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(49, 6, 1, 2, 'shoulder', 207900, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(50, 6, 3, 5, 'shoulder', 173250, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(51, 6, 6, 20, 'shoulder', 155925, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(52, 6, 1, 2, 'low', 198000, NULL, NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25'),
(53, 6, 3, 5, 'low', 165000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(54, 6, 6, 20, 'low', 148500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(55, 7, 1, 2, 'peak', 227700, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(56, 7, 3, 5, 'peak', 189750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(57, 7, 6, 20, 'peak', 170775, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(58, 7, 1, 2, 'shoulder', 207900, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(59, 7, 3, 5, 'shoulder', 173250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(60, 7, 6, 20, 'shoulder', 155925, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(61, 7, 1, 2, 'low', 198000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(62, 7, 3, 5, 'low', 165000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(63, 7, 6, 20, 'low', 148500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(64, 8, 1, 2, 'peak', 262200, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(65, 8, 3, 5, 'peak', 218500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(66, 8, 6, 20, 'peak', 196650, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(67, 8, 1, 2, 'shoulder', 239400, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(68, 8, 3, 5, 'shoulder', 199500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(69, 8, 6, 20, 'shoulder', 179550, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(70, 8, 1, 2, 'low', 228000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(71, 8, 3, 5, 'low', 190000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(72, 8, 6, 20, 'low', 171000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(73, 9, 1, 2, 'peak', 310500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(74, 9, 3, 5, 'peak', 258750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(75, 9, 6, 20, 'peak', 232875, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(76, 9, 1, 2, 'shoulder', 283500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(77, 9, 3, 5, 'shoulder', 236250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(78, 9, 6, 20, 'shoulder', 212625, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(79, 9, 1, 2, 'low', 270000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(80, 9, 3, 5, 'low', 225000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(81, 9, 6, 20, 'low', 202500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(82, 10, 1, 2, 'peak', 345000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(83, 10, 3, 5, 'peak', 287500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(84, 10, 6, 20, 'peak', 258750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(85, 10, 1, 2, 'shoulder', 315000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(86, 10, 3, 5, 'shoulder', 262500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(87, 10, 6, 20, 'shoulder', 236250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(88, 10, 1, 2, 'low', 300000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(89, 10, 3, 5, 'low', 250000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(90, 10, 6, 20, 'low', 225000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(91, 11, 1, 2, 'peak', 227700, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(92, 11, 3, 5, 'peak', 189750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(93, 11, 6, 20, 'peak', 170775, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(94, 11, 1, 2, 'shoulder', 207900, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(95, 11, 3, 5, 'shoulder', 173250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(96, 11, 6, 20, 'shoulder', 155925, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(97, 11, 1, 2, 'low', 198000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(98, 11, 3, 5, 'low', 165000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(99, 11, 6, 20, 'low', 148500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(100, 12, 1, 2, 'peak', 262200, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(101, 12, 3, 5, 'peak', 218500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(102, 12, 6, 20, 'peak', 196650, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(103, 12, 1, 2, 'shoulder', 239400, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(104, 12, 3, 5, 'shoulder', 199500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(105, 12, 6, 20, 'shoulder', 179550, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(106, 12, 1, 2, 'low', 228000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(107, 12, 3, 5, 'low', 190000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(108, 12, 6, 20, 'low', 171000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(109, 13, 1, 2, 'peak', 379500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(110, 13, 3, 5, 'peak', 316250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(111, 13, 6, 20, 'peak', 284625, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(112, 13, 1, 2, 'shoulder', 346500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(113, 13, 3, 5, 'shoulder', 288750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(114, 13, 6, 20, 'shoulder', 259875, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(115, 13, 1, 2, 'low', 330000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(116, 13, 3, 5, 'low', 275000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(117, 13, 6, 20, 'low', 247500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(118, 14, 1, 2, 'peak', 414000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(119, 14, 3, 5, 'peak', 345000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(120, 14, 6, 20, 'peak', 310500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(121, 14, 1, 2, 'shoulder', 378000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(122, 14, 3, 5, 'shoulder', 315000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(123, 14, 6, 20, 'shoulder', 283500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(124, 14, 1, 2, 'low', 360000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(125, 14, 3, 5, 'low', 300000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(126, 14, 6, 20, 'low', 270000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(127, 15, 1, 2, 'peak', 117300, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(128, 15, 3, 5, 'peak', 97750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(129, 15, 6, 20, 'peak', 87975, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(130, 15, 1, 2, 'shoulder', 107100, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(131, 15, 3, 5, 'shoulder', 89250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(132, 15, 6, 20, 'shoulder', 80325, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(133, 15, 1, 2, 'low', 102000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(134, 15, 3, 5, 'low', 85000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(135, 15, 6, 20, 'low', 76500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(136, 16, 1, 2, 'peak', 131100, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(137, 16, 3, 5, 'peak', 109250, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(138, 16, 6, 20, 'peak', 98325, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(139, 16, 1, 2, 'shoulder', 119700, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(140, 16, 3, 5, 'shoulder', 99750, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(141, 16, 6, 20, 'shoulder', 89775, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(142, 16, 1, 2, 'low', 114000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(143, 16, 3, 5, 'low', 95000, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(144, 16, 6, 20, 'low', 85500, NULL, NULL, '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `route_itinerary_days`
--

CREATE TABLE `route_itinerary_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trekking_route_id` bigint(20) UNSIGNED NOT NULL,
  `day_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `elevation` int(11) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `hiking_time` varchar(255) DEFAULT NULL,
  `habitat` varchar(255) DEFAULT NULL,
  `accommodation` varchar(255) DEFAULT NULL,
  `meals` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_itinerary_days`
--

INSERT INTO `route_itinerary_days` (`id`, `trekking_route_id`, `day_number`, `title`, `description`, `elevation`, `distance`, `hiking_time`, `habitat`, `accommodation`, `meals`, `created_at`, `updated_at`) VALUES
(143, 14, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi. The Northern Circuit is the longest and most remote route on Kilimanjaro, offering nearly 360 degrees of incredible views and the highest success rate.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(144, 14, 2, 'Londorossi to Mti Mkubwa', 'We drive to Londorossi Gate and begin our trek through the western rainforest to Mti Mkubwa Camp. The peaceful atmosphere sets the tone for our long journey around the mountain.', 2820, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(145, 14, 3, 'Mti Mkubwa to Shira 2', 'We ascend onto the Shira Plateau, crossing the volcanic caldera toward Shira 1 Camp. The air begins to thin, and the landscape transitions into unique moorland with giant heathers.', 3850, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(146, 14, 4, 'Shira 2 to Moir Camp', 'We trek across the plateau toward Moir Hut, a remote and quiet camp tucked away in the volcanic ridges. This northern diversion away from the crowds provides a tranquil wilderness experience.', 4200, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(147, 14, 5, 'Moir to Buffalo', 'A steady climb takes us along the northern slopes of Kilimanjaro. This part of the mountain is rarely visited, offering pristine views and incredible solitude as we acclimate at altitude.', 4020, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(148, 14, 6, 'Buffalo to 3rd Cave', 'We continue our journey around the north of the mountain, moving toward Buffalo Camp. The views of the Kenyan plains below are expansive and breathtaking as we navigate the high-desert terrain.', 3800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(149, 14, 7, '3rd Cave to School Hut', 'The trail leads us across the northern ridges toward Third Cave Camp. The acclimatization on this route is world-class, making the later stages of the trek much more manageable for most climbers.', 4800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(150, 14, 8, 'Uhuru Peak and Crater Camp', 'We climb toward School Hut, our high base camp. The terrain is stark and volcanic, emphasizing the power of the mountain. We have an early dinner and rest before the midnight push.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(151, 14, 9, 'Crater to Millennium', 'Summit Night. We ascend to the crater rim at Gilman\'s Point and continue to Uhuru Peak. After celebrating, we begin the long descent to Mweka Gate, having completed nearly a full circle around the peak.', 5790, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(152, 14, 10, 'Millennium to Mweka Gate', 'Final descent through the forest and return to Moshi for celebrations.', 1640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(153, 14, 11, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:54:31', '2026-04-11 15:54:31'),
(154, 2, 1, 'Arrive in Tanzania', 'Welcome to Tanzania! Your expedition begins with a private transfer from Kilimanjaro International Airport (JRO) to your hotel in Moshi. In the afternoon, your head guide will perform a gear check and conduct a thorough pre-trek briefing, ensuring you are prepared for the days ahead. Enjoy a relaxing evening and a final night in a comfortable bed.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(155, 2, 2, 'Lemosho Glades to Big Tree Camp', 'We drive to the Londorossi Gate to begin our ascent through the pristine Lemosho forest. The trail is alive with the sounds of colobus monkeys and exotic birds. We\'ll hike steadily through the lush, shaded canopy to reach Mti Mkubwa (Big Tree) Camp, our first night under the stars in the heart of the rainforest.', 2780, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(156, 2, 3, 'Big Tree Camp to Shira 1 Camp', 'We leave the forest behind and enter the moorland zone, trekking across the vast Shira Plateau. The views of Kibo Peak are spectacular as we navigate volcanic rock formations and cross several small streams. This plateau traversal is essential for our body\'s acclimatization to the thinning air.', 3500, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(157, 2, 4, 'Shira 1 Camp to Shira 2 Camp', 'A steady climb eastward across the Shira Plateau offers unique views of the Northern Ice fields. We gain altitude gradually but significantly today as we move toward Shira 2 Camp. The panorama of the mountain\'s western breach is truly awe-inspiring, and we\'ll take an afternoon acclimatization walk after arriving at camp.', 3900, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(158, 2, 5, 'Shira 2 Camp to Barranco Camp', 'Crucial Acclimatization Day. We ascend to the distinctive Lava Tower (4,640m) for lunch—our high point today. This \'climb high, sleep low\' strategy is the best way to prepare your body for the summit. Afterward, we descend into the Great Barranco Valley, passing through the surreal \'Garden of the Senecios\'.', 3960, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(159, 2, 6, 'Barranco Camp to Karanga Camp', 'We begin by tackling the Great Barranco Wall, an exciting but non-technical scramble that rewards us with incredible views. From the top, we traverse ridges and valleys to reach Karanga Camp. We\'ll have a shorter day here, allowing our bodies to recover and prepare for the final push to base camp.', 3963, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(160, 2, 7, 'Karanga Camp to Barafu Camp', 'The trail continues through the alpine desert toward Barafu Camp. The air is very thin, and the landscape is a stark moonscape of rock and ice. We arrive at base camp early, giving us time to eat, hydrate, and get a few hours of sleep before our midnight summit attempt begins.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(161, 2, 8, 'Uhuru Peak and Millennium Camp', 'Summit Night. Shortly after midnight, we begin our push to the roof of Africa. The steep, zigzagging trail to Stella Point is the ultimate test of endurance. Reaching Uhuru Peak at sunrise is an experience that defies words. After celebrating our victory, we descend to Mweka Gate (or Millennium Camp) where the thick air and deep rest await.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(162, 2, 9, 'Millennium Camp to Mweka Gate', 'Our final descent takes us back through the rainforest to Mweka Gate. The rich oxygen and vibrant greenery are a welcome change. After collecting certificates and saying goodbye to our crew, we meet our vehicles for the return drive to Moshi for a hot shower and celebratory feast.', 1630, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(163, 2, 10, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:55:18', '2026-04-11 15:55:18'),
(172, 8, 1, 'Arrive in Tanzania', 'Your journey starts with airport arrival and a transfer to your hotel in Moshi. Your guide will meet you for a briefing and gear check. The northern approach is remote and beautiful, offering a quieter experience of the mountain.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(173, 8, 2, 'Nalemoru Gate to Simba Camp', 'We drive to the Nale Moru village to begin our trek through pine weight and farmlands. This northern side is drier and offers a distinct perspective of the mountain. We reach Simba Camp at the edge of the moorland for our first night, with views of the Kenyan plains below.', 2625, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(174, 8, 3, 'Simba Camp to 2nd Cave Camp', 'A steady ascent through the moorland brings us toward Second Cave Camp. This section is known for its incredible views of Kibo and the eastern ice fields. The gradient is gentle, allowing for excellent early-stage acclimatization.', 3480, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(175, 8, 4, 'Kikelewa Cave to Mawenzi Tarn', 'We continue our climb through the high-altitude wilderness toward Mawenzi Tarn camp. This camp is spectacularly situated beneath the towering, jagged spires of Mawenzi Peak. Spend the afternoon exploring the area and acclimating to the 4,300m elevation.', 4303, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(176, 8, 5, 'Mawenzi Tarn to Kibo Hut', 'We head west across the vast saddle that joins Mawenzi and Kibo. The terrain is stark alpine desert, a landscape of rock and silence. We reach Kibo Hut at 4,730m by early afternoon, resting and hydrating in preparation for our midnight summit push.', 4730, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(177, 8, 6, 'Uhuru Peak and Horombo Hut', 'Summit Night. We rise before midnight for tea and biscuits before beginning the steep climb to Gillman\'s Point on the crater rim. From there, we push toward Uhuru Peak (5,895m). After a victorious moment at the summit, we descend to Horombo Hut for a well-earned rest.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(178, 8, 7, 'Horombo Hut to Marangu Gate', 'Our final day on the mountain is a steady 6-hour descent through the forest to Marangu Gate. After signing out and receiving your certificates, we meet our driver for the return trip to Moshi for celebrations.', 1860, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(179, 8, 8, 'Depart Tanzania', 'Final departure from Tanzania. Depending on your flight time, you may explore Moshi for souvenirs or transfer directly to JRO airport.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:56:27', '2026-04-11 15:56:27'),
(180, 10, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi. The Northern Circuit is the longest and most remote route on Kilimanjaro, offering nearly 360 degrees of incredible views and the highest success rate.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(181, 10, 2, 'Londorossi Gate to Mti Mkubwa', 'We drive to Londorossi Gate and begin our trek through the western rainforest to Mti Mkubwa Camp. The peaceful atmosphere sets the tone for our long journey around the mountain.', 2820, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(182, 10, 3, 'Mti Mkubwa to Shira Camp 1', 'We ascend onto the Shira Plateau, crossing the volcanic caldera toward Shira 1 Camp. The air begins to thin, and the landscape transitions into unique moorland with giant heathers.', 3610, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(183, 10, 4, 'Shira Camp 1 to Shira Camp 2', 'We trek across the plateau toward Moir Hut, a remote and quiet camp tucked away in the volcanic ridges. This northern diversion away from the crowds provides a tranquil wilderness experience.', 3850, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(184, 10, 5, 'Shira Camp 2 to Moir Camp', 'A steady climb takes us along the northern slopes of Kilimanjaro. This part of the mountain is rarely visited, offering pristine views and incredible solitude as we acclimate at altitude.', 4200, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(185, 10, 6, 'Moir Camp to Buffalo Camp', 'We continue our journey around the north of the mountain, moving toward Buffalo Camp. The views of the Kenyan plains below are expansive and breathtaking as we navigate the high-desert terrain.', 4020, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(186, 10, 7, 'Buffalo Camp to 3rd Cave Camp', 'The trail leads us across the northern ridges toward Third Cave Camp. The acclimatization on this route is world-class, making the later stages of the trek much more manageable for most climbers.', 3800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(187, 10, 8, '3rd Cave to School Hut', 'We climb toward School Hut, our high base camp. The terrain is stark and volcanic, emphasizing the power of the mountain. We have an early dinner and rest before the midnight push.', 4800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(188, 10, 9, 'Uhuru Peak and Millennium Camp', 'Summit Night. We ascend to the crater rim at Gilman\'s Point and continue to Uhuru Peak. After celebrating, we begin the long descent to Mweka Gate, having completed nearly a full circle around the peak.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(189, 10, 10, 'Millennium Camp to Mweka Gate', 'Final descent through the forest and return to Moshi for celebrations.', 1640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(190, 10, 11, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:57:28', '2026-04-11 15:57:28'),
(191, 6, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi for briefing. The Marangu Route, or \'Coca-Cola Route\', is the oldest and most established path, offering hut accommodation instead of camping.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(192, 6, 2, 'Marangu Gate to Mandara Hut', 'We drive to Marangu Gate and begin our trek through the dense montane forest. The trail is well-maintained and leads steadily to Mandara Hut. A short walk to Maundi Crater nearby offers beautiful views of Northern Tanzania.', 2700, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(193, 6, 3, 'Mandara Hut to Horombo Hut', 'We leave the forest and enter the moorland zone. The trail opens up to vast views as we head toward Horombo Hut. On a clear day, both Mawenzi and Kibo peaks are visible. This night in the A-frame huts is cozy and social.', 3700, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(194, 6, 4, 'Horombo Hut (Acclimatization)', 'Acclimatization Day. We take a hike toward Zebra Rocks (4,020m), named for their distinctive black and white patterns. This extra day of activity followed by rest at Horombo is essential for your body\'s adjustment.', 4020, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(195, 6, 5, 'Horombo Hut to Kibo Hut', 'Today is a long, steady walk across the alpine desert of \'the saddle\'. We cross the barren landscape between the peaks of Mawenzi and Kibo to reach Kibo Hut, our last stop before the summit.', 4720, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(196, 6, 6, 'Uhuru Peak and Horombo Hut', 'Summit Night. Around midnight, we begin the steep ascent to Gillman\'s Point and then Uhuru Peak. After celebrating our victory, we descend all the way back to Horombo Hut for a night of deep sleep.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(197, 6, 7, 'Horombo Hut to Marangu Gate', 'Final descent through the forest to Marangu Gate. After collecting certificates, we meet our driver and return to Moshi for a celebratory dinner.', 1860, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(198, 6, 8, 'Depart Tanzania', 'Departure from Tanzania or extension to safari/Zanzibar.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 15:58:43', '2026-04-11 15:58:43'),
(199, 1, 1, 'Arrive in Tanzania', 'Welcome to Tanzania! Your expedition begins with a private transfer from Kilimanjaro International Airport (JRO) to your hotel in Moshi. In the afternoon, your head guide will perform a gear check and conduct a thorough pre-trek briefing, ensuring you are prepared for the days ahead. Enjoy a relaxing evening and a final night in a comfortable bed.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(200, 1, 2, 'Lemosho Glades to Big Tree Camp', 'We drive to the Londorossi Gate to begin our ascent through the pristine Lemosho forest. The trail is alive with the sounds of colobus monkeys and exotic birds. We\'ll hike steadily through the lush, shaded canopy to reach Mti Mkubwa (Big Tree) Camp, our first night under the stars in the heart of the rainforest.', 2780, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(201, 1, 3, 'Big Tree Camp to Shira 2 Camp', 'We leave the forest behind and enter the moorland zone, trekking across the vast Shira Plateau. The views of Kibo Peak are spectacular as we navigate volcanic rock formations and cross several small streams. This plateau traversal is essential for our body\'s acclimatization to the thinning air.', 3900, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(202, 1, 4, 'Shira 2 Camp to Barranco Camp', 'A steady climb eastward across the Shira Plateau offers unique views of the Northern Ice fields. We gain altitude gradually but significantly today as we move toward Shira 2 Camp. The panorama of the mountain\'s western breach is truly awe-inspiring, and we\'ll take an afternoon acclimatization walk after arriving at camp.', 3960, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(203, 1, 5, 'Barranco Camp to Karanga Camp', 'Crucial Acclimatization Day. We ascend to the distinctive Lava Tower (4,640m) for lunch—our high point today. This \'climb high, sleep low\' strategy is the best way to prepare your body for the summit. Afterward, we descend into the Great Barranco Valley, passing through the surreal \'Garden of the Senecios\'.', 3963, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(204, 1, 6, 'Karanga Camp to Barafu Camp', 'We begin by tackling the Great Barranco Wall, an exciting but non-technical scramble that rewards us with incredible views. From the top, we traverse ridges and valleys to reach Karanga Camp. We\'ll have a shorter day here, allowing our bodies to recover and prepare for the final push to base camp.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(205, 1, 7, 'Uhuru Peak and Millennium Camp', 'The trail continues through the alpine desert toward Barafu Camp. The air is very thin, and the landscape is a stark moonscape of rock and ice. We arrive at base camp early, giving us time to eat, hydrate, and get a few hours of sleep before our midnight summit attempt begins.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(206, 1, 8, 'Millennium Camp to Mweka Gate', 'Summit Night. Shortly after midnight, we begin our push to the roof of Africa. The steep, zigzagging trail to Stella Point is the ultimate test of endurance. Reaching Uhuru Peak at sunrise is an experience that defies words. After celebrating our victory, we descend to Mweka Gate (or Millennium Camp) where the thick air and deep rest await.', 1630, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(207, 1, 9, 'Depart Tanzania', 'Our final descent takes us back through the rainforest to Mweka Gate. The rich oxygen and vibrant greenery are a welcome change. After collecting certificates and saying goodbye to our crew, we meet our vehicles for the return drive to Moshi for a hot shower and celebratory feast.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:30:01', '2026-04-11 16:30:01'),
(208, 13, 1, 'Arrive in Tanzania', 'Welcome to Tanzania! Your expedition begins with a private transfer from Kilimanjaro International Airport (JRO) to your hotel in Moshi. In the afternoon, your head guide will perform a gear check and conduct a thorough pre-trek briefing, ensuring you are prepared for the days ahead. Enjoy a relaxing evening and a final night in a comfortable bed.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(209, 13, 2, 'Lemosho Glades to Big Tree Camp', 'We drive to the Londorossi Gate to begin our ascent through the pristine Lemosho forest. The trail is alive with the sounds of colobus monkeys and exotic birds. We\'ll hike steadily through the lush, shaded canopy to reach Mti Mkubwa (Big Tree) Camp, our first night under the stars in the heart of the rainforest.', 2780, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(210, 13, 3, 'Big Tree Camp to Shira 2 Camp', 'We leave the forest behind and enter the moorland zone, trekking across the vast Shira Plateau. The views of Kibo Peak are spectacular as we navigate volcanic rock formations and cross several small streams. This plateau traversal is essential for our body\'s acclimatization to the thinning air.', 3900, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(211, 13, 4, 'Shira 2 to Barranco Camp', 'A steady climb eastward across the Shira Plateau offers unique views of the Northern Ice fields. We gain altitude gradually but significantly today as we move toward Shira 2 Camp. The panorama of the mountain\'s western breach is truly awe-inspiring, and we\'ll take an afternoon acclimatization walk after arriving at camp.', 3960, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(212, 13, 5, 'Barranco to Karanga', 'Crucial Acclimatization Day. We ascend to the distinctive Lava Tower (4,640m) for lunch—our high point today. This \'climb high, sleep low\' strategy is the best way to prepare your body for the summit. Afterward, we descend into the Great Barranco Valley, passing through the surreal \'Garden of the Senecios\'.', 3963, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(213, 13, 6, 'Karanga to Barafu', 'We begin by tackling the Great Barranco Wall, an exciting but non-technical scramble that rewards us with incredible views. From the top, we traverse ridges and valleys to reach Karanga Camp. We\'ll have a shorter day here, allowing our bodies to recover and prepare for the final push to base camp.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(214, 13, 7, 'Uhuru Peak to Crater Camp', 'The trail continues through the alpine desert toward Barafu Camp. The air is very thin, and the landscape is a stark moonscape of rock and ice. We arrive at base camp early, giving us time to eat, hydrate, and get a few hours of sleep before our midnight summit attempt begins.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(215, 13, 8, 'Crater Camp to Millennium', 'Summit Night. Shortly after midnight, we begin our push to the roof of Africa. The steep, zigzagging trail to Stella Point is the ultimate test of endurance. Reaching Uhuru Peak at sunrise is an experience that defies words. After celebrating our victory, we descend to Mweka Gate (or Millennium Camp) where the thick air and deep rest await.', 5790, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(216, 13, 9, 'Millennium to Mweka Gate', 'Our final descent takes us back through the rainforest to Mweka Gate. The rich oxygen and vibrant greenery are a welcome change. After collecting certificates and saying goodbye to our crew, we meet our vehicles for the return drive to Moshi for a hot shower and celebratory feast.', 1630, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(217, 13, 10, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:31:02', '2026-04-11 16:31:02'),
(227, 11, 1, 'Arrive in Tanzania', 'Arrive in Tanzania: Arrival and briefing.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(228, 11, 2, 'Umbwe Gate to Cave Bivouac', 'Umbwe Gate to Cave Bivouac: Steep climb through heavy forest.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 2850, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(229, 11, 3, 'Cave Bivouac to Barranco Camp', 'Cave Bivouac to Barranco Camp: Ridge trek to the scenic senecio-filled valley.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3950, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(230, 11, 4, 'Barranco (Acclimatization)', 'Barranco (Acclimatization): Rest day in the Great Barranco Valley.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3900, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(231, 11, 5, 'Barranco to Barafu Camp', 'Barranco to Barafu Camp: Traverse glaciers to base camp.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 4600, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(232, 11, 6, 'Uhuru Peak and Mweka Camp', 'Uhuru Peak and Mweka Camp: Midnight summit push and long descent.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(233, 11, 7, 'Mweka Camp to Gate', 'Mweka Camp to Gate: Final hike to the gate.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 1500, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(234, 11, 8, 'Depart Tanzania', 'Depart Tanzania: Final checkout.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:32:40', '2026-04-11 16:32:40'),
(235, 9, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi. The Northern Circuit is the longest and most remote route on Kilimanjaro, offering nearly 360 degrees of incredible views and the highest success rate.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(236, 9, 2, 'Londorossi Gate to Mti Mkubwa', 'We drive to Londorossi Gate and begin our trek through the western rainforest to Mti Mkubwa Camp. The peaceful atmosphere sets the tone for our long journey around the mountain.', 2820, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(237, 9, 3, 'Mti Mkubwa to Shira 1', 'We ascend onto the Shira Plateau, crossing the volcanic caldera toward Shira 1 Camp. The air begins to thin, and the landscape transitions into unique moorland with giant heathers.', 3610, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(238, 9, 4, 'Shira 1 to Moir Camp', 'We trek across the plateau toward Moir Hut, a remote and quiet camp tucked away in the volcanic ridges. This northern diversion away from the crowds provides a tranquil wilderness experience.', 4200, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(239, 9, 5, 'Moir to Buffalo Camp', 'A steady climb takes us along the northern slopes of Kilimanjaro. This part of the mountain is rarely visited, offering pristine views and incredible solitude as we acclimate at altitude.', 4020, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(240, 9, 6, 'Buffalo to 3rd Cave', 'We continue our journey around the north of the mountain, moving toward Buffalo Camp. The views of the Kenyan plains below are expansive and breathtaking as we navigate the high-desert terrain.', 3800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(241, 9, 7, '3rd Cave to School Hut', 'The trail leads us across the northern ridges toward Third Cave Camp. The acclimatization on this route is world-class, making the later stages of the trek much more manageable for most climbers.', 4800, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(242, 9, 8, 'Uhuru Peak and Millennium', 'We climb toward School Hut, our high base camp. The terrain is stark and volcanic, emphasizing the power of the mountain. We have an early dinner and rest before the midnight push.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(243, 9, 9, 'Millennium to Gate', 'Summit Night. We ascend to the crater rim at Gilman\'s Point and continue to Uhuru Peak. After celebrating, we begin the long descent to Mweka Gate, having completed nearly a full circle around the peak.', 1640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(244, 9, 10, 'Depart Tanzania', 'Final descent through the forest and return to Moshi for celebrations.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:33:40', '2026-04-11 16:33:40'),
(245, 5, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi for briefing. The Marangu Route, or \'Coca-Cola Route\', is the oldest and most established path, offering hut accommodation instead of camping.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(246, 5, 2, 'Marangu Gate to Mandara Hut', 'We drive to Marangu Gate and begin our trek through the dense montane forest. The trail is well-maintained and leads steadily to Mandara Hut. A short walk to Maundi Crater nearby offers beautiful views of Northern Tanzania.', 2700, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(247, 5, 3, 'Mandara Hut to Horombo Hut', 'We leave the forest and enter the moorland zone. The trail opens up to vast views as we head toward Horombo Hut. On a clear day, both Mawenzi and Kibo peaks are visible. This night in the A-frame huts is cozy and social.', 3700, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(248, 5, 4, 'Horombo Hut to Kibo Hut', 'Acclimatization Day. We take a hike toward Zebra Rocks (4,020m), named for their distinctive black and white patterns. This extra day of activity followed by rest at Horombo is essential for your body\'s adjustment.', 4720, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(249, 5, 5, 'Uhuru Peak and Horombo Hut', 'Today is a long, steady walk across the alpine desert of \'the saddle\'. We cross the barren landscape between the peaks of Mawenzi and Kibo to reach Kibo Hut, our last stop before the summit.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(250, 5, 6, 'Horombo to Gate', 'Summit Night. Around midnight, we begin the steep ascent to Gillman\'s Point and then Uhuru Peak. After celebrating our victory, we descend all the way back to Horombo Hut for a night of deep sleep.', 1860, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(251, 5, 7, 'Depart Tanzania', 'Final descent through the forest to Marangu Gate. After collecting certificates, we meet our driver and return to Moshi for a celebratory dinner.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:34:29', '2026-04-11 16:34:29'),
(252, 7, 1, 'Arrive in Tanzania', 'Arrive in Tanzania: Pickup and briefing.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(253, 7, 2, 'Nalemoru Gate to Simba Camp', 'Nalemoru Gate to Simba Camp: Trek through pine forest.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 2625, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(254, 7, 3, 'Simba Camp to 2nd Cave Camp', 'Simba Camp to 2nd Cave Camp: Moorland trek with views of Kibo.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3480, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(255, 7, 4, '2nd Cave to Kibo Hut', '2nd Cave to Kibo Hut: Cross the alpine desert saddle.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 4730, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(256, 7, 5, 'Uhuru Peak and Horombo Hut', 'Uhuru Peak and Horombo Hut: Summit night and descent.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(257, 7, 6, 'Horombo to Gate', 'Horombo to Gate: Final descent.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 1860, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(258, 7, 7, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:14', '2026-04-11 16:35:14'),
(259, 4, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi for briefing and gear check. The Machame Route, known as the \'Whiskey Route\', offers incredible scenic variety and a high success rate due to its acclimatization profile.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(260, 4, 2, 'Machame Gate to Machame Camp', 'We drive to Machame Gate and begin our ascent through the lush, emerald cloud forest. The trail can be muddy, but the vibrant biodiversity is stunning. We reach Machame Camp in the late afternoon for dinner.', 3010, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(261, 4, 3, 'Machame Camp to Shira Camp', 'We leave the forest and climb a rocky ridge onto the Shira Plateau. The heather and moorland zones offer spectacular views of the mountain\'s southern glaciers. We camp at Shira Cave, enjoying one of the best sunsets on the mountain.', 3845, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(262, 4, 4, 'Shira Cave to Barranco Camp', 'We trek eastward through the alpine desert toward Lava Tower (4,640m). After an acclimatization lunch at the tower, we descend into the Barranco Valley. This \'walk high, sleep low\' day is the key to our high success rate.', 3960, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(263, 4, 5, 'Barranco Camp to Karanga Camp', 'The day begins with a scramble up the Great Barranco Wall. At the top, we\'re rewarded with views of the Heim Glacier. We traverse to Karanga Valley camp, a shorter day that helps conserve energy for the final push.', 3963, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(264, 4, 6, 'Karanga Camp to Barafu Camp', 'We ascend to Barafu Camp, our high-altitude base. The air is thin, and the terrain is volcanic desert. We arrive early, hydrate well, and have an early dinner before attempting to sleep ahead of our midnight summit attempt.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(265, 4, 7, 'Uhuru Peak and Millennium Camp', 'Summit Day. We depart at midnight, pushing through the cold and altitude toward Uhuru Peak. Reaching the summit at dawn is the highlight of a lifetime. We then begin the long descent to Mweka Gate for rest.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(266, 4, 8, 'Millennium Camp to Mweka Gate', 'Final descent through the forest leads to the park gate. After collecting certificates, we return to Moshi for celebrations and a hot shower.', 1630, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(267, 4, 9, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:35:58', '2026-04-11 16:35:58'),
(268, 3, 1, 'Arrive in Tanzania', 'Arrival and transfer to Moshi for briefing and gear check. The Machame Route, known as the \'Whiskey Route\', offers incredible scenic variety and a high success rate due to its acclimatization profile.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(269, 3, 2, 'Machame Gate to Machame Camp', 'We drive to Machame Gate and begin our ascent through the lush, emerald cloud forest. The trail can be muddy, but the vibrant biodiversity is stunning. We reach Machame Camp in the late afternoon for dinner.', 3010, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(270, 3, 3, 'Machame Camp to Shira Camp', 'We leave the forest and climb a rocky ridge onto the Shira Plateau. The heather and moorland zones offer spectacular views of the mountain\'s southern glaciers. We camp at Shira Cave, enjoying one of the best sunsets on the mountain.', 3845, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(271, 3, 4, 'Shira Cave to Barranco Camp', 'We trek eastward through the alpine desert toward Lava Tower (4,640m). After an acclimatization lunch at the tower, we descend into the Barranco Valley. This \'walk high, sleep low\' day is the key to our high success rate.', 3960, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(272, 3, 5, 'Barranco Camp to Barafu Camp', 'The day begins with a scramble up the Great Barranco Wall. At the top, we\'re rewarded with views of the Heim Glacier. We traverse to Karanga Valley camp, a shorter day that helps conserve energy for the final push.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(273, 3, 6, 'Uhuru Peak and Millennium Camp', 'We ascend to Barafu Camp, our high-altitude base. The air is thin, and the terrain is volcanic desert. We arrive early, hydrate well, and have an early dinner before attempting to sleep ahead of our midnight summit attempt.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(274, 3, 7, 'Millennium Camp to Mweka Gate', 'Summit Day. We depart at midnight, pushing through the cold and altitude toward Uhuru Peak. Reaching the summit at dawn is the highlight of a lifetime. We then begin the long descent to Mweka Gate for rest.', 1630, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(275, 3, 8, 'Depart Tanzania', 'Final descent through the forest leads to the park gate. After collecting certificates, we return to Moshi for celebrations and a hot shower.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:36:57', '2026-04-11 16:36:57'),
(276, 12, 1, 'Arrive in Tanzania', 'Arrive in Tanzania: Arrival briefing.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(277, 12, 2, 'Umbwe Gate to Cave Bivouac', 'Umbwe Gate to Cave Bivouac: Jungle canopy climb.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 2850, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(278, 12, 3, 'Cave Bivouac to Barranco', 'Cave Bivouac to Barranco: Rise to the moorland ridge.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3950, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(279, 12, 4, 'Barranco Camp', 'Barranco Camp: Full acclimatization rest day.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3900, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(280, 12, 5, 'Barranco to Karanga', 'Barranco to Karanga: Wall scramble.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 3963, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(281, 12, 6, 'Karanga to Barafu', 'Karanga to Barafu: Base camp push.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 4640, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(282, 12, 7, 'Uhuru Peak and Mweka', 'Uhuru Peak and Mweka: Summit and descent.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 5895, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(283, 12, 8, 'Mweka to Gate', 'Mweka to Gate: Final descent.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', 1500, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(284, 12, 9, 'Depart Tanzania', 'Depart Tanzania: Departure transfer.. Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:37:52', '2026-04-11 16:37:52'),
(285, 16, 1, 'Momella Gate to Miriakamba Hut', 'Your Mount Meru expedition starts with a transfer to Arusha National Park. After registration at Momella Gate, we begin our climb through typical African savanna where giraffes and buffalo are often seen. We ascend through the forest to Miriakamba Hut.', 2514, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:39:03', '2026-04-11 16:39:03'),
(286, 16, 2, 'Miriakamba to Saddle Hut', 'The trail steepens as we climb toward Saddle Hut. We\'ll pass through the \'Elephant Ridge\' and enjoy views of the Meru Crater. After lunch at the hut, we take a short acclimatization hike to Little Meru for stunning views of Kilimanjaro.', 3570, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:39:03', '2026-04-11 16:39:03'),
(287, 16, 3, 'Saddle Hut (Acclimatization)', 'Summit Day. We rise at midnight for the steep, rocky climb to Socialist Peak (4,562m). The sunrise over Kilimanjaro from the summit of Meru is legendary. After celebrating, we descend all the way back to Miriakamba Hut.', 3820, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:39:03', '2026-04-11 16:39:03'),
(288, 16, 4, 'Socialist Peak to Gate', 'Our final descent takes us back to Momella Gate through the park\'s lush forests. We\'ll meet our vehicle and return to Arusha for much-needed rest and celebrations.', 4562, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:39:03', '2026-04-11 16:39:03'),
(289, 15, 1, 'Momella Gate to Miriakamba Hut', 'Arrival at Momella Gate and ascent through the Arusha National Park savanna and forest to Miriakamba Hut. This route is challenging but offers some of the best wildlife viewing in Tanzania.', 2514, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:40:18', '2026-04-11 16:40:18'),
(290, 15, 2, 'Miriakamba to Saddle Hut', 'A steeper climb through the forest and moorland to Saddle Hut. We\'ll take an afternoon hike to Little Meru to help with acclimatization before tomorrow\'s summit push.', 3570, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:40:18', '2026-04-11 16:40:18'),
(291, 15, 3, 'Peak and Descent to Gate', 'Summit Peak. We climb to Socialist Peak (4,562m) at midnight. After watching the sunrise over the African plains, we begin a long descent back to Momella Gate to meet our transport.', 4562, NULL, NULL, NULL, NULL, NULL, '2026-04-11 16:40:18', '2026-04-11 16:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `safari_packages`
--

CREATE TABLE `safari_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `meta_tag` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL,
  `inclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`inclusions`)),
  `exclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`exclusions`)),
  `itinerary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`itinerary`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safari_packages`
--

INSERT INTO `safari_packages` (`id`, `slug`, `name`, `category`, `meta_tag`, `duration`, `description`, `hero_image`, `base_price`, `inclusions`, `exclusions`, `itinerary`, `created_at`, `updated_at`) VALUES
(1, 'great-migration-edition', 'The Great Migration Edition', 'SIGNATURE', '10 Days · Serengeti • Ngorongoro • Manyara', 10, 'A definitive 10-day expedition tracking the Great Wildebeest Migration across the Serengeti plains. This signature safari offers front-row seats to nature\'s most dramatic spectacle, complemented by luxury tented camps and exclusive wilderness access.', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop', 8400.00, '[\"Private Custom 4x4 Safari Cruiser with pop-up roof\", \"Elite Multi-lingual Driver-Guide\", \"Ultra-Luxury Tented Camps inside the National Parks\", \"All Park Entry, Concession, and Crater Fees\", \"Exclusive Serengeti Bush Dinner Experience\", \"Internal Bush Flights (if applicable to itinerary)\", \"All Chef-Prepared Meals on Safari (B, L, D)\", \"Unlimited Bottled Water, Coffee, and Tea\", \"Flying Doctors Emergency Evacuation Cover\"]', '[\"International Flights and Visas\", \"Premium Alcoholic Beverages\", \"Gratuities for Guide and Camp Staff\", \"Optional Hot Air Balloon Safari ($599 pp)\", \"Travel Insurance\"]', '[{\"day\": 1, \"desc\": \"Touch down at Kilimanjaro International Airport. Your private chauffeur will transfer you to a serene coffee lodge on the outskirts of Arusha for rest and briefing.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Arusha\", \"accommodation\": \"Legendary Lodge\"}, {\"day\": 2, \"desc\": \"Descend into the Great Rift Valley for a game drive amidst the groundwater forests of Lake Manyara, seeking tree-climbing lions and vast flocks of flamingos.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Lake Manyara National Park\", \"accommodation\": \"Lake Manyara Tree Lodge\"}, {\"day\": 3, \"desc\": \"Ascend to the rim of the Ngorongoro Crater. Enjoy an afternoon guided walk along the crater rim or visit a traditional Maasai Boma in the afternoon light.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Highlands\", \"accommodation\": \"Ngorongoro Crater Lodge\"}, {\"day\": 4, \"desc\": \"A dawn descent into the caldera. This UNESCO World Heritage site is a haven for the Big Five, including the critically endangered black rhino. Enjoy a picnic lunch by the hippo pool.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Crater Descent\", \"accommodation\": \"Ngorongoro Crater Lodge\"}, {\"day\": 5, \"desc\": \"Depart the highlands and traverse the rolling plains into the Serengeti. The afternoon is dedicated to following the migrating herds and observing predator activity.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Enter the Serengeti\", \"accommodation\": \"Singita Sasakwa Lodge\"}, {\"day\": 6, \"desc\": \"Drive to the extreme north of the park. Position yourself along the Mara River, waiting for the dramatic, chaotic spectacle of wildebeest crossing crocodile-infested waters.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Northern Serengeti - The Mara River\", \"accommodation\": \"Sayari Camp\"}, {\"day\": 7, \"desc\": \"A full day dedicated to the river. Nature dictates the schedule here, demanding patience that is often rewarded with unparalleled wildlife theater.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Full Day River Crossings\", \"accommodation\": \"Sayari Camp\"}, {\"day\": 8, \"desc\": \"Head south to the Seronera valley, famous for its resident leopards lounging in sausage trees and vast lion prides surveying the golden grasses.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Central Serengeti - Seronera\", \"accommodation\": \"Four Seasons Safari Lodge\"}, {\"day\": 9, \"desc\": \"Optional dawn hot air balloon safari over the plains, concluding with a champagne breakfast. Spend your final afternoon tracking cheetahs on the open savanna.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Plains at Dawn\", \"accommodation\": \"Four Seasons Safari Lodge\"}, {\"day\": 10, \"desc\": \"A final morning game drive en route to the Seronera airstrip. Fly back to Arusha over the crater highlands for an evening departure flight.\", \"meals\": \"Breakfast, Lunch\", \"title\": \"Serengeti to Arusha\", \"accommodation\": \"Day Room in Arusha\"}]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 'pioneers-route', 'The Pioneer\'s Route', 'CLASSIC', '7 Days · Tarangire • Manyara • Ngorongoro', 7, 'A profound 7-day immersion into the lesser-traveled paths of the Northern Circuit. Focused on massive elephant herds, ancient baobabs, and the geological wonder of the Rift Valley.', 'https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=2000&q=85&auto=format&fit=crop', 5200.00, '[\"Private Custom 4x4 Safari Cruiser\", \"Elite Head Guide & Tracker\", \"Premium Lodge Accommodation throughout\", \"Guided Walking Safaris in Tarangire\", \"All Park, Concession, and Crater Fees\", \"All Chef-Prepared Meals (B, L, D)\", \"Sundowner experiences\"]', '[\"International Flights\", \"Gratuities\", \"Visas\", \"Travel Insurance\"]', '[{\"day\": 1, \"desc\": \"Arrive at Kilimanjaro Airport where our guide will meet you. Transfer to your boutique hotel in Arusha to unwind.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Tanzania\", \"accommodation\": \"Arusha Coffee Lodge\"}, {\"day\": 2, \"desc\": \"Drive to Tarangire, a landscape dominated by ancient baobab trees and the twisting Tarangire River. Spend the afternoon observing the massive elephant herds.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Tarangire National Park\", \"accommodation\": \"Oliver\'s Camp\"}, {\"day\": 3, \"desc\": \"A morning walking safari with an armed ranger. Experience the bush intimately—tracking footprints, identifying flora, and feeling the wild pulse of the land.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Walking Safari in Tarangire\", \"accommodation\": \"Oliver\'s Camp\"}, {\"day\": 4, \"desc\": \"A short drive to the escarpment of the Great Rift Valley. After a standard afternoon game drive, embark on a rare night safari to seek out leopards, genets, and porcupines.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Lake Manyara Night Drive\", \"accommodation\": \"Escarpment Luxury Lodge\"}, {\"day\": 5, \"desc\": \"Climb through the rich agricultural lands of Karatu up to the Ngorongoro Highlands. The afternoon is spent relaxing by the fire as the mountain air cools.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Journey to the Crater\", \"accommodation\": \"Gibb\'s Farm\"}, {\"day\": 6, \"desc\": \"An extended, full-day game drive on the crater floor. This enclosed microcosm is the best place in East Africa to spot the Big Five in a single day.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Caldera Ecosystem\", \"accommodation\": \"Gibb\'s Farm\"}, {\"day\": 7, \"desc\": \"Enjoy a final, leisurely farm-to-table breakfast before returning to Arusha. Browse the Cultural Heritage Center before your onward flight.\", \"meals\": \"Breakfast, Lunch\", \"title\": \"Return to Arusha\", \"accommodation\": \"None\"}]', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 'grand-canvas', 'The Grand Canvas', 'EXCLUSIVE', '14 Days · Northern Parks • Zanzibar', 14, 'The ultimate bush-to-beach odyssey. Two weeks combining the raw, visceral thrill of the deep Serengeti with the languid, spice-scented luxury of a secluded Zanzibar retreat.', 'https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=2000&q=85&auto=format&fit=crop', 14500.00, '[\"Internal Bush Flights (Serengeti, Zanzibar, Arusha)\", \"Private Custom 4x4 Safari Cruiser with pop-up roof\", \"Private Chef & Butler in select camps\", \"Ultra-Luxury Accommodation\", \"All Park and Concession Fees\", \"All Meals and Premium Beverages on Safari\", \"Zanzibar Recovery Retreat (Half Board or All-Inclusive)\", \"Private Dhow Sunset Cruise in Zanzibar\"]', '[\"International Flights\", \"Vintage Wines and Champagnes\", \"Spa Treatments\", \"Gratuities for Guides and Staff\"]', '[{\"day\": 1, \"desc\": \"Private VIP transfer from Kilimanjaro Airport to a secluded estate.\", \"meals\": \"Dinner\", \"title\": \"Arrival in Arusha\", \"accommodation\": \"Legendary Lodge\"}, {\"day\": 2, \"desc\": \"Drive to Tarangire. Afternoon game drive focusing on elephant encounters.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Tarangire Wilderness\", \"accommodation\": \"Kuro Tarangire\"}, {\"day\": 3, \"desc\": \"Traverse the Rift Valley to the highlands. Afternoon at leisure.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Ngorongoro Highlands\", \"accommodation\": \"The Highlands\"}, {\"day\": 4, \"desc\": \"Dawn descent into the Ngorongoro Crater for premier big game viewing.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Crater Floor\", \"accommodation\": \"The Highlands\"}, {\"day\": 5, \"desc\": \"Fly or drive into the Serengeti. Encounter the vast lion prides of the Seronera valley.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Central Serengeti\", \"accommodation\": \"Namiri Plains\"}, {\"day\": 6, \"desc\": \"A full day exploring the eastern Serengeti, a territory renowned for cheetah and leopard.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Predator Tracking\", \"accommodation\": \"Namiri Plains\"}, {\"day\": 7, \"desc\": \"Game drive north towards the Mara River. The landscape changes from plains to rolling hills.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"Northern Serengeti\", \"accommodation\": \"Singita Mara River Tented Camp\"}, {\"day\": 8, \"desc\": \"A day spent along the riverbanks, seeking the elusive and dramatic river crossings.\", \"meals\": \"Breakfast, Lunch, Dinner\", \"title\": \"The Mara River\", \"accommodation\": \"Singita Mara River Tented Camp\"}, {\"day\": 9, \"desc\": \"Board a light aircraft from the Serengeti bush directly to the spice island of Zanzibar.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Bush to Beach\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 10, \"desc\": \"A day of absolute recovery. White sands, turquoise waters, and ocean breezes.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Zanzibar Coast\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 11, \"desc\": \"Explore the labyrinthine alleys of historic Stone Town and visit a local spice farm.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Stone Town & Spice Tour\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 12, \"desc\": \"Sail on a traditional wooden dhow, snorkeling the vibrant coral reefs.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Indian Ocean Excursion\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 13, \"desc\": \"Your final full day to bask in the sun or indulge in world-class spa treatments.\", \"meals\": \"Breakfast, Dinner\", \"title\": \"Barefoot Luxury\", \"accommodation\": \"Zuri Zanzibar\"}, {\"day\": 14, \"desc\": \"Private transfer to Zanzibar Airport for your international flight home.\", \"meals\": \"Breakfast\", \"title\": \"Departure\", \"accommodation\": \"None\"}]', '2026-04-09 06:51:26', '2026-04-09 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('24PE5ojtgRDKjJyk9gYEveub4yKPTwTMMJW04lXD', NULL, '205.169.39.11', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazc4ODlWSmU5N2ZOSURqcGNETUlHZVNsbmd5SXhoVTBuWmpIOEplVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777979371),
('3y7F5GkuLVip1fNA3Rctu3Unjm8sApfdc9moPeoC', NULL, '104.23.217.25', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXJIMkxVYVUybnl0TTgxNjcwcXVWNVM3SkNIMnBJd3VNTzdXSWJXbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777981489),
('6ovNXmQvSsxhof9Afxqf4KlIv5yo2fN80zo5D9TB', NULL, '142.250.32.7', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmNaT0thc1dLbTk4dWNLa3lRNVc0UHpSbFZxTWpLYVI5MWJuTnEwYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982403),
('8Rl8VCT9lDyDPmFsyCu2cNpmf5Rp9eXniRlgkNtP', NULL, '142.250.32.9', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnpDVm85Z2N0VWxoYUtMbUhyR2Q0VFQ2SHVOd3JPQXE0ck1iZXpBdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982403),
('9zcbQDToddjx0HXyMLDbfretFCiXpkKaN5U3Q30n', NULL, '17.241.219.136', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzNvSFg2c29WYWJBSURJeURZajdZejZid3dOQlg2UDlpYzFuZ2xIRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vYXBpL3BhZ2VzL2NvbnRhY3QiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6bGEyUU5DUFcyd0NEdHdPQiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982777),
('AoVAFi9nK4D6hKVMi1N7o0GXlB6gWogjBNUenBGJ', NULL, '104.23.221.28', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmRyWnZ2VTRqYWp5UVUydEZRU2x2cEJ3cEp3RHQzZk83bnh4TU93RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777977060),
('aPyPKPQV2xlFKxv0HJvtzaceiCnu93ppgoyQGJ0m', NULL, '202.8.41.38', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFVVbnNzZkc2TFh2WGtSQUF3bW5CQkh6MUc3dlhMRGdXUU9hR0pBNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vYXBpL3RyZWtraW5nLXJvdXRlcyI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjpqTEVMdVRaM2hNVlpQWU9NIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777981550),
('bDP5UERXEPz9eDvgAPr9NvPnXhEHrgmovGrBsqsw', NULL, '216.73.216.186', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmFnUVRiTkN0UFpHNUZzVGlXc1lLdnZvYWxtcGNWZXlYMHcxano5WCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vbWFpbC50YW56YW5pYXNlbnNhdGlvbmFsLmNvbS9zaXRlbWFwLnhtbCI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp2N1BDYnVyNzhDcFZFZlo5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777979093),
('cREU2QoI7V47OmWJsuceXVDmrzShaRSga5goamGb', NULL, '142.250.32.7', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVhxdEhYNU1qQmJGYWFOTlg2SERtOTFZOHo4OVVHVjJRWHYwMnlLUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vZ29vZ2xlMWFiNWVhYjgxYjBjYzQzYi5odG1sIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OkROWjdmVjRsV3RqdmQ0NFoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777982402),
('Do2sZKdhCitHbW1xgwP47DsnlfBAncFAEz3WB4bc', NULL, '44.204.65.148', 'Mozilla/5.0 (compatible; Konqueror/4.5; NetBSD 5.0.2; X11; amd64; en_US) KHTML/4.5.4 (like Gecko)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicHR0SVdkaFoybzY5VVpnVEpQVkpTOVJiSXJ2dzJ3SXhRSkttZEIybCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbSI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjpETlo3ZlY0bFd0anZkNDRaIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777976422),
('eyiCyDuIeVNzXIStTRt3di3UCmSntEBIvgb2Ltu3', NULL, '216.73.216.186', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmR5VXNzTDBDSHd2T1lheUxtR0ppbEFpbHdaSVo4Y1JUaVZCTnZzRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vbWFpbC50YW56YW5pYXNlbnNhdGlvbmFsLmNvbS9zaXRlbWFwLnhtbCI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp2N1BDYnVyNzhDcFZFZlo5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777982745),
('F1BcPYBZvhU6Z6SWxsS2FpX1pwxmNSP2xsvyCBmn', NULL, '88.151.32.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGxDMkllZGZnd0ZEZXF0UHFKTThLeEZoSUhGNFNFSlZFdHhNc2htOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbSI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjpETlo3ZlY0bFd0anZkNDRaIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777976795),
('fIJqO80Oywu7xtqRmwBYOIQPkaw205HfFbtniVFd', NULL, '23.27.145.38', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY29palA5ZnJvejFFUmRvMjVLZXVkVzFFNDN3MDQyMmJWTTBIOVpDciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777980163),
('GH8pnI6lGLLOMyBz5ngmMKBT47jyes2oOI5UNxGU', NULL, '104.23.217.25', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2F0RFFiZVZRdm5rT05RRVA4TVFOSDJWYmVPSjEzRHYycmxnaUtvWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777977053),
('IKTZQTvfRrgtEToa1NscZs2MCGSHvCeTXwSgIccu', NULL, '142.250.32.8', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1lqdVNQUGduMnl6ZFZhWmYyTHVoamUzdmpsd2dFWTgwdDFscTNoWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vZ29vZ2xlOGQ2MmJmN2NkMjMxNjhiMS5odG1sIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OkROWjdmVjRsV3RqdmQ0NFoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777982403),
('inFe3xszUQ667IwgE76do1Xd2XcYDv1dlBuxqXDQ', 1, '41.59.200.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRzZWS1l5MUE2eFJ5S0dsSnpOSVNtRmxMU0pYaUdwb2JJRlhhVTl4byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vYXBpL2FkbWluL25vdGlmaWNhdGlvbnM/cGVyX3BhZ2U9MTAiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6dXppQWU3dWx3ekVCU2RpWCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjRjNDBjZTk1ODk1ODEzM2U0NWFjMjJlYzU4NDhhNGRjZGRjMDYzODg0ZWU5NWYwYzlmNzkyM2IwZjc3ZmY2Y2EiO30=', 1777982808),
('jFZfHDtDdOPIrp0UULtP8WIIl5o0evduaCALXpAE', NULL, '170.106.37.134', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNW5tVVJTYjFkV0JnaVp3aHBtOWRwQXZFdDJpaGZlQ1U4bENLSVJSdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777975957),
('jIhjfC78AjsEY8wwY1R6kIMQz9ygryCUHGVPvOA3', NULL, '66.102.9.1', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnlzOTJ4VGdkQU9PNGVMcXVmVXltQ0RubHhZeXA0Slp0TW8wMGtoaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982403),
('LOs5PIKqyiM6zT0sZaTXDSOIj8PjqCYPUnM1EKMF', NULL, '104.23.221.28', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0Q0YVRGcmV5QmRlS2hpc2x2VncxMzlBT1lqVWwxaGhNU2JET3U5TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777979082),
('LSUtnJ9oBPDUlOIpOWn5XQCsOZqjsM4CkoXebCvw', NULL, '44.204.65.148', 'Mozilla/5.0 (Linux; Android 11; Redmi Note 8T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXN4VjBWUFQ4U3VkME5LVkozS0RSb1lsSW81ODQ3VTNiZkQwWDdqTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20iO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777976422),
('M2P8cIxkaV83fiNpThi6xEa6lGgUJE4orTzWykS8', NULL, '17.241.227.172', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3RaS1A0bkNEYVRmWlhjSnFuWlh4WmR1aW5XdlpIUHNxOVFZZmYzcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS9hcGkvdXNlciI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp6SzBxdkRBY3lSQmcxUUdrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777982413),
('Nrx2kQ43yduLsFR5qCMXd7T5xnroLUPPqr3PAfiT', NULL, '104.197.69.115', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlhwYmtDeEF0eFR4WDhZa1lhNE1Pc1JrbFBsN05QZ3R6bVg1b2xlSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS9hcGkvdXNlciI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp6SzBxdkRBY3lSQmcxUUdrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777979359),
('oLjAXS6gPNPss6wOr5QhYI0IONL8C88lR1YiKvTQ', NULL, '142.250.32.8', 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3FpQzBuSXdNVmZJOTNUUEtjd3c4enV0aTVZRnBHOGFJVEtRWkpxViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vdGFuemFuaWFzZW5zYXRpb25hbC5jb20vP2NhY2hlYnVzdGVyPTM2NDUwNDkyNDUiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982403),
('OMq8evzs8Q7E0JW0AT48R9mmUUwlgn0K4TJTbnCO', NULL, '162.158.182.172', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjlRcGF0eHA3djIyQUxpTTdxdmhXdmYxRG1LREFCeTJtUWRNMUFrYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777978504),
('poOAPLUK1fQ1XDB27KHtCeDJxE8Xfm63aAJV3PR3', NULL, '162.158.182.173', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGJzNnhtaGwxQjhSZGxIc2x1SkdhYU9LeFdEMm1tWXZGRUV1Z1BUeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777976753),
('wJKrS4KF44bkmZbCbdExSSeByvQqFMfFK7EAjnMS', NULL, '104.23.223.79', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWZMaVluZjBXM2lqUWpyZ1B3SjlqUVFNT2hRaW1EZlB4WGlqRngwcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777980983),
('X6GSiqXvDKHDKboGNuQoTapT6XGlzYIDTDnSCXk6', NULL, '104.23.217.24', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXBsZUNBTVRoM1lJRkpVMlBSV3hiZkNLcW1nekswQXRQcG1xRFU1SSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777982646),
('xAY0yfCZVvCQJv4YFqmVfv6lJ2T9Y0zTtDhewx9A', NULL, '104.23.221.29', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2JwclpuR0pNYkpqUWJvelNaVkZIUUwxQ0N6ZzBVeFdyMUIycDRBWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777980340),
('y0eQs09BqRZ8RAHw2tM736aGuIkNNm3BPf5K7BzH', NULL, '104.23.221.29', 'http://tanzaniasensational.com/wp-admin/install.php?step=1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUdSRWdZV1M5NkRGRk5hMFZWemdQRlRCQlZJY0d6SFJXakhTYURQMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly90YW56YW5pYXNlbnNhdGlvbmFsLmNvbS93cC1hZG1pbi9pbnN0YWxsLnBocD9zdGVwPTEiO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6RE5aN2ZWNGxXdGp2ZDQ0WiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777975526);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `key` varchar(255) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `group`, `key`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'general', 'company_name', '{\"value\":\"Tanzania Sensational\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(2, 'general', 'tagline', '{\"value\":null}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(3, 'general', 'currency', '{\"value\":\"USD\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(4, 'contact', 'support_email', '{\"value\":\"info@tanzaniasensational.com\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 09:44:54'),
(5, 'contact', 'phone', '{\"value\":\"+255 743 262 822\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(6, 'contact', 'whatsapp', '{\"value\":\"+255 743 262 822\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(7, 'contact', 'address', '{\"value\":\"Arusha, Tanzania.\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 09:56:14'),
(8, 'social', 'instagram', '{\"value\":null}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(9, 'social', 'facebook', '{\"value\":null}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(10, 'social', 'twitter', '{\"value\":null}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(11, 'social', 'linkedin', '{\"value\":null}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08'),
(12, 'branding', 'primary_color', '{\"value\":\"#C9A84C\"}', NULL, '2026-05-05 08:46:08', '2026-05-05 08:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `trekking_routes`
--

CREATE TABLE `trekking_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_badge` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `difficulty` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `elevation_gain` varchar(255) DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL,
  `max_group_size` int(11) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `editorial_image` varchar(255) DEFAULT NULL,
  `editorial_image_2` varchar(255) DEFAULT NULL,
  `editorial_content` text DEFAULT NULL,
  `success_rate` varchar(255) DEFAULT NULL,
  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inclusions` text DEFAULT NULL,
  `exclusions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trekking_routes`
--

INSERT INTO `trekking_routes` (`id`, `name`, `slug`, `meta_badge`, `description`, `difficulty`, `duration`, `distance`, `elevation_gain`, `base_price`, `max_group_size`, `hero_image`, `editorial_image`, `editorial_image_2`, `editorial_content`, `success_rate`, `highlights`, `created_at`, `updated_at`, `inclusions`, `exclusions`) VALUES
(1, '7 Days Lemosho Route', 'lemosho-7-days', NULL, 'The Lemosho route is widely considered to be the most scenic route on Kilimanjaro, offering panoramic views on various sides of the mountain. It starts with a wild and quiet start in the rainforest before opening up to the literal roof of Africa.', 'Moderate-High', 7, NULL, NULL, 1900.00, 12, '/storage/trekking-routes/Mhy7JTNjHbJAwcl0yqfWEmmrfFoQWkT0SPD8NI3F.jpg', NULL, NULL, NULL, '85%', '[\"Exceptional Scenery\", \"Excellent Acclimatization\", \"Wild and Quiet Start\", \"Rich Biodiversity\"]', '2026-04-09 06:51:25', '2026-04-11 16:30:01', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(2, '8 Days Lemosho Route', 'lemosho-8-days', NULL, 'Adding an extra day for acclimatization makes the 8-day Lemosho route the gold standard for success. It offers the same stunning scenery as the 7-day version but with a gentler pace.', 'Moderate', 8, NULL, NULL, 2250.00, 12, '/storage/trekking-routes/ILWG6WKxh7LKGRMJrkMYOViA1cvEQ0z0LE4WRnX5.jpg', NULL, NULL, NULL, '90%', '[\"Maximum Success Rate\", \"Optimal Acclimatization\", \"Stunning Shira Plateau\", \"Remote Western Approach\"]', '2026-04-09 06:51:25', '2026-04-11 15:55:18', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(3, '6 Days Machame Route', 'machame-6-days', NULL, 'The \'Whiskey Route\' is the most popular path on Kilimanjaro. The 6-day version is arduous and fast-paced, suited for fit trekkers with some mountain experience.', 'High', 6, NULL, NULL, 1650.00, 12, '/storage/trekking-routes/VeNWv7nGjnxyGvlWMiJULX7AN1BCP4K9RnTCHtu4.jpg', NULL, NULL, NULL, '75%', '[\"Dramatic Landscapes\", \"Barranco Wall Scramble\", \"Diverse Ecology\", \"Popular Scenic Choice\"]', '2026-04-09 06:51:25', '2026-04-11 16:36:57', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(4, '7 Days Machame Route', 'machame-7-days', NULL, 'The 7-day Machame route offers a much better success rate than the 6-day version. It includes an extra day at Karanga Valley for essential acclimatization.', 'Moderate-High', 7, NULL, NULL, 1900.00, 12, '/storage/trekking-routes/uhmp5TNlYeHfKdmLChkxXcLbgEhoJJtFL8QWxDgg.jpg', NULL, NULL, NULL, '85%', '[\"Better Acclimatization\", \"Iconic Southern Circuit\", \"Breathtaking Views\", \"Summit Success Focus\"]', '2026-04-09 06:51:25', '2026-04-11 16:35:58', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(5, '5 Days Marangu Route', 'marangu-5-days', NULL, 'The shortest path to the summit via huts. Arduous due to the rapid ascent, the 5-day Marangu is an intense test of willpower and physical fitness.', 'Hard', 5, NULL, NULL, 1400.00, 12, '/storage/trekking-routes/DwEJxkszNVuKu24hQbw9NEEXrsMwcmql4HsqbBlJ.jpg', NULL, NULL, NULL, '60%', '[\"Hut Accommodation\", \"Classic Route\", \"Fastest Hut Ascent\", \"Budget Friendly\"]', '2026-04-09 06:51:25', '2026-04-11 16:34:29', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(6, '6 Days Marangu Route', 'marangu-6-days', NULL, 'The \'Coca-Cola\' route is the only one offering hut accommodation. The 6-day version is recommended for its mandatory acclimatization day at Horombo Hut.', 'Moderate', 6, NULL, NULL, 1650.00, 12, '/storage/trekking-routes/K2i97q9I6jRHxzs8j012rYb56ccTTE4w7zBdVRQY.jpg', NULL, NULL, NULL, '75%', '[\"Hut Accommodation\", \"Classic Kilimanjaro Path\", \"Gentle Terrain\", \"Rainy Season Friendly\"]', '2026-04-09 06:51:25', '2026-04-11 15:58:43', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(7, '6 Days Rongai Route', 'rongai-6-days', NULL, 'A direct approach from the north. The 6-day Rongai is a steady climb through varied wilderness, descending via the popular Marangu trail.', 'Moderate-High', 6, NULL, NULL, 1650.00, 12, '/storage/trekking-routes/9eWCjL7TDuWgV8PB48wFVOujaVLMfV0GIPqhgMKr.jpg', NULL, NULL, NULL, '75%', '[\"Northern Approach\", \"Less Crowded\", \"Wildlife Spottings\", \"Scenic Variety\"]', '2026-04-09 06:51:25', '2026-04-11 16:35:14', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(8, '7 Days Rongai Route', 'rongai-7-days', NULL, 'Approaching from the north near the Kenyan border, the Rongai route is drier and less crowded. It transitions from pine forests to cinematic alpine deserts.', 'Moderate', 7, NULL, NULL, 1900.00, 12, '/storage/trekking-routes/uCsQVNgwure2xFR4BrTCfiyhRiFiE8zcklrBSM2d.jpg', NULL, NULL, NULL, '85%', '[\"Remote Northern Slope\", \"Wildlife Opportunities\", \"Drier Ascent Path\", \"Quiet Wilderness\"]', '2026-04-09 06:51:25', '2026-04-11 15:56:27', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(9, '8 Days Northern Circuit', 'northern-circuit-8-days', NULL, 'A condensed version of the world-class Northern Circuit. Circles the high northern slopes, avoiding the crowds of the southern routes completely.', 'Moderate', 8, NULL, NULL, 2250.00, 12, '/storage/trekking-routes/TWPD6YVu2sYnNuXub0ZW1zZtws8h0oe9qAMxr798.jpg', NULL, NULL, NULL, '90%', '[\"High Success Rate\", \"Northern Wilderness\", \"360-Degree Vistas\", \"Remote Solitude\"]', '2026-04-09 06:51:25', '2026-04-11 16:33:40', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(10, '9 Days Northern Circuit', 'northern-circuit-9-days', NULL, 'The newest and longest route on Kilimanjaro. It circles nearly the entire mountain, offering incredible 360-degree views and arguably the best acclimatization profile.', 'Moderate', 9, NULL, NULL, 2500.00, 12, '/storage/trekking-routes/UaEyEOyXKPsEcuJYO8y1V3dzY5TYg4dXSHpDgYTZ.jpg', NULL, NULL, NULL, '95%', '[\"360 Degree Views\", \"Maximum Acclimatization\", \"Newest Remote Path\", \"Diverse Scenic Changes\"]', '2026-04-09 06:51:25', '2026-04-11 15:57:28', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(11, '6 Days Umbwe Route', 'umbwe-6-days', NULL, 'Short, steep, and hard. The Umbwe route is for experienced climbers only, offering a direct vertical ascent through spectacular terrain.', 'Extreme', 6, NULL, NULL, 1650.00, 12, '/storage/trekking-routes/nhzGaTfR6aIE2ZPzaAsvuzu738W94rvUJ0oYS8EO.jpg', NULL, NULL, NULL, '65%', '[\"Fastest Direct Ascent\", \"Most Technical Path\", \"Extreme Challenge\", \"Spectacular Solitude\"]', '2026-04-09 06:51:25', '2026-04-12 11:59:07', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(12, '7 Days Umbwe Route', 'umbwe-7-days', NULL, 'The 7-day variation of the steep Umbwe route offers a slightly improved acclimatization window at Barranco, making the vertical push more manageable.', 'Extreme', 7, NULL, NULL, 1900.00, 12, '/storage/trekking-routes/bSJLELpncO60ybTEjYve2kdyEKB9QEsvnH7m3tef.jpg', NULL, NULL, NULL, '75%', '[\"Vertical Challenge\", \"Luxury of Solitude\", \"Barranco Wall Detail\", \"High Altitude Experience\"]', '2026-04-09 06:51:25', '2026-04-11 16:37:52', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(13, '8 Days Lemosho with Crater Camp', 'lemosho-8-days-crater', NULL, 'Sleep within the ancient volcanic bowl of Kilimanjaro. This elite expedition includes a night at Crater Camp (5730m) near the glaciers.', 'Extreme', 8, NULL, NULL, 2750.00, 12, '/storage/trekking-routes/qeyevv9pEuAhLCCQJP2Xl3sMpBZ8jUaiYR4owe3j.jpg', NULL, NULL, NULL, '85%', '[\"Sleep in the Crater\", \"Elite Adventure\", \"Touch the Glaciers\", \"Sunrise at the Peak\"]', '2026-04-09 06:51:25', '2026-04-11 16:31:02', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(14, '9 Days Northern Circuit & Crater', 'northern-circuit-9-days-crater', NULL, 'The ultimate Kilimanjaro experience. Combines the best-acclimatized route with a night inside the crater. Experience the mountain in its full glory.', 'Extreme', 9, NULL, NULL, 3000.00, 12, '/storage/trekking-routes/g1s7nd23SRgNcjPy8AYhrRNllAoZKArUHhtHTewJ.jpg', NULL, NULL, NULL, '90%', '[\"360 Degree Northern Circuit\", \"Crater Overnight\", \"Unrivaled Success Rate\", \"Glacial Sleeping Experience\"]', '2026-04-09 06:51:25', '2026-04-11 15:54:31', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(15, '3 Days Mount Meru Climb', 'mt-meru-3-days', NULL, 'Mount Meru is the perfect warm-up for Kilimanjaro or a stunning stand-alone peak. This 3-day trek is fast-paced but scenically rewarding.', 'Moderate', 3, NULL, NULL, 850.00, 12, '/storage/trekking-routes/tEfA4LMMq2g5xy7R1BifoPlLX6HTl4zq39SPIc93.jpg', NULL, NULL, NULL, '85%', '[\"Walking Safari\", \"Dramatic Ash Cone\", \"View of Kilimanjaro\", \"Arusha National Park\"]', '2026-04-09 06:51:25', '2026-04-11 16:40:18', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]'),
(16, '4 Days Mount Meru Climb', 'mt-meru-4-days', NULL, 'The recommended Meru itinerary. Includes an extra day at Saddle Hut for better acclimatization and higher success at the Socialist Peak.', 'Moderate', 4, NULL, NULL, 950.00, 12, '/storage/trekking-routes/PslQ05LuLaB1qCWIYIqcec3Cgm75LlVgsRCdy5B0.jpg', NULL, NULL, NULL, '95%', '[\"Optimal Acclimatization\", \"Ash Cone Vistas\", \"Kilimanjaro Silhouettes\", \"Rich Wildlife\"]', '2026-04-09 06:51:25', '2026-04-11 16:39:03', '[\"2 Nights Hotel Accommodation (Moshi\\/Arusha)\",\"All Kilimanjaro National Park Fees\",\"Professional Certified Mountain Guides\",\"Personalized Mountain Cook & Assistant\",\"Traceable Oxygen & Pulse Oximeters\",\"All Meals on Mountain (B, L, D)\",\"High-Quality Mountain Tents & Mats\",\"Fair Crew Wages & Comprehensive Insurance\"]', '[\"International & Domestic Flights\",\"Tanzania Entry Visa Fees\",\"Tips for Mountain Crew (Recommended)\",\"Personal Trekking Gear & Sleeping Bags\",\"Travel & Medical Insurance\",\"Items of a Personal Nature\"]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@tanzaniasensational.com', NULL, '$2y$12$tIVEr5WfhO0nszUXvN0plu11.P/KW/wGTrroC2jvhrt8cNrf/j.fq', 'admin', NULL, '2026-04-09 06:51:25', '2026-04-09 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `visual_assets`
--

CREATE TABLE `visual_assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'image',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visual_assets`
--

INSERT INTO `visual_assets` (`id`, `section`, `key`, `url`, `type`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'branding', 'logo', '/logo.png', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(2, 'branding', 'favicon', '/favicon.ico', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(3, 'common', 'bentoPattern', 'https://www.transparenttextures.com/patterns/stardust.png', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(4, 'common', 'placeholderHero', 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(5, 'booking', 'hero', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(6, 'home', 'experienceMain', 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(7, 'home', 'experienceSecondary', 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(8, 'home', 'extensionSerengeti', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(9, 'home', 'extensionZanzibar', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(10, 'home', 'ctaBg', 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=2000&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(11, 'about', 'legacy', 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(12, 'about', 'experienceBand', 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(13, 'zanzibar', 'regionStoneTown', 'https://images.unsplash.com/photo-1580979878201-1e9d1a3eb64f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(14, 'zanzibar', 'regionNungwi', 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(15, 'zanzibar', 'regionPaje', 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(16, 'zanzibar', 'expSpice', 'https://images.unsplash.com/photo-1606041008023-472dfb5e530f?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(17, 'zanzibar', 'expSafariBlue', 'https://images.unsplash.com/photo-1533221375330-84c6af70ce9b?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(18, 'zanzibar', 'expPrisonIsland', 'https://images.unsplash.com/photo-1437622368342-7a3d73a40cfa?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(19, 'planning', 'meruHero', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(20, 'planning', 'gearHero', 'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(21, 'planning', 'trainingHero', 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(22, 'planning', 'faqHero', 'https://images.unsplash.com/photo-1589308454676-e1af9491a670?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(23, 'planning', 'addonsHero', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(24, 'trekking.routes', 'lemoshoEditorial', 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(25, 'trekking.routes', 'machameEditorial', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(26, 'trekking.routes', 'maranguEditorial', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(27, 'trekking.routes', 'northernEditorial', 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(28, 'trekking.prep', 'bestTime', 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(29, 'trekking.prep', 'bestRoutes', 'https://images.unsplash.com/photo-1589182397057-b82b16867e7c?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(30, 'trekking.prep', 'whyUs', 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(31, 'trekking.prep', 'tippingHero', 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(32, 'safaris', 'listHero', 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(33, 'safaris', 'migrationHero', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(34, 'destinations', 'serengetiHero', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(35, 'destinations', 'ngorongoroHero', 'https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=2000&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(36, 'destinations', 'tarangireHero', 'https://images.unsplash.com/photo-1581852015102-142a2c317022?w=2000&q=85&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(37, 'destinations.gallery', 'serengeti-1', 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(38, 'destinations.gallery', 'serengeti-2', 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(39, 'destinations.gallery', 'serengeti-3', 'https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(40, 'contact', 'luxuryBg', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop', 'image', '{\"is_static\": true}', '2026-04-09 06:51:26', '2026-04-09 06:51:26'),
(43, 'home.experienceMain', 'home_experiencemain_patriestb_kilimanjaro_1221879_1920_1_45595', '/storage/visual-assets/home_experiencemain/rej1izEAo08gLBSnjfd58iFJ1d9GIGyNM2DHqs2a.jpg', 'image', '{\"alt\": null}', '2026-04-11 15:41:08', '2026-04-11 15:41:08'),
(44, 'home.experienceSecondary', 'home_experiencesecondary_wandelvrouw_kilimanjaro_944311_1920_1_14621', '/storage/visual-assets/home_experiencesecondary/V7PDKWWvUFpB6c1YZQwOd1HAxAEqZUkH5kjnyoCw.jpg', 'image', '{\"alt\": null}', '2026-04-11 15:43:54', '2026-04-11 15:43:54'),
(45, 'home.extensionSerengeti', 'home_extensionserengeti_jurgen_bierlein_lion_7490149_1920_1_41074', '/storage/visual-assets/home_extensionserengeti/W0namb9kKmlfyy03QG47GolxgTyFg50LCkqA2Nhk.jpg', 'image', '{\"alt\": null}', '2026-04-11 15:51:11', '2026-04-11 15:51:11'),
(46, 'home.extensionZanzibar', 'home_extensionzanzibar_darkeyed_island_4948796_1920_1_705', '/storage/visual-assets/home_extensionzanzibar/BW6HCCJP4oucwW7Hd33S2c7cL28dIYLHpNwTLvYU.jpg', 'image', '{\"alt\": null}', '2026-04-11 15:52:25', '2026-04-11 15:52:25'),
(49, 'trekking.routes.lemosho', 'trekking_routes_lemosho_pexels_marina_zvada_844583049_31144648_1_19227', '/storage/visual-assets/trekking_routes_lemosho/oV9PsaGFwzLCODG9CskGGVTHoanH7uSbKkPE1nsl.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:20:13', '2026-04-11 16:20:13'),
(50, 'trekking.routes.lemoshoEditorial', 'trekking_routes_lemoshoeditorial_jmarti20_kilimanjaro_4436821_1920_1_79852', '/storage/visual-assets/trekking_routes_lemoshoeditorial/x1uaPAzEKdRRP8jaulZjA9UOdHYtdI89oRWeVOOr.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:21:17', '2026-04-11 16:21:17'),
(51, 'trekking.routes.machame', 'trekking_routes_machame_251556_kilimanjaro_342697_1920_1_47717', '/storage/visual-assets/trekking_routes_machame/SW7EAFfTbGE5qwblQmcxx6zMyI1vKZn9RMNz96T8.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:23:10', '2026-04-11 16:23:10'),
(52, 'trekking.routes.machameEditorial', 'trekking_routes_machameeditorial_pexels_nirav_shah_6927042_15904775_76275', '/storage/visual-assets/trekking_routes_machameeditorial/uGic58QJAeSlFdNdJv6BLyGZnoZx9Mso9p1TE86e.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:23:17', '2026-04-11 16:23:17'),
(53, 'trekking.routes.marangu', 'trekking_routes_marangu_7523944_kilimanjaro_4597809_1920_1_4696', '/storage/visual-assets/trekking_routes_marangu/04IXbPBo8MizThdEtVSx0lEWZCfCIZOSkUriJAJ9.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:24:35', '2026-04-11 16:25:17'),
(55, 'trekking.routes.rongai', 'trekking_routes_rongai_3282700_nature_1821576_1920_1_59328', '/storage/visual-assets/trekking_routes_rongai/Vvp5iLRnkqWSMDqaKaAyensD29lKFQpy0QX0ObiO.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:26:54', '2026-04-11 16:26:54'),
(56, 'trekking.routes.northern', 'trekking_routes_northern_moodin_kilimanjaro_1203937_1920_1_66220', '/storage/visual-assets/trekking_routes_northern/2v4KBVo16oOK0lBW2IBdoQ3CFZnLqwPrKNrwVjUC.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:27:54', '2026-04-11 16:27:54'),
(57, 'trekking.routes.umbwe', 'trekking_routes_umbwe_squirrel_photos_kilimanjaro_7312235_1920_1_87265', '/storage/visual-assets/trekking_routes_umbwe/fUuW3kKYGfUiOxCqgqGQIf4vaZdwlHwssS1r09mB.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:28:57', '2026-04-11 16:28:57'),
(58, 'trekking.prep.bestRoutes', 'trekking_prep_bestroutes_pexels_balazsimon_15993990_1_48056', '/storage/visual-assets/trekking_prep_bestroutes/XXg6tUeQWDx0jMAjfumykETJKqA12xweoPtI4ilo.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:43:31', '2026-04-11 16:43:31'),
(59, 'trekking.prep.bestRoutesEditorial', 'trekking_prep_bestrouteseditorial_pexels_balazsimon_15993990_1_72991', '/storage/visual-assets/trekking_prep_bestrouteseditorial/8sHWGTJMQEIk4HZmTEW51LiG3uL6Bh1YWLwnH8aj.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:43:45', '2026-04-11 16:46:08'),
(60, 'trekking.prep.whyUs', 'trekking_prep_whyus_pexels_1093389518_31107597_1_47752', '/storage/visual-assets/trekking_prep_whyus/afPTDoZ6M35XHHaNLHCvLAwuMNjcx4jmksZASfR7.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:44:32', '2026-04-11 16:49:13'),
(61, 'trekking.prep.whyUsEditorial', 'trekking_prep_whyuseditorial_pexels_1093389518_31107595_1_1_55844', '/storage/visual-assets/trekking_prep_whyuseditorial/sky665TaoG88qOJKyuIl15dRnmea6KyvcgWgPmmd.jpg', 'image', '{\"alt\": null}', '2026-04-11 16:49:24', '2026-04-11 16:50:34'),
(62, 'trekking.prep.tippingHero', 'trekking_prep_tippinghero_pexels_rdne_7363200_1_21086', '/storage/visual-assets/trekking_prep_tippinghero/UkwQ4eLbpktAw26ws7C8naUL1uMLrhBgZMi3yprF.jpg', 'image', '{\"alt\": null}', '2026-04-12 00:56:33', '2026-04-12 00:56:33'),
(63, 'trekking.prep.tippingEditorial', 'trekking_prep_tippingeditorial_pexels_1093389518_30980287_1_1_1214', '/storage/visual-assets/trekking_prep_tippingeditorial/b8jH7SUWn7RKAgaZelZGkHePcfItEifihYuOpgKf.jpg', 'image', '{\"alt\": null}', '2026-04-12 00:58:18', '2026-04-12 00:58:18'),
(64, 'trekking.prep.toiletsHero', 'trekking_prep_toiletshero_pexels_marina_zvada_844583049_31168813_2_94565', '/storage/visual-assets/trekking_prep_toiletshero/tzmyGn0gza6jVp7xtd1dqPMzOs9wZtMrOePZHcUs.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:03:49', '2026-04-12 01:03:49'),
(65, 'trekking.prep.toiletsEditorial', 'trekking_prep_toiletseditorial_pexels_merakshot_9349466_1_55495', '/storage/visual-assets/trekking_prep_toiletseditorial/BpxwHg4AZ2v5fBG41O80Aoz65OQ3IRDSKkiYuV8i.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:04:42', '2026-04-12 01:04:42'),
(66, 'trekking.health.vaccinations', 'trekking_health_vaccinations_spencerbdavis1_vaccine_6165772_1280_25870', '/storage/visual-assets/trekking_health_vaccinations/vJIieByA0VaCb2vnkPT6zk1X65fzDUOX0gJZ8UFQ.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:05:34', '2026-04-12 01:05:34'),
(67, 'trekking.health.vaccinationsEditorial', 'trekking_health_vaccinationseditorial_nuzree_mosquito_213806_1280_1_8229', '/storage/visual-assets/trekking_health_vaccinationseditorial/WzB5HvM7AtO1YKSQYU1IxT4KsTjnH9Lm2gXEcek7.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:06:40', '2026-04-12 01:06:40'),
(68, 'trekking.health.altitudeEditorial', 'trekking_health_altitudeeditorial_pexels_rom_fotgrafo_9409993_1_85281', '/storage/visual-assets/trekking_health_altitudeeditorial/MqNlSSE40VMUHk2N8HZDooNCsxF1LUNQcndQQg2E.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:08:06', '2026-04-12 01:08:28'),
(69, 'trekking.health.altitudeSickness', 'trekking_health_altitudesickness_pexels_roger_brown_3435524_5149754_45769', '/storage/visual-assets/trekking_health_altitudesickness/9XBHUrOJy35QCmudTtpGgnhpIN5Qp4lVgJGTpjDe.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:09:31', '2026-04-12 01:09:31'),
(70, 'trekking.health.diamox', 'trekking_health_diamox_heungsoon_tablets_5620566_1920_1_61089', '/storage/visual-assets/trekking_health_diamox/NSwFScHEGCIgWTCrw56ubunbXRNFKqpB8LPndoNy.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:13:00', '2026-04-12 01:13:00'),
(71, 'trekking.health.diamoxEditorial', 'trekking_health_diamoxeditorial_diamoxer500mgcapsulestripof15_1_56038', '/storage/visual-assets/trekking_health_diamoxeditorial/DsO7NYJNrQykuv1GgZF2ityHqyX0SDPwUydAIhkF.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:13:29', '2026-04-12 01:13:29'),
(72, 'trekking.health.oxygenEditorial', 'trekking_health_oxygeneditorial_oxygen_gas_653_46967', '/storage/visual-assets/trekking_health_oxygeneditorial/kvW02cqR2cWwNe6ecQImQ2r9EOUYXUKFGpSK35Jo.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:17:23', '2026-04-12 01:17:23'),
(73, 'trekking.health.oxygen', 'trekking_health_oxygen_pexels_balazsimon_15993990_2_79229', '/storage/visual-assets/trekking_health_oxygen/ZCaEnJ12giAV7p8R276ZdVjFMAjj4d5wVrs0VeuK.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:18:09', '2026-04-12 01:18:09'),
(74, 'trekking.during.routine', 'trekking_during_routine_pexels_noursakina_35875330_72989', '/storage/visual-assets/trekking_during_routine/c3rDqtWlV2R8LpsqqmhoJp7QLiedJzoB4qTbNnrv.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:19:48', '2026-04-12 01:19:48'),
(75, 'trekking.during.routineEditorial', 'trekking_during_routineeditorial_pexels_atiek_arief_2154698689_35919644_1_74403', '/storage/visual-assets/trekking_during_routineeditorial/dAIZTSSjQ8Xc8Gzrpm8bymybXjJGoaQJDItlBwVk.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:20:37', '2026-04-12 01:20:37'),
(76, 'trekking.after.visa', 'trekking_after_visa_pexels_tima_miroshnichenko_7010170_30485', '/storage/visual-assets/trekking_after_visa/RMo5HUBOuWC09JIihMm5vnaVqWP2oC9Jvg8fws5U.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:21:35', '2026-04-12 01:21:35'),
(77, 'trekking.after.visaEditorial', 'trekking_after_visaeditorial_pexels_davegarcia_32642491_3444', '/storage/visual-assets/trekking_after_visaeditorial/3HRYpbwvtDf2bcxYlARNRC8ULr3ueNUa5XWfPorF.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:22:17', '2026-04-12 01:22:17'),
(78, 'trekking.during.food', 'trekking_during_food_kilimanjaro_foods_2_6408', '/storage/visual-assets/trekking_during_food/RtZdJe4kwVTEesFrxVtEAtY2Rdf6m8WUuN0ToeCr.webp', 'image', '{\"alt\": null}', '2026-04-12 01:29:26', '2026-04-12 01:29:46'),
(79, 'trekking.during.foodEditorial', 'trekking_during_foodeditorial_kilimanjaro_foods_2_27480', '/storage/visual-assets/trekking_during_foodeditorial/WYmS9iSUk3jEebTYtGB9C9ilzyjHBqJTGZiMKjZi.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:29:43', '2026-04-12 01:29:43'),
(80, 'trekking.during.packDaypack', 'trekking_during_packdaypack_pexels_balazsimon_15994022_2_46749', '/storage/visual-assets/trekking_during_packdaypack/EivDA9zVPIyJL9IP5xQjp6VYrsxeesD8UQxumNMA.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:32:03', '2026-04-12 01:32:03'),
(81, 'trekking.during.packDaypackEditorial', 'trekking_during_packdaypackeditorial_pexels_marina_zasorina_8904756_81343', '/storage/visual-assets/trekking_during_packdaypackeditorial/Q01unzT2hOo8KUJLHdhX1aEzSSqwsHptl5gO8yjU.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:32:53', '2026-04-12 01:32:53'),
(82, 'trekking.during.connectivity', 'trekking_during_connectivity_jeshoots_com_iphone_410324_1920_79745', '/storage/visual-assets/trekking_during_connectivity/SAjATNrNd0Duguhi2Vb4M6E6annCsGr3cwbrnrKs.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:34:18', '2026-04-12 01:34:18'),
(83, 'trekking.during.connectivityEditorial', 'trekking_during_connectivityeditorial_lyoo_jw_smartphone_4396169_1280_85283', '/storage/visual-assets/trekking_during_connectivityeditorial/zktj4ia71NAGjRQYVyDxkTQDmPSJyC5YSR4g0oXq.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:34:22', '2026-04-12 01:34:22'),
(84, 'trekking.after.gearListEditorial', 'trekking_after_gearlisteditorial_pexels_vid_music_1857448_6253925_63043', '/storage/visual-assets/trekking_after_gearlisteditorial/k3cj5rcBzGy8JQQVitZZdyMQANxSoj15f3bbJa2z.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:36:31', '2026-04-12 01:36:31'),
(85, 'trekking.after.gearList', 'trekking_after_gearlist_pexels_viny_18999101_37094', '/storage/visual-assets/trekking_after_gearlist/ZrvUGYogOsBXt7hoQxr7wKbUN8nqzrtyO8Zqt1y2.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:37:08', '2026-04-12 01:37:08'),
(86, 'trekking.after.gettingThere', 'trekking_after_gettingthere_kilimanjaro_international_airport_750x450_26586', '/storage/visual-assets/trekking_after_gettingthere/ljwc0RUGJDxPIhMLNsLlFhOUz9pEiT5PdN6gjAvc.jpg', 'image', '{\"alt\": null}', '2026-04-12 01:38:12', '2026-04-12 01:38:12'),
(87, 'trekking.after.gettingThereEditorial', 'trekking_after_gettingthereeditorial_9azw7zw42owt7rxo3cxr52udoi0rwzof_90285', '/storage/visual-assets/trekking_after_gettingthereeditorial/9BI0GnqquGlwC3b8l6oFmcfYrO0tx9DbN0AmJzVm.webp', 'image', '{\"alt\": null}', '2026-04-12 01:39:18', '2026-04-12 01:39:18'),
(89, 'trekking.routes.umbweEditorial', 'trekking_routes_umbweeditorial_pexels_timon_cornelissen_241844481_27372717_99967', '/storage/visual-assets/trekking_routes_umbweeditorial/qu4Bycs9ZtBnES1xGr1DNnhGIwCS9YB9ViJiBqId.jpg', 'image', '{\"alt\": null}', '2026-04-12 11:08:58', '2026-04-12 12:25:31'),
(90, 'trekking.common.fullBleed', 'trekking_common_fullbleed_pexels_emmanuel_gidamis_331483512_13869976_34357', '/storage/visual-assets/trekking_common_fullbleed/7SSycd7p6hjeuOTtSSZM6xsddMnGTnQoQfmBojGq.jpg', 'image', '{\"alt\": null}', '2026-04-12 11:54:30', '2026-04-12 11:54:30'),
(91, 'trekking.routes.rongaiEditorial', 'trekking_routes_rongaieditorial_pexels_balazsimon_15993988_1_76502', '/storage/visual-assets/trekking_routes_rongaieditorial/MfkSv59EIqaSHiHo3UuC2OEbTPc0lZpyEjaD66D5.jpg', 'image', '{\"alt\": null}', '2026-04-12 12:23:32', '2026-04-12 12:23:32'),
(92, 'trekking.routes.northernEditorial', 'trekking_routes_northerneditorial_pexels_balazsimon_15994016_1_42032', '/storage/visual-assets/trekking_routes_northerneditorial/9iVIzfIj7lpjPMmndNBpfz0qImSlTbwSEKB3TJdw.jpg', 'image', '{\"alt\": null}', '2026-04-12 12:24:18', '2026-04-12 12:25:47'),
(93, 'home.hero', 'home_hero_crispin_jones_ddebal7ulao_unsplash_85670', '/storage/visual-assets/home_hero/0rhALsD10dgfjoiWWvn0VBI09EEivj1oDq6GAHyd.jpg', 'image', '{\"alt\":null}', '2026-04-14 08:52:42', '2026-04-14 08:53:31'),
(94, 'trekking.routes.maranguEditorial', 'trekking_routes_marangueditorial_crispin_jones_ddebal7ulao_unsplash_71332', '/storage/visual-assets/trekking_routes_marangueditorial/LLqnIzvKSm2qzHFbkJTCS51kImvkJ3f1P66hr4PB.jpg', 'image', '{\"alt\":null}', '2026-04-14 10:45:48', '2026-04-14 10:45:48'),
(95, 'trekking.prep.bestTime', 'trekking_prep_besttime_pexels_amani_allan_2147911089_36841474_36556', '/storage/visual-assets/trekking_prep_besttime/nnJt5qn5jUAt8tPduMwiOqI3DsQJ80MpTCUQwQ2G.jpg', 'image', '{\"alt\":null}', '2026-04-14 10:48:40', '2026-04-14 10:48:40'),
(96, 'trekking.prep.bestTimeEditorial', 'trekking_prep_besttimeeditorial_pexels_balazsimon_15994016_69926', '/storage/visual-assets/trekking_prep_besttimeeditorial/xThYXuBFn4Jy8fX1or1VD26MecBL8kh0EBd4QHnn.jpg', 'image', '{\"alt\":null}', '2026-04-14 10:50:22', '2026-04-14 10:50:22'),
(97, 'trekking.prep.parkFeesHero', 'trekking_prep_parkfeeshero_pexels_laukevtravel_26924191_62355', '/storage/visual-assets/trekking_prep_parkfeeshero/s3lVfLz6ZzA38r7kGdcfB6XhD7hMW48PWs3j7X1D.jpg', 'image', '{\"alt\":null}', '2026-04-14 10:52:48', '2026-04-14 10:52:48'),
(98, 'trekking.prep.parkFeesEditorial', 'trekking_prep_parkfeeseditorial_pexels_comrade_kileo_2156275061_34771753_1_30347', '/storage/visual-assets/trekking_prep_parkfeeseditorial/zyrJwOTAwn5s2YCTK2qWWhRBGJAF1BNjI9boYjjH.jpg', 'image', '{\"alt\":null}', '2026-04-14 10:52:54', '2026-04-14 10:52:54'),
(99, 'zanzibar.regionStoneTown', 'zanzibar_regionstonetown_pexels_holmboe_17324934_964', '/storage/visual-assets/zanzibar_regionstonetown/JspeyUwll953fYlD7jRD6wfwNLxCoi9G2qEmYDhB.jpg', 'image', '{\"alt\":null}', '2026-04-14 11:11:34', '2026-04-14 11:25:50'),
(100, 'zanzibar.expPrisonIsland', 'zanzibar_expprisonisland_pexels_chechil_orifa_224183752_14401141_53428', '/storage/visual-assets/zanzibar_expprisonisland/WknkOqFQv5wSpSOSQdgqt6QqPgqwPoegellCvV5w.jpg', 'image', '{\"alt\":null}', '2026-04-14 11:13:04', '2026-04-14 11:13:04'),
(101, 'zanzibar.hero', 'zanzibar_hero_pexels_chechil_orifa_224183752_14401141_32849', '/storage/visual-assets/zanzibar_hero/zmMgUUUjnExEYZSq3bq0MSqWoLkVFpsoxnFucRl0.jpg', 'image', '{\"alt\":null}', '2026-04-14 11:15:21', '2026-04-14 14:35:44'),
(102, 'zanzibar.regionNungwi', 'zanzibar_regionnungwi_pexels_chechil_orifa_224183752_14401141_64314', '/storage/visual-assets/zanzibar_regionnungwi/ROPQ2xLRrEeiqYEDcmXf6zy9kN4C8MmnhBS4lrRt.jpg', 'image', '{\"alt\":null}', '2026-04-14 11:15:35', '2026-04-14 12:04:37'),
(103, 'zanzibar.expSafariBlue', 'zanzibar_expsafariblue_pexels_gavinr_14093348_2238', '/storage/visual-assets/zanzibar_expsafariblue/8AG3hgJeq7a9C46NIU8EoHKmyO96l4JVWVWE3a9y.jpg', 'image', '{\"alt\":null}', '2026-04-14 11:16:29', '2026-04-14 12:03:08'),
(104, 'zanzibar.regionPaje', 'zanzibar_regionpaje_pexels_benjamin_olivier_schaeuffele_487831539_23325941_47414', '/storage/visual-assets/zanzibar_regionpaje/eHjnG6uMxOvu9Q0syihaf9jwHQpzzBKZYLoWe0jv.jpg', 'image', '{\"alt\":null}', '2026-04-14 12:00:14', '2026-04-14 12:00:14'),
(105, 'zanzibar.expSpice', 'zanzibar_expspice_aga2rk_spices_4727969_640_84574', '/storage/visual-assets/zanzibar_expspice/8488Wx5OZ33BCnhTboGvs4UzZzrQswiJQgTrpg0u.jpg', 'image', '{\"alt\":null}', '2026-04-14 12:01:39', '2026-04-14 12:01:39'),
(106, 'safari.whatToWearEditorial', 'safari_whattoweareditorial_pexels_youngafrikanna_20852883_42438', '/storage/visual-assets/safari_whattoweareditorial/UMSKZ9mp0SUAuKDH6LRqSCgkyXekW51ow71ZIAHr.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:31:14', '2026-04-14 13:31:14'),
(107, 'safari.whatToWearHero', 'safari_whattowearhero_pexels_droneafrica_13234382_81267', '/storage/visual-assets/safari_whattowearhero/U1ifYD5WG7z4KCnesAKNBOlkMSaGoVjgEQ6RLdWg.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:35:43', '2026-04-14 13:35:43'),
(108, 'safari.whatToWearFullBleed', 'safari_whattowearfullbleed_pexels_490714164_28157088_20675', '/storage/visual-assets/safari_whattowearfullbleed/SaYFkCNny5EOMopkRcLDKCXE0uiMcRXV0LOny1iS.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:37:01', '2026-04-14 13:37:53'),
(109, 'safari.packingHero', 'safari_packinghero_pexels_ketut_subiyanto_4907611_45302', '/storage/visual-assets/safari_packinghero/IJaAX3elEc2pMGJpyJz7kEArxgg5VyCN66GHWMTh.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:39:11', '2026-04-14 13:39:11'),
(110, 'safari.packingEditorial', 'safari_packingeditorial_dariuszsankowski_camera_1130731_640_81003', '/storage/visual-assets/safari_packingeditorial/UzCpQW3BE21ncFTzeMDfqxhjaLaxIGfGbMNixHbl.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:40:12', '2026-04-14 13:40:12'),
(111, 'safari.packingFullBleed', 'safari_packingfullbleed_pexels_ketut_subiyanto_4901982_42412', '/storage/visual-assets/safari_packingfullbleed/rrsBOmMrrE3XrAI2U27PkGMXN4T6sbalkUwIZSYO.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:40:36', '2026-04-14 13:40:36'),
(112, 'safari.healthHero', 'safari_healthhero_pexels_pavel_danilyuk_7653345_45861', '/storage/visual-assets/safari_healthhero/JEetcirn0bdFhobfKZkcKz1WscNw7Z7aqdyOimXn.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:42:50', '2026-04-14 13:42:50'),
(113, 'safari.healthEditorial', 'safari_healtheditorial_pexels_karola_g_5207097_44393', '/storage/visual-assets/safari_healtheditorial/AhYUdGyJZh5lK3FV796WvTFkZSxOjKpkaCQjAE4O.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:45:23', '2026-04-14 13:45:23'),
(114, 'safari.healthFullBleed', 'safari_healthfullbleed_teefarm_gazelle_3758346_1280_63882', '/storage/visual-assets/safari_healthfullbleed/DWzNVHhuWTQHUIspTMEAJT9BUsH72KpQBlifZrjG.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:46:06', '2026-04-14 13:46:06'),
(115, 'safari.etiquetteHero', 'safari_etiquettehero_pexels_jonathan_john_1035705388_29915025_59546', '/storage/visual-assets/safari_etiquettehero/2hKxByQanu7rujdF7XUUE6D3zPcG98s8gAD2dZQK.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:48:58', '2026-04-14 13:48:58'),
(116, 'safari.etiquetteEditorial', 'safari_etiquetteeditorial_pexels_followalice_667202_41059', '/storage/visual-assets/safari_etiquetteeditorial/Tk2DUVbsbKYaCzSlo6SllJsGgMkwOK2TQ2Bc1kVv.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:50:03', '2026-04-14 13:50:03'),
(117, 'safari.etiquetteFullBleed', 'safari_etiquettefullbleed_ejakob_leopard_163035_1280_99839', '/storage/visual-assets/safari_etiquettefullbleed/wS3T1vO9R4Uj4I2VM8dsQnb2z7G2KhLLMXAe4QuM.jpg', 'image', '{\"alt\":null}', '2026-04-14 13:51:26', '2026-04-14 13:51:26'),
(118, 'trekking.groupDeparturesHero', 'trekking_groupdepartureshero_pexels_seyfidurmaz_5311543_73986', '/storage/visual-assets/trekking_groupdepartureshero/4vJnFDW1RPd4KRR4AlaYjVNNqktw6UNyKolWXBaX.jpg', 'image', '{\"alt\":null}', '2026-04-14 14:55:21', '2026-04-14 14:55:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_notifications_type_index` (`type`),
  ADD KEY `admin_notifications_read_at_index` (`read_at`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_ref_unique` (`booking_ref`),
  ADD KEY `bookings_departure_id_foreign` (`departure_id`),
  ADD KEY `bookings_safari_package_id_foreign` (`safari_package_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departures`
--
ALTER TABLE `departures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departures_trekking_route_id_foreign` (`trekking_route_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gear_items`
--
ALTER TABLE `gear_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gear_rental_requests`
--
ALTER TABLE `gear_rental_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gear_rental_requests_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pricing_rules_trekking_route_id_foreign` (`trekking_route_id`);

--
-- Indexes for table `route_itinerary_days`
--
ALTER TABLE `route_itinerary_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_itinerary_days_trekking_route_id_foreign` (`trekking_route_id`);

--
-- Indexes for table `safari_packages`
--
ALTER TABLE `safari_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `safari_packages_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`),
  ADD KEY `site_settings_group_index` (`group`);

--
-- Indexes for table `trekking_routes`
--
ALTER TABLE `trekking_routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trekking_routes_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visual_assets`
--
ALTER TABLE `visual_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visual_assets_key_unique` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departures`
--
ALTER TABLE `departures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gear_items`
--
ALTER TABLE `gear_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gear_rental_requests`
--
ALTER TABLE `gear_rental_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `route_itinerary_days`
--
ALTER TABLE `route_itinerary_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `safari_packages`
--
ALTER TABLE `safari_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `trekking_routes`
--
ALTER TABLE `trekking_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visual_assets`
--
ALTER TABLE `visual_assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_departure_id_foreign` FOREIGN KEY (`departure_id`) REFERENCES `departures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_safari_package_id_foreign` FOREIGN KEY (`safari_package_id`) REFERENCES `safari_packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `departures`
--
ALTER TABLE `departures`
  ADD CONSTRAINT `departures_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gear_rental_requests`
--
ALTER TABLE `gear_rental_requests`
  ADD CONSTRAINT `gear_rental_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD CONSTRAINT `pricing_rules_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_itinerary_days`
--
ALTER TABLE `route_itinerary_days`
  ADD CONSTRAINT `route_itinerary_days_trekking_route_id_foreign` FOREIGN KEY (`trekking_route_id`) REFERENCES `trekking_routes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
