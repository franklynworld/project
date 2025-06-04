-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 05:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skylink`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL DEFAULT current_timestamp(),
  `passengers` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `flight_number` varchar(50) NOT NULL,
  `departure_location` varchar(100) NOT NULL,
  `unique_code` varchar(32) NOT NULL,
  `arrival_location` varchar(100) NOT NULL,
  `departureDate` date NOT NULL,
  `arrival_date` date NOT NULL,
  `seats_available` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchasedate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `flight_number`, `departure_location`, `unique_code`, `arrival_location`, `departureDate`, `arrival_date`, `seats_available`, `price`, `purchasedate`) VALUES
(5, 'AA 12E', 'United State', '38954b16c9fde0b0451dd1189d574807', 'London', '2025-01-11', '2025-01-12', 0, 400.00, '2025-01-11 17:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `frequent_flyer_transactions`
--

CREATE TABLE `frequent_flyer_transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `miles_earned` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`) VALUES
(3, 'James smith', 'James@gmail.com', '$2y$10$zno56ygPbGHbHvGN7WVKk.kOmLRmm5rjBjhEi73wu7aHg8siQ19sO', 0),
(4, 'James harword', 'jamesh@gmail.com', '$2y$10$4LYSFKv7dB2UZTuzudCFleI93irAlyke5xB9XTJzj25LzoGY3ZTh6', 0),
(7, 'franklyn', 'shadow@gmail.com', '$2y$10$ubaWY3T0jlmUxc5lz2jLpOWO/yQirdr7Jr26j7O8Kb7eZFrfCPf8i', 0),
(9, 'franklyn', 'name@gmail.com', '$2y$10$qHeRz8eCqzO1CSYItMFo6.wVf0hnzl.dOSvbjJ6NNMt4QbHWjUnIq', 0),
(10, 'john joe', 'johnson@gmail.com', '$2y$10$IwqAaQHo8Hvq.DXTwqcJsORGSQa6/ZRVuXVZSu9Uog3j81lpBUpZ.', 0),
(11, 'franklyn', 'franklyn@gmail.com', '$2y$10$20uyEcL82PcJUf0aSikRJuUbMu5BrhEqHrGL2VmdOr4Ezpc33MeRq', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frequent_flyer_transactions`
--
ALTER TABLE `frequent_flyer_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `frequent_flyer_transactions`
--
ALTER TABLE `frequent_flyer_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `flight_id` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
