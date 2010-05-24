select * from geo where nombre in (
	select muni.nombre
	from geo muni
	inner join geo prov on prov.id = muni.geo_id
	inner join geo comu on comu.id = prov.geo_id
	inner join geo pais on pais.id = comu.geo_id
	where pais.id = 1
	group by prov.id, muni.nombre
	having count(*) > 1
	order by count(*) desc
)
and id not in (select geo_id from institucion);

select distinct ii.* from institucion i
inner join institucion_i18n ii on (i.id = ii.id and culture ='es')
where geo_id in (605,731,7771,7772,7773,7774,7775,7776,7777,7779,7780,7781,7783,7784,7786,7787,7788,7789,7790,7791,7792,7794,7795,7796,7798,7799)
and i.id not in (select institucion_id from politico_institucion);

#delete from institucion_i18n where id in (7724,7725,7741,7742,7743,7744,7745,7747,7748,7749,7751,7752);
#delete from institucion where id in (7724,7725,7741,7742,7743,7744,7745,7747,7748,7749,7751,7752);
#delete from geo where id = 605;

select count(*)
from concejal, geo muni, geo prov, institucion i
where concejal.municipio = muni.nombre
and prov.id = muni.geo_id
and prov.codigo = concejal.provincia_id
and i.geo_id = muni.id
;#and concejal.geo_id is null;

######################
#Asignar geo de municipio correcto
######################
UPDATE concejal, geo muni, geo prov
SET concejal.geo_id = muni.id
where concejal.municipio = muni.nombre
and prov.id = muni.geo_id
and prov.codigo = concejal.provincia_id
;#and concejal.geo_id is null;

select distinct municipio_id, provincia_id, municipio from concejal where geo_id is null order by provincia_id, municipio;

select muni.id, prov.codigo, muni.nombre
from geo muni
inner join geo prov on prov.id = muni.geo_id
where prov.codigo is not null
order by prov.codigo, muni.nombre;

select * 
from institucion 
inner join institucion_i18n on institucion_i18n.id = institucion.id
where geo_id in (select id from geo where geo_id in (7850) and id between 8099 and 8194);

delete from institucion_i18n where id not in (select institucion_id from politico_institucion);
delete from institucion where id not in (select institucion_id from politico_institucion);
delete from geo where nombre ='';

delete from c
using concejal c, politico p
where lower(concat(c.nombre, ' ', c.apellidos))  = lower(concat(p.nombre, ' ', p.apellidos)) ;

update politico_institucion pi, institucion_i18n ii
set cargo = 'AL'
where ii.id = pi.institucion_id
and ii.culture = 'es'
and ii.nombre like 'Ayuntamiento %';

select distinct municipio_id, provincia_id, municipio from concejal where geo_id is null;

select id, nombre
	, concat('Ayuntamiento-', replace(replace(replace(nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ayuntamiento ', replace(replace(replace(nombre, ' ', '-'),'(','-'),')','-')) 
	, concat('Ayuntamiento de ', replace(replace(replace(nombre, ' ', '-'),'(','-'),')','-')) 
	from geo where id >= 8198;

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

###########################
# Asignar institucion (ayuntamiento)
###########################
update concejal set institucion_id = null;
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

select distinct count(*)
from concejal c
where posicion = 1;

###########################
# Eliminar alcaldes que ya tenemos
###########################
delete from c
using concejal c, politico_institucion pi
where c.institucion_id = pi.institucion_id
and c.posicion = 1 
and pi.cargo = 'AL';

