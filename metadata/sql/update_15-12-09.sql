SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `voota`.`institucion_i18n` (
  `id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `vanity` VARCHAR(45) NULL ,
  `nombre_corto` VARCHAR(45) NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_institucion_i18n_1` (`id` ASC) ,
  UNIQUE INDEX `uniq_inst_i18n` (`culture` ASC, `vanity` ASC) ,
  CONSTRAINT `fk_institucion_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`institucion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

insert into institucion_i18n (id, culture, vanity, nombre, nombre_corto)
select id, 'es', vanity, nombre, nombre_corto from institucion;
insert into institucion_i18n (id, culture, vanity, nombre, nombre_corto)
select id, 'ca', vanity, nombre, nombre_corto from institucion;

ALTER TABLE `voota`.`institucion` DROP COLUMN `nombre_corto` , DROP COLUMN `nombre` , DROP COLUMN `vanity` 
, DROP INDEX `uniq_institucion` ;

ALTER TABLE `voota`.`politico` DROP COLUMN `bio` , DROP COLUMN `formacion` , DROP COLUMN `presentacion` ;

ALTER TABLE `voota`.`politico_i18n` 
  ADD CONSTRAINT `fk_politico_i18n_1`
  FOREIGN KEY (`id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

