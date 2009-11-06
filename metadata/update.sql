ALTER TABLE `voota`.`sf_review` ADD COLUMN `modified_at` DATETIME NULL DEFAULT NULL  AFTER `text` ;


ALTER TABLE `voota`.`politico` ADD COLUMN `hijas` INT(11) NULL DEFAULT NULL  AFTER `sumd` , ADD COLUMN `hijos` INT(11) NULL DEFAULT NULL  AFTER `sumd` , ADD COLUMN `relacion` CHAR(2) NULL DEFAULT NULL  AFTER `sumd`;



