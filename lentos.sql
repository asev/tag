
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tag`
--

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `requestId` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50),
  `reqText` varchar(5000) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,  
  `manager` int(4) NOT NULL DEFAULT 0,
  `created` DATETIME NOT NULL,
  `assigned` DATETIME,
  `completed` DATETIME,
  `spam` INT(1) NOT NULL DEFAULT 0,
  `subject` VARCHAR(500) NOT NULL,
  `comment` VARCHAR(2000) DEFAULT '',
  PRIMARY KEY (`requestId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders`(
	`orderId` int(11) NOT NULL AUTO_INCREMENT,
	`requestId` int(11) NOT NULL,
	`createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`managerId` int(11) NOT NULL,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	`comment` VARCHAR(2000) DEFAULT '',
	PRIMARY KEY(`orderId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items`(
	`itemId` int(11) NOT NULL,
	`orderId` int(11) NOT NULL,
	`itemName` VARCHAR(300) NOT NULL,
	`itemPrice` float(7,2) NOT NULL,
	`itemQuantity` int(8) NOT NULL DEFAULT 0,
	`active` tinyint(1) NOT NULL DEFAULT 1,
	PRIMARY KEY(`itemId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 
	
