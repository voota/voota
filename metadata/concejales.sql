# Crear ayuntamientos de cuenca que faltan
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

# Asignar instituciones
#update concejal set geo_id = null, institucion_id = null;
update concejal, institucion
	set concejal.institucion_id = institucion.id
where concejal.geo_id = institucion.geo_id
;#and concejal.institucion_id is null;

# Copia tabla de concejales
# Borrar alcaldes repetidos
select distinct count(*)
from concejal c, politico_institucion pi
where c.institucion_id = pi.institucion_id
and c.posicion = 1
and pi.cargo = 'AL';

insert into politico (nombre, apellidos, partido_txt, pais) select nombre, apellidos, partido, concat(geo_id, "_", posicion) as pais  from concejal;
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
#delete from politico_institucion where politico_id > 10550;
insert into politico_institucion (politico_id, institucion_id, cargo)
	select p.id, c.institucion_id, 'CJ'
	from concejal c, politico p
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and concat(c.geo_id, "_", c.posicion) = p.pais
	and institucion_id is not null
	;

update politico, partido
set politico.partido_id = partido.id
where politico.partido_txt = partido.abreviatura
and politico.partido_id is null
and politico.id > 10550;

# php symfony genVanity --env=dev --table=politico
