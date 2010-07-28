<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoNotice') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'pro')) ?>
<?php end_slot('menu') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){	  
	  $('#back').click(function(){
		  $('#op').val( 'n' );
		  $('#nueva_propuesta_frm').submit();
		  return false;
	  });

	  $('#nueva_propuesta_frm').submit(function(){
			if ($('#publicar_propuesta_en_facebook').is(':checked')){
		    facebookConnect_promptPermission("publish_stream", function(perms) {
		    	if (perms) {
		  		  var attachment = { 
						  'name': '<?php echo sq( __('Opiniones a favor y en contra de la propuesta \"%2%\" en Voota', array('%2%' => $form['titulo']->getValue())) )?>',
							'href': '<?php echo url_for('propuesta/show?id='.SfVoUtil::fixVanityChars($form['titulo']->getValue()), true) ?>',
						  'media': [{
				  			'type': 'image',
				  			'src': '<?php echo S3Voota::getImagesUrl() ?>/propuestas/cc_s_<?php echo $form['imagen']->getValue() ?>',
						  	'href': '<?php echo url_for('propuesta/show?id='.SfVoUtil::fixVanityChars($form['titulo']->getValue()), true) ?>'
						  }]
						};
					  try {
					    publishFaceBook("<?php echo __('He dejado una nueva propuesta en Voota: \"%1\"', array('%1' => $form['titulo']->getValue()))?>", attachment, [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}], '<?php echo __('Vamos a publicar esto en Facebook, ¿que te parece?') ?>');
					  } catch(err){}
					}
				});
			}
			return true;
	  });
  });
  //-->
</script>

<div class="propuesta-preview">
  <div class="inner">

    <h2><?php echo __('Así se verá: %nombre%', array('%nombre%' => $form['titulo']->getValue())) ?></h2>
    <div class="picture">
      <p><a href="#" id="back" ><?php echo __('&laquo; Volver, hacer cambios')?></a></p>
      <?php if($form['imagen']->getValue()):?>
      	<p><?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/cc_'.$form['imagen']->getValue(), 'alt="'. __('Imagen de %1%', array('%1%' => $form['titulo']->getValue())) .'"') ?></p>
      <?php endif ?>
    </div>
  
    <div class="description">
      <h3><?php echo __('Sobre la propuesta') ?></h3>
      <?php echo formatDesc($form['descripcion']->getValue()) ?>
      <?php if($form['doc']->getValue()): ?>
        <p><?php echo __('Documento')?>: <a class="document"  href="<?php echo S3Voota::getImagesUrl().'/docs/'.$form['doc']->getValue() ?>"><?php echo $form['doc']->getValue() ?></a> (<?php $s=new S3Voota();echo ByteSize( $s->getSize('docs/'.$form['doc']->getValue()) );?>)</p><?php // TODO: Sustituir por enlace a fichero y tamaño de fichero correcto?>
      <?php endif ?>
    </div>
    
    <div id="sidebar">
      <div id="external-links">
      	<?php if($form['enlace_n1']['url']->getValue() || $form['enlace_n2']['url']->getValue() || $form['enlace_n3']['url']->getValue() || $form['enlace_n4']['url']->getValue() || $form['enlace_n5']['url']->getValue()):?>
          <h3><?php echo __('Enlaces externos')?></h3>
          <ul>
          	<?php if($form['enlace_n1']['url']->getValue()): ?>
    		      <li><?php echo link_to(toShownUrl(urldecode( $form['enlace_n1']['url']->getValue() )), toUrl( $form['enlace_n1']['url']->getValue() ) )?></li>
          	<?php endif ?>
          	<?php if($form['enlace_n2']['url']->getValue()): ?>
    		      <li><?php echo link_to(toShownUrl(urldecode( $form['enlace_n2']['url']->getValue() )), toUrl( $form['enlace_n2']['url']->getValue() ) )?></li>
          	<?php endif ?>
          	<?php if($form['enlace_n3']['url']->getValue()): ?>
    		      <li><?php echo link_to(toShownUrl(urldecode( $form['enlace_n3']['url']->getValue() )), toUrl( $form['enlace_n3']['url']->getValue() ) )?></li>
          	<?php endif ?>
          	<?php if($form['enlace_n4']['url']->getValue()): ?>
    		      <li><?php echo link_to(toShownUrl(urldecode( $form['enlace_n4']['url']->getValue() )), toUrl( $form['enlace_n4']['url']->getValue() ) )?></li>
          	<?php endif ?>
          	<?php if($form['enlace_n5']['url']->getValue()): ?>
    		      <li><?php echo link_to(toShownUrl(urldecode( $form['enlace_n5']['url']->getValue() )), toUrl( $form['enlace_n5']['url']->getValue() ) )?></li>
          	<?php endif ?>
          </ul>
      	<?php endif ?>
      </div>
    </div>

  </div>
</div>

<div class="vooto">
  <div class="inner">
    <h3><?php echo __('¿Todo en orden? ¿Seguimos?') ?></h3>
    <p><strong><?php echo __('Importante')?></strong>: <?php echo __('una vez subida, no podrás borrar ni editar la propuesta. Sólo podrás hacer cambios sobre los enlaces o el fichero incluído.') ?></p>

    <form id="nueva_propuesta_frm" method="post" action="<?php echo url_for('propuesta/new')?>">
	    <input id="op" type="hidden" name="op" value="c" />
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

      <p class="facebook-only submit">
	      <img src="/images/icoFacebook.png" width="16" height="16" alt="Facebook" />
	      <label for="publicar_propuesta_en_facebook"><?php echo __('Publicar en mi Facebook') ?></label>
	      <input type="checkbox" name="fb_publish" value="1" id="publicar_propuesta_en_facebook" />
	    </p>
	    <p class="submit"><input type="submit" value="<?php echo __('¡Ok! Subir propuesta') ?>" /></p>
    </form>
  </div>
</div>