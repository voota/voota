SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


CREATE  TABLE IF NOT EXISTS `voota`.`lista_calle` (
  `convocatoria_id` INT(11) NOT NULL ,
  `partido_id` INT(11) NOT NULL ,
  `geo_id` INT(11) NULL DEFAULT NULL ,
  `politico_id` INT(11) NOT NULL ,
  `sumu` INT(11) NOT NULL DEFAULT 0 ,
  `sumd` INT(11) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`convocatoria_id`, `partido_id`, `geo_id`, `politico_id`) ,
  INDEX `fk_lista_calle_1` (`convocatoria_id` ASC) ,
  INDEX `fk_lista_calle_2` (`partido_id` ASC) ,
  INDEX `fk_lista_calle_3` (`politico_id` ASC) ,
  INDEX `fk_lista_calle_4` (`geo_id` ASC) ,
  CONSTRAINT `fk_lista_calle_1`
    FOREIGN KEY (`convocatoria_id` )
    REFERENCES `voota`.`convocatoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_calle_2`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_calle_3`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

ALTER TABLE `voota`.`convocatoria` ADD COLUMN `closed_at` DATETIME NULL DEFAULT NULL  AFTER `imagen` , ADD COLUMN `min_sumd` INT(11) NULL DEFAULT NULL  AFTER `closed_at` , ADD COLUMN `min_sumu` INT(11) NULL DEFAULT NULL  AFTER `closed_at` , ADD COLUMN `total_escanyos` INT(11) NULL DEFAULT NULL  AFTER `closed_at` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

