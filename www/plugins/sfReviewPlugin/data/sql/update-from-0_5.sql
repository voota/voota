SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `sf_review` ADD COLUMN `balance` INT(11) NULL DEFAULT 0  AFTER `culture` , ADD COLUMN `is_active` TINYINT(4) NOT NULL DEFAULT 1  AFTER `balance` , ADD COLUMN `sf_review_id` INT(11) NULL DEFAULT NULL  AFTER `culture` , CHANGE COLUMN `entity_id` `entity_id` INT(11) NULL DEFAULT NULL  , CHANGE COLUMN `sf_review_type_id` `sf_review_type_id` INT(11) NULL DEFAULT NULL  , DROP FOREIGN KEY `sf_review_FK_1` , DROP FOREIGN KEY `sf_review_FK_2` , DROP FOREIGN KEY `sf_review_FK_3` ;

ALTER TABLE `sf_review` 
  ADD CONSTRAINT `fk_sf_review_1`
  FOREIGN KEY (`sf_guard_user_id` )
  REFERENCES `sf_guard_user` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_sf_review_2`
  FOREIGN KEY (`sf_review_type_id` )
  REFERENCES `sf_review_type` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_sf_review_3`
  FOREIGN KEY (`sf_review_status_id` )
  REFERENCES `sf_review_status` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_sf_review_4`
  FOREIGN KEY (`sf_review_id` )
  REFERENCES `sf_review` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_sf_review_4` (`sf_review_id` ASC) ;

ALTER TABLE `sf_review_attach` DROP FOREIGN KEY `sf_review_attach_FK_1` ;

ALTER TABLE `sf_review_attach` 
  ADD CONSTRAINT `fk_sf_review_attach_1`
  FOREIGN KEY (`sf_review_id` )
  REFERENCES `sf_review` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `sf_review_moderation` DROP FOREIGN KEY `sf_review_moderation_FK_1` , DROP FOREIGN KEY `sf_review_moderation_FK_2` ;

ALTER TABLE `sf_review_moderation` 
  ADD CONSTRAINT `fk_sf_review_moderation_1`
  FOREIGN KEY (`reason_id` )
  REFERENCES `sf_review_reason` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_sf_review_moderation_2`
  FOREIGN KEY (`sf_review_id` )
  REFERENCES `sf_review` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `sf_review_type` ADD COLUMN `model` VARCHAR(45) NULL DEFAULT NULL  AFTER `max_value` , ADD COLUMN `module` VARCHAR(45) NULL DEFAULT NULL  AFTER `model` ;

ALTER TABLE `sf_review_type_entity` DROP FOREIGN KEY `sf_review_type_entity_FK_1` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

