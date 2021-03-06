SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`enlace` ADD COLUMN `sf_guard_user_id` INT(11) NULL DEFAULT NULL  AFTER `politico_id` , 
  ADD CONSTRAINT `fk_enlace_1`
  FOREIGN KEY (`sf_guard_user_id` )
  REFERENCES `voota`.`sf_guard_user` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_enlace_1` (`sf_guard_user_id` ASC) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

