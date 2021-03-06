<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser') ?>

<h2>
  <img src="/images/icoOk.gif" alt="Ok" width="46" height="39" />
  <?php echo __('Ok, mensaje enviado a'); ?> <?php echo link_to(fullName($user), "@usuario?username=".$user->getProfile()->getVanity()); ?>
  <?php echo getAvatar($user); ?>
</h2>

<div id="content">
  <p class="next-step-msg"><?php echo __('¿Que hacemos ahora?') ?> <?php echo __('Tú dirás.') ?></p>
  <p class="next-step-msg"><?php echo __('¿Nos vamos a la')?> <?php echo link_to("home de Voota", "@homepage") ?>?</p>
  <p class="next-step-msg"><?php echo __('¿Una vuelta por el')?> <?php echo link_to(__("ranking de políticos"), "politico/ranking") ?> <?php echo __('quizás?') ?></p>
</div>