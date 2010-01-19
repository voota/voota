<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<?php use_helper('VoNotice') ?>

<?php echo showNotices( $sf_user ) ?>

<h2><?php echo __('¿Olvidaste tu contraseña?')?></h2>

<div id="content">
  <p><?php echo __('Danos tu email y te la enviamos ahora mismo') ?></p>

  <form action="<?php echo url_for('@usuario_reminder') ?>" method="post">
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
        <td class="submit"><input type="submit" value="<?php echo __('Enviar') ?>" class="button" /></td>
      </tr>
    </table>
  </form>
</div>