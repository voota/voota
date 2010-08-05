<?php use_helper('VoUser'); ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<?php if ($sf_user->isAuthenticated() && $sf_user->getProfile()->getTwOauthToken()): ?>
  <h3>
    <img src="/images/icoTwitterPref.png" alt="Twitter Connect" />
    <?php echo __('Conectado a Twitter') ?>
    (<a id="twitter-disconnect" href="#"><?php echo __('Desconectar') ?></a>)
    <script type="text/javascript">
	    $('#twitter-disconnect').click(function() {
	      twitterDisconnectAccount('<?php echo url_for('@usuario_tw_edit?op=dis') ?>');
	      return false;
	    });
    </script>
  </h3>
  <p><?php echo __('Publicar en Twitter:') ?></p>
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
<?php else: ?>
  <h3>
    <img src="/images/icoTwitter.png" alt="Facebook Connect" />
    <?php echo __('Sincroniza Voota con Twitter') ?>
  </h3>
  <p><?php echo __('Sincronizando tu perfil de Voota con Twitter tus contactos podrán seguir tus Vootos y opiniones en tu muro.') ?></p>
  <p><?php echo __('¿Te animas? Sólo tienes que pinchar sobre el siguiente botón:') ?></p>
  <a href="javascript:twitterAssociate('<?php echo url_for('sfGuardAuth/signin?op=twt') ?>')" class="twitter-button"><span><?php echo __('Sincronizar con Twitter') ?></span></a>
  <p></p>
<?php endif ?>