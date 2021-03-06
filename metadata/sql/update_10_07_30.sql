SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `tw_publish_cambios_perfil` TINYINT(4) NULL DEFAULT NULL  AFTER `anonymous` , ADD COLUMN `tw_publish_votos_otros` TINYINT(4) NULL DEFAULT NULL  AFTER `anonymous` , ADD COLUMN `tw_publish_votos` TINYINT(4) NULL DEFAULT NULL  AFTER `anonymous` ;

ALTER TABLE `voota`.`sf_review` ADD COLUMN `sf_reviewcol` VARCHAR(45) NULL DEFAULT NULL  AFTER `source` , ADD COLUMN `to_tw` TINYINT(4) NOT NULL DEFAULT 0  AFTER `anonymous` ;

ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `tw_oauth_token_secret` VARCHAR(45) NULL DEFAULT NULL  AFTER `tw_publish_cambios_perfil` , ADD COLUMN `tw_oauth_token` VARCHAR(45) NULL DEFAULT NULL  AFTER `tw_publish_cambios_perfil` ;

ALTER TABLE `voota`.`sf_guard_user_profile` CHANGE COLUMN `tw_oauth_token` `tw_oauth_token` VARCHAR(80) NULL DEFAULT NULL  , CHANGE COLUMN `tw_oauth_token_secret` `tw_oauth_token_secret` VARCHAR(80) NULL DEFAULT NULL  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

