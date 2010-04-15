<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>

<h3>
Título: <?php echo $form['titulo']->getValue() ?>
</h3>
<p>
Descripción: <?php echo $form['descripcion']->getValue() ?>
</p>


  <form method="post" action="<?php echo url_for('propuesta/new')?>">
  	<input type="hidden" name="op" value="c" />;
          <?php echo $form['titulo']->render() ?>
          <?php echo $form['descripcion']->render() ?>
          <?php echo $form['imagen']->render() ?>
          <?php echo $form['doc']->render() ?>
          <?php echo $form['doc']->renderError() ?>
          
          <input name="button" type="submit" class="button" value="<?php echo __('Ok')?>" />
  </form>