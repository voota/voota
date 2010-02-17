SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`institucion` ADD COLUMN `is_active` TINYINT(4) NOT NULL DEFAULT 1  AFTER `imagen` , ADD COLUMN `is_main` TINYINT(4) NOT NULL DEFAULT 1  AFTER `is_active` ;


update institucion set is_main = 0 where disabled = 'Y' or disabled = 'S';
update institucion set is_main = 1 where disabled = 'N';
update institucion set is_main = 0 where disabled is NULL ;
update institucion set is_active = 1;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

