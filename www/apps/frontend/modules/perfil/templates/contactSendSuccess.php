<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<h2>
  <img src="/images/icoOk.gif" alt="Ok" width="46" height="39" />
  Ok, mensaje enviado a <a href="#"><?php echo $user ?></a>
  <?php if($user->getProfile() && $user->getProfile()->getImagen() && $user->getProfile()->getImagen() != '' ): ?>
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($user->getProfile()->getImagen()), 'alt="Foto '. $user->getProfile()->getNombre().' ' . $user->getProfile()->getApellidos() .'"') ?>
  <?php endif ?>
</h2>

<div id="content">
  <p class="next-step-msg"><?php echo __('¿Que hacemos ahora?') ?> <?php echo __('Tú dirás.') ?></p>
  <p class="next-step-msg"><?php echo __('¿Nos vamos a la')?> <?php echo link_to("home de Voota", "@homepage") ?>?</p>
  <p class="next-step-msg"><?php echo __('¿Una vuelta por el')?> <?php echo link_to(__("ranking de políticos"), "politico/ranking") ?> <?php echo __('quizás?') ?></p>
</div>