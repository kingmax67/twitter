-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2019 at 05:19 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tweety`
--

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweetID` int(11) NOT NULL,
  `status` varchar(140) NOT NULL,
  `tweetBy` int(11) NOT NULL,
  `retweetID` int(11) NOT NULL,
  `retweetBy` int(11) NOT NULL,
  `tweetimage` varchar(255) NOT NULL,
  `likesCount` int(11) NOT NULL,
  `retweetCount` int(11) NOT NULL,
  `postedOn` date NOT NULL,
  `retweetMsg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tweetID`, `status`, `tweetBy`, `retweetID`, `retweetBy`, `tweetimage`, `likesCount`, `retweetCount`, `postedOn`, `retweetMsg`) VALUES
(1, 'hey', 3, 0, 0, 'users/Koala.jpg', 0, 0, '2019-10-10', ''),
(2, 'how are u guys', 3, 0, 0, '', 0, 0, '2019-10-10', ''),
(3, 'go to google.com', 3, 0, 0, '', 0, 0, '2019-10-10', ''),
(4, 'https://google.com', 3, 0, 0, '', 0, 0, '2019-10-10', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `screenName` varchar(30) NOT NULL,
  `profileimage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `followers` int(11) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `screenName`, `profileimage`, `profileCover`, `followers`, `bio`, `country`, `website`, `following`) VALUES
(1, '', '9379e19abf2d7c566d7e8d7cc71c730b', 'kingleyche77@gmail.com', 'Che kingsley', 'assets/images/profileimage.png', 'assets/images/defaultCoverImage.png', 0, '', '', '', 0),
(2, 'kingsley', '9379e19abf2d7c566d7e8d7cc71c730b', 'kingleychse77@gmail.com', 'Marshall', 'assets/images/profileimage.png', 'assets/images/defaultCoverImage.png', 0, '', '', '', 0),
(3, 'kingssss', '9379e19abf2d7c566d7e8d7cc71c730b', 'kingleychhe77@gmail.com', 'Che kingsleys', 'users/Jellyfish.jpg', 'users/Tulips.jpg', 0, '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweetID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
