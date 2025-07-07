-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 01:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gobus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, 'awais', 'admin@admin.com', '$2a$10$Up0d3lIjqTccc95q74/nq.NzOBblwgwhFEFpEZ1mKyJkUFKoazh5i', '2024-09-19 01:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `seat_numbers` varchar(255) DEFAULT NULL,
  `recharge_code` varchar(50) DEFAULT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('confirmed','canceled') DEFAULT 'confirmed',
  `seat_price` decimal(10,2) NOT NULL DEFAULT 20.00,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `seats` varchar(255) NOT NULL,
  `total_fare` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `bus_id`, `seat_numbers`, `recharge_code`, `booking_time`, `status`, `seat_price`, `purchase_price`, `seats`, `total_fare`) VALUES
(95, 1, 876, '21,22,23,24', 'CODE1234', '2025-05-23 10:35:20', 'confirmed', 24.98, NULL, '', 99.92),
(96, 1, 876, '16', 'CODE1234', '2025-05-23 18:07:25', 'confirmed', 24.98, NULL, '', 24.98),
(98, 1, 925, '5,6,7,8', 'CODE1234', '2025-05-23 18:59:33', 'confirmed', 20.00, NULL, '', 0.00),
(99, 1, 925, '9,10,11,12', 'CODE1234', '2025-05-23 19:02:01', 'confirmed', 20.00, NULL, '', 0.00),
(100, 1, 926, '5,6,7,8', 'CODE1234', '2025-05-23 19:03:06', 'confirmed', 20.00, NULL, '', 0.00),
(101, 1, 926, '9,10', 'CODE1234', '2025-05-23 19:30:02', 'confirmed', 20.00, NULL, '', 0.00),
(102, 1, 926, '11,12', 'CODE1234', '2025-05-23 19:31:31', 'confirmed', 20.00, NULL, '', 0.00),
(103, 1, 926, '13,14', 'CODE1234', '2025-05-23 19:32:03', 'confirmed', 20.00, NULL, '', 0.00),
(104, 1, 926, '15,16,17,18', 'CODE1234', '2025-05-23 19:32:29', 'confirmed', 20.00, NULL, '', 0.00),
(105, 1, 926, '21,22', 'CODE1234', '2025-05-23 19:32:55', 'confirmed', 20.00, NULL, '', 0.00),
(106, 1, 926, '4', 'CODE1234', '2025-05-23 19:33:30', 'confirmed', 20.00, NULL, '', 0.00),
(107, 1, 926, '19', 'CODE1234', '2025-05-23 19:34:33', 'confirmed', 20.00, NULL, '', 0.00),
(108, 1, 926, '23', 'CODE1234', '2025-05-23 19:34:53', 'confirmed', 20.00, NULL, '', 0.00),
(109, 1, 926, '23', 'CODE1234', '2025-05-23 19:36:34', 'confirmed', 20.00, NULL, '', 0.00),
(110, 1, 933, '5,6,7,8', 'CODE1234', '2025-05-23 22:02:31', 'confirmed', 20.00, NULL, '', 0.00),
(111, 1, 933, '9,10,11,12', 'CODE1234', '2025-05-23 22:07:56', 'confirmed', 20.00, NULL, '', 0.00),
(112, 1, 934, '5,6,7,8', 'CODE1234', '2025-05-23 22:43:00', 'confirmed', 20.00, NULL, '', 0.00),
(113, 1, 934, '9,10,11,12', 'CODE1234', '2025-05-23 22:52:56', 'confirmed', 20.00, NULL, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `bus_number` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `available_seats` int(11) DEFAULT 30,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `route_id`, `bus_number`, `date`, `time`, `available_seats`, `status`) VALUES
(931, 9, '1', '2025-05-24', '01:30:00', 30, 'inactive'),
(932, 9, '1 - 1', '2025-05-24', '02:30:00', 30, 'inactive'),
(933, 9, '1 - 2', '2025-05-24', '03:30:00', 30, 'inactive'),
(934, 9, '1 - 3', '2025-05-24', '04:30:00', 30, 'active'),
(935, 9, '1 - 4', '2025-05-24', '05:30:00', 30, 'active'),
(936, 9, '1 - 5', '2025-05-24', '06:30:00', 30, 'active'),
(937, 9, '1 - 6', '2025-05-24', '07:30:00', 30, 'active'),
(938, 9, '1 - 7', '2025-05-24', '08:30:00', 30, 'active'),
(939, 9, '1 - 8', '2025-05-24', '09:30:00', 30, 'active'),
(940, 9, '1 - 9', '2025-05-24', '10:30:00', 30, 'active'),
(941, 9, '1 - 10', '2025-05-24', '11:30:00', 30, 'active'),
(942, 9, '1 - 11', '2025-05-24', '12:30:00', 30, 'active'),
(943, 9, '1 - 12', '2025-05-24', '13:30:00', 30, 'active'),
(944, 9, '1 - 13', '2025-05-24', '14:30:00', 30, 'active'),
(945, 9, '1 - 14', '2025-05-24', '15:30:00', 30, 'active'),
(946, 9, '1 - 15', '2025-05-24', '16:30:00', 30, 'active'),
(947, 9, '1 - 16', '2025-05-24', '17:30:00', 30, 'active'),
(948, 9, '1 - 17', '2025-05-24', '18:30:00', 30, 'active'),
(949, 9, '1 - 18', '2025-05-24', '19:30:00', 30, 'active'),
(950, 9, '1 - 19', '2025-05-24', '20:30:00', 30, 'active'),
(951, 9, '1 - 20', '2025-05-24', '21:30:00', 30, 'active'),
(952, 9, '1 - 21', '2025-05-24', '22:30:00', 30, 'active'),
(953, 9, '1 - 22', '2025-05-24', '23:30:00', 30, 'active'),
(954, 9, '1 - 23', '2025-05-25', '00:30:00', 30, 'active'),
(955, 9, '1 - 24', '2025-05-25', '01:30:00', 30, 'active'),
(956, 9, '1', '2025-05-24', '03:45:00', 30, 'inactive'),
(957, 9, '1', '2025-05-24', '03:45:00', 30, 'inactive'),
(958, 9, '20', '2025-05-24', '03:47:00', 30, 'inactive'),
(959, 9, '20', '2025-05-24', '03:47:00', 30, 'inactive'),
(960, 9, '20', '2025-05-24', '03:47:00', 30, 'inactive'),
(961, 9, '12', '2025-05-24', '03:54:00', 30, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `start_point` varchar(255) DEFAULT NULL,
  `end_point` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_name`, `start_point`, `end_point`) VALUES
(9, 'Canberra To Sydney', NULL, NULL),
(10, 'Canberra  To Melbourne ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `seat_number` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 20.00,
  `status` enum('available','reserved','default_booked') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `bus_id`, `seat_number`, `price`, `status`) VALUES
(21331, 931, 1, 30.00, 'default_booked'),
(21332, 931, 2, 30.00, 'default_booked'),
(21333, 931, 3, 30.00, 'default_booked'),
(21334, 931, 4, 30.00, 'available'),
(21335, 931, 5, 30.00, 'available'),
(21336, 931, 6, 30.00, 'available'),
(21337, 931, 7, 30.00, 'available'),
(21338, 931, 8, 30.00, 'available'),
(21339, 931, 9, 30.00, 'available'),
(21340, 931, 10, 30.00, 'available'),
(21341, 931, 11, 30.00, 'available'),
(21342, 931, 12, 30.00, 'available'),
(21343, 931, 13, 30.00, 'available'),
(21344, 931, 14, 30.00, 'available'),
(21345, 931, 15, 30.00, 'available'),
(21346, 931, 16, 30.00, 'available'),
(21347, 931, 17, 30.00, 'available'),
(21348, 931, 18, 30.00, 'available'),
(21349, 931, 19, 30.00, 'available'),
(21350, 931, 20, 30.00, 'available'),
(21351, 931, 21, 30.00, 'available'),
(21352, 931, 22, 30.00, 'available'),
(21353, 931, 23, 30.00, 'available'),
(21354, 931, 24, 30.00, 'available'),
(21355, 931, 25, 30.00, 'available'),
(21356, 931, 26, 30.00, 'available'),
(21357, 931, 27, 30.00, 'available'),
(21358, 931, 28, 30.00, 'available'),
(21359, 931, 29, 30.00, 'available'),
(21360, 931, 30, 30.00, 'available'),
(21361, 932, 1, 30.00, 'default_booked'),
(21362, 932, 2, 30.00, 'default_booked'),
(21363, 932, 3, 30.00, 'default_booked'),
(21364, 932, 4, 30.00, 'available'),
(21365, 932, 5, 30.00, 'available'),
(21366, 932, 6, 30.00, 'available'),
(21367, 932, 7, 30.00, 'available'),
(21368, 932, 8, 30.00, 'available'),
(21369, 932, 9, 30.00, 'available'),
(21370, 932, 10, 30.00, 'available'),
(21371, 932, 11, 30.00, 'available'),
(21372, 932, 12, 30.00, 'available'),
(21373, 932, 13, 30.00, 'available'),
(21374, 932, 14, 30.00, 'available'),
(21375, 932, 15, 30.00, 'available'),
(21376, 932, 16, 30.00, 'available'),
(21377, 932, 17, 30.00, 'available'),
(21378, 932, 18, 30.00, 'available'),
(21379, 932, 19, 30.00, 'available'),
(21380, 932, 20, 30.00, 'available'),
(21381, 932, 21, 30.00, 'available'),
(21382, 932, 22, 30.00, 'available'),
(21383, 932, 23, 30.00, 'available'),
(21384, 932, 24, 30.00, 'available'),
(21385, 932, 25, 30.00, 'available'),
(21386, 932, 26, 30.00, 'available'),
(21387, 932, 27, 30.00, 'available'),
(21388, 932, 28, 30.00, 'available'),
(21389, 932, 29, 30.00, 'available'),
(21390, 932, 30, 30.00, 'available'),
(21391, 933, 1, 30.00, 'default_booked'),
(21392, 933, 2, 30.00, 'default_booked'),
(21393, 933, 3, 30.00, 'default_booked'),
(21394, 933, 4, 30.00, 'available'),
(21395, 933, 5, 30.00, 'reserved'),
(21396, 933, 6, 30.00, 'reserved'),
(21397, 933, 7, 30.00, 'reserved'),
(21398, 933, 8, 30.00, 'reserved'),
(21399, 933, 9, 30.00, 'reserved'),
(21400, 933, 10, 30.00, 'reserved'),
(21401, 933, 11, 30.00, 'reserved'),
(21402, 933, 12, 30.00, 'reserved'),
(21403, 933, 13, 30.00, 'available'),
(21404, 933, 14, 30.00, 'available'),
(21405, 933, 15, 30.00, 'available'),
(21406, 933, 16, 30.00, 'available'),
(21407, 933, 17, 30.00, 'available'),
(21408, 933, 18, 30.00, 'available'),
(21409, 933, 19, 30.00, 'available'),
(21410, 933, 20, 30.00, 'available'),
(21411, 933, 21, 30.00, 'available'),
(21412, 933, 22, 30.00, 'available'),
(21413, 933, 23, 30.00, 'available'),
(21414, 933, 24, 30.00, 'available'),
(21415, 933, 25, 30.00, 'available'),
(21416, 933, 26, 30.00, 'available'),
(21417, 933, 27, 30.00, 'available'),
(21418, 933, 28, 30.00, 'available'),
(21419, 933, 29, 30.00, 'available'),
(21420, 933, 30, 30.00, 'available'),
(21421, 934, 1, 30.00, 'default_booked'),
(21422, 934, 2, 30.00, 'default_booked'),
(21423, 934, 3, 30.00, 'default_booked'),
(21424, 934, 4, 30.00, 'available'),
(21425, 934, 5, 30.00, 'reserved'),
(21426, 934, 6, 30.00, 'reserved'),
(21427, 934, 7, 30.00, 'reserved'),
(21428, 934, 8, 30.00, 'reserved'),
(21429, 934, 9, 30.00, 'reserved'),
(21430, 934, 10, 30.00, 'reserved'),
(21431, 934, 11, 30.00, 'reserved'),
(21432, 934, 12, 30.00, 'reserved'),
(21433, 934, 13, 30.00, 'available'),
(21434, 934, 14, 30.00, 'available'),
(21435, 934, 15, 30.00, 'available'),
(21436, 934, 16, 30.00, 'available'),
(21437, 934, 17, 30.00, 'available'),
(21438, 934, 18, 30.00, 'available'),
(21439, 934, 19, 30.00, 'available'),
(21440, 934, 20, 30.00, 'available'),
(21441, 934, 21, 30.00, 'available'),
(21442, 934, 22, 30.00, 'available'),
(21443, 934, 23, 30.00, 'available'),
(21444, 934, 24, 30.00, 'available'),
(21445, 934, 25, 30.00, 'available'),
(21446, 934, 26, 30.00, 'available'),
(21447, 934, 27, 30.00, 'available'),
(21448, 934, 28, 30.00, 'available'),
(21449, 934, 29, 30.00, 'available'),
(21450, 934, 30, 30.00, 'available'),
(21451, 935, 1, 30.00, 'default_booked'),
(21452, 935, 2, 30.00, 'default_booked'),
(21453, 935, 3, 30.00, 'default_booked'),
(21454, 935, 4, 30.00, 'available'),
(21455, 935, 5, 30.00, 'available'),
(21456, 935, 6, 30.00, 'available'),
(21457, 935, 7, 30.00, 'available'),
(21458, 935, 8, 30.00, 'available'),
(21459, 935, 9, 30.00, 'available'),
(21460, 935, 10, 30.00, 'available'),
(21461, 935, 11, 30.00, 'available'),
(21462, 935, 12, 30.00, 'available'),
(21463, 935, 13, 30.00, 'available'),
(21464, 935, 14, 30.00, 'available'),
(21465, 935, 15, 30.00, 'available'),
(21466, 935, 16, 30.00, 'available'),
(21467, 935, 17, 30.00, 'available'),
(21468, 935, 18, 30.00, 'available'),
(21469, 935, 19, 30.00, 'available'),
(21470, 935, 20, 30.00, 'available'),
(21471, 935, 21, 30.00, 'available'),
(21472, 935, 22, 30.00, 'available'),
(21473, 935, 23, 30.00, 'available'),
(21474, 935, 24, 30.00, 'available'),
(21475, 935, 25, 30.00, 'available'),
(21476, 935, 26, 30.00, 'available'),
(21477, 935, 27, 30.00, 'available'),
(21478, 935, 28, 30.00, 'available'),
(21479, 935, 29, 30.00, 'available'),
(21480, 935, 30, 30.00, 'available'),
(21481, 936, 1, 30.00, 'default_booked'),
(21482, 936, 2, 30.00, 'default_booked'),
(21483, 936, 3, 30.00, 'default_booked'),
(21484, 936, 4, 30.00, 'available'),
(21485, 936, 5, 30.00, 'available'),
(21486, 936, 6, 30.00, 'available'),
(21487, 936, 7, 30.00, 'available'),
(21488, 936, 8, 30.00, 'available'),
(21489, 936, 9, 30.00, 'available'),
(21490, 936, 10, 30.00, 'available'),
(21491, 936, 11, 30.00, 'available'),
(21492, 936, 12, 30.00, 'available'),
(21493, 936, 13, 30.00, 'available'),
(21494, 936, 14, 30.00, 'available'),
(21495, 936, 15, 30.00, 'available'),
(21496, 936, 16, 30.00, 'available'),
(21497, 936, 17, 30.00, 'available'),
(21498, 936, 18, 30.00, 'available'),
(21499, 936, 19, 30.00, 'available'),
(21500, 936, 20, 30.00, 'available'),
(21501, 936, 21, 30.00, 'available'),
(21502, 936, 22, 30.00, 'available'),
(21503, 936, 23, 30.00, 'available'),
(21504, 936, 24, 30.00, 'available'),
(21505, 936, 25, 30.00, 'available'),
(21506, 936, 26, 30.00, 'available'),
(21507, 936, 27, 30.00, 'available'),
(21508, 936, 28, 30.00, 'available'),
(21509, 936, 29, 30.00, 'available'),
(21510, 936, 30, 30.00, 'available'),
(21511, 937, 1, 30.00, 'default_booked'),
(21512, 937, 2, 30.00, 'default_booked'),
(21513, 937, 3, 30.00, 'default_booked'),
(21514, 937, 4, 30.00, 'available'),
(21515, 937, 5, 30.00, 'available'),
(21516, 937, 6, 30.00, 'available'),
(21517, 937, 7, 30.00, 'available'),
(21518, 937, 8, 30.00, 'available'),
(21519, 937, 9, 30.00, 'available'),
(21520, 937, 10, 30.00, 'available'),
(21521, 937, 11, 30.00, 'available'),
(21522, 937, 12, 30.00, 'available'),
(21523, 937, 13, 30.00, 'available'),
(21524, 937, 14, 30.00, 'available'),
(21525, 937, 15, 30.00, 'available'),
(21526, 937, 16, 30.00, 'available'),
(21527, 937, 17, 30.00, 'available'),
(21528, 937, 18, 30.00, 'available'),
(21529, 937, 19, 30.00, 'available'),
(21530, 937, 20, 30.00, 'available'),
(21531, 937, 21, 30.00, 'available'),
(21532, 937, 22, 30.00, 'available'),
(21533, 937, 23, 30.00, 'available'),
(21534, 937, 24, 30.00, 'available'),
(21535, 937, 25, 30.00, 'available'),
(21536, 937, 26, 30.00, 'available'),
(21537, 937, 27, 30.00, 'available'),
(21538, 937, 28, 30.00, 'available'),
(21539, 937, 29, 30.00, 'available'),
(21540, 937, 30, 30.00, 'available'),
(21541, 938, 1, 30.00, 'default_booked'),
(21542, 938, 2, 30.00, 'default_booked'),
(21543, 938, 3, 30.00, 'default_booked'),
(21544, 938, 4, 30.00, 'available'),
(21545, 938, 5, 30.00, 'available'),
(21546, 938, 6, 30.00, 'available'),
(21547, 938, 7, 30.00, 'available'),
(21548, 938, 8, 30.00, 'available'),
(21549, 938, 9, 30.00, 'available'),
(21550, 938, 10, 30.00, 'available'),
(21551, 938, 11, 30.00, 'available'),
(21552, 938, 12, 30.00, 'available'),
(21553, 938, 13, 30.00, 'available'),
(21554, 938, 14, 30.00, 'available'),
(21555, 938, 15, 30.00, 'available'),
(21556, 938, 16, 30.00, 'available'),
(21557, 938, 17, 30.00, 'available'),
(21558, 938, 18, 30.00, 'available'),
(21559, 938, 19, 30.00, 'available'),
(21560, 938, 20, 30.00, 'available'),
(21561, 938, 21, 30.00, 'available'),
(21562, 938, 22, 30.00, 'available'),
(21563, 938, 23, 30.00, 'available'),
(21564, 938, 24, 30.00, 'available'),
(21565, 938, 25, 30.00, 'available'),
(21566, 938, 26, 30.00, 'available'),
(21567, 938, 27, 30.00, 'available'),
(21568, 938, 28, 30.00, 'available'),
(21569, 938, 29, 30.00, 'available'),
(21570, 938, 30, 30.00, 'available'),
(21571, 939, 1, 30.00, 'default_booked'),
(21572, 939, 2, 30.00, 'default_booked'),
(21573, 939, 3, 30.00, 'default_booked'),
(21574, 939, 4, 30.00, 'available'),
(21575, 939, 5, 30.00, 'available'),
(21576, 939, 6, 30.00, 'available'),
(21577, 939, 7, 30.00, 'available'),
(21578, 939, 8, 30.00, 'available'),
(21579, 939, 9, 30.00, 'available'),
(21580, 939, 10, 30.00, 'available'),
(21581, 939, 11, 30.00, 'available'),
(21582, 939, 12, 30.00, 'available'),
(21583, 939, 13, 30.00, 'available'),
(21584, 939, 14, 30.00, 'available'),
(21585, 939, 15, 30.00, 'available'),
(21586, 939, 16, 30.00, 'available'),
(21587, 939, 17, 30.00, 'available'),
(21588, 939, 18, 30.00, 'available'),
(21589, 939, 19, 30.00, 'available'),
(21590, 939, 20, 30.00, 'available'),
(21591, 939, 21, 30.00, 'available'),
(21592, 939, 22, 30.00, 'available'),
(21593, 939, 23, 30.00, 'available'),
(21594, 939, 24, 30.00, 'available'),
(21595, 939, 25, 30.00, 'available'),
(21596, 939, 26, 30.00, 'available'),
(21597, 939, 27, 30.00, 'available'),
(21598, 939, 28, 30.00, 'available'),
(21599, 939, 29, 30.00, 'available'),
(21600, 939, 30, 30.00, 'available'),
(21601, 940, 1, 30.00, 'default_booked'),
(21602, 940, 2, 30.00, 'default_booked'),
(21603, 940, 3, 30.00, 'default_booked'),
(21604, 940, 4, 30.00, 'available'),
(21605, 940, 5, 30.00, 'available'),
(21606, 940, 6, 30.00, 'available'),
(21607, 940, 7, 30.00, 'available'),
(21608, 940, 8, 30.00, 'available'),
(21609, 940, 9, 30.00, 'available'),
(21610, 940, 10, 30.00, 'available'),
(21611, 940, 11, 30.00, 'available'),
(21612, 940, 12, 30.00, 'available'),
(21613, 940, 13, 30.00, 'available'),
(21614, 940, 14, 30.00, 'available'),
(21615, 940, 15, 30.00, 'available'),
(21616, 940, 16, 30.00, 'available'),
(21617, 940, 17, 30.00, 'available'),
(21618, 940, 18, 30.00, 'available'),
(21619, 940, 19, 30.00, 'available'),
(21620, 940, 20, 30.00, 'available'),
(21621, 940, 21, 30.00, 'available'),
(21622, 940, 22, 30.00, 'available'),
(21623, 940, 23, 30.00, 'available'),
(21624, 940, 24, 30.00, 'available'),
(21625, 940, 25, 30.00, 'available'),
(21626, 940, 26, 30.00, 'available'),
(21627, 940, 27, 30.00, 'available'),
(21628, 940, 28, 30.00, 'available'),
(21629, 940, 29, 30.00, 'available'),
(21630, 940, 30, 30.00, 'available'),
(21631, 941, 1, 30.00, 'default_booked'),
(21632, 941, 2, 30.00, 'default_booked'),
(21633, 941, 3, 30.00, 'default_booked'),
(21634, 941, 4, 30.00, 'available'),
(21635, 941, 5, 30.00, 'available'),
(21636, 941, 6, 30.00, 'available'),
(21637, 941, 7, 30.00, 'available'),
(21638, 941, 8, 30.00, 'available'),
(21639, 941, 9, 30.00, 'available'),
(21640, 941, 10, 30.00, 'available'),
(21641, 941, 11, 30.00, 'available'),
(21642, 941, 12, 30.00, 'available'),
(21643, 941, 13, 30.00, 'available'),
(21644, 941, 14, 30.00, 'available'),
(21645, 941, 15, 30.00, 'available'),
(21646, 941, 16, 30.00, 'available'),
(21647, 941, 17, 30.00, 'available'),
(21648, 941, 18, 30.00, 'available'),
(21649, 941, 19, 30.00, 'available'),
(21650, 941, 20, 30.00, 'available'),
(21651, 941, 21, 30.00, 'available'),
(21652, 941, 22, 30.00, 'available'),
(21653, 941, 23, 30.00, 'available'),
(21654, 941, 24, 30.00, 'available'),
(21655, 941, 25, 30.00, 'available'),
(21656, 941, 26, 30.00, 'available'),
(21657, 941, 27, 30.00, 'available'),
(21658, 941, 28, 30.00, 'available'),
(21659, 941, 29, 30.00, 'available'),
(21660, 941, 30, 30.00, 'available'),
(21661, 942, 1, 30.00, 'default_booked'),
(21662, 942, 2, 30.00, 'default_booked'),
(21663, 942, 3, 30.00, 'default_booked'),
(21664, 942, 4, 30.00, 'available'),
(21665, 942, 5, 30.00, 'available'),
(21666, 942, 6, 30.00, 'available'),
(21667, 942, 7, 30.00, 'available'),
(21668, 942, 8, 30.00, 'available'),
(21669, 942, 9, 30.00, 'available'),
(21670, 942, 10, 30.00, 'available'),
(21671, 942, 11, 30.00, 'available'),
(21672, 942, 12, 30.00, 'available'),
(21673, 942, 13, 30.00, 'available'),
(21674, 942, 14, 30.00, 'available'),
(21675, 942, 15, 30.00, 'available'),
(21676, 942, 16, 30.00, 'available'),
(21677, 942, 17, 30.00, 'available'),
(21678, 942, 18, 30.00, 'available'),
(21679, 942, 19, 30.00, 'available'),
(21680, 942, 20, 30.00, 'available'),
(21681, 942, 21, 30.00, 'available'),
(21682, 942, 22, 30.00, 'available'),
(21683, 942, 23, 30.00, 'available'),
(21684, 942, 24, 30.00, 'available'),
(21685, 942, 25, 30.00, 'available'),
(21686, 942, 26, 30.00, 'available'),
(21687, 942, 27, 30.00, 'available'),
(21688, 942, 28, 30.00, 'available'),
(21689, 942, 29, 30.00, 'available'),
(21690, 942, 30, 30.00, 'available'),
(21691, 943, 1, 30.00, 'default_booked'),
(21692, 943, 2, 30.00, 'default_booked'),
(21693, 943, 3, 30.00, 'default_booked'),
(21694, 943, 4, 30.00, 'available'),
(21695, 943, 5, 30.00, 'available'),
(21696, 943, 6, 30.00, 'available'),
(21697, 943, 7, 30.00, 'available'),
(21698, 943, 8, 30.00, 'available'),
(21699, 943, 9, 30.00, 'available'),
(21700, 943, 10, 30.00, 'available'),
(21701, 943, 11, 30.00, 'available'),
(21702, 943, 12, 30.00, 'available'),
(21703, 943, 13, 30.00, 'available'),
(21704, 943, 14, 30.00, 'available'),
(21705, 943, 15, 30.00, 'available'),
(21706, 943, 16, 30.00, 'available'),
(21707, 943, 17, 30.00, 'available'),
(21708, 943, 18, 30.00, 'available'),
(21709, 943, 19, 30.00, 'available'),
(21710, 943, 20, 30.00, 'available'),
(21711, 943, 21, 30.00, 'available'),
(21712, 943, 22, 30.00, 'available'),
(21713, 943, 23, 30.00, 'available'),
(21714, 943, 24, 30.00, 'available'),
(21715, 943, 25, 30.00, 'available'),
(21716, 943, 26, 30.00, 'available'),
(21717, 943, 27, 30.00, 'available'),
(21718, 943, 28, 30.00, 'available'),
(21719, 943, 29, 30.00, 'available'),
(21720, 943, 30, 30.00, 'available'),
(21721, 944, 1, 30.00, 'default_booked'),
(21722, 944, 2, 30.00, 'default_booked'),
(21723, 944, 3, 30.00, 'default_booked'),
(21724, 944, 4, 30.00, 'available'),
(21725, 944, 5, 30.00, 'available'),
(21726, 944, 6, 30.00, 'available'),
(21727, 944, 7, 30.00, 'available'),
(21728, 944, 8, 30.00, 'available'),
(21729, 944, 9, 30.00, 'available'),
(21730, 944, 10, 30.00, 'available'),
(21731, 944, 11, 30.00, 'available'),
(21732, 944, 12, 30.00, 'available'),
(21733, 944, 13, 30.00, 'available'),
(21734, 944, 14, 30.00, 'available'),
(21735, 944, 15, 30.00, 'available'),
(21736, 944, 16, 30.00, 'available'),
(21737, 944, 17, 30.00, 'available'),
(21738, 944, 18, 30.00, 'available'),
(21739, 944, 19, 30.00, 'available'),
(21740, 944, 20, 30.00, 'available'),
(21741, 944, 21, 30.00, 'available'),
(21742, 944, 22, 30.00, 'available'),
(21743, 944, 23, 30.00, 'available'),
(21744, 944, 24, 30.00, 'available'),
(21745, 944, 25, 30.00, 'available'),
(21746, 944, 26, 30.00, 'available'),
(21747, 944, 27, 30.00, 'available'),
(21748, 944, 28, 30.00, 'available'),
(21749, 944, 29, 30.00, 'available'),
(21750, 944, 30, 30.00, 'available'),
(21751, 945, 1, 30.00, 'default_booked'),
(21752, 945, 2, 30.00, 'default_booked'),
(21753, 945, 3, 30.00, 'default_booked'),
(21754, 945, 4, 30.00, 'available'),
(21755, 945, 5, 30.00, 'available'),
(21756, 945, 6, 30.00, 'available'),
(21757, 945, 7, 30.00, 'available'),
(21758, 945, 8, 30.00, 'available'),
(21759, 945, 9, 30.00, 'available'),
(21760, 945, 10, 30.00, 'available'),
(21761, 945, 11, 30.00, 'available'),
(21762, 945, 12, 30.00, 'available'),
(21763, 945, 13, 30.00, 'available'),
(21764, 945, 14, 30.00, 'available'),
(21765, 945, 15, 30.00, 'available'),
(21766, 945, 16, 30.00, 'available'),
(21767, 945, 17, 30.00, 'available'),
(21768, 945, 18, 30.00, 'available'),
(21769, 945, 19, 30.00, 'available'),
(21770, 945, 20, 30.00, 'available'),
(21771, 945, 21, 30.00, 'available'),
(21772, 945, 22, 30.00, 'available'),
(21773, 945, 23, 30.00, 'available'),
(21774, 945, 24, 30.00, 'available'),
(21775, 945, 25, 30.00, 'available'),
(21776, 945, 26, 30.00, 'available'),
(21777, 945, 27, 30.00, 'available'),
(21778, 945, 28, 30.00, 'available'),
(21779, 945, 29, 30.00, 'available'),
(21780, 945, 30, 30.00, 'available'),
(21781, 946, 1, 30.00, 'default_booked'),
(21782, 946, 2, 30.00, 'default_booked'),
(21783, 946, 3, 30.00, 'default_booked'),
(21784, 946, 4, 30.00, 'available'),
(21785, 946, 5, 30.00, 'available'),
(21786, 946, 6, 30.00, 'available'),
(21787, 946, 7, 30.00, 'available'),
(21788, 946, 8, 30.00, 'available'),
(21789, 946, 9, 30.00, 'available'),
(21790, 946, 10, 30.00, 'available'),
(21791, 946, 11, 30.00, 'available'),
(21792, 946, 12, 30.00, 'available'),
(21793, 946, 13, 30.00, 'available'),
(21794, 946, 14, 30.00, 'available'),
(21795, 946, 15, 30.00, 'available'),
(21796, 946, 16, 30.00, 'available'),
(21797, 946, 17, 30.00, 'available'),
(21798, 946, 18, 30.00, 'available'),
(21799, 946, 19, 30.00, 'available'),
(21800, 946, 20, 30.00, 'available'),
(21801, 946, 21, 30.00, 'available'),
(21802, 946, 22, 30.00, 'available'),
(21803, 946, 23, 30.00, 'available'),
(21804, 946, 24, 30.00, 'available'),
(21805, 946, 25, 30.00, 'available'),
(21806, 946, 26, 30.00, 'available'),
(21807, 946, 27, 30.00, 'available'),
(21808, 946, 28, 30.00, 'available'),
(21809, 946, 29, 30.00, 'available'),
(21810, 946, 30, 30.00, 'available'),
(21811, 947, 1, 30.00, 'default_booked'),
(21812, 947, 2, 30.00, 'default_booked'),
(21813, 947, 3, 30.00, 'default_booked'),
(21814, 947, 4, 30.00, 'available'),
(21815, 947, 5, 30.00, 'available'),
(21816, 947, 6, 30.00, 'available'),
(21817, 947, 7, 30.00, 'available'),
(21818, 947, 8, 30.00, 'available'),
(21819, 947, 9, 30.00, 'available'),
(21820, 947, 10, 30.00, 'available'),
(21821, 947, 11, 30.00, 'available'),
(21822, 947, 12, 30.00, 'available'),
(21823, 947, 13, 30.00, 'available'),
(21824, 947, 14, 30.00, 'available'),
(21825, 947, 15, 30.00, 'available'),
(21826, 947, 16, 30.00, 'available'),
(21827, 947, 17, 30.00, 'available'),
(21828, 947, 18, 30.00, 'available'),
(21829, 947, 19, 30.00, 'available'),
(21830, 947, 20, 30.00, 'available'),
(21831, 947, 21, 30.00, 'available'),
(21832, 947, 22, 30.00, 'available'),
(21833, 947, 23, 30.00, 'available'),
(21834, 947, 24, 30.00, 'available'),
(21835, 947, 25, 30.00, 'available'),
(21836, 947, 26, 30.00, 'available'),
(21837, 947, 27, 30.00, 'available'),
(21838, 947, 28, 30.00, 'available'),
(21839, 947, 29, 30.00, 'available'),
(21840, 947, 30, 30.00, 'available'),
(21841, 948, 1, 30.00, 'default_booked'),
(21842, 948, 2, 30.00, 'default_booked'),
(21843, 948, 3, 30.00, 'default_booked'),
(21844, 948, 4, 30.00, 'available'),
(21845, 948, 5, 30.00, 'available'),
(21846, 948, 6, 30.00, 'available'),
(21847, 948, 7, 30.00, 'available'),
(21848, 948, 8, 30.00, 'available'),
(21849, 948, 9, 30.00, 'available'),
(21850, 948, 10, 30.00, 'available'),
(21851, 948, 11, 30.00, 'available'),
(21852, 948, 12, 30.00, 'available'),
(21853, 948, 13, 30.00, 'available'),
(21854, 948, 14, 30.00, 'available'),
(21855, 948, 15, 30.00, 'available'),
(21856, 948, 16, 30.00, 'available'),
(21857, 948, 17, 30.00, 'available'),
(21858, 948, 18, 30.00, 'available'),
(21859, 948, 19, 30.00, 'available'),
(21860, 948, 20, 30.00, 'available'),
(21861, 948, 21, 30.00, 'available'),
(21862, 948, 22, 30.00, 'available'),
(21863, 948, 23, 30.00, 'available'),
(21864, 948, 24, 30.00, 'available'),
(21865, 948, 25, 30.00, 'available'),
(21866, 948, 26, 30.00, 'available'),
(21867, 948, 27, 30.00, 'available'),
(21868, 948, 28, 30.00, 'available'),
(21869, 948, 29, 30.00, 'available'),
(21870, 948, 30, 30.00, 'available'),
(21871, 949, 1, 30.00, 'default_booked'),
(21872, 949, 2, 30.00, 'default_booked'),
(21873, 949, 3, 30.00, 'default_booked'),
(21874, 949, 4, 30.00, 'available'),
(21875, 949, 5, 30.00, 'available'),
(21876, 949, 6, 30.00, 'available'),
(21877, 949, 7, 30.00, 'available'),
(21878, 949, 8, 30.00, 'available'),
(21879, 949, 9, 30.00, 'available'),
(21880, 949, 10, 30.00, 'available'),
(21881, 949, 11, 30.00, 'available'),
(21882, 949, 12, 30.00, 'available'),
(21883, 949, 13, 30.00, 'available'),
(21884, 949, 14, 30.00, 'available'),
(21885, 949, 15, 30.00, 'available'),
(21886, 949, 16, 30.00, 'available'),
(21887, 949, 17, 30.00, 'available'),
(21888, 949, 18, 30.00, 'available'),
(21889, 949, 19, 30.00, 'available'),
(21890, 949, 20, 30.00, 'available'),
(21891, 949, 21, 30.00, 'available'),
(21892, 949, 22, 30.00, 'available'),
(21893, 949, 23, 30.00, 'available'),
(21894, 949, 24, 30.00, 'available'),
(21895, 949, 25, 30.00, 'available'),
(21896, 949, 26, 30.00, 'available'),
(21897, 949, 27, 30.00, 'available'),
(21898, 949, 28, 30.00, 'available'),
(21899, 949, 29, 30.00, 'available'),
(21900, 949, 30, 30.00, 'available'),
(21901, 950, 1, 30.00, 'default_booked'),
(21902, 950, 2, 30.00, 'default_booked'),
(21903, 950, 3, 30.00, 'default_booked'),
(21904, 950, 4, 30.00, 'available'),
(21905, 950, 5, 30.00, 'available'),
(21906, 950, 6, 30.00, 'available'),
(21907, 950, 7, 30.00, 'available'),
(21908, 950, 8, 30.00, 'available'),
(21909, 950, 9, 30.00, 'available'),
(21910, 950, 10, 30.00, 'available'),
(21911, 950, 11, 30.00, 'available'),
(21912, 950, 12, 30.00, 'available'),
(21913, 950, 13, 30.00, 'available'),
(21914, 950, 14, 30.00, 'available'),
(21915, 950, 15, 30.00, 'available'),
(21916, 950, 16, 30.00, 'available'),
(21917, 950, 17, 30.00, 'available'),
(21918, 950, 18, 30.00, 'available'),
(21919, 950, 19, 30.00, 'available'),
(21920, 950, 20, 30.00, 'available'),
(21921, 950, 21, 30.00, 'available'),
(21922, 950, 22, 30.00, 'available'),
(21923, 950, 23, 30.00, 'available'),
(21924, 950, 24, 30.00, 'available'),
(21925, 950, 25, 30.00, 'available'),
(21926, 950, 26, 30.00, 'available'),
(21927, 950, 27, 30.00, 'available'),
(21928, 950, 28, 30.00, 'available'),
(21929, 950, 29, 30.00, 'available'),
(21930, 950, 30, 30.00, 'available'),
(21931, 951, 1, 30.00, 'default_booked'),
(21932, 951, 2, 30.00, 'default_booked'),
(21933, 951, 3, 30.00, 'default_booked'),
(21934, 951, 4, 30.00, 'available'),
(21935, 951, 5, 30.00, 'available'),
(21936, 951, 6, 30.00, 'available'),
(21937, 951, 7, 30.00, 'available'),
(21938, 951, 8, 30.00, 'available'),
(21939, 951, 9, 30.00, 'available'),
(21940, 951, 10, 30.00, 'available'),
(21941, 951, 11, 30.00, 'available'),
(21942, 951, 12, 30.00, 'available'),
(21943, 951, 13, 30.00, 'available'),
(21944, 951, 14, 30.00, 'available'),
(21945, 951, 15, 30.00, 'available'),
(21946, 951, 16, 30.00, 'available'),
(21947, 951, 17, 30.00, 'available'),
(21948, 951, 18, 30.00, 'available'),
(21949, 951, 19, 30.00, 'available'),
(21950, 951, 20, 30.00, 'available'),
(21951, 951, 21, 30.00, 'available'),
(21952, 951, 22, 30.00, 'available'),
(21953, 951, 23, 30.00, 'available'),
(21954, 951, 24, 30.00, 'available'),
(21955, 951, 25, 30.00, 'available'),
(21956, 951, 26, 30.00, 'available'),
(21957, 951, 27, 30.00, 'available'),
(21958, 951, 28, 30.00, 'available'),
(21959, 951, 29, 30.00, 'available'),
(21960, 951, 30, 30.00, 'available'),
(21961, 952, 1, 30.00, 'default_booked'),
(21962, 952, 2, 30.00, 'default_booked'),
(21963, 952, 3, 30.00, 'default_booked'),
(21964, 952, 4, 30.00, 'available'),
(21965, 952, 5, 30.00, 'available'),
(21966, 952, 6, 30.00, 'available'),
(21967, 952, 7, 30.00, 'available'),
(21968, 952, 8, 30.00, 'available'),
(21969, 952, 9, 30.00, 'available'),
(21970, 952, 10, 30.00, 'available'),
(21971, 952, 11, 30.00, 'available'),
(21972, 952, 12, 30.00, 'available'),
(21973, 952, 13, 30.00, 'available'),
(21974, 952, 14, 30.00, 'available'),
(21975, 952, 15, 30.00, 'available'),
(21976, 952, 16, 30.00, 'available'),
(21977, 952, 17, 30.00, 'available'),
(21978, 952, 18, 30.00, 'available'),
(21979, 952, 19, 30.00, 'available'),
(21980, 952, 20, 30.00, 'available'),
(21981, 952, 21, 30.00, 'available'),
(21982, 952, 22, 30.00, 'available'),
(21983, 952, 23, 30.00, 'available'),
(21984, 952, 24, 30.00, 'available'),
(21985, 952, 25, 30.00, 'available'),
(21986, 952, 26, 30.00, 'available'),
(21987, 952, 27, 30.00, 'available'),
(21988, 952, 28, 30.00, 'available'),
(21989, 952, 29, 30.00, 'available'),
(21990, 952, 30, 30.00, 'available'),
(21991, 953, 1, 30.00, 'default_booked'),
(21992, 953, 2, 30.00, 'default_booked'),
(21993, 953, 3, 30.00, 'default_booked'),
(21994, 953, 4, 30.00, 'available'),
(21995, 953, 5, 30.00, 'available'),
(21996, 953, 6, 30.00, 'available'),
(21997, 953, 7, 30.00, 'available'),
(21998, 953, 8, 30.00, 'available'),
(21999, 953, 9, 30.00, 'available'),
(22000, 953, 10, 30.00, 'available'),
(22001, 953, 11, 30.00, 'available'),
(22002, 953, 12, 30.00, 'available'),
(22003, 953, 13, 30.00, 'available'),
(22004, 953, 14, 30.00, 'available'),
(22005, 953, 15, 30.00, 'available'),
(22006, 953, 16, 30.00, 'available'),
(22007, 953, 17, 30.00, 'available'),
(22008, 953, 18, 30.00, 'available'),
(22009, 953, 19, 30.00, 'available'),
(22010, 953, 20, 30.00, 'available'),
(22011, 953, 21, 30.00, 'available'),
(22012, 953, 22, 30.00, 'available'),
(22013, 953, 23, 30.00, 'available'),
(22014, 953, 24, 30.00, 'available'),
(22015, 953, 25, 30.00, 'available'),
(22016, 953, 26, 30.00, 'available'),
(22017, 953, 27, 30.00, 'available'),
(22018, 953, 28, 30.00, 'available'),
(22019, 953, 29, 30.00, 'available'),
(22020, 953, 30, 30.00, 'available'),
(22021, 954, 1, 30.00, 'default_booked'),
(22022, 954, 2, 30.00, 'default_booked'),
(22023, 954, 3, 30.00, 'default_booked'),
(22024, 954, 4, 30.00, 'available'),
(22025, 954, 5, 30.00, 'available'),
(22026, 954, 6, 30.00, 'available'),
(22027, 954, 7, 30.00, 'available'),
(22028, 954, 8, 30.00, 'available'),
(22029, 954, 9, 30.00, 'available'),
(22030, 954, 10, 30.00, 'available'),
(22031, 954, 11, 30.00, 'available'),
(22032, 954, 12, 30.00, 'available'),
(22033, 954, 13, 30.00, 'available'),
(22034, 954, 14, 30.00, 'available'),
(22035, 954, 15, 30.00, 'available'),
(22036, 954, 16, 30.00, 'available'),
(22037, 954, 17, 30.00, 'available'),
(22038, 954, 18, 30.00, 'available'),
(22039, 954, 19, 30.00, 'available'),
(22040, 954, 20, 30.00, 'available'),
(22041, 954, 21, 30.00, 'available'),
(22042, 954, 22, 30.00, 'available'),
(22043, 954, 23, 30.00, 'available'),
(22044, 954, 24, 30.00, 'available'),
(22045, 954, 25, 30.00, 'available'),
(22046, 954, 26, 30.00, 'available'),
(22047, 954, 27, 30.00, 'available'),
(22048, 954, 28, 30.00, 'available'),
(22049, 954, 29, 30.00, 'available'),
(22050, 954, 30, 30.00, 'available'),
(22051, 955, 1, 30.00, 'default_booked'),
(22052, 955, 2, 30.00, 'default_booked'),
(22053, 955, 3, 30.00, 'default_booked'),
(22054, 955, 4, 30.00, 'available'),
(22055, 955, 5, 30.00, 'available'),
(22056, 955, 6, 30.00, 'available'),
(22057, 955, 7, 30.00, 'available'),
(22058, 955, 8, 30.00, 'available'),
(22059, 955, 9, 30.00, 'available'),
(22060, 955, 10, 30.00, 'available'),
(22061, 955, 11, 30.00, 'available'),
(22062, 955, 12, 30.00, 'available'),
(22063, 955, 13, 30.00, 'available'),
(22064, 955, 14, 30.00, 'available'),
(22065, 955, 15, 30.00, 'available'),
(22066, 955, 16, 30.00, 'available'),
(22067, 955, 17, 30.00, 'available'),
(22068, 955, 18, 30.00, 'available'),
(22069, 955, 19, 30.00, 'available'),
(22070, 955, 20, 30.00, 'available'),
(22071, 955, 21, 30.00, 'available'),
(22072, 955, 22, 30.00, 'available'),
(22073, 955, 23, 30.00, 'available'),
(22074, 955, 24, 30.00, 'available'),
(22075, 955, 25, 30.00, 'available'),
(22076, 955, 26, 30.00, 'available'),
(22077, 955, 27, 30.00, 'available'),
(22078, 955, 28, 30.00, 'available'),
(22079, 955, 29, 30.00, 'available'),
(22080, 955, 30, 30.00, 'available'),
(22081, 956, 1, 200.00, 'default_booked'),
(22082, 956, 2, 200.00, 'default_booked'),
(22083, 956, 3, 200.00, 'default_booked'),
(22084, 956, 4, 200.00, 'available'),
(22085, 956, 5, 200.00, 'available'),
(22086, 956, 6, 200.00, 'available'),
(22087, 956, 7, 200.00, 'available'),
(22088, 956, 8, 200.00, 'available'),
(22089, 956, 9, 200.00, 'available'),
(22090, 956, 10, 200.00, 'available'),
(22091, 956, 11, 200.00, 'available'),
(22092, 956, 12, 200.00, 'available'),
(22093, 956, 13, 200.00, 'available'),
(22094, 956, 14, 200.00, 'available'),
(22095, 956, 15, 200.00, 'available'),
(22096, 956, 16, 200.00, 'available'),
(22097, 956, 17, 200.00, 'available'),
(22098, 956, 18, 200.00, 'available'),
(22099, 956, 19, 200.00, 'available'),
(22100, 956, 20, 200.00, 'available'),
(22101, 956, 21, 200.00, 'available'),
(22102, 956, 22, 200.00, 'available'),
(22103, 956, 23, 200.00, 'available'),
(22104, 956, 24, 200.00, 'available'),
(22105, 956, 25, 200.00, 'available'),
(22106, 956, 26, 200.00, 'available'),
(22107, 956, 27, 200.00, 'available'),
(22108, 956, 28, 200.00, 'available'),
(22109, 956, 29, 200.00, 'available'),
(22110, 956, 30, 200.00, 'available'),
(22111, 957, 1, 200.00, 'default_booked'),
(22112, 957, 2, 200.00, 'default_booked'),
(22113, 957, 3, 200.00, 'default_booked'),
(22114, 957, 4, 200.00, 'available'),
(22115, 957, 5, 200.00, 'available'),
(22116, 957, 6, 200.00, 'available'),
(22117, 957, 7, 200.00, 'available'),
(22118, 957, 8, 200.00, 'available'),
(22119, 957, 9, 200.00, 'available'),
(22120, 957, 10, 200.00, 'available'),
(22121, 957, 11, 200.00, 'available'),
(22122, 957, 12, 200.00, 'available'),
(22123, 957, 13, 200.00, 'available'),
(22124, 957, 14, 200.00, 'available'),
(22125, 957, 15, 200.00, 'available'),
(22126, 957, 16, 200.00, 'available'),
(22127, 957, 17, 200.00, 'available'),
(22128, 957, 18, 200.00, 'available'),
(22129, 957, 19, 200.00, 'available'),
(22130, 957, 20, 200.00, 'available'),
(22131, 957, 21, 200.00, 'available'),
(22132, 957, 22, 200.00, 'available'),
(22133, 957, 23, 200.00, 'available'),
(22134, 957, 24, 200.00, 'available'),
(22135, 957, 25, 200.00, 'available'),
(22136, 957, 26, 200.00, 'available'),
(22137, 957, 27, 200.00, 'available'),
(22138, 957, 28, 200.00, 'available'),
(22139, 957, 29, 200.00, 'available'),
(22140, 957, 30, 200.00, 'available'),
(22141, 958, 1, 20.00, 'default_booked'),
(22142, 958, 2, 20.00, 'default_booked'),
(22143, 958, 3, 20.00, 'default_booked'),
(22144, 958, 4, 20.00, 'available'),
(22145, 958, 5, 20.00, 'available'),
(22146, 958, 6, 20.00, 'available'),
(22147, 958, 7, 20.00, 'available'),
(22148, 958, 8, 20.00, 'available'),
(22149, 958, 9, 20.00, 'available'),
(22150, 958, 10, 20.00, 'available'),
(22151, 958, 11, 20.00, 'available'),
(22152, 958, 12, 20.00, 'available'),
(22153, 958, 13, 20.00, 'available'),
(22154, 958, 14, 20.00, 'available'),
(22155, 958, 15, 20.00, 'available'),
(22156, 958, 16, 20.00, 'available'),
(22157, 958, 17, 20.00, 'available'),
(22158, 958, 18, 20.00, 'available'),
(22159, 958, 19, 20.00, 'available'),
(22160, 958, 20, 20.00, 'available'),
(22161, 958, 21, 20.00, 'available'),
(22162, 958, 22, 20.00, 'available'),
(22163, 958, 23, 20.00, 'available'),
(22164, 958, 24, 20.00, 'available'),
(22165, 958, 25, 20.00, 'available'),
(22166, 958, 26, 20.00, 'available'),
(22167, 958, 27, 20.00, 'available'),
(22168, 958, 28, 20.00, 'available'),
(22169, 958, 29, 20.00, 'available'),
(22170, 958, 30, 20.00, 'available'),
(22171, 959, 1, 20.00, 'default_booked'),
(22172, 959, 2, 20.00, 'default_booked'),
(22173, 959, 3, 20.00, 'default_booked'),
(22174, 959, 4, 20.00, 'available'),
(22175, 959, 5, 20.00, 'available'),
(22176, 959, 6, 20.00, 'available'),
(22177, 959, 7, 20.00, 'available'),
(22178, 959, 8, 20.00, 'available'),
(22179, 959, 9, 20.00, 'available'),
(22180, 959, 10, 20.00, 'available'),
(22181, 959, 11, 20.00, 'available'),
(22182, 959, 12, 20.00, 'available'),
(22183, 959, 13, 20.00, 'available'),
(22184, 959, 14, 20.00, 'available'),
(22185, 959, 15, 20.00, 'available'),
(22186, 959, 16, 20.00, 'available'),
(22187, 959, 17, 20.00, 'available'),
(22188, 959, 18, 20.00, 'available'),
(22189, 959, 19, 20.00, 'available'),
(22190, 959, 20, 20.00, 'available'),
(22191, 959, 21, 20.00, 'available'),
(22192, 959, 22, 20.00, 'available'),
(22193, 959, 23, 20.00, 'available'),
(22194, 959, 24, 20.00, 'available'),
(22195, 959, 25, 20.00, 'available'),
(22196, 959, 26, 20.00, 'available'),
(22197, 959, 27, 20.00, 'available'),
(22198, 959, 28, 20.00, 'available'),
(22199, 959, 29, 20.00, 'available'),
(22200, 959, 30, 20.00, 'available'),
(22201, 960, 1, 20.00, 'default_booked'),
(22202, 960, 2, 20.00, 'default_booked'),
(22203, 960, 3, 20.00, 'default_booked'),
(22204, 960, 4, 20.00, 'available'),
(22205, 960, 5, 20.00, 'available'),
(22206, 960, 6, 20.00, 'available'),
(22207, 960, 7, 20.00, 'available'),
(22208, 960, 8, 20.00, 'available'),
(22209, 960, 9, 20.00, 'available'),
(22210, 960, 10, 20.00, 'available'),
(22211, 960, 11, 20.00, 'available'),
(22212, 960, 12, 20.00, 'available'),
(22213, 960, 13, 20.00, 'available'),
(22214, 960, 14, 20.00, 'available'),
(22215, 960, 15, 20.00, 'available'),
(22216, 960, 16, 20.00, 'available'),
(22217, 960, 17, 20.00, 'available'),
(22218, 960, 18, 20.00, 'available'),
(22219, 960, 19, 20.00, 'available'),
(22220, 960, 20, 20.00, 'available'),
(22221, 960, 21, 20.00, 'available'),
(22222, 960, 22, 20.00, 'available'),
(22223, 960, 23, 20.00, 'available'),
(22224, 960, 24, 20.00, 'available'),
(22225, 960, 25, 20.00, 'available'),
(22226, 960, 26, 20.00, 'available'),
(22227, 960, 27, 20.00, 'available'),
(22228, 960, 28, 20.00, 'available'),
(22229, 960, 29, 20.00, 'available'),
(22230, 960, 30, 20.00, 'available'),
(22231, 961, 1, 20.00, 'default_booked'),
(22232, 961, 2, 20.00, 'default_booked'),
(22233, 961, 3, 20.00, 'default_booked'),
(22234, 961, 4, 20.00, 'available'),
(22235, 961, 5, 20.00, 'available'),
(22236, 961, 6, 20.00, 'available'),
(22237, 961, 7, 20.00, 'available'),
(22238, 961, 8, 20.00, 'available'),
(22239, 961, 9, 20.00, 'available'),
(22240, 961, 10, 20.00, 'available'),
(22241, 961, 11, 20.00, 'available'),
(22242, 961, 12, 20.00, 'available'),
(22243, 961, 13, 20.00, 'available'),
(22244, 961, 14, 20.00, 'available'),
(22245, 961, 15, 20.00, 'available'),
(22246, 961, 16, 20.00, 'available'),
(22247, 961, 17, 20.00, 'available'),
(22248, 961, 18, 20.00, 'available'),
(22249, 961, 19, 20.00, 'available'),
(22250, 961, 20, 20.00, 'available'),
(22251, 961, 21, 20.00, 'available'),
(22252, 961, 22, 20.00, 'available'),
(22253, 961, 23, 20.00, 'available'),
(22254, 961, 24, 20.00, 'available'),
(22255, 961, 25, 20.00, 'available'),
(22256, 961, 26, 20.00, 'available'),
(22257, 961, 27, 20.00, 'available'),
(22258, 961, 28, 20.00, 'available'),
(22259, 961, 29, 20.00, 'available'),
(22260, 961, 30, 20.00, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('completed','failed') DEFAULT 'completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `transaction_date`, `status`) VALUES
(7, 1, 700.00, '2025-05-22 13:58:20', 'completed'),
(8, 6, 1200.00, '2025-05-22 21:10:06', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `recharge_code` varchar(10) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `recharge_code`, `balance`, `status`) VALUES
(1, 'Test', 'Awaisg1066@gmail.com', '$2y$10$Mf65uLb51Lq0p3uFAP847eWfJjMvJgGHyXnurrVp.0FOf4FcmEHHu', '2024-09-16 21:11:38', 'CODE1234', 2867.10, 'active'),
(6, 'Tarun', 'tarun@gmail.com', '$2y$10$2yFZC8YNe.OetOa5zEjUuudObjK87BNufGjHYIjIjBD9nyYLGDV8G', '2025-05-22 21:09:24', '821F12CB', 19850.12, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `recharge_code` (`recharge_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=962;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22261;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
