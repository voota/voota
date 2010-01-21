<?php use_helper('I18N') ?>

<h2 class="error">
  <?php echo __('Lo siento, %1% no nos autoriza a mandarle emails.', array('%1%' => $user->getProfile()->getNombre())); ?>
</h2>

<div id="content">
  <p class="next-step-msg"><?php echo __('¿Que hacemos ahora?') ?> <?php echo __('Tú dirás.') ?></p>
  <p class="next-step-msg"><?php echo __('¿Nos vamos a la')?> <?php echo link_to("home de Voota", "@homepage") ?>?</p>
  <p class="next-step-msg"><?php echo __('¿Una vuelta por el')?> <?php echo link_to(__("ranking de políticos"), "politico/ranking") ?> <?php echo __('quizás?') ?></p>
</div>