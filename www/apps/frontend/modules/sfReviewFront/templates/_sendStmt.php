<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>

var text = $("#sf-review-text_<?php echo $reviewBox?$reviewBox:'sf_review'?>").val();

<?php /* Otra opinion sobre un político */?>
<?php if($reviewType == null && isset($politico)): ?>
  var text_intro = this.v[0].checked?'<?php echo sq( __('vooto a favor de una opinión de un usuario sobre %1%', array('%1%' => $politico)) )?>':'<?php echo sq( __('voota en contra de una opinión de un usuario sobre %1%', array('%1%' => $politico)) )?>';
  text = text_intro + (text != ''?(': '+text):'');
  var story_attrs = {
  	picture : '<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>',
		name    : '<?php echo sq( __('Opiniones a favor y en contra de %2% en Voota', array('%2%' => $politico)) )?><?php if ($politico->getPartido()):?> (<?php echo sq($politico->getPartido()) ?>)<?php endif ?>',
		link    : '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>',
  	message : text
  };	  		
  
<?php /* Otra opinion sobre un partido */?>
<?php elseif($reviewType == null && isset($partido)): ?>
  var text_intro = this.v[0].checked?'<?php echo sq( __('vooto a favor de una opinión de un usuario sobre el partido %1%', array('%1%' => $partido)) )?>':'<?php echo sq( __('voota en contra de una opinión de un usuario sobre %1%', array('%1%' => $partido)) )?>';
  text = text_intro + (text != ''?(': '+text):'');
  var story_attrs = {
  	picture : '<?php echo S3Voota::getImagesUrl() ?>/partidos/cc_s_<?php echo $partido->getImagen() ?>',
		name    : '<?php echo __('Opiniones a favor y en contra del partido %2% en Voota', array('%2%' => $partido))?>',
		link    : '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>',
  	message : text
  };
<?php elseif($reviewType == null): ?>
  var text_intro = this.v[0].checked?'<?php echo sq( __('vooto a favor de una opinión de un usuario sobre \"%1%\"', array('%1%' => $entity)) )?>':'<?php echo sq( __('voota en contra de una opinión de un usuario sobre \"%1%\"', array('%1%' => $entity)) )?>';
  text = text_intro + (text != ''?(': '+text):'');
  var story_attrs = {
  	picture : '<?php echo S3Voota::getImagesUrl() ?>/<?php echo $entity->getImagePath() ?>/cc_s_<?php echo $entity->getImagen() ?>',
		name    : '<?php echo __('Opiniones a favor y en contra de \"%2%\" en Voota', array('%2%' => $entity))?>',
		link    : '<?php echo url_for($entity->getModule().'/show?id='.$entity->getVanity(), true) ?>',
  	message : text
  };
  
<?php /* Sobre un politico */?>
<?php elseif($reviewType == Politico::NUM_ENTITY): ?>
  var text_intro = this.v[0].checked?'<?php echo __('vooto a favor de %1%', array('%1%' => $politico))?>':'<?php echo __('voota en contra de %1%', array('%1%' => $politico))?>';
  text = text_intro + (text != ''?(': '+text):'');  
  var story_attrs = {
  	picture : '<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>',
		name    : '<?php echo sq( __('Opiniones a favor y en contra de %2% en Voota', array('%2%' => $politico)) )?><?php if ($politico->getPartido()):?> (<?php echo sq( $politico->getPartido() ) ?>)<?php endif ?>',
		link    : '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>',
  	message : text
  };
  
<?php /* Sobre un partido */?>
<?php elseif($reviewType == Partido::NUM_ENTITY): ?>
  var text_intro = this.v[0].checked?'<?php echo sq( __('vooto a favor del partido %1%', array('%1%' => $partido)) )?>':'<?php echo sq( __('voota en contra de %1%', array('%1%' => $partido)) )?>';
  text = text_intro + (text != ''?(': '+text):'');	  
  var story_attrs = {
  	picture : '<?php echo S3Voota::getImagesUrl() ?>/partidos/cc_s_<?php echo $partido->getImagen() ?>',
		name    : '<?php echo sq( __('Opiniones a favor y en contra del partido %2% en Voota', array('%2%' => $partido)) )?>',
		link    : '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>',
    message : text
  };
<?php else: ?>
  var text_intro = this.v[0].checked?'<?php echo sq( __('vooto a favor de \"%1%\"', array('%1%' => $entity)) )?>':'<?php echo sq( __('voota en contra de \"%1%\"', array('%1%' => $entity)) )?>';
  text = text_intro + (text != ''?(': '+text):'');	
  var story_attrs = {
    picture : '<?php echo S3Voota::getImagesUrl() ?>/<?php echo $entity->getImagePath() ?>/cc_s_<?php echo $entity->getImagen() ?>',
		name    : '<?php echo sq( __('Opiniones a favor y en contra de %2% en Voota', array('%2%' => $entity)) )?>',
		link    : '<?php echo url_for($entity->getModule().'/show?id='.$entity->getVanity(), true) ?>',
    message : text
  };
<?php endif ?>	

if (this.fb_publish.checked) { facebookPublishStory(story_attrs); }
sendReviewForm(this, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>');