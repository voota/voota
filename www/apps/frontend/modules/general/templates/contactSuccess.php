<?php use_helper('I18N') ?>

<h2><?php echo __('Contacta con Voota') ?></h2>

<div id="content">

  <form method="post" action="<?php echo url_for( '@contact' ) ?>">
    <dl>
      <dt><label for="contact_nombre"><?php echo __('Tu nombre') ?>:</label></dt>
      <dd>
      	<?php echo $form['nombre']->renderError() ?>
      	<?php echo $form['nombre']->render(array('value' => $sf_user->isAuthenticated()?$sf_user->getGuardUser():'')) ?> <span class="hints"><?php echo __('(Opcional)') ?></span></dd>
      
      <dt><label for="contact_email">Email:</label></dt>
      <dd>
        <?php echo $form['email']->renderError() ?>
      	<?php echo $form['email']->render(array('value' => $sf_user->isAuthenticated()?$sf_user->getGuardUser()->getUserName():'')) ?>
      </dd>
      
      <dt><label for="contact_tipo"><?php echo __('¿De qué se trata?') ?></label></dt>
      <dd>
        <select name="contact[tipo]" id="contact_tipo">
			    <option value="Sugerencia" selected="selected"><?php echo __('Sugerencia')?></option>
			    <option value="Queja"><?php echo __('Queja')?></option>
			    <option value="Correccion"><?php echo __('Corrección')?></option>
			    <option value="Socios"><?php echo __('Socios')?></option>
			    <option value="Otros"><?php echo __('Otros')?></option>
		    </select>
      </dd>

      <dt><label for="contact_mensaje"><?php echo __('Tu mensaje') ?>:</label></dt>
      <dd>
      	<?php echo $form['mensaje']->renderError() ?>
      	<?php echo $form['mensaje']->render( array('rows' => 12, 'cols' => 60) ) ?>
      </dd>
    </dl>
    <p class="submit">
      <input type="submit" name="enviar" value="<?php echo __('Enviar') ?>" />
    </p>
  </form>
</div>

<div id="sidebar">
  <?php include_partial('socialBox') ?>
</div>
