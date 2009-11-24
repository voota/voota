insert into politico_institucion (politico_id, institucion_id) select id, 7 from politico where id >= 1197 and id <= 1271; --euskadi
insert into politico_institucion (politico_id, institucion_id) select id, 8 from politico where id >= 1272 and id <= 1389; -- andalucia
insert into politico_institucion (politico_id, institucion_id) select id, 9 from politico where id >= 1390 and id <= 1440; -- castilla la mancha
insert into politico_institucion (politico_id, institucion_id) select id, 11 from politico where id >= 1441 and id <= 1500; -- canarias
insert into politico_institucion (politico_id, institucion_id) select id, 16 from politico where id >= 1615 and id <= 1713; -- valencia
insert into politico_institucion (politico_id, institucion_id) select id, 12 from politico where id >= 1550 and id <= 1614; -- extremadura
insert into politico_institucion (politico_id, institucion_id) select id, 10 from politico where id >= 1714 and id <= 1762; -- murcia



ALTER TABLE `voota`.`sf_guard_user_profile` ADD COLUMN `papel_voota` VARCHAR(280) NULL DEFAULT NULL  AFTER `codigo` ;

