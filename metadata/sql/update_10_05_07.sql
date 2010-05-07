SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`convocatoria` ADD COLUMN `imagen` VARCHAR(50) NULL DEFAULT NULL  AFTER `created_at` ;

ALTER TABLE `voota`.`eleccion_i18n` DROP FOREIGN KEY `fk_eleccion_i18n_1` ;

ALTER TABLE `voota`.`eleccion_i18n` 
  ADD CONSTRAINT `fk_eleccion_i18n_1`
  FOREIGN KEY (`id` )
  REFERENCES `voota`.`convocatoria` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, RENAME TO  `voota`.`convocatoria_i18n` ;

ALTER TABLE `voota`.`eleccion` DROP COLUMN `imagen` , DROP COLUMN `vanity` , ADD COLUMN `vanity` VARCHAR(45) NOT NULL  AFTER `id` 
, DROP INDEX `uniq_eleccion` 
, ADD UNIQUE INDEX `uniq_eleccion` (`vanity` ASC) ;




CREATE  TABLE IF NOT EXISTS `voota`.`eleccion_i18n` (
  `id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `nombre_corto` VARCHAR(45) NULL ,
  `nombre` VARCHAR(150) NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_convocatoria_i18n_1` (`id` ASC) ,
  CONSTRAINT `fk_convocatoria_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `voota`.`convocatoria_i18n` DROP COLUMN `nombre_corto` , DROP COLUMN `nombre` ;





ALTER TABLE `voota`.`enlace` CHANGE COLUMN `eleccion_id` `convocatoria_id` INT(11) NULL DEFAULT NULL  , DROP FOREIGN KEY `fk_enlace_3` ;

ALTER TABLE `voota`.`enlace` 
  ADD CONSTRAINT `fk_enlace_3`
  FOREIGN KEY (`convocatoria_id` )
  REFERENCES `voota`.`convocatoria` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP INDEX `fk_enlace_3` 
, ADD INDEX `fk_enlace_3` (`convocatoria_id` ASC) ;





SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

