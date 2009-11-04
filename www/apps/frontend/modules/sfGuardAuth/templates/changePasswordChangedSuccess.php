<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('Muy bien, contraseña cambiada') ?></h2>
<div class="limpiar"></div>
</div>
<div class="formSing">

<h5><?php echo __('¿Que hacemos ahora?') ?><span class="tituloAzul"></span> <?php echo __('Tú dirás.') ?></h5>
<h5><?php echo __('¿Nos vamos a la') ?> 
<?php echo link_to(
				"home de Voota", 
				"@homepage"
			) ?>?</h5>

<div class="limpiar"></div>
</div>
</div>
</div>

<div class="limpiar"></div>
</div>
<!-- FIN CONTENT -->

