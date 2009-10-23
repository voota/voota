
ALTER TABLE `voota`.`imagen` DROP FOREIGN KEY `fk_i_opinion` 
, DROP INDEX `fk_i_opinion` ;

DROP TABLE IF EXISTS `voota`.`opinion` ;


ALTER TABLE `voota`.`institucion` 
DROP INDEX `uniq_institucion` 
, ADD UNIQUE INDEX `uniq_institucion` (`nombre_corto` ASC) ;

ALTER TABLE `voota`.`lista` DROP FOREIGN KEY `fk_l_eleccion` ;


ALTER TABLE `voota`.`lista` 
  ADD CONSTRAINT `fk_l_eleccion`
  FOREIGN KEY (`eleccion_id` )
  REFERENCES `voota`.`eleccion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `voota`.`partido` 
DROP INDEX `uniq_abreviatura` 
, ADD UNIQUE INDEX `uniq_abreviatura` (`abreviatura` ASC) ;


ALTER TABLE `voota`.`politico_institucion` 
DROP PRIMARY KEY 
, ADD PRIMARY KEY (`politico_id`, `institucion_id`) ;


ALTER TABLE `voota`.`politico` 
  ADD CONSTRAINT `fk_politico_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `voota`.`sf_guard_user_profile` 
DROP INDEX `uniq_sf_guard_user_profile_vanity` 
, ADD UNIQUE INDEX `uniq_sf_guard_user_profile_vanity` (`vanity` ASC) ;

ALTER TABLE `voota`.`partido_lista` DROP FOREIGN KEY `fk_pl_lista` , DROP FOREIGN KEY `fk_pl_partido` ;


ALTER TABLE `voota`.`partido_lista` 
  ADD CONSTRAINT `fk_pl_lista`
  FOREIGN KEY (`lista_id` )
  REFERENCES `voota`.`lista` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_pl_partido`
  FOREIGN KEY (`partido_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP INDEX `fk_pl_lista` 
, DROP INDEX `fk_pl_partido` 
, ADD INDEX `fk_pl_partido` (`partido_id` ASC) 
, ADD INDEX `fk_pl_lista` (`lista_id` ASC) ;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `max_value` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review_status` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `published` TINYINT(4) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `entity_id` INT(11) NOT NULL ,
  `value` INT(11) NOT NULL DEFAULT 0 ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `sf_review_type_id` INT(11) NOT NULL ,
  `sf_review_status_id` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `cookie` VARCHAR(45) NULL DEFAULT NULL ,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL ,
  `text` VARCHAR(420) NULL DEFAULT NULL ,
  INDEX `fk_sf_review_1` (`sf_guard_user_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sf_review_2` (`sf_review_type_id` ASC) ,
  INDEX `fk_sf_review_3` (`sf_review_status_id` ASC) ,
  UNIQUE INDEX `uniq_review` (`entity_id` ASC, `sf_guard_user_id` ASC, `sf_review_type_id` ASC) ,
  CONSTRAINT `fk_sf_review_1`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `voota`.`sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_2`
    FOREIGN KEY (`sf_review_type_id` )
    REFERENCES `voota`.`sf_review_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_3`
    FOREIGN KEY (`sf_review_status_id` )
    REFERENCES `voota`.`sf_review_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `entity_id` INT(11) NOT NULL ,
  `value` INT(11) NOT NULL DEFAULT 0 ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `sf_review_type_id` INT(11) NOT NULL ,
  `sf_review_status_id` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `cookie` VARCHAR(45) NULL DEFAULT NULL ,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL ,
  `text` VARCHAR(420) NULL DEFAULT NULL ,
  INDEX `fk_sf_review_1` (`sf_guard_user_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sf_review_2` (`sf_review_type_id` ASC) ,
  INDEX `fk_sf_review_3` (`sf_review_status_id` ASC) ,
  UNIQUE INDEX `uniq_review` (`entity_id` ASC, `sf_guard_user_id` ASC, `sf_review_type_id` ASC) ,
  CONSTRAINT `fk_sf_review_1`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `voota`.`sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_2`
    FOREIGN KEY (`sf_review_type_id` )
    REFERENCES `voota`.`sf_review_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_3`
    FOREIGN KEY (`sf_review_status_id` )
    REFERENCES `voota`.`sf_review_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


CREATE  TABLE IF NOT EXISTS `voota`.`sf_review_attach` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `sf_review_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sf_review_attach_1` (`sf_review_id` ASC) ,
  CONSTRAINT `fk_sf_review_attach_1`
    FOREIGN KEY (`sf_review_id` )
    REFERENCES `voota`.`sf_review` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review_reason` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`sf_review_type_entity` (
  `sf_review_type_id` INT(11) NOT NULL ,
  `entity_id` INT(11) NOT NULL ,
  `date` DATE NOT NULL ,
  `value` INT(11) NOT NULL ,
  `sum` FLOAT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`sf_review_type_id`, `entity_id`, `date`, `value`) ,
  INDEX `fk_sf_review_type_politico_1` (`sf_review_type_id` ASC) ,
  CONSTRAINT `fk_sf_review_type_politico_1`
    FOREIGN KEY (`sf_review_type_id` )
    REFERENCES `voota`.`sf_review_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

