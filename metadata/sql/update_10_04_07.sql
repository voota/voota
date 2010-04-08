SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`partido_i18n` DROP COLUMN `sumd` , DROP COLUMN `sumu` ;

ALTER TABLE `voota`.`partido` ADD COLUMN `sumd` INT(11) NOT NULL DEFAULT 0  AFTER `is_main` , ADD COLUMN `sumu` INT(11) NOT NULL DEFAULT 0  AFTER `is_main` ;

ALTER TABLE `voota`.`politico` ADD COLUMN `sumd` INT(11) NOT NULL DEFAULT 0  AFTER `hijas` , ADD COLUMN `sumu` INT(11) NOT NULL DEFAULT 0  AFTER `hijas` ;

ALTER TABLE `voota`.`politico_i18n` DROP COLUMN `sumd` , DROP COLUMN `sumu` ;


UPDATE politico
INNER JOIN (
	SELECT r.entity_id, sum(r.value=1) as cnt, sum(r.value=-1) as cntd
	FROM sf_review r
	WHERE r.sf_review_type_id = 1
	GROUP BY r.entity_id
) r ON politico.id=r.entity_id
SET sumu = r.cnt
, sumd = r.cntd;

UPDATE partido
INNER JOIN (
	SELECT r.entity_id, sum(r.value=1) as cnt, sum(r.value=-1) as cntd
	FROM sf_review r
	WHERE r.sf_review_type_id = 2
	GROUP BY r.entity_id
) r ON partido.id=r.entity_id
SET sumu = r.cnt
, sumd = r.cntd;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


