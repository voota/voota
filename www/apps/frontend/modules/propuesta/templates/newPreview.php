<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoNotice') ?>

<div class="propuesta-preview">
  <div class="inner">
    <h2><?php echo __('Así se verá: %nombre%', array('%nombre%' => $form['titulo']->getValue())) ?></h2>
    <div class="picture">
      <p><a href="#"><?php echo __('&laquo; Volver, hacer cambios')?></a></p>
      <p><img src="/images/proto/img_propuesta.png" alt="Título de la propuesta" /><?php // TODO: Sustituir URL y texto alt ?></p>
    </div>
    <div id="external-links">
      <?php if (true): // TODO: Si hay enlaces definidos?>
        <h3><?php echo __('Enlaces externos')?></h3>
        <ul>
          <?php // foreach(enlace): ?>
  		      <li><a href="#">seisdeagosto.com/indica</a></li>
  		      <li><a href="#">seisdeagosto.com/indica</a></li>
  		      <li><a href="#">seisdeagosto.com/indica</a></li>
  		      <li><a href="#">seisdeagosto.com/indica</a></li>
          <?php // endforeach ?>
        </ul>
      <?php endif ?>
    </div>
    <div class="description">
      <h3><?php echo __('Sobre la propuesta') ?></h3>
      <?php echo formatDesc($form['descripcion']->getValue()) ?>
      <?php if (true): // TODO: Sustituir por 'si ha subido subido un fichero' ?>
        <p>Documento: <a href="#">Normas_Generales.pdf</a> (245Mb)</p><?php // TODO: Sustituir por enlace a fichero y tamaño de fichero correcto?>
      <?php endif ?>
    </div>
  </div>
</div>

<div class="vooto">
  <div class="inner">
    <h3><?php echo __('¿Todo en orden? ¿Seguimos?') ?></h3>
    <p><strong><?php echo __('Importante')?></strong>: <?php echo __('una vez subida, no podrás borrar ni editar la propuesta. Sólo podrás hacer cambios sobre los enlaces o el fichero incluído.') ?></p>
    <form> <?php // TODO: Sustituir por etiqueta de formulario apropiada ?>
      <p class="facebook-only submit">
        <img src="/images/icoFacebook.png" width="16" height="16" alt="Facebook" />
        <label for="publicar_propuesta_en_facebook"><?php echo __('Publicar en mi Facebook') ?></label>
        <input type="checkbox" name="fb_publish" value="1" id="publicar_propuesta_en_facebook" />
      </p>
      <p class="submit"><input type="submit" value="<?php echo __('¡Ok! Subir propuesta') ?>" /></p>
    </form>
  </div>
</div>

<form method="post" action="<?php echo url_for('propuesta/new')?>">
	<input type="hidden" name="op" value="c" />;
        <?php echo $form['titulo']->render() ?>
        <?php echo $form['descripcion']->render() ?>
        <?php echo $form['imagen']->render() ?>
        <?php echo $form['doc']->render() ?>
        
        <?php echo $form['enlace_n1']['orden']->render() ?>
        <?php echo $form['enlace_n1']['url']->render() ?>
        <?php echo $form['enlace_n2']['orden']->render() ?>
        <?php echo $form['enlace_n2']['url']->render() ?>
        <?php echo $form['enlace_n3']['orden']->render() ?>
        <?php echo $form['enlace_n3']['url']->render() ?>
        <?php echo $form['enlace_n4']['orden']->render() ?>
        <?php echo $form['enlace_n4']['url']->render() ?>
        <?php echo $form['enlace_n5']['orden']->render() ?>
        <?php echo $form['enlace_n5']['url']->render() ?>
        
        <input name="button" type="submit" class="button" value="<?php echo __('Ok')?>" />
</form>