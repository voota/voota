<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<h2><?php echo __('¿Y ahora qué?')?></h2>

<p class="next-step-msg"><?php echo __('Te hemos enviado un email a')?> <strong class="email"><?php echo $form->getValue('username') ?></strong></p>
<p class="next-step-msg"><?php echo __('Confirma tus datos sobre el enlace que aparecerá en tu bandeja de entrada.')?></p>
<p class="next-step-msg"><?php echo __('Dependiendo del correo que utilices tardará más o menos en llegarte (Hotmail tarda bastante...)') ?></p>
