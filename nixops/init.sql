CREATE DATABASE IF NOT EXISTS `blog`;

CREATE TABLE IF NOT EXISTS `blog`.`user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `blog`.`article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL,
  `teaser` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `body_html` text NOT NULL,
  `teaser_html` text NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `FKgwrtdbqvt9ucntp82nd3yiuec` (`author_id`),
  CONSTRAINT `FKgwrtdbqvt9ucntp82nd3yiuec` FOREIGN KEY (`author_id`) REFERENCES `blog`.`user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE USER IF NOT EXISTS 'plc'@'localhost' IDENTIFIED BY 'test';
GRANT ALL PRIVILEGES ON blog.* TO 'plc'@'localhost';
