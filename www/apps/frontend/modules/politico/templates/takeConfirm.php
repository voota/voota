<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<div id="photo">
  <?php // TODO: Reemplazar imagen con imagen del político o usuario ?>
  <img src="/images/proto/politico_medium" alt="<?php $sf_user->getGuardUser()->getProfile() ?>" />
    
</div>

<div id="content">
  <h2><?php echo __('Bienvenido, %nombre_usuario%, un placer verte por aquí.', array("%nombre_usuario%" => $sf_user->getGuardUser()->getProfile()->getNombre())) ?></h2>

  <p class="pre-ul"><?php echo __('A partir de ahora podrás:')?></p>
  
  <ul>
    <li><?php echo __('Editar la información que aparece en tu perfil (fotografía, bio, enlaces externos, etc.).') ?></li>
    <li><?php echo __('Responder a las opiniones que otros usuarios hacen sobre ti.') ?></li>
    <li><?php echo __('Recibir notificaciones cuando tienes una nueva opinión.') ?></li>
  </ul>

  <p>
    <?php echo __('¿Listo?') ?>
    <?php echo link_to(__('Adelante, estás en tu casa'), '@usuario_edit') ?>
  </p>
</div>