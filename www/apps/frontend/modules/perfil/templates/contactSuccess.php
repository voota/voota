<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>



  <div class="profile">
    <h2>
      Contactar  a <?php echo $user ?>
      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $user->getId()): ?>
        <?php echo link_to(__('Hacer cambios en tu perfil'), "@usuario_edit"); ?>
      <?php endif ?>
    </h2>
  

</div>