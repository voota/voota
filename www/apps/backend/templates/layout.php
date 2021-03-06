<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>

<div style="border-bottom:1px solid grey;margin-bottom:5px;">
<?php echo image_tag('voota', 'alt=voota') ?>
<br />
Administraci&oacute;n
</div>

<?php if ($sf_user->isAuthenticated()): ?>
<div>
<?php if ($sf_user->hasCredential('admin')) { ?>
	<span style="background-color:white;padding:2px;">
	<?php echo link_to('politicos', 'politico/index') ?>
	<?php echo link_to('partidos', 'partido/index') ?> 
	<?php echo link_to('propuestas', 'propuesta/index') ?> 
	<?php echo link_to('instituciones', 'institucion/index') ?> 
	<?php echo link_to('geos', 'geo/index') ?></span>
<?php } ?>
<?php if ($sf_user->hasCredential('moderator')) { ?>
	| <span style="background-color:white;padding:2px;">
	Sistema de <strong>opiniones:</strong>
	<?php //echo link_to('Moderación', '@sf_review') ?> 
	<?php echo link_to('Moderación', 'sfReview/filter/action?sf_review_filters[value][text]=-1&sf_review_filters[text][is_not_empty]=on&sf_review_filters[is_active]=1') ?> 
	<?php echo link_to('tipos', '@sf_review_type') ?> 
	<?php echo link_to('estados', '@sf_review_status') ?></span> 
<?php } ?>
<?php if ($sf_user->hasCredential('admin')) { ?>
	| <span style="background-color:white;padding:2px;">
	Sistema de <strong>elecciones:</strong>
	<?php echo link_to('elecciones', 'eleccion/index') ?> 
	<?php echo link_to('convocatorias', 'convocatoria/index') ?> 
	<?php echo link_to('listas', 'lista/index') ?>
	<?php echo link_to('circunscripciones', 'circunscripcion/index') ?></span>
<?php } ?>
	| <?php echo link_to('salir', '@sf_guard_signout') ?>
</div>
<?php if ($sf_user->hasCredential('superadmin')) { ?>
	<strong>Administración:</strong>
	<?php echo link_to('usuarios', '@sf_guard_user') ?> 
	<?php echo link_to('grupos', '@sf_guard_group') ?> 
	<?php echo link_to('permisos', '@sf_guard_permission') ?> 
<?php } ?>
<?php endif; ?>

    <?php echo $sf_content ?>
  </body>
</html>
