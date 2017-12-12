CREATE DATABASE `blog`;

CREATE TABLE `blog`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `blog`.`article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL,
  `teaser` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `body_html` text NOT NULL,
  `teaser_html` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKgwrtdbqvt9ucntp82nd3yiuec` (`author_id`),
  CONSTRAINT `FKgwrtdbqvt9ucntp82nd3yiuec` FOREIGN KEY (`author_id`) REFERENCES `blog`.`user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE USER 'plc'@'localhost' IDENTIFIED BY 'test';
GRANT ALL PRIVILEGES ON blog.* TO 'plc'@'localhost';