<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php if($sf_user->getCurrentFacebookUid()): ?>
	<?php if($reviewType == null && isset($politico)): ?>
	  var attachment = { 
			'name': (this.v[0].checked?'<?php echo __('a favor')?>':'<?php echo __('en contra')?>') + '<?php echo __(' de la opinión de un usuario sobre %2%', array('%2%' => $politico))?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?>'
			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  };
	  
	  var action_links = [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}];
	<?php elseif($reviewType == null && isset($partido)): ?>
	  var attachment = { 
			'name': (this.v[0].checked?'<?php echo __('a favor')?>':'<?php echo __('en contra')?>') + '<?php echo __(' de %2%', array('%2%' => $partido))?>'
			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  };
	  
	  var action_links = [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}];
	<?php elseif($reviewType == Politico::NUM_ENTITY): ?>
	  var attachment = { 
			'name': (this.v[0].checked?'<?php echo __('a favor')?>':'<?php echo __('en contra')?>') + '<?php echo __(' de %2%', array('%2%' => $politico))?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?>'
			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
			/*, 'description': this.review_text.value*/
			, 'properties': { 
		  		'<?php echo __('Ficha en Voota')?>': { 'text': '<?php echo $politico->getApellidos() ?>', 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'}
	  		}
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/politicos/cc_s_<?php echo $politico->getImagen() ?>'
	  			, 'href': '<?php echo url_for('politico/show?id='.$politico->getVanity(), true) ?>'
	  		}] 
	  };
	  
	  var action_links = [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}];
	<?php elseif($reviewType == Partido::NUM_ENTITY): ?>
	  var attachment = { 
			'name': (this.v[0].checked?'<?php echo __('a favor')?>':'<?php echo __('en contra')?>') + '<?php echo __(' de %2%', array('%2%' => $partido))?>'
			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
			/*, 'description': this.review_text.value*/
			, 'properties': { 
		  		'<?php echo __('Ficha en Voota')?>': { 'text': '<?php echo $partido ?>', 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'}
	  		}
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/partidos/cc_s_<?php echo $partido->getImagen() ?>'
	  			, 'href': '<?php echo url_for('partido/show?id='.$partido->getAbreviatura(), true) ?>'
	  		}] 
	  };
	  
	  var action_links = [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}];
	<?php else: ?>		  var attachment = null;
	<?php endif ?>	
	sendReviewFormFB(this, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>', attachment, action_links);
<?php else: ?>
	sendReviewForm(this, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>');
<?php endif ?>
