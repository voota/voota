SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `voota`.`eleccion_institucion` (
  `eleccion_id` INT(11) NOT NULL ,
  `institucion_id` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`eleccion_id`, `institucion_id`) ,
  INDEX `fk_ele_inst_eleccion` (`eleccion_id` ASC) ,
  INDEX `fk_ele_inst_institucion` (`institucion_id` ASC) ,
  CONSTRAINT `fk_ele_inst_eleccion`
    FOREIGN KEY (`eleccion_id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ele_inst_institucion`
    FOREIGN KEY (`institucion_id` )
    REFERENCES `voota`.`institucion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`eleccion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `fecha` DATE NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`enlace` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(150) NOT NULL ,
  `tipo` INT(11) NULL DEFAULT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL ,
  `politico_id` INT(11) NULL DEFAULT NULL ,
  `orden` INT(11) NULL DEFAULT NULL ,
  `mostrar` CHAR(1) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_e_partido` (`partido_id` ASC) ,
  INDEX `fk_e_politico` (`politico_id` ASC) ,
  CONSTRAINT `fk_e_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_e_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`geo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`imagen` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tipo` CHAR(1) NULL DEFAULT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL COMMENT '	' ,
  `politico_id` INT(11) NULL DEFAULT NULL ,
  `opinion_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_i_partido` (`partido_id` ASC) ,
  INDEX `fk_i_politico` (`politico_id` ASC) ,
  INDEX `fk_i_opinion` (`opinion_id` ASC) ,
  CONSTRAINT `fk_i_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_i_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_i_opinion`
    FOREIGN KEY (`opinion_id` )
    REFERENCES `voota`.`opinion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`institucion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `region_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_region` (`region_id` ASC) ,
  CONSTRAINT `fk_region`
    FOREIGN KEY (`region_id` )
    REFERENCES `voota`.`geo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`lista` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `partido_id` INT(11) NOT NULL ,
  `eleccion_id` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_l_partido` (`partido_id` ASC) ,
  INDEX `fk_l_eleccion` (`eleccion_id` ASC) ,
  CONSTRAINT `fk_l_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_l_eleccion`
    FOREIGN KEY (`eleccion_id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`media` (
  `idmedia` INT(11) NOT NULL ,
  `tipo` CHAR(1) NULL DEFAULT NULL ,
  `idpolitico` INT(11) NULL DEFAULT NULL ,
  `idpartido` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`idmedia`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`opinion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `valor` INT(11) NULL DEFAULT NULL ,
  `texto` VARCHAR(500) NULL DEFAULT NULL ,
  `usuario_id` INT(11) NOT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL ,
  `politico_id` INT(11) NULL DEFAULT NULL ,
  `opinion_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_o_usuario` (`usuario_id` ASC) ,
  INDEX `fk_o_partido` (`partido_id` ASC) ,
  INDEX `fk_o_politico` (`politico_id` ASC) ,
  INDEX `fk_opinion` (`opinion_id` ASC) ,
  CONSTRAINT `fk_o_usuario`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `voota`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_o_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_o_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opinion`
    FOREIGN KEY (`opinion_id` )
    REFERENCES `voota`.`opinion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`partido_lista` (
  `partido_id` INT(11) NOT NULL ,
  `lista_id` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`lista_id`, `partido_id`) ,
  INDEX `fk_partido` (`partido_id` ASC) ,
  INDEX `fk_lista` (`lista_id` ASC) ,
  CONSTRAINT `fk_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista`
    FOREIGN KEY (`lista_id` )
    REFERENCES `voota`.`lista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`partido` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `abreviatura` VARCHAR(8) NULL DEFAULT NULL ,
  `color` VARCHAR(8) NULL DEFAULT NULL ,
  `web` VARCHAR(150) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_partido_partido` (`partido_id` ASC) ,
  CONSTRAINT `fk_partido_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`politico_lista` (
  `politico_id` INT(11) NOT NULL ,
  `lista_id` INT(11) NOT NULL ,
  `orden` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`politico_id`, `lista_id`) ,
  INDEX `fk_politico` (`politico_id` ASC) ,
  INDEX `fk_politico_lista_lista` (`lista_id` ASC) ,
  CONSTRAINT `fk_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_politico_lista_lista`
    FOREIGN KEY (`lista_id` )
    REFERENCES `voota`.`lista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`politico_temp` (
  `email` VARCHAR(50) NULL DEFAULT NULL ,
  `partido` VARCHAR(50) NULL DEFAULT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `apellidos` VARCHAR(100) NULL DEFAULT NULL ,
  `bio` LONGTEXT NULL DEFAULT NULL  )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`politico` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `url_key` VARCHAR(45) NOT NULL ,
  `alias` VARCHAR(45) NULL DEFAULT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(150) NOT NULL ,
  `email` VARCHAR(45) NULL DEFAULT NULL ,
  `sexo` CHAR(1) NULL DEFAULT NULL ,
  `fecha_nacimiento` DATE NULL DEFAULT NULL ,
  `pais` VARCHAR(45) NULL DEFAULT NULL ,
  `formacion` VARCHAR(255) NULL DEFAULT NULL ,
  `residencia` VARCHAR(45) NULL DEFAULT NULL ,
  `presentacion` VARCHAR(500) NULL DEFAULT NULL ,
  `usuario_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL ,
  `bio` LONGTEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuario` (`usuario_id` ASC) ,
  INDEX `fk_politico_partido` (`partido_id` ASC) ,
  CONSTRAINT `fk_usuario`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `voota`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_politico_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`promocion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `fecha_inicio` DATE NOT NULL ,
  `fecha_fin` DATE NOT NULL ,
  `partido_id` INT(11) NULL DEFAULT NULL ,
  `politico_id` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pr_partido` (`partido_id` ASC) ,
  INDEX `fk_pr_politico` (`politico_id` ASC) ,
  CONSTRAINT `fk_pr_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pr_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(150) NOT NULL ,
  `clave` VARCHAR(45) NOT NULL ,
  `acepta_mensajes` CHAR(1) NULL DEFAULT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(150) NULL DEFAULT NULL ,
  `fecha_nacimiento` DATE NULL DEFAULT NULL ,
  `pais` VARCHAR(45) NULL DEFAULT NULL ,
  `formacion` VARCHAR(255) NULL DEFAULT NULL ,
  `residencia` VARCHAR(45) NULL DEFAULT NULL ,
  `presentacion` VARCHAR(500) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `voota`.`voto` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `uid` VARCHAR(20) NULL DEFAULT NULL ,
  `valor` INT(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

