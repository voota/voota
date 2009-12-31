<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>
<?php use_helper('VoNotice') ?>

<h2><?php echo __('Define tu nueva contraseña')?></h2>

<?php echo showNotices( $sf_user ) ?>

<?php echo form_tag('@usuario_change_password2') ?>
  <?php echo input_hidden_tag('codigo', $codigo) ?>
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
      <td class="submit"><?php echo submit_tag(__('Enviar'), array('class'   => 'button',)) ?></td>
    </tr>
  </table>
</form>