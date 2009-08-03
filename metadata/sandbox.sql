SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `voota` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `voota`;

-- -----------------------------------------------------
-- Table `voota`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(150) NOT NULL ,
  `clave` VARCHAR(45) NOT NULL ,
  `acepta_mensajes` CHAR(1) NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(150) NULL ,
  `fecha_nacimiento` DATE NULL ,
  `pais` VARCHAR(45) NULL ,
  `formacion` VARCHAR(255) NULL ,
  `residencia` VARCHAR(45) NULL ,
  `presentacion` VARCHAR(500) NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`politico`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`politico` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url_key` VARCHAR(45) NOT NULL ,
  `alias` VARCHAR(45) NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(150) NOT NULL ,
  `sexo` CHAR(1) NULL ,
  `fecha_nacimiento` DATE NULL ,
  `pais` VARCHAR(45) NULL ,
  `formacion` VARCHAR(255) NULL ,
  `residencia` VARCHAR(45) NULL ,
  `presentacion` VARCHAR(500) NULL ,
  `usuario_id` INT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuario` (`usuario_id` ASC) ,
  CONSTRAINT `fk_usuario`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `voota`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`partido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`partido` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `abreviatura` VARCHAR(8) NULL ,
  `color` VARCHAR(8) NULL ,
  `web` VARCHAR(150) NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`region`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`region` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`institucion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`institucion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `region_id` INT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_region` (`region_id` ASC) ,
  CONSTRAINT `fk_region`
    FOREIGN KEY (`region_id` )
    REFERENCES `voota`.`region` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`eleccion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`eleccion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(150) NOT NULL ,
  `fecha` DATE NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`lista`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`lista` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `partido_id` INT NOT NULL ,
  `eleccion_id` INT NOT NULL ,
  `created_at` DATETIME NULL ,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`eleccion_institucion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`eleccion_institucion` (
  `eleccion_id` INT NOT NULL ,
  `institucion_id` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`eleccion_id`, `institucion_id`) ,
  INDEX `fk_eleccion` (`eleccion_id` ASC) ,
  INDEX `fk_institucion` (`institucion_id` ASC) ,
  CONSTRAINT `fk_eleccion`
    FOREIGN KEY (`eleccion_id` )
    REFERENCES `voota`.`eleccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_institucion`
    FOREIGN KEY (`institucion_id` )
    REFERENCES `voota`.`institucion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`politico_lista`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`politico_lista` (
  `politico_id` INT NOT NULL ,
  `lista_id` INT NOT NULL ,
  `orden` INT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`politico_id`, `lista_id`) ,
  INDEX `fk_politico` (`politico_id` ASC) ,
  INDEX `fk_lista` (`lista_id` ASC) ,
  CONSTRAINT `fk_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista`
    FOREIGN KEY (`lista_id` )
    REFERENCES `voota`.`lista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`media`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`media` (
  `idmedia` INT NOT NULL ,
  `tipo` CHAR(1) NULL ,
  `idpolitico` INT NULL ,
  `idpartido` INT NULL ,
  PRIMARY KEY (`idmedia`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`opinion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`opinion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `valor` INT NULL ,
  `texto` VARCHAR(500) NULL ,
  `usuario_id` INT NOT NULL ,
  `partido_id` INT NULL ,
  `politico_id` INT NULL ,
  `opinion_id` INT NULL ,
  `created_at` DATETIME NULL ,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`imagen`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`imagen` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tipo` CHAR(1) NULL ,
  `partido_id` INT NULL COMMENT '	' ,
  `politico_id` INT NULL ,
  `opinion_id` INT NULL ,
  `created_at` DATETIME NULL ,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`promocion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`promocion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fecha_inicio` DATE NOT NULL ,
  `fecha_fin` DATE NOT NULL ,
  `partido_id` INT NULL ,
  `politico_id` INT NULL ,
  `created_at` DATETIME NULL ,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`enlace`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`enlace` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(150) NOT NULL ,
  `tipo` INT NULL ,
  `partido_id` INT NULL ,
  `politico_id` INT NULL ,
  `orden` INT NULL ,
  `mostrar` CHAR(1) NULL ,
  `created_at` DATETIME NULL ,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`afiliacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`afiliacion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fecha_inicio` DATE NULL ,
  `fecha_fin` DATE NULL ,
  `partido_id` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_a_partido` (`partido_id` ASC) ,
  CONSTRAINT `fk_a_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`partido_afiliacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`partido_afiliacion` (
  `partido_id` INT NOT NULL ,
  `afiliacion_id` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`partido_id`, `afiliacion_id`) ,
  INDEX `fk_paa_partido` (`partido_id` ASC) ,
  INDEX `fk_paa_afiliacion` (`afiliacion_id` ASC) ,
  CONSTRAINT `fk_paa_partido`
    FOREIGN KEY (`partido_id` )
    REFERENCES `voota`.`partido` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_paa_afiliacion`
    FOREIGN KEY (`afiliacion_id` )
    REFERENCES `voota`.`afiliacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `voota`.`politico_afiliacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `voota`.`politico_afiliacion` (
  `politico_id` INT NOT NULL ,
  `afiliacion_id` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`politico_id`, `afiliacion_id`) ,
  INDEX `fk_poa_politico` (`politico_id` ASC) ,
  INDEX `fk_poa_afiliacion` (`afiliacion_id` ASC) ,
  CONSTRAINT `fk_poa_politico`
    FOREIGN KEY (`politico_id` )
    REFERENCES `voota`.`politico` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_poa_afiliacion`
    FOREIGN KEY (`afiliacion_id` )
    REFERENCES `voota`.`afiliacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
