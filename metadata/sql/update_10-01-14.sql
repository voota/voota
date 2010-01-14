SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `voota`.`partido_i18n` (
  `id` INT(11) NOT NULL DEFAULT NULL ,
  `culture` VARCHAR(7) NOT NULL ,
  `nombre` VARCHAR(150) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `culture`) ,
  INDEX `fk_partido_i18n_1` (`id` ASC) ,
  CONSTRAINT `fk_partido_i18n_1`
    FOREIGN KEY (`id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

insert into partido_i18n (id, culture, nombre) select id, 'es', nombre from partido;
insert into partido_i18n (id, culture, nombre) select id, 'ca', nombre from partido;

ALTER TABLE `voota`.`partido_i18n` CHANGE COLUMN `nombre` `nombre` VARCHAR(150) NOT NULL  ;
ALTER TABLE `voota`.`partido` DROP COLUMN `nombre` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

