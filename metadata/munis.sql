

# Cargar los que faltan de cuenca
delete from institucion_i18n where id >= 8198;
delete from institucion where id >= 8198;

insert into institucion (geo_id)
	select id from geo where id >= 8198;

insert into institucion_i18n (id, culture, vanity, nombre_corto, nombre)
select institucion.id, 'es'
	, concat('Ayuntamiento-', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ayuntamiento ', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ayuntamiento de ', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	from geo, institucion
where institucion.geo_id = geo.id
and geo.id >= 8198;

insert into institucion_i18n (id, culture, vanity, nombre_corto, nombre)
select institucion.id, 'ca'
	, concat('Ajuntament-', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ajuntament ', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ajuntament de ', replace(replace(replace(geo.nombre, ' ', '-'),'(','-'),')','-')) 
	from geo, institucion
where institucion.geo_id = geo.id
and geo.id >= 8198;

update concejal set geo_id = null, institucion_id = null;
update concejal, institucion
	set concejal.institucion_id = institucion.id
where concejal.geo_id = institucion.geo_id
;#and concejal.institucion_id is null;

select distinct municipio_id, municipio from concejal where institucion_id is null;


select distinct count(*)
from concejal c, politico_institucion pi
where c.institucion_id = pi.institucion_id
and c.posicion = 1
and pi.cargo = 'AL';

select count(*) from concejal c 
where posicion = 1;

select count(*) from concejal c, institucion i
where c.geo_id = i.geo_id

# Copia tabla de concejales
# Borrar alcaldes repetidos
select distinct count(*)
from concejal c, politico_institucion pi
where c.institucion_id = pi.institucion_id
and c.posicion = 1
and pi.cargo = 'AL';

select nombre, apellidos, partido, concat(geo_id, "_", posicion) as pais, count(*) as num
from concejal
group by nombre, apellidos, partido , pais
order by num desc

select max(id) from politico;
insert into politico (nombre, apellidos, partido_txt, pais) select nombre, apellidos, partido, concat(geo_id, "_", posicion) as pais  from concejal;

alter table politico add index p1 (nombre asc, apellidos asc);
alter table concejal add index c1 (nombre asc, apellidos asc);

insert into politico_i18n (id, culture, bio) 
	select p.id, 'es', concat('Concejal de ', i.nombre,' 2007')
	from concejal c, politico p, institucion_i18n i
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and concat(c.geo_id, "_", c.posicion) = p.pais
	and i.id = c.institucion_id and i.culture = 'es';

insert into politico_i18n (id, culture, bio) 
	select p.id, 'ca', concat('Regidor de ', i.nombre,' 2007')
	from concejal c, politico p, institucion_i18n i
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and concat(c.geo_id, "_", c.posicion) = p.pais
	and i.id = c.institucion_id and i.culture = 'ca';

delete from politico_institucion where politico_id > 10550;
insert into politico_institucion (politico_id, institucion_id, cargo)
	select p.id, c.institucion_id, 'CJ'
	from concejal c, politico p
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and concat(c.geo_id, "_", c.posicion) = p.pais
	and institucion_id is not null
	;

alter table politico drop index p1;


select institucion_id from concejal where institucion_id is not null order by institucion_id desc;

update politico, partido
set politico.partido_id = partido.id
where politico.partido_txt = partido.abreviatura
and politico.partido_id is null
and politico.id > 10550;

select count(*) from  concejal where institucion_id is null;

select * from politico_institucion pi
inner join politico p on p.id = pi.politico_id where institucion_id = 4130

# php symfony genVanity --env=dev --table=politico
