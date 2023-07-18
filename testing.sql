-- phpMyAdmin SQL Dump
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `testing` (
  `id` int NOT NULL,
  `column1` varchar(255) DEFAULT NULL,
  `column2` varchar(255) DEFAULT NULL,
  `column3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `testing`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `testing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
