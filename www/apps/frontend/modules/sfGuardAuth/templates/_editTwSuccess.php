<?php use_helper('VoUser'); ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<?php if ($sf_user->isAuthenticated() && $sf_user->getProfile()->getTwOauthToken()): ?>
  <h3>
    <img src="/images/icoFacebookPref.png" alt="Twitter Connect" />
    <?php echo __('Conectado a Twitter como:') ?> <strong>XXX</strong>
    (<a id="twitter-disconnect" href="#"><?php echo __('Desconectar') ?></a>)
    <script type="text/javascript">
      <?php if (SfVoUtil::isCanonicalVootaUser($sf_user->getGuardUser())): ?>
  	    $('#twitter-disconnect').click(function() {
  	      twitterDisconnectAccount('<?php echo url_for('@usuario_tw_edit?op=dis') ?>');
  	      return false;
  	    });
      <?php else: ?>
        $('#twitter-disconnect').click(function() {
  	      twitterLogoutAndRedirect('<?php echo url_for('@usuario_tw_edit?op=dis') ?>', '<?php echo url_for('@homepage') ?>');
  	      return false;
  	    });
      <?php endif ?>
    </script>
  </h3>
  <p><?php echo __('Actualizar tu muro de Twitter:') ?></p>
  <ul>
    <li>
      <p>
        <?php echo $profileEditForm['tw_publish_votos']->render() ?>
        <label for="profile_tw_publish_votos"><?php echo __('Cada vez que agregas un voto') ?></label>
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
        <?php echo $profileEditForm['tw_publish_votos_otros']->render() ?>
        <label for="profile_tw_publish_votos_otros"><?php echo __('Cada vez que opinas sobre un voto hecho por otro usuario') ?></label>
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
        <?php echo $profileEditForm['tw_publish_cambios_perfil']->render() ?>
        <label for="profile_tw_publish_cambios_perfil"><?php echo __('Cada vez que haces cambios en tu perfil (tu foto o sobre ti)') ?></label>
      </p>
    </li>
  </ul>
<?php endif ?>