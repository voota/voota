SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';



ALTER TABLE `voota`.`propuesta` ADD COLUMN `created_at` DATETIME NULL DEFAULT NULL  AFTER `sumd` , ADD COLUMN `is_active` TINYINT(4) NOT NULL DEFAULT 1  AFTER `sumd` , ADD COLUMN `modified_at` DATETIME NULL DEFAULT NULL  AFTER `created_at` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

