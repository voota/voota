<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>
<?php use_helper('VoNotice') ?>

<h2><?php echo __('Define tu nueva contraseña')?></h2>

<?php echo showNotices( $sf_user ) ?>

<form action="<?php echo url_for('@usuario_change_password2') ?>" method="post">
  <input type="hidden" name="codigo" value="<?php echo $codigo ?>" />
  <table>
    <tr>
      <th><label for="profile_passwordNew"><?php echo __('Contraseña') ?></label></th>
      <td>
        <?php echo $form['passwordNew']->render() ?>
        <?php echo $form['passwordNew']->renderError() ?>
      </td>
    </tr>
    <tr>
      <th><label for="profile_password_again"><?php echo __('Otra vez') ?></label></th>
      <td>
        <?php echo $form['password_again']->render() ?>
        <?php echo $form['password_again']->renderError() ?>
      </td>
    </tr>
    <tr>
      <th></th>
      <td class="submit"><input type="submit" value="<?php echo __('Enviar') ?>" class="button" />
    </tr>
  </table>
</form>