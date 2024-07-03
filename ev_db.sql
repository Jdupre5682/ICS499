-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 04:14 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `Customers` (
  `CustomerID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15),
  `Address` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Customers` (`CustomerID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Address`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '123-456-7890', '123 Elm St'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '987-654-3210', '456 Oak St');

ALTER TABLE `Customers`
  ADD PRIMARY KEY (`CustomerID`);

ALTER TABLE `Customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

CREATE TABLE `Cars` (
  `CarID` int(11) NOT NULL,
  `Make` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `LicensePlate` varchar(20) NOT NULL,
  `Color` varchar(20),
  `BatteryCapacity` decimal(5,2) NOT NULL,
  `RangePerCharge` decimal(5,2) NOT NULL,
  `RentalRatePerDay` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Cars` (`CarID`, `Make`, `Model`, `Year`, `LicensePlate`, `Color`, `BatteryCapacity`, `RangePerCharge`, `RentalRatePerDay`) VALUES
(1, 'Tesla', 'Model S', 2022, 'ABC123', 'Red', 100.00, 370.00, 150.00),
(2, 'Nissan', 'Leaf', 2021, 'XYZ789', 'Blue', 62.00, 226.00, 80.00);

ALTER TABLE `Cars`
  ADD PRIMARY KEY (`CarID`);

ALTER TABLE `Cars`
  MODIFY `CarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

CREATE TABLE `Rentals` (
  `RentalID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `CarID` int(11) NOT NULL,
  `RentalDate` date NOT NULL,
  `ReturnDate` date,
  `TotalCost` decimal(10,2),
  FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`),
  FOREIGN KEY (`CarID`) REFERENCES `Cars`(`CarID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Rentals` (`RentalID`, `CustomerID`, `CarID`, `RentalDate`, `ReturnDate`, `TotalCost`) VALUES
(1, 1, 1, '2023-06-01', '2023-06-05', 600.00),
(2, 2, 2, '2023-06-10', '2023-06-12', 160.00);

ALTER TABLE `Rentals`
  ADD PRIMARY KEY (`RentalID`);

ALTER TABLE `Rentals`
  MODIFY `RentalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

CREATE TABLE `Payments` (
  `PaymentID` int(11) NOT NULL,
  `RentalID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  FOREIGN KEY (`RentalID`) REFERENCES `Rentals`(`RentalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Payments` (`PaymentID`, `RentalID`, `PaymentDate`, `Amount`, `PaymentMethod`) VALUES
(1, 1, '2023-06-05', 600.00, 'Credit Card'),
(2, 2, '2023-06-12', 160.00, 'PayPal');

ALTER TABLE `Payments`
  ADD PRIMARY KEY (`PaymentID`);

ALTER TABLE `Payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;
