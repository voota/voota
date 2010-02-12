<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

	var text = $("#sf-review-text_<?php echo $reviewBox?$reviewBox:'sf_review'?>").val();
	
	<?php /* Otra opinion sobre un político */?>
	<?php if($reviewType == null && isset($politico)): ?>
	  var attachment = { 
			'name': '<?php echo __('Opiniones a favor y en contra de %2% en Voota', array('%2%' => $politico))?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?>'
			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/politicos/cc_s_<?php echo $politico->getImagen() ?>'
	  			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  		}] 
	  };	  		
	  var text_intro = this.v[0].checked?'<?php echo __('voota a favor de una opinión de un usuario sobre %1%', array('%1%' => $politico))?>':'<?php echo __('voota en contra de una opinión de un usuario sobre %1%', array('%1%' => $politico))?>';
	  text = text_intro + (text != ''?(': '+text):'');
	  
	<?php /* Otra opinion sobre un partido */?>
	<?php elseif($reviewType == null && isset($partido)): ?>
	  var attachment = { 
			'name': '<?php echo __('Opiniones a favor y en contra del partido %2% en Voota', array('%2%' => $partido))?>'
			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/partidos/cc_s_<?php echo $partido->getImagen() ?>'
	  			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  		}] 
	  };
	  var text_intro = this.v[0].checked?'<?php echo __('voota a favor de una opinión de un usuario sobre el partido %1%', array('%1%' => $partido))?>':'<?php echo __('voota en contra de una opinión de un usuario sobre %1%', array('%1%' => $partido))?>';
	  text = text_intro + (text != ''?(': '+text):'');
	  
	<?php /* Sobre un politico */?>
	<?php elseif($reviewType == Politico::NUM_ENTITY): ?>
	  var attachment = { 
			'name': '<?php echo __('Opiniones a favor y en contra de %2% en Voota', array('%2%' => $politico))?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?>'
			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/politicos/cc_s_<?php echo $politico->getImagen() ?>'
	  			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  		}] 
	  };	  		
	  var text_intro = this.v[0].checked?'<?php echo __('voota a favor de %1%', array('%1%' => $politico))?>':'<?php echo __('voota en contra de %1%', array('%1%' => $politico))?>';
	  text = text_intro + (text != ''?(': '+text):'');
	  
	<?php /* Sobre un partido */?>
	<?php elseif($reviewType == Partido::NUM_ENTITY): ?>
	  var attachment = { 
			'name': '<?php echo __('Opiniones a favor y en contra del partido %2% en Voota', array('%2%' => $partido))?>'
			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/partidos/cc_s_<?php echo $partido->getImagen() ?>'
	  			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  		}] 
	  };
	  var text_intro = this.v[0].checked?'<?php echo __('voota a favor del partido %1%', array('%1%' => $partido))?>':'<?php echo __('voota en contra de %1%', array('%1%' => $partido))?>';
	  text = text_intro + (text != ''?(': '+text):'');
	  
	<?php else: ?>
		var attachment = null;
	<?php endif ?>	

	sendReviewFormFB(this, 	text, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>', attachment, [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}]);

