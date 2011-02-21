CREATE  TABLE IF NOT EXISTS `sf_review_status` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `sf_review_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;
CREATE  TABLE IF NOT EXISTS `sf_review` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `value` INT(11) NULL DEFAULT NULL ,
  `sf_guard_user_id` INT(11) NOT NULL ,
  `sf_review_type_id` INT(11) NOT NULL ,
  `sf_review_status_id` INT(11) NOT NULL ,
  INDEX `fk_sf_review_1` (`sf_guard_user_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sf_review_2` (`sf_review_type_id` ASC) ,
  INDEX `fk_sf_review_3` (`sf_review_status_id` ASC) ,
  CONSTRAINT `fk_sf_review_1`
    FOREIGN KEY (`sf_guard_user_id` )
    REFERENCES `sf_guard_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_2`
    FOREIGN KEY (`sf_review_type_id` )
    REFERENCES `sf_review_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sf_review_3`
    FOREIGN KEY (`sf_review_status_id` )
    REFERENCES `sf_review_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `sf_review_attach` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `sf_review_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sf_review_attach_1` (`sf_review_id` ASC) ,
  CONSTRAINT `fk_sf_review_attach_1`
    FOREIGN KEY (`sf_review_id` )
    REFERENCES `sf_review` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;
