CREATE USER 'chatapp'@'localhost' IDENTIFIED BY 'chatapp';

CREATE DATABASE chatapp;

USE chatapp;

DROP TABLE IF EXISTS `block_ip`;

CREATE TABLE `block_ip` (
  `ip_addr` char(40) NOT NULL,
  `attempts` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `block_ip` VALUES ('127.0.0.1',1),('::1',5);

DROP TABLE IF EXISTS `chat`;

CREATE TABLE `chat` (
  `msg_from` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg` text,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `chat` VALUES (2,1,'hi lailt','2017-10-06 07:59:37'),(1,2,'hi','2017-10-06 07:59:53'),(2,1,'what are you doing','2017-10-06 08:00:02'),(1,2,'nothing i\'m fine','2017-10-06 08:00:12');

DROP TABLE IF EXISTS `friend_list`;

CREATE TABLE `friend_list` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `friend_list` VALUES (1,2),(1,5),(1,4),(1,7),(1,8),(2,1),(2,3),(2,5),(2,6),(3,1),(3,2),(3,4),(3,5),(3,7),(4,1),(4,2),(4,3),(4,5),(4,6),(5,1),(6,7),(6,2),(7,2),(7,1),(7,3),(8,1),(9,1),(10,1),(2,10),(1,11),(11,4),(11,7);

DROP TABLE IF EXISTS `online_users`;

CREATE TABLE `online_users` (
  `user_id` int(11) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `firstname` char(20) NOT NULL,
  `lastname` char(20) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO `users` VALUES (1,'lalitmunne','lalit','munne','b14c089d08713734a6081c91804401e1'),(2,'nilesh','nilesh','dongre','5c5a4bf04d39cc8905f350b352a4dbd0'),(3,'sachin','sachin','khan','15285722f9def45c091725aee9c387cb'),(4,'karan','karan','meghe','db068ce9f744fbb35eedc9a883f91085'),(5,'rajiv','rajiv','joshi','9a9af43c15771eaf3b2db8bb28a2829d'),(6,'swapnil','swapnil','pandey','b39a5005f03f16e882a911cd34f86043'),(7,'alex','alex','phill','534b44a19bf18d20b71ecc4eb77c572f'),(8,'akki','akki','patel','c769d3c6031b7943b46bf198a29057d2'),(9,'arnav','arnav','pise','3971f2a82d7f32017d8d9cfa5e7f0dfb'),(10,'kamal','kamal','khan','aa63b0d5d950361c05012235ab520512'),(11,'jayant','jayant','rahangadale','8feac9b198743b6f59914f448385c179');

