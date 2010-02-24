<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>

<?php echo showNotices( $sf_user ) ?>

<h2><?php echo __('Una cosilla antes de continuar...')?></h2>

<div id="accounts-join-login">
  <p>
  	<?php echo __('Si ya tienes una cuenta Voota, es el mejor momento para vincularla con tu usuario de Facebook. Sólo tienes que introducir tu email y tu contraseña en Voota, y todo quedará unificado. ¿Cómo lo ves?')?>
  </p>
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <input type="hidden" name="op" value="<?php echo $op ?>" />
    <table>
      <tr>
        <th><label for="signin_username"><?php echo __('Tu Email') ?></label></th>
        <td>
          <?php echo $signinform['username']->render() ?>
          <?php echo $signinform['username']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><label for="signin_password"><?php echo __('Contraseña') ?></label></th>
        <td>
          <?php echo $signinform['password']->render() ?>
          <?php echo $signinform['password']->renderError() ?>
          <p class="hints"><?php echo link_to(__('¿Olvidaste tu contraseña?'), 'sfGuardAuth/reminder') ?></p>
          <p class="hints"><?php echo $signinform['remember']->render() ?> <label for="signin_remember"><?php echo __('Recordar contraseña') ?></label></p>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="submit"><input name="button" type="submit" class="button" value="<?php echo __('Entrar')?>" /></td>
      </tr>
    </table>
  </form>
</div>

<div id="accounts-join-skip">
  <p>
    Si no tienes cuenta en Voota no pasa nada, ¿eh?
  </p>

  <p>
  	<a href="<?php echo url_for('sfFacebookConnectAuth/signin') ?>"><?php echo __("Paa'lante, quizás en otro momento &raquo;") ?></a>
  </p>
</div>