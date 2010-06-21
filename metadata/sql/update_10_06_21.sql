SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP TABLE IF EXISTS `voota`.`etiqueta_sf_guard_user` ;
DROP TABLE IF EXISTS `voota`.`etiqueta_politico` ;
DROP TABLE IF EXISTS `voota`.`etiqueta_partido` ;
DROP TABLE IF EXISTS `voota`.`etiqueta_propuesta` ;
DROP TABLE IF EXISTS `voota`.`etiqueta` ;

CREATE  TABLE IF NOT EXISTS `voota`.`etiqueta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `culture` VARCHAR(7) NOT NULL DEFAULT 'es' ,
  `texto` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  UNIQUE INDEX `texto_UNIQUE` (`texto` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`etiqueta_partido` (
  `etiqueta_id` INT(11) NOT NULL ,
  `partido_id` INT(11) NOT NULL ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `culture` VARCHAR(45) NOT NULL ,
  `fecha` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`etiqueta_id`, `partido_id`, `culture`, `sf_guard_user_id`) ,
  INDEX `fk_etiqueta_partido_1` (`etiqueta_id` ASC, `culture` ASC) ,
  INDEX `fk_etiqueta_partido_2` (`partido_id` ASC) ,
  INDEX `fk_etiqueta_partido_3` (`sf_guard_user_id` ASC) ,
  CONSTRAINT `fk_etiqueta_partido_1`
    FOREIGN KEY (`etiqueta_id` , `culture` )
    REFERENCES `voota`.`etiqueta` (`id` , `culture` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_partido_2`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_partido_3`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `voota`.`sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`etiqueta_politico` (
  `etiqueta_id` INT(11) NOT NULL ,
  `politico_id` INT(11) NOT NULL ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `fecha` DATETIME NOT NULL ,
  INDEX `fk_etiqueta_politico_1` (`etiqueta_id` ASC, `culture` ASC) ,
  INDEX `fk_etiqueta_politico_2` (`politico_id` ASC) ,
  PRIMARY KEY (`etiqueta_id`, `politico_id`, `sf_guard_user_id`, `culture`) ,
  INDEX `fk_etiqueta_politico_3` (`sf_guard_user_id` ASC) ,
  CONSTRAINT `fk_etiqueta_politico_1`
    FOREIGN KEY (`etiqueta_id` , `culture` )
    REFERENCES `voota`.`etiqueta` (`id` , `culture` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_politico_2`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_politico_3`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `voota`.`sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`etiqueta_propuesta` (
  `etiqueta_id` INT(11) NOT NULL ,
  `propuesta_id` INT(11) NOT NULL ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `fecha` DATETIME NULL DEFAULT NULL ,
  INDEX `fk_etiqueta_propuesta_1` (`etiqueta_id` ASC, `culture` ASC) ,
  INDEX `fk_etiqueta_propuesta_2` (`propuesta_id` ASC) ,
  PRIMARY KEY (`etiqueta_id`, `propuesta_id`, `sf_guard_user_id`, `culture`) ,
  INDEX `fk_etiqueta_propuesta_3` (`sf_guard_user_id` ASC) ,
  CONSTRAINT `fk_etiqueta_propuesta_1`
    FOREIGN KEY (`etiqueta_id` , `culture` )
    REFERENCES `voota`.`etiqueta` (`id` , `culture` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_propuesta_2`
    FOREIGN KEY (`propuesta_id` )
    REFERENCES `voota`.`propuesta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etiqueta_propuesta_3`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `voota`.`sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

