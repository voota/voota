CREATE  TABLE IF NOT EXISTS `voota`.`politico_i18n` (
  `id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `formacion` VARCHAR(255) NULL DEFAULT NULL ,
  `presentacion` VARCHAR(500) NULL DEFAULT NULL ,
  `bio` LONGTEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_politico_i18n_1` (`id` ASC) ,
  CONSTRAINT `fk_politico_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;
