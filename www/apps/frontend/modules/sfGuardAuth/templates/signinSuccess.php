<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>
<?php use_helper('VoUser'); ?>

<?php echo showNotices( $sf_user ) ?>
<?php if ($sf_request->getParameter("dialog") == 1): ?>
	<p class='warning'><?php echo __('¿Nuevo por aquí? Necesitas tener una cuenta Voota (o en Facebook) para continuar. Tu vooto será público o secreto, como gustes.') ?></p>
<?php endif ?>

<div id="signup">
  <h2><?php echo __('¿Nuevo en Voota? Empieza aquí')?></h2>
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <div><input type="hidden" name="op" value="r" /></div>
    <table>
      <tr>
        <th><label for="registration_username"><?php echo __('Tu Email') ?></label></th>
        <td>
          <?php echo $registrationform['username']->render() ?>
          <?php echo $registrationform['username']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><label for="registration_nombre"><?php echo __('Nombre') ?></label></th>
        <td>
          <?php echo $registrationform['nombre']->render() ?>
          <?php echo $registrationform['nombre']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><label for="registration_apellidos"><?php echo __('Apellidos') ?></label></th>
        <td>
          <?php echo $registrationform['apellidos']->render() ?>
          <?php echo $registrationform['apellidos']->renderError() ?>
          <p class="anonymous">
            <label for="registration_anonymous"><?php echo __('Vooto secreto (estás en tu derecho)') ?></label>
            <?php echo $registrationform['anonymous']->render() ?>
            <?php echo $registrationform['anonymous']->renderError() ?>
          </p>
        </td>
      </tr>
      <tr>
        <th><label for="registration_password"><?php echo __('Contraseña') ?></label></th>
        <td>
          <?php echo $registrationform['password']->render() ?>
          <?php echo $registrationform['password']->renderError() ?>
          <p class="hints">
            <span id="show_pass_label"><a href="#" onclick="return showHidePass('registration_password')"><?php echo __('Ver la contraseña')?></a></span>
  		      <span id="hide_pass_label" class="hidden"><a href="#" onclick="return showHidePass('registration_password')"><?php echo __('Ocultar la contraseña')?></a></span>
          </p>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="legal">
          <label for="registration_accept">He leído y acepto el <?php echo link_to(__('aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array()) ?><?php echo $registrationform['accept']->render() ?></label>
          <?php echo $registrationform['accept']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="submit">
          <input name="button" type="submit" class="button" value="<?php echo __('Regístrate en Voota')?>" />
        </td>
      </tr>
    </table>
  </form>
</div><!-- FIN SIGNUP -->

<div id="login">
  <h2><?php echo __('¿Ya estás registrado? Adelante :)')?></h2>
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
      <tr class="facebook-login">
        <th><label><?php echo __('Otra opción...') ?></label></th>
        <td>
          <a href="#" onclick="javascript:facebookLogin('<?php echo url_for('sfGuardAuth/signin?op=fbc') ?>')" class="facebook-button"><span><?php echo __('Entrar con Facebook') ?></span></a>
        </td>
      </tr>
    </table>
  </form>
</div>


