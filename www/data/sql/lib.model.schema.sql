
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- afiliacion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `afiliacion`;


CREATE TABLE `afiliacion`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`fecha_inicio` DATE,
	`fecha_fin` DATE,
	`partido_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_a_partido`(`partido_id`),
	CONSTRAINT `afiliacion_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- eleccion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `eleccion`;


CREATE TABLE `eleccion`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(150)  NOT NULL,
	`fecha` DATE,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- eleccion_institucion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `eleccion_institucion`;


CREATE TABLE `eleccion_institucion`
(
	`eleccion_id` INTEGER(11)  NOT NULL,
	`institucion_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`eleccion_id`,`institucion_id`),
	KEY `fk_institucion`(`institucion_id`),
	KEY `fk_eleccion`(`eleccion_id`),
	CONSTRAINT `eleccion_institucion_FK_1`
		FOREIGN KEY (`eleccion_id`)
		REFERENCES `eleccion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `eleccion_institucion_FK_2`
		FOREIGN KEY (`institucion_id`)
		REFERENCES `institucion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- enlace
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `enlace`;


CREATE TABLE `enlace`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(150)  NOT NULL,
	`tipo` INTEGER(11),
	`partido_id` INTEGER(11),
	`politico_id` INTEGER(11),
	`orden` INTEGER(11),
	`mostrar` CHAR(1),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_e_partido`(`partido_id`),
	KEY `fk_e_politico`(`politico_id`),
	CONSTRAINT `enlace_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `enlace_FK_2`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- imagen
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imagen`;


CREATE TABLE `imagen`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`tipo` CHAR(1),
	`partido_id` INTEGER(11),
	`politico_id` INTEGER(11),
	`opinion_id` INTEGER(11),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_i_partido`(`partido_id`),
	KEY `fk_i_politico`(`politico_id`),
	KEY `fk_i_opinion`(`opinion_id`),
	CONSTRAINT `imagen_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `imagen_FK_2`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `imagen_FK_3`
		FOREIGN KEY (`opinion_id`)
		REFERENCES `opinion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- institucion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `institucion`;


CREATE TABLE `institucion`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(150)  NOT NULL,
	`region_id` INTEGER(11),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_region`(`region_id`),
	CONSTRAINT `institucion_FK_1`
		FOREIGN KEY (`region_id`)
		REFERENCES `region` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- lista
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `lista`;


CREATE TABLE `lista`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`partido_id` INTEGER(11)  NOT NULL,
	`eleccion_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_l_partido`(`partido_id`),
	KEY `fk_l_eleccion`(`eleccion_id`),
	CONSTRAINT `lista_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `lista_FK_2`
		FOREIGN KEY (`eleccion_id`)
		REFERENCES `eleccion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- media
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `media`;


CREATE TABLE `media`
(
	`idmedia` INTEGER(11)  NOT NULL,
	`tipo` CHAR(1),
	`idpolitico` INTEGER(11),
	`idpartido` INTEGER(11),
	PRIMARY KEY (`idmedia`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opinion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opinion`;


CREATE TABLE `opinion`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`valor` INTEGER(11),
	`texto` VARCHAR(500),
	`usuario_id` INTEGER(11)  NOT NULL,
	`partido_id` INTEGER(11),
	`politico_id` INTEGER(11),
	`opinion_id` INTEGER(11),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_o_usuario`(`usuario_id`),
	KEY `fk_o_partido`(`partido_id`),
	KEY `fk_o_politico`(`politico_id`),
	KEY `fk_opinion`(`opinion_id`),
	CONSTRAINT `opinion_FK_1`
		FOREIGN KEY (`usuario_id`)
		REFERENCES `usuario` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `opinion_FK_2`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `opinion_FK_3`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `opinion_FK_4`
		FOREIGN KEY (`opinion_id`)
		REFERENCES `opinion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- partido
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `partido`;


CREATE TABLE `partido`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(150)  NOT NULL,
	`abreviatura` VARCHAR(8),
	`color` VARCHAR(8),
	`web` VARCHAR(150),
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- partido_afiliacion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `partido_afiliacion`;


CREATE TABLE `partido_afiliacion`
(
	`partido_id` INTEGER(11)  NOT NULL,
	`afiliacion_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`partido_id`,`afiliacion_id`),
	KEY `fk_paa_partido`(`partido_id`),
	KEY `fk_paa_afiliacion`(`afiliacion_id`),
	CONSTRAINT `partido_afiliacion_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `partido_afiliacion_FK_2`
		FOREIGN KEY (`afiliacion_id`)
		REFERENCES `afiliacion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- politico
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `politico`;


CREATE TABLE `politico`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`alias` VARCHAR(45),
	`nombre` VARCHAR(45)  NOT NULL,
	`apellidos` VARCHAR(150)  NOT NULL,
	`sexo` CHAR(1),
	`fecha_nacimiento` DATE,
	`pais` VARCHAR(45),
	`formacion` VARCHAR(255),
	`residencia` VARCHAR(45),
	`presentacion` VARCHAR(500),
	`usuario_id` INTEGER(11),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_usuario`(`usuario_id`),
	CONSTRAINT `politico_FK_1`
		FOREIGN KEY (`usuario_id`)
		REFERENCES `usuario` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- politico_afiliacion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `politico_afiliacion`;


CREATE TABLE `politico_afiliacion`
(
	`politico_id` INTEGER(11)  NOT NULL,
	`afiliacion_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`politico_id`,`afiliacion_id`),
	KEY `fk_poa_politico`(`politico_id`),
	KEY `fk_poa_afiliacion`(`afiliacion_id`),
	CONSTRAINT `politico_afiliacion_FK_1`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `politico_afiliacion_FK_2`
		FOREIGN KEY (`afiliacion_id`)
		REFERENCES `afiliacion` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- politico_lista
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `politico_lista`;


CREATE TABLE `politico_lista`
(
	`politico_id` INTEGER(11)  NOT NULL,
	`lista_id` INTEGER(11)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`politico_id`,`lista_id`),
	KEY `fk_politico`(`politico_id`),
	KEY `fk_lista`(`lista_id`),
	CONSTRAINT `politico_lista_FK_1`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `politico_lista_FK_2`
		FOREIGN KEY (`lista_id`)
		REFERENCES `lista` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- promocion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `promocion`;


CREATE TABLE `promocion`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`fecha_inicio` DATE  NOT NULL,
	`fecha_fin` DATE  NOT NULL,
	`partido_id` INTEGER(11),
	`politico_id` INTEGER(11),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `fk_pr_partido`(`partido_id`),
	KEY `fk_pr_politico`(`politico_id`),
	CONSTRAINT `promocion_FK_1`
		FOREIGN KEY (`partido_id`)
		REFERENCES `partido` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	CONSTRAINT `promocion_FK_2`
		FOREIGN KEY (`politico_id`)
		REFERENCES `politico` (`id`)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- region
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `region`;


CREATE TABLE `region`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(150)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- usuario
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;


CREATE TABLE `usuario`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(150)  NOT NULL,
	`clave` VARCHAR(45)  NOT NULL,
	`acepta_mensajes` CHAR(1),
	`nombre` VARCHAR(45)  NOT NULL,
	`apellidos` VARCHAR(150),
	`fecha_nacimiento` DATE,
	`pais` VARCHAR(45),
	`formacion` VARCHAR(255),
	`residencia` VARCHAR(45),
	`presentacion` VARCHAR(500),
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
