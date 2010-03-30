SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `voota`.`partido_i18n` ADD COLUMN `sumd` INT(11) NOT NULL DEFAULT 0  AFTER `presentacion` , ADD COLUMN `sumu` INT(11) NOT NULL DEFAULT 0  AFTER `presentacion` ;

ALTER TABLE `voota`.`partido` DROP COLUMN `sumd` , DROP COLUMN `sumu` ;

ALTER TABLE `voota`.`politico` DROP COLUMN `sumd` , DROP COLUMN `sumu` ;

ALTER TABLE `voota`.`politico_i18n` ADD COLUMN `sumd` INT(11) NOT NULL DEFAULT 0  AFTER `bio` , ADD COLUMN `sumu` INT(11) NOT NULL DEFAULT 0  AFTER `bio` ;

UPDATE politico_i18n
INNER JOIN (
	SELECT r.entity_id, count(*) as cnt
	FROM sf_review r
	WHERE r.sf_review_type_id = 1
	AND (r.culture = 'es' OR r.culture IS NULL)
	GROUP BY r.entity_id
) r ON politico_i18n.id=r.entity_id
SET sumu = r.cnt
WHERE culture = 'es';

UPDATE politico_i18n
INNER JOIN (
	SELECT r.entity_id, count(*) as cnt
	FROM sf_review r
	WHERE r.sf_review_type_id = 1
	AND (r.culture = 'ca' OR r.culture IS NULL)
	GROUP BY r.entity_id
) r ON politico_i18n.id=r.entity_id
SET sumu = r.cnt
WHERE culture = 'ca';

UPDATE partido_i18n
INNER JOIN (
	SELECT r.entity_id, count(*) as cnt
	FROM sf_review r
	WHERE r.sf_review_type_id = 2
	AND (r.culture = 'es' OR r.culture IS NULL)
	GROUP BY r.entity_id
) r ON partido_i18n.id=r.entity_id
SET sumu = r.cnt
WHERE culture = 'es';

UPDATE partido_i18n
INNER JOIN (
	SELECT r.entity_id, count(*) as cnt
	FROM sf_review r
	WHERE r.sf_review_type_id = 2
	AND (r.culture = 'ca' OR r.culture IS NULL)
	GROUP BY r.entity_id
) r ON partido_i18n.id=r.entity_id
SET sumu = r.cnt
WHERE culture = 'ca';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

