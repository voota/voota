<?php use_helper('I18N') ?>

<h2><?php echo __('¿Y ahora qué?')?></h2>

<p class="next-step-msg"><?php echo __('Te hemos enviado un e-mail a')?> <strong class="email"><?php echo $user->getUsername() ?></strong></p>
<p class="next-step-msg"><?php echo __('Confirma tus datos pinchando sobre el enlace que aparecerá en tu bandeja de entrada.')?></p>
<p class="next-step-msg"><?php echo __('Dependiendo del correo que utilices tardará más o menos en llegarte (Hotmail tarda bastante ...)')?></p>