
ALTER TABLE `voota`.`sf_review_type_entity` DROP COLUMN `score` , ADD COLUMN `value` INT(11) NOT NULL  AFTER `date` 
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`sf_review_type_id`, `entity_id`, `date`, `value`) ;

ALTER TABLE `voota`.`politico` ADD COLUMN `sumd` INT(11) NOT NULL DEFAULT 0  AFTER `lugar_nacimiento` , ADD COLUMN `sumu` INT(11) NOT NULL DEFAULT 0  AFTER `lugar_nacimiento` , DROP FOREIGN KEY `fk_politico_partido` ;

