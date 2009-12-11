insert into politico_institucion (politico_id, institucion_id) select id, 7 from politico where id >= 1197 and id <= 1271; --euskadi
insert into politico_institucion (politico_id, institucion_id) select id, 8 from politico where id >= 1272 and id <= 1389; -- andalucia
insert into politico_institucion (politico_id, institucion_id) select id, 9 from politico where id >= 1390 and id <= 1440; -- castilla la mancha
insert into politico_institucion (politico_id, institucion_id) select id, 11 from politico where id >= 1441 and id <= 1500; -- canarias
insert into politico_institucion (politico_id, institucion_id) select id, 16 from politico where id >= 1615 and id <= 1713; -- valencia
insert into politico_institucion (politico_id, institucion_id) select id, 12 from politico where id >= 1550 and id <= 1614; -- extremadura
insert into politico_institucion (politico_id, institucion_id) select id, 10 from politico where id >= 1714 and id <= 1762; -- murcia

insert into politico_institucion (politico_id, institucion_id) select id, 17 from politico where id >= 1968 and id <= 2037; -- aragon
insert into politico_institucion (politico_id, institucion_id) select id, 15 from politico where id >= 2038 and id <= 2087; -- navarra
insert into politico_institucion (politico_id, institucion_id) select id, 21 from politico where id >= 2088 and id <= 2162; -- galicia





CREATE TABLE IF NOT EXISTS `politico_i18n` (
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  `formacion` varchar(255) DEFAULT NULL,
  `presentacion` varchar(500) DEFAULT NULL,
  `bio` longtext,
  PRIMARY KEY (`id`,`culture`),
  KEY `fk_politico_i18n_1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
truncate politico_i18n;
insert into politico_i18n (id, culture, formacion, presentacion, bio)
select id, 'es', formacion, presentacion, bio from politico where id not in (
  select politico_id from politico_institucion where institucion_id in (16,4) 
);
insert into politico_i18n (id, culture, formacion, presentacion, bio)
select id, 'ca', formacion, presentacion, bio from politico where id in (
  select politico_id from politico_institucion where institucion_id in (16,4) 
);

ALTER TABLE `voota`.`sf_review` ADD COLUMN `balance` INT(11) NULL DEFAULT 0  AFTER `culture` , ADD COLUMN `sf_review_id` INT(11) NULL DEFAULT NULL  AFTER `culture` , CHANGE COLUMN `entity_id` `entity_id` INT(11) NULL DEFAULT NULL  , CHANGE COLUMN `sf_review_type_id` `sf_review_type_id` INT(11) NULL DEFAULT NULL  , 
  ADD CONSTRAINT `fk_sf_review_4`
  FOREIGN KEY (`sf_review_id` )
  REFERENCES `voota`.`sf_review` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_sf_review_4` (`sf_review_id` ASC) ;

ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `mails_comentarios` INT(11) NOT NULL DEFAULT 1  AFTER `papel_voota` , ADD COLUMN `mails_contacto` INT(11) NOT NULL DEFAULT 1  AFTER `mails_comentarios` , ADD COLUMN `mails_noticias` INT(11) NOT NULL DEFAULT 1  AFTER `mails_comentarios` , ADD COLUMN `mails_seguidor` INT(11) NOT NULL DEFAULT 1  AFTER `mails_contacto` ;


