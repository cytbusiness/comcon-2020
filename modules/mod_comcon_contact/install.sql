CREATE TABLE IF NOT EXISTS `#__comcon_contact_inbox`
(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

  `title` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `surname` varchar(150) NOT NULL,

  `type` text NOT NULL,
  `org` text NOT NULL,

  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `town` text NOT NULL,
  `county` text NOT NULL,
  `postcode` text NOT NULL,

  `tele` text NOT NULL,
  `email` text NOT NULL,

  `status` varchar(150) not NULL,
  `info` text NOT NULL,
  `products` text NOT NULL,
  `comments` text NOT NULL,

  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
