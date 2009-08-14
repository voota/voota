SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP TABLE IF EXISTS `voota`.`afiliacion` ;

DROP TABLE IF EXISTS `voota`.`partido_afiliacion` ;

DROP TABLE IF EXISTS `voota`.`politico_afiliacion` ;

DROP TABLE IF EXISTS `voota`.`region` ;


ALTER TABLE `voota`.`eleccion_institucion` DROP FOREIGN KEY `eleccion_institucion_FK_1` , DROP FOREIGN KEY `eleccion_institucion_FK_2` ;

ALTER TABLE `voota`.`eleccion_institucion` 
  ADD CONSTRAINT `fk_eleccion`
  FOREIGN KEY (`eleccion_id` )
  REFERENCES `voota`.`eleccion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_institucion`
  FOREIGN KEY (`institucion_id` )
  REFERENCES `voota`.`institucion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP INDEX `fk_institucion` 
, ADD INDEX `fk_institucion` (`institucion_id` ASC) ;

ALTER TABLE `voota`.`enlace` DROP FOREIGN KEY `enlace_FK_1` , DROP FOREIGN KEY `enlace_FK_2` ;

ALTER TABLE `voota`.`enlace` 
  ADD CONSTRAINT `fk_e_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_e_politico`
  FOREIGN KEY (`politico_id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`imagen` CHANGE COLUMN `partido_id` `partido_id` INT(11) NULL DEFAULT NULL COMMENT '	'  , DROP FOREIGN KEY `imagen_FK_1` , DROP FOREIGN KEY `imagen_FK_2` , DROP FOREIGN KEY `imagen_FK_3` ;

ALTER TABLE `voota`.`imagen` 
  ADD CONSTRAINT `fk_i_opinion`
  FOREIGN KEY (`opinion_id` )
  REFERENCES `voota`.`opinion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_i_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_i_politico`
  FOREIGN KEY (`politico_id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`partido` ADD COLUMN `partido_id` INT(11) NULL DEFAULT NULL  AFTER `created_at` ;

ALTER TABLE `voota`.`politico_lista` ADD COLUMN `orden` INT(11) NULL DEFAULT NULL  AFTER `lista_id` , DROP FOREIGN KEY `politico_lista_FK_1` , DROP FOREIGN KEY `politico_lista_FK_2` ;

ALTER TABLE `voota`.`politico_lista` 
  ADD CONSTRAINT `fk_lista`
  FOREIGN KEY (`lista_id` )
  REFERENCES `voota`.`lista` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_politico`
  FOREIGN KEY (`politico_id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`politico` ADD COLUMN `bio` VARCHAR(255) NULL DEFAULT NULL  AFTER `created_at` , ADD COLUMN `email` VARCHAR(45) NULL DEFAULT NULL  AFTER `apellidos` , ADD COLUMN `partido_id` INT(11) NULL DEFAULT NULL  AFTER `created_at` , ADD COLUMN `url_key` VARCHAR(45) NOT NULL  AFTER `id` , DROP FOREIGN KEY `politico_FK_1` ;

ALTER TABLE `voota`.`politico` 
  ADD CONSTRAINT `fk_usuario`
  FOREIGN KEY (`usuario_id` )
  REFERENCES `voota`.`usuario` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`institucion` DROP FOREIGN KEY `institucion_FK_1` ;

ALTER TABLE `voota`.`institucion` 
  ADD CONSTRAINT `fk_region`
  FOREIGN KEY (`region_id` )
  REFERENCES `voota`.`geo` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`lista` DROP FOREIGN KEY `lista_FK_1` , DROP FOREIGN KEY `lista_FK_2` ;

ALTER TABLE `voota`.`lista` 
  ADD CONSTRAINT `fk_l_eleccion`
  FOREIGN KEY (`eleccion_id` )
  REFERENCES `voota`.`eleccion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_l_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`opinion` DROP FOREIGN KEY `opinion_FK_1` , DROP FOREIGN KEY `opinion_FK_2` , DROP FOREIGN KEY `opinion_FK_3` , DROP FOREIGN KEY `opinion_FK_4` ;

ALTER TABLE `voota`.`opinion` 
  ADD CONSTRAINT `fk_opinion`
  FOREIGN KEY (`opinion_id` )
  REFERENCES `voota`.`opinion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_o_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_o_politico`
  FOREIGN KEY (`politico_id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_o_usuario`
  FOREIGN KEY (`usuario_id` )
  REFERENCES `voota`.`usuario` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `voota`.`promocion` DROP FOREIGN KEY `promocion_FK_1` , DROP FOREIGN KEY `promocion_FK_2` ;

ALTER TABLE `voota`.`promocion` 
  ADD CONSTRAINT `fk_pr_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_pr_politico`
  FOREIGN KEY (`politico_id` )
  REFERENCES `voota`.`politico` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

