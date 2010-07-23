ALTER TABLE `voota`.`propuesta` ADD COLUMN `partido_video1_id` INT(11) NULL DEFAULT NULL  AFTER `vanity` , ADD COLUMN `partido_video2_id` INT(11) NULL DEFAULT NULL  AFTER `partido_video1_id` , ADD COLUMN `url_video_1` VARCHAR(150) NULL DEFAULT NULL  AFTER `vanity` , ADD COLUMN `url_video_2` VARCHAR(150) NULL DEFAULT NULL  AFTER `partido_video1_id` , 
  ADD CONSTRAINT `fk_propuesta_2`
  FOREIGN KEY (`partido_video1_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_propuesta_3`
  FOREIGN KEY (`partido_video2_id` )
  REFERENCES `voota`.`partido` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_propuesta_2` (`partido_video1_id` ASC) 
, ADD INDEX `fk_propuesta_3` (`partido_video2_id` ASC) ;
