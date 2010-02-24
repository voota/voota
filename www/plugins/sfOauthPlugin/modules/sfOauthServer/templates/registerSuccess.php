<?php use_helper('I18N') ?>

<form action="<?php echo url_for('sfOauthServer/register') ?>" method="post" method="post" enctype="multipart/form-data">
	<table>
      <tr>
        <th><label for="app_nombre"><?php echo __('Tu nombre') ?> *</label></th>
        <td>
          <?php echo $form['name']->render() ?>
          <?php echo $form['name']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Tu email') ?> *</label></th>
        <td>
          <?php echo $form['email']->render() ?>
          <?php echo $form['email']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Dirección de callback') ?></label></th>
        <td>
          <?php echo $form['callback_uri']->render() ?>
          <?php echo $form['callback_uri']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Web de la aplicación') ?></label></th>
        <td>
          <?php echo $form['application_uri']->render() ?>
          <?php echo $form['application_uri']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Título') ?></label></th>
        <td>
          <?php echo $form['application_title']->render() ?>
          <?php echo $form['application_title']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Descripción') ?></label></th>
        <td>
          <?php echo $form['application_descr']->render() ?>
          <?php echo $form['application_descr']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Notas') ?></label></th>
        <td>
          <?php echo $form['application_notes']->render() ?>
          <?php echo $form['application_notes']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('Tipo') ?></label></th>
        <td>
          <?php echo $form['application_type']->render() ?>
          <?php echo $form['application_type']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="app_email"><?php echo __('¿Es comercial?') ?></label></th>
        <td>
          <?php echo $form['application_commercial']->render() ?>
          <?php echo $form['application_commercial']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th></th>
        <td class="submit"><input type="submit" value="<?php echo __('Guardar') ?>" /></td>
        <td class="hints"></td>
      </tr>
	</table>
</form>