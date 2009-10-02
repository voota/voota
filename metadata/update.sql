ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `imagen` VARCHAR(50) NULL DEFAULT NULL  AFTER `vanity` 
, DROP INDEX `uniq_user_email` 
, ADD UNIQUE INDEX `uniq_user_email` (`email` ASC) ;

ALTER TABLE `voota`.`sf_guard_user_profile` DROP COLUMN `email` 
, DROP INDEX `uniq_user_email` ;
