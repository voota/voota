CREATE  TABLE IF NOT EXISTS `voota`.`politico_institucion` (
  `politico_id` INT(11) NOT NULL ,
  `institucion_id` INT(11) NOT NULL ,
  `fecha_inicio` DATE NULL DEFAULT NULL ,
  `fecha_fin` DATE NULL DEFAULT NULL ,
  INDEX `fk_institucion_politico_1` (`institucion_id` ASC) ,
  INDEX `fk_institucion_politico_2` (`politico_id` ASC) ,
  PRIMARY KEY (`politico_id`, `institucion_id`) ,
  CONSTRAINT `fk_institucion_politico_1`
    FOREIGN KEY (`institucion_id` )
    REFERENCES `voota`.`institucion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_institucion_politico_2`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

insert into politico_institucion (institucion_id, politico_id) SELECT 1,id FROM `politico` ;
