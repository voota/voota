<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>

<?php echo showNotices( $sf_user ) ?>

<div >
  <form method="post">
    <div><input type="hidden" name="op" value="r" /></div>
    <table>
      <tr>
        <th><label for="registration_username"><?php echo __('Título') ?></label></th>
        <td>
          <?php echo $form['titulo']->render() ?>
          <?php echo $form['titulo']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><label for="registration_nombre"><?php echo __('Descripción') ?></label></th>
        <td>
          <?php echo $form['descripcion']->render() ?>
          <?php echo $form['descripcion']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><label for="profile_imagen"><?php echo __('Imagen') ?></label></th>
        <td class="avatar">
          <?php echo $form['imagen']->render() ?>
          <?php echo $form['imagen']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_imagen"><?php echo __('Documento') ?></label></th>
        <td class="avatar">
          <?php echo $form['doc']->render() ?>
          <?php echo $form['doc']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>

      <tr>
        <th></th>
        <td class="submit">
          <input name="button" type="submit" class="button" value="<?php echo __('Enviar')?>" />
        </td>
      </tr>
    </table>
  </form>
</div><!-- FIN SIGNUP -->



