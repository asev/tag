
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
-- Dump data to `request`
--

INSERT INTO `request` (`fullName`, `email`, `phone`, `subject`, `reqText`, `state`, `manager`, `spam`, `created`, `assigned`, `completed`, `comment`) VALUES
('Karolis R', 'karolis@example.com', '+37060000000', 'Indiškas virtuvės baldų komplektas', 'In gravida arcu non arcu molestie ornare. Morbi id nulla et lorem luctus blandit. Maecenas eu tincidunt dolor. Ut commodo nisl sed purus sodales pretium. Mauris congue diam a mauris auctor a iaculis magna placerat. Etiam adipiscing risus sed arcu tincidunt eget eleifend risus suscipit. Fusce eu mauris id velit porttitor bibendum. Nam velit magna, ornare sed malesuada eget, convallis dignissim sem. Sed ullamcorper sodales erat quis luctus. Nulla quis justo eget dui placerat pulvinar. Nulla eros justo, mollis in consectetur eget, malesuada at sem. Suspendisse quis elit velit, quis mollis turpis. Pellentesque a dolor at odio eleifend scelerisque ut id nisi. Maecenas orci metus, eleifend sed fermentum at, facilisis at arcu. Morbi est justo, egestas quis placerat eget, suscipit id nunc. Nulla facilisi.', 2, 3, 0, '2012-11-26 12:00:00', '2012-11-26 12:20:00', '2012-11-29 22:00:00', 'Pristatymas į Nidą.'),
('Albertas Kesturaukis', 'albertas@example.com', '+37060000001', 'Sofa-lova', 'Vivamus ac pharetra justo. Aliquam scelerisque gravida velit nec rutrum. Aliquam erat volutpat. Ut dignissim metus ac justo porttitor facilisis. Quisque ligula eros, gravida sit amet commodo condimentum, consequat eget diam. Cras vestibulum volutpat sollicitudin. Cras blandit leo nec tellus scelerisque id mollis nisi sodales. Aliquam ornare tellus eu lacus ultricies at venenatis metus fringilla. Mauris dignissim semper congue. Morbi euismod mauris quis felis consectetur volutpat sit amet id est. Nullam nibh lectus, dapibus congue feugiat quis, posuere vel lacus. Donec mauris orci, fringilla et tempus sed, varius ut mi. Mauris facilisis risus quis dolor faucibus cursus.', 3, 3, 0, '2012-11-26 13:00:00', '2012-11-26 13:21:00', '2012-11-29 22:01:00', 'Nemandagus klientas.'),
('Kristupas Karalius', 'kkaralius@example.com', '+37060000002', '100 lovų viešbučiui', 'Aliquam vel lacus id risus laoreet suscipit vitae quis elit. Suspendisse posuere ante vitae tellus ullamcorper posuere. Nullam sed nibh ac dui bibendum laoreet ac sit amet odio. Integer nisl ipsum, vulputate id cursus eget, lobortis ut neque. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget libero augue, ut ornare augue. Sed accumsan augue eget sem viverra vitae faucibus tellus feugiat. Donec sagittis congue velit eget congue. Proin commodo rhoncus eleifend. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc laoreet egestas mauris quis malesuada. Etiam in sem et velit iaculis sodales eget sed nulla.', 1, 2, 0, '2012-11-27 00:22:12', '2012-11-27 08:02:12', null, ''),
('Kristupas Karalius', 'kkaralius@example.com', '+37060000002', '90 stalų viešbučiui', 'Aliquam vel lacus id risus laoreet suscipit vitae quis elit. Suspendisse posuere ante vitae tellus ullamcorper posuere. Nullam sed nibh ac dui bibendum laoreet ac sit amet odio. Integer nisl ipsum, vulputate id cursus eget, lobortis ut neque. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget libero augue, ut ornare augue. Sed accumsan augue eget sem viverra vitae faucibus tellus feugiat. Donec sagittis congue velit eget congue. Proin commodo rhoncus eleifend. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc laoreet egestas mauris quis malesuada. Etiam in sem et velit iaculis sodales eget sed nulla.', 1, 2, 0, '2012-11-27 00:23:42', '2012-11-27 08:02:42', null, ''),
('Aurimas', 'aurimas@example.com', '+37060000003', 'Virtuvės baldų komplektas', 'Nam eleifend lectus at erat tempor in consequat nisi rhoncus. In hac habitasse platea dictumst. Nam rutrum tellus sed purus mattis interdum quis in erat. Suspendisse eu nibh aliquam libero hendrerit aliquet. Pellentesque faucibus sapien ac ante egestas ut dapibus felis adipiscing. Quisque dapibus nulla nec lectus bibendum fringilla. Morbi vel risus nisl, quis feugiat nisl. Aenean consequat dignissim nulla, et bibendum justo mattis hendrerit. Fusce tincidunt, enim vel imperdiet tempor, odio felis lacinia massa, vel cursus libero erat volutpat lorem. Ut eget metus ipsum. Morbi dignissim porttitor nulla, a accumsan ligula luctus et. Nullam mattis fermentum quam, sed ultricies elit posuere id. Praesent scelerisque posuere nisi at mollis. Maecenas quam lectus, auctor ut tincidunt eu, suscipit commodo nisi. Integer id neque arcu, ut laoreet orci. Sed ornare commodo convallis.', 3, 3, 0, '2012-11-27 00:55:12', '2012-11-27 00:59:12', '2012-11-30 17:24:12', ''),
('nesakysiu', 'nesakysiu@example.com', '+37060000004', 'Kiaušinio formos lova', 'Aliquam vel lacus id risus laoreet suscipit vitae quis elit. Suspendisse posuere ante vitae tellus ullamcorper posuere. Nullam sed nibh ac dui bibendum laoreet ac sit amet odio. Integer nisl ipsum, vulputate id cursus eget, lobortis ut neque. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget libero augue, ut ornare augue. Sed accumsan augue eget sem viverra vitae faucibus tellus feugiat. Donec sagittis congue velit eget congue. Proin commodo rhoncus eleifend. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc laoreet egestas mauris quis malesuada. Etiam in sem et velit iaculis sodales eget sed nulla.', 0, 2, 1, '2012-11-27 01:02:12', null, null, ''),
('Algirdas', 'algirdas@example.com', '+37060000005', 'TV staliukas', 'Aliquam et lorem sapien. Praesent vitae sapien vel orci euismod tincidunt. Vestibulum nisi lectus, suscipit a dapibus id, dapibus ac arcu. Vestibulum tellus lacus, lacinia ut hendrerit at, interdum vel ante. Nulla nunc lectus, elementum eget placerat ut, blandit in dolor. Praesent sollicitudin laoreet molestie. Aliquam erat volutpat. Suspendisse velit velit, consectetur non venenatis vel, varius id sem. Nulla a nunc eros, vel consectetur tellus. Mauris gravida cursus bibendum. Proin tortor nunc, rutrum sed scelerisque vitae, rhoncus non neque. Phasellus iaculis dictum quam, a ultricies est euismod a. Nunc tincidunt nulla nec ante suscipit dictum. Etiam luctus consectetur blandit. Mauris eget ipsum libero, eu tempor dui.', 1, 3, 0, '2012-11-30 22:02:12', '2012-12-01 07:55:12', null, ''),
('Narimantas', 'narlis@example.com', '+37060000006', 'Naktinis staliukas', 'Vestibulum ut augue leo. Curabitur luctus turpis eu massa congue quis auctor purus sagittis. Donec pulvinar consequat ligula quis posuere. Vestibulum sed diam mi, sit amet rhoncus diam. Praesent placerat accumsan est, id tincidunt magna semper at. Sed bibendum, tellus vel interdum hendrerit, tellus ipsum imperdiet lectus, in interdum arcu urna quis orci. Vestibulum lobortis tortor dolor. Phasellus mollis massa id sem vehicula iaculis tincidunt neque scelerisque. Praesent non eros in est imperdiet rhoncus eget sit amet tellus. Aliquam vel augue eget leo vulputate ultricies. Mauris vehicula pharetra leo eu sollicitudin. Aliquam varius adipiscing libero, vel fermentum purus scelerisque ac. Nunc dictum semper porttitor.', 0, 0, 0, '2012-11-27 01:02:12', null, null, ''),
('Eugenija', 'efgenka@example.com', '+37060000007', 'Sed pharetra ultrices tellus, id posuere ligula pretium vitae. Sed accumsan sem in nibh vehicula tincidunt.', 'Sed pharetra ultrices tellus, id posuere ligula pretium vitae. Sed accumsan sem in nibh vehicula tincidunt. Suspendisse hendrerit magna ut erat suscipit quis scelerisque magna tincidunt. Suspendisse potenti. Mauris nulla quam, facilisis in ullamcorper a, auctor vitae ante. Nullam vel nisi urna. Phasellus cursus eros lectus, quis porttitor mauris. Vestibulum nisl urna, viverra eu malesuada in, iaculis vel tortor. Maecenas id lacus tortor. Aliquam erat volutpat. Vivamus vitae ipsum et quam sollicitudin convallis elementum ultricies lorem. Etiam ullamcorper tempor ligula, ut tincidunt risus placerat rhoncus. Proin ullamcorper volutpat metus non volutpat. Quisque luctus ante eget massa cursus sollicitudin.', 0, 0, 0, '2012-11-30 22:02:12', null, null, '');

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders`(
	`orderId` int(11) NOT NULL AUTO_INCREMENT,
	`requestId` int(11) NOT NULL,
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
	CONSTRAINT `order_item` PRIMARY KEY (`itemId`,`orderId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 
	
