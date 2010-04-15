SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`propuesta` ADD COLUMN `vanity` VARCHAR(150) NOT NULL  AFTER `modified_at` , CHANGE COLUMN `sumu` `sumu` INT(11) NULL DEFAULT 0  , CHANGE COLUMN `sumd` `sumd` INT(11) NULL DEFAULT 0  
, ADD UNIQUE INDEX `vanity_UNIQUE` (`vanity` ASC) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
