<?php use_helper('VoUser'); ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<?php if ($sf_user->isFacebookConnected()): ?>
  <h3>
    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
    <?php echo __('Conectado a Facebook como:') ?> <strong><fb:name uid="<?php echo $sf_user->getProfile()->getFacebookUid() ?>" useyou="false" linked="false"></fb:name></strong>
    <button onclick="facebookConnect_disconnect('<?php echo url_for('@usuario_fb_edit?op=dis') ?>'); return false"><?php echo __('Desconectar') ?></button>
  </h3>
  <p><?php echo __('Actualizar tu muro de Facebook:') ?></p>
  <ul>
    <li>
      <p>
        <?php echo $profileEditForm['fb_publish_votos']->render() ?>
        <label for="profile_fb_publish_votos"><?php echo __('Cada vez que agregas un voto') ?></label>
      </p>
      <?php if (isset($lastReview) && $lastReview): ?>
        <p>
          <?php echo __('Tu último voto:') ?>
          <br />
          <q><?php echo review_text( $lastReview ) ?></q>
        </p>
      <?php endif ?>
    </li>
    <li>
      <p>
        <?php echo $profileEditForm['fb_publish_votos_otros']->render() ?>
        <label for="profile_fb_publish_votos_otros"><?php echo __('Cada vez que opinas sobre un voto hecho por otro usuario') ?></label>
      </p>
      <?php if (isset($lastReviewOnReview) && $lastReviewOnReview): ?>
      <?php // if (usuario_tiene_último_comentario_sobre_voto): ?>
        <p>
          <?php echo __('Tu última opinión sobre un voto:') ?>
          <br />
          <q><?php echo review_text( $lastReviewOnReview ) ?></q>
        </p>
      <?php endif ?>
    </li>
    <li>
      <p>
        <?php echo $profileEditForm['fb_publish_cambios_perfil']->render() ?>
        <label for="profile_fb_publish_cambios_perfil"><?php echo __('Cada vez que haces cambios en tu perfil (tu foto o sobre ti)') ?></label>
      </p>
    </li>
  </ul>
<?php else: ?>
  <h3>
    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
    <?php echo __('Sincroniza Voota con Facebook') ?>
  </h3>
  <p><?php echo __('Sincronizando tu perfil de Voota con Facebook tus contactos podrán seguir sus Vootos y opiniones en tu muro.') ?></p>
  <p><?php echo __('¿Te animas? Sólo tienes que pinchar sobre el siguiente botón:') ?></p>
  <p><?php echo vo_facebook_connect_associate_button(); ?></p>
<?php endif ?>