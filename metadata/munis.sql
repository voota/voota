alter table politico add index p2 (pais asc);

alter table concejal add column pais varchar(50);
alter table concejal add index c2 (pais asc);
update concejal set pais = concat(geo_id, "_", posicion);

select max(id) from politico; -- 76561

insert into politico (nombre, apellidos, partido_txt, pais) 
	select nombre, apellidos, partido, pais  from concejal where pais like '%_1' and posicion <> 1;

alter table politico add index p1 (nombre asc, apellidos asc);

alter table concejal add index c1 (nombre asc, apellidos asc);

insert into politico_i18n (id, culture, bio) 
	select p.id, 'es', concat('Concejal de ', g.nombre,' (2007 - presente)')
	from concejal c, politico p, institucion i, geo g
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and c.pais = p.pais
	and g.id = i.geo_id
	and i.id = c.institucion_id
	and p.id > 76561;

insert into politico_i18n (id, culture, bio) 
	select p.id, 'ca', concat('Regidor de ', g.nombre,' (2007 - present)')
	from concejal c, politico p, institucion i, geo g
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and c.pais = p.pais
	and g.id = i.geo_id
	and i.id = c.institucion_id
	and p.id > 76561;

insert into politico_institucion (politico_id, institucion_id, cargo)
	select p.id, c.institucion_id, 'CJ'
	from concejal c, politico p
	where c.nombre = p.nombre and c.apellidos = p.apellidos and c.partido = p.partido_txt and c.pais = p.pais
	and institucion_id is not null
	and p.id > 76561;

update politico, partido
	set politico.partido_id = partido.id
	where politico.partido_txt = partido.abreviatura
	and politico.partido_id is null
	and politico.id > 76561;

alter table politico drop index p1;
alter table politico drop index p2;

