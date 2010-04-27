SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`oauth_consumer_token` CHANGE COLUMN `oct_token_type` `oct_token_type` ENUM('request','authorized','access') NULL DEFAULT NULL  ;

ALTER TABLE `voota`.`oauth_log` CHANGE COLUMN `olg_received` `olg_received` TEXT NOT NULL  , CHANGE COLUMN `olg_sent` `olg_sent` TEXT NOT NULL  , CHANGE COLUMN `olg_base_string` `olg_base_string` TEXT NOT NULL  , CHANGE COLUMN `olg_notes` `olg_notes` TEXT NOT NULL  ;

ALTER TABLE `voota`.`oauth_server_registry` CHANGE COLUMN `osr_status` `osr_status` VARCHAR(16) NOT NULL  , CHANGE COLUMN `osr_requester_name` `osr_requester_name` VARCHAR(64) NOT NULL  , CHANGE COLUMN `osr_requester_email` `osr_requester_email` VARCHAR(64) NOT NULL  , CHANGE COLUMN `osr_callback_uri` `osr_callback_uri` VARCHAR(255) NOT NULL  , CHANGE COLUMN `osr_application_uri` `osr_application_uri` VARCHAR(255) NOT NULL  , CHANGE COLUMN `osr_application_title` `osr_application_title` VARCHAR(80) NOT NULL  , CHANGE COLUMN `osr_application_descr` `osr_application_descr` TEXT NOT NULL  , CHANGE COLUMN `osr_application_notes` `osr_application_notes` TEXT NOT NULL  , CHANGE COLUMN `osr_application_type` `osr_application_type` VARCHAR(20) NOT NULL  ;

ALTER TABLE `voota`.`oauth_server_token` CHANGE COLUMN `ost_token_type` `ost_token_type` ENUM('request','access') NULL DEFAULT NULL  , CHANGE COLUMN `ost_referrer_host` `ost_referrer_host` VARCHAR(128) NOT NULL  ;

ALTER TABLE `voota`.`sf_review` ADD COLUMN `source` VARCHAR(64) NULL DEFAULT NULL  AFTER `to_fb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

