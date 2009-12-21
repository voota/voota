<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<?php use_helper('VoNotice') ?>

<?php echo showNotices( $sf_user ) ?>

<h2><?php echo __('¿Olvidaste tu contraseña?')?></h2>

<div id="content">
  <p><?php echo __('Danos tu email y te la enviamos ahora mismo') ?></p>

  <?php echo form_tag('@usuario_reminder') ?>
    <table>
      <tr>
        <th><?php echo __('Tu Email') ?></th>
        <td>
          <?php echo $form['username']->render() ?>
          <?php echo $form['username']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="submit"><?php echo submit_tag(__('Enviar'), array('class'   => 'button',)) ?></td>
      </tr>
    </table>
  </form>
</div>