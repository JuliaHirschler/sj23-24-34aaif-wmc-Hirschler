-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_ID` int(11) NOT NULL,
  `author_firstName` text NOT NULL,
  `author_LastName` text NOT NULL,
  `author_birthdate` date NOT NULL,
  `author_generes` int(11) DEFAULT NULL,
  `author_biography` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_ID`, `author_firstName`, `author_LastName`, `author_birthdate`, `author_generes`, `author_biography`) VALUES
(1, 'Elly', 'Griffiths', '1948-08-22', 1, 'Elly Griffiths is the pen name of Domenica de Rosa. a British crime novelist. She has written two series as Griffiths, one featuring Ruth Galloway, the other featuring Detective Inspector Edgar Stephens and Max Mephisto.'),
(2, 'Peter', 'James', '1963-08-17', 1, 'Peter James is a British writer of crime fiction. He was born in Brighton, the son of Cornelia James, the former glovemaker to Queen Elizabeth II.'),
(3, 'Sarah J', 'Maas', '1986-03-05', 2, 'Sarah J Maas is an American fantasy author, best known for her debut series Throne of Glass published in 2012 and A Court of Thorns and Roses series, published in 2015. Her newest work is the Crescent City series. As of 2021, she has sold over twelve million copies of her books and been translated into thirty-seven languages.'),
(4, 'Stephen Edwin', 'King', '1947-09-21', 3, 'Stephen Edwin King is an American author. His books have sold over 400 million copies as of 2017 and have been translated into over 40 languages.'),
(5, 'Agatha', 'Christie', '1890-09-15', 4, 'Agatha Christie is the worlds best-known mystery writer. Her books have sold over a billion copies in the English language and another billion in 44 foreign languages. She is the most widely published author of all time in any language, outsold only by the Bible and Shakespeare.'),
(6, 'Mary', 'Bloody', '1970-01-01', 6, 'ashduashuxchsudxhkajsnxj');

-- --------------------------------------------------------

--
-- Table structure for table `generes1`
--

CREATE TABLE `generes1` (
  `ID_Generes` int(11) NOT NULL,
  `Generes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `generes1`
--

INSERT INTO `generes1` (`ID_Generes`, `Generes`) VALUES
(1, 'Crime Fiction'),
(2, 'Fantasy'),
(3, 'Horror'),
(4, 'Mystery'),
(5, 'Biography'),
(6, 'Blau');

-- --------------------------------------------------------

--
-- Table structure for table `titles1`
--

CREATE TABLE `titles1` (
  `ID_Title` int(11) NOT NULL,
  `Titles` text NOT NULL,
  `Author` int(11) DEFAULT NULL,
  `Generes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `titles1`
--

INSERT INTO `titles1` (`ID_Title`, `Titles`, `Author`, `Generes`) VALUES
(1, 'The Crossing Places', 1, 1),
(2, 'Not Dead Enough', 2, 1),
(3, 'Throne of Glass', 3, 2),
(4, 'The Stand', 4, 3),
(5, 'Murder in the Orient Express', 5, 4),
(6, 'SQL JOINS', 6, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_ID`),
  ADD KEY `fk_author_generes` (`author_generes`);

--
-- Indexes for table `generes1`
--
ALTER TABLE `generes1`
  ADD PRIMARY KEY (`ID_Generes`);

--
-- Indexes for table `titles1`
--
ALTER TABLE `titles1`
  ADD PRIMARY KEY (`ID_Title`),
  ADD KEY `fk_Author` (`Author`),
  ADD KEY `fk_Generes` (`Generes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `generes1`
--
ALTER TABLE `generes1`
  MODIFY `ID_Generes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `titles1`
--
ALTER TABLE `titles1`
  MODIFY `ID_Title` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `fk_author_generes` FOREIGN KEY (`author_generes`) REFERENCES `generes1` (`ID_Generes`);

--
-- Constraints for table `titles1`
--
ALTER TABLE `titles1`
  ADD CONSTRAINT `fk_Author` FOREIGN KEY (`Author`) REFERENCES `author` (`author_ID`),
  ADD CONSTRAINT `fk_Generes` FOREIGN KEY (`Generes`) REFERENCES `generes1` (`ID_Generes`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
