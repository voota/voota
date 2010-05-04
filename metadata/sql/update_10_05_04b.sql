SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `voota`.`convocatoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `eleccion_id` INT(11) NOT NULL ,
  `fecha` DATE NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `fk_convocatoria_1` (`eleccion_id` ASC) ,
  CONSTRAINT `fk_convocatoria_1`
    FOREIGN KEY (`eleccion_id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`eleccion_i18n` (
  `id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL ,
  `nombre` VARCHAR(150) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL ,
  `descripcion` VARCHAR(600) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_eleccion_i18n_1` (`id` ASC) ,
  CONSTRAINT `fk_eleccion_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

ALTER TABLE `voota`.`eleccion` DROP COLUMN `fecha` , DROP COLUMN `nombre` , ADD COLUMN `nombre_corto` VARCHAR(45) NOT NULL  AFTER `id` ;

ALTER TABLE `voota`.`lista` DROP COLUMN `eleccion_id` , ADD COLUMN `convocatoria_id` INT(11) NOT NULL  AFTER `partido_id` , ADD COLUMN `geo_id` INT(11) NOT NULL  AFTER `convocatoria_id` , DROP FOREIGN KEY `fk_l_eleccion` ;

ALTER TABLE `voota`.`lista` 
  ADD CONSTRAINT `fk_lista_1`
  FOREIGN KEY (`geo_id` )
  REFERENCES `voota`.`geo` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_l_convocatoria`
  FOREIGN KEY (`convocatoria_id` )
  REFERENCES `voota`.`convocatoria` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_lista_1` (`geo_id` ASC) 
, ADD UNIQUE INDEX `uniq_lista` (`partido_id` ASC, `convocatoria_id` ASC, `geo_id` ASC) 
, DROP INDEX `fk_l_eleccion` 
, ADD INDEX `fk_l_eleccion` (`convocatoria_id` ASC) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

