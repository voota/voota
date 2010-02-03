<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php if($sf_user->getCurrentFacebookUid()): ?>
	<?php if($reviewType == Politico::NUM_ENTITY): ?>
	  var attachment = { 
			'name': (this.v[0].checked?'<?php echo __('a favor')?>':'<?php echo __('en contra')?>') + '<?php echo __(' de %2%', array('%2%' => $politico))?>'
			, 'href': 'http://voota.es/es/politico/<?php echo $politico->getVanity() ?>'
			/*, 'description': this.review_text.value*/
			, 'properties': { 
		  		'<?php echo __('Ficha en Voota')?>': { 'text': '<?php echo $politico->getApellidos() ?>', 'href': 'http://voota.es/es/politico/<?php echo $politico->getVanity() ?>'}
	  		}
	  		, 'media': [{ 
	  			'type': 'image'
	  			, 'src': 'http://imagesvoota.s3.amazonaws.com/politicos/cc_s_<?php echo $politico->getImagen() ?>'
	  			, 'href': 'http://voota.es/es/politico/<?php echo $politico->getVanity() ?>'
	  		}] 
	  };
	  
	  var action_links = [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}];
	<?php else: ?>	
	  var attachment = null;
	<?php endif ?>	
	sendReviewFormFB(this, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>', attachment, action_links);
<?php else: ?>
	sendReviewForm(this, '<?php echo url_for('sfReviewFront/send')?>', '<?php echo $reviewBox?$reviewBox:'sf_review'?>');
<?php endif ?>
