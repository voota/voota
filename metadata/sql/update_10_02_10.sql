SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `fb_publish_cambios_perfil` INT(11) NULL DEFAULT 1  AFTER `email_hash` , ADD COLUMN `fb_publish_votos_otros` INT(11) NULL DEFAULT 1  AFTER `email_hash` , ADD COLUMN `fb_publish_votos` INT(11) NULL DEFAULT 1  AFTER `email_hash` , CHANGE COLUMN `facebook_uid` `facebook_uid` VARCHAR(128) NULL DEFAULT NULL  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

