SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `voota`.`circunscripcion` (
  `id` INT(11) NOT NULL ,
  `escanyos` INT(11) NULL DEFAULT NULL ,
  `geo_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_circunscripcion_1` (`geo_id` ASC) ,
  CONSTRAINT `fk_circunscripcion_1`
    FOREIGN KEY (`geo_id` )
    REFERENCES `voota`.`geo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

ALTER TABLE `voota`.`lista_calle` ADD COLUMN `circunscripcion_id` INT(11) NULL DEFAULT NULL  AFTER `sumd` , CHANGE COLUMN `geo_id` `geo_id` INT(11) NULL DEFAULT NULL  , 
  ADD CONSTRAINT `fk_lista_calle_4`
  FOREIGN KEY (`geo_id` )
  REFERENCES `voota`.`geo` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_lista_calle_5`
  FOREIGN KEY (`circunscripcion_id` )
  REFERENCES `voota`.`circunscripcion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_lista_calle_5` (`circunscripcion_id` ASC) 
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`convocatoria_id`, `partido_id`, `politico_id`) ;

ALTER TABLE `voota`.`lista` ADD COLUMN `circunscripcion_id` INT(11) NULL DEFAULT NULL  AFTER `created_at` , 
  ADD CONSTRAINT `fk_lista_2`
  FOREIGN KEY (`circunscripcion_id` )
  REFERENCES `voota`.`circunscripcion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_lista_2` (`circunscripcion_id` ASC) ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;








SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`circunscripcion` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  ;

drop table if exists lista_calle;
CREATE  TABLE IF NOT EXISTS `voota`.`lista_calle` (
  `convocatoria_id` INT(11) NOT NULL ,
  `partido_id` INT(11) NOT NULL ,
  `politico_id` INT(11) NOT NULL ,
  `circunscripcion_id` INT(11) NOT NULL ,
  `sumu` INT(11) NOT NULL DEFAULT 0 ,
  `sumd` INT(11) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`convocatoria_id`, `partido_id`, `politico_id`, `circunscripcion_id`) ,
  INDEX `fk_lista_calle_1` (`convocatoria_id` ASC) ,
  INDEX `fk_lista_calle_2` (`partido_id` ASC) ,
  INDEX `fk_lista_calle_3` (`politico_id` ASC) ,
  INDEX `fk_lista_calle_5` (`circunscripcion_id` ASC) ,
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
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_calle_5`
    FOREIGN KEY (`circunscripcion_id` )
    REFERENCES `voota`.`circunscripcion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

INSERT INTO circunscripcion (geo_id) select distinct geo_id from lista;
update lista l, circunscripcion c set l.circunscripcion_id = c.id WHERE l.geo_id = c.geo_id;

ALTER TABLE `voota`.`lista` 
 DROP INDEX `uniq_lista` 
, ADD UNIQUE INDEX `uniq_lista` (`partido_id` ASC, `convocatoria_id` ASC, `circunscripcion_id` ASC) ;

ALTER TABLE `voota`.`lista` DROP FOREIGN KEY `fk_lista_1` ;
ALTER TABLE `voota`.`lista` DROP COLUMN `geo_id` , CHANGE COLUMN `circunscripcion_id` `circunscripcion_id` INT(11) NOT NULL;

ALTER TABLE `voota`.`lista` 
  ADD CONSTRAINT `fk_lista_2`
  FOREIGN KEY (`circunscripcion_id` )
  REFERENCES `voota`.`circunscripcion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
