ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `imagen` VARCHAR(50) NULL DEFAULT NULL  AFTER `vanity` 
, DROP INDEX `uniq_user_email` 
, ADD UNIQUE INDEX `uniq_user_email` (`email` ASC) ;

ALTER TABLE `voota`.`sf_guard_user_profile` DROP COLUMN `email` 
, DROP INDEX `uniq_user_email` ;

ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `codigo` VARCHAR(45) NULL DEFAULT NULL  AFTER `imagen` , ADD COLUMN `sf_guard_user_profilecol` VARCHAR(45) NULL DEFAULT NULL  AFTER `imagen` ;


ALTER TABLE `voota`.`sf_guard_user_profile` 
ADD UNIQUE INDEX `uniq_sf_guard_user_profile_vanity` (`vanity` ASC) ;
