<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>

<h2><?php echo __('Contacta con Voota') ?></h2>

<div id="content">

  <?php echo form_tag('@contact') ?>
    <dl>
      <dt><label for="nombre"><?php echo __('Tu nombre') ?>:</label></dt>
      <dd>
      	<?php echo $form['nombre']->renderError() ?>
      	<?php echo $form['nombre']->render() ?> <span class="hints"><?php echo __('(Opcional)') ?></span></dd>
      
      <dt><label for="email">Email:</label></dt>
      <dd>
        <?php echo $form['email']->renderError() ?>
      	<?php echo $form['email']->render() ?>
      </dd>
      
      <dt><label for="topic"><?php echo __('¿De qué se trata?') ?></label></dt>
      <dd>
        <select name="contact[tipo]" id="contact_tipo">
			<option value="Sugerencia" selected="selected"><?php echo __('Sugerencia')?></option>
			<option value="Queja"><?php echo __('Queja')?></option>
			<option value="Correccion"><?php echo __('Corrección')?></option>
			<option value="Socios"><?php echo __('Socios')?></option>
			<option value="Otros"><?php echo __('Otros')?></option>
		</select>
        <?php /* <span class="hints"><?php echo __('(Opcional)') ?></span> */?>
      </dd>

      <dt><label for="body"><?php echo __('Tu mensaje') ?>:</label></dt>
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
