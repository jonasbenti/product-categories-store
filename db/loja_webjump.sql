/*
SQLyog Enterprise v12.13 (64 bit)
MySQL - 5.7.28 : Database - loja_webjump
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`loja_webjump` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `loja_webjump`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `row_id` int(11) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `price` decimal(20,2) DEFAULT '0.00',
  `description` text,
  `quantity` bigint(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `product_categories` */

DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`),
  KEY `fk_product` (`product_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/* Trigger structure for table `category` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_insert_category` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_insert_category` AFTER INSERT ON `category` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(NEW.id, 'Categoria' ,'insert', 	
	CONCAT('Inseriu Categoria com os dados (id: ', NEW.id, ', Nome: ', NEW.name, ', code: ', NEW.code,').')
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `category` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_update_category` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_update_category` AFTER UPDATE ON `category` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(NEW.id, 'Categoria' ,'update', 	
	CONCAT('Atualizou Categoria com os dados (id: ', NEW.id, ', Nome: ', NEW.name, ', code: ', NEW.code,').')
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `category` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_delete_category` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_delete_category` AFTER DELETE ON `category` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(OLD.id, 'Categoria' ,'delete', 	
	CONCAT('Info antigas id: ', OLD.id, ', Nome: ', OLD.name, ', code: ', OLD.code)
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `product` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_insert_product` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_insert_product` AFTER INSERT ON `product` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, type, action, description)
	VALUES
	(NEW.id, 'Produto' ,'insert', 	
	concat('Inseriu Produto com os dados (id: ', NEW.id, ', Nome: ', NEW.name, ', code: ', NEW.code, ', preço: ', NEW.price, ', Qtd: ', new.quantity, 
	', descrição: ', NEW.description, ',Imagem: ', NEW.image,').')
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `product` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_update_product` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_update_product` AFTER UPDATE ON `product` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(NEW.id, 'Produto' ,'update', 	
	CONCAT('Atualizou Produto com os dados (id: ', NEW.id, ', Nome: ', NEW.name, ', code: ', NEW.code, ', preço: ', NEW.price, ', Qtd: ', NEW.quantity, 
	', descrição: ', ifnull(NEW.description, ''), ',Imagem: ', ifnull(NEW.image,''),').')
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `product` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_delete_product` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_delete_product` AFTER DELETE ON `product` FOR EACH ROW BEGIN
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(OLD.id, 'Produto' ,'delete', 	
	CONCAT('Dados antigos do produto id: ', OLD.id, ', Nome: ', OLD.name, ', code: ', OLD.code, ', preço: ', OLD.price, ', Qtd: ', OLD.quantity, 
	', descrição: ', IFNULL(OLD.description, ''), ',Imagem: ', IFNULL(OLD.image,''),').')
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `product_categories` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_insert_product_categories` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_insert_product_categories` AFTER INSERT ON `product_categories` FOR EACH ROW BEGIN
    
    DECLARE data_product varchar(255);  
    DECLARE data_category varchar(255); 
    
	SELECT CONCAT('[',c.code,'] - ',c.name), CONCAT('[',p.code,'] - ',p.name) INTO data_category, data_product FROM loja_webjump.product_categories pc
	INNER JOIN loja_webjump.category c ON (pc.category_id = c.id)
	INNER JOIN loja_webjump.product p ON (pc.product_id = p.id)
	WHERE pc.id = NEW.id;
    
    
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(NEW.id, 'Categoria do Produto' ,'insert', 	
	CONCAT('Categoria: ', data_category,' inserida para o produto: ', data_product)
	);
    END */$$


DELIMITER ;

/* Trigger structure for table `product_categories` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `log_delete_product_categories` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `log_delete_product_categories` BEFORE DELETE ON `product_categories` FOR EACH ROW BEGIN
    
    DECLARE data_product varchar(255);  
    DECLARE data_category varchar(255); 
    
	SELECT CONCAT('[',c.code,'] - ',c.name), CONCAT('[',p.code,'] - ',p.name) INTO data_category, data_product FROM loja_webjump.product_categories pc
	INNER JOIN loja_webjump.category c ON (pc.category_id = c.id)
	INNER JOIN loja_webjump.product p ON (pc.product_id = p.id)
	WHERE pc.id = OLD.id;
    
    
	INSERT INTO loja_webjump.log 
	(row_id, TYPE, ACTION, description)
	VALUES
	(OLD.id, 'Categoria do Produto' ,'delete', 	
	CONCAT('Categoria: ', data_category,' excluida do produto: ', data_product)
	);
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
