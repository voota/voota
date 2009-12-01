<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('¿Y ahora qué?')?></h2>

<div class="limpiar"></div>

<div class="formSing">


<h5>
<?php echo __('Te hemos enviado un email a')?> <span class="tituloAzul"><?php echo $form->getValue('username')?></span>
</h5>
<h5>
<?php echo __('Confirma tus datos sobre el enlace que aparecerá en tu bandeja de entrada.')?>
</h5>
<h5>
<?php echo __('Dependiendo del correo que utilices tardará más o menos en llegarte (Hotmail tarda bastante...)')?>
</h5>



<div class="limpiar"></div>
</div>

<div class="limpiar"></div>
<div class="limpiar"></div>
</div>
</div>