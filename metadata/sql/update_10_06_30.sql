CREATE  TABLE IF NOT EXISTS `voota`.`sf_guard_user_profile_i18n` (
  `id` INT(11) NOT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `presentacion` VARCHAR(600) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_sf_guard_user_profile_i18n_1` (`id` ASC) ,
  CONSTRAINT `fk_sf_guard_user_profile_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`sf_guard_user_profile` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

INSERT INTO sf_guard_user_profile_i18n SELECT id, 'es', presentacion FROM sf_guard_user_profile;

ALTER TABLE sf_guard_user_profile DROP COLUMN presentacion;