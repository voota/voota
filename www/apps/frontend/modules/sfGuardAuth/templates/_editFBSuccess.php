<?php use_helper('VoUser'); ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<?php if ($sf_user->isAuthenticated() && $sf_user->getProfile()->getFacebookUid() && $sf_user->getProfile()->getFacebookUid() != ''): ?>
  <h3>
    <img src="/images/icoFacebookPref.png" alt="Facebook Connect" />
    <?php echo __('Conectado a Facebook como:') ?> <strong><?php echo jsWrite('fb:name', array('uid' => $sf_user->getProfile()->getFacebookUid(), 'useyou' => 'false', 'linked' => 'false')) ?></strong>
    (<a id="facebook-disconnect" href="#"><?php echo __('Desconectar') ?></a>)
    <script type="text/javascript">
      <?php if (SfVoUtil::isCanonicalVootaUser($sf_user->getGuardUser())): ?>
  	    $('#facebook-disconnect').click(function() {
  	      facebookDisconnectAccount('<?php echo url_for('@usuario_fb_edit?op=dis') ?>');
  	      return false;
  	    });
      <?php else: ?>
        $('#facebook-disconnect').click(function() {
  	      facebookLogoutAndRedirect('<?php echo url_for('@usuario_fb_edit?op=dis') ?>', '<?php echo url_for('@homepage') ?>');
  	      return false;
  	    });
      <?php endif ?>
    </script>
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