<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'pol')) ?>
<?php end_slot('menu') ?>


<script type="text/javascript">
  <!--
  $(document).ready(function(){
    $('.reviews').tabs({
    	<?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['tab']):?>selected: <?php echo $sfr_status['tab'] ?>,<?php $sf_user->setAttribute('sfr_status', $sfr_status, 'sf_review');?><?php endif ?>
    	load: function() {
    	  //facebookParseXFBML();
    	}
	});
  });
  
  $(window).load(function(){
    <?php include_component_slot('sparkline', array('reviewable' => $politico, 'id' => 'sparkline_'.$politico->getId() )) ?>
  });

  function sfr_refresh( type ){
	$('.reviews').tabs( "select" , 0 );
	var aUrl = '<?php echo url_for("sfReviewFront/filteredList?value=&entityId=".$politico->getId(). "&sfReviewType=".$politico->getType() )?>';
	$(this).parent().append('<img src="/css/ui-voota/images/ui-anim_basic_16x16.gif" alt="..." />');
	$('.reviews').tabs( "url" , 0, aUrl );
	$('.reviews').tabs( "load" , 0 );
	//facebookParseXFBML();
  }
  //-->
</script>

<div class="entity-page">
  <?php if ($politicosPager): ?>
  	<?php include_partial('general/entity_pagination', array('position' => 'top', 'pager' => $politicosPager, 'id' => $politico->getId())) ?>
  <?php endif ?>

  <h2 id="name">
    <?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?>
    <?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido()  ?>)<?php endif ?>
  	<?php include_partial('general/sparkline_box', array('reviewable' => $politico, 'id' => 'sparkline_'.$politico->getId() )) ?>
    <span class="rank">
    	<?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $politico->getSumu()), $politico->getSumu()) ?>
    </span>
  </h2>

  <div id="content">
    <div title="<?php echo secureString($politico->getNombre().' ' . $politico->getApellidos()) ?>" id="photo">
  	    <?php echo image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/bw_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
      <div class="vote">
        <h3><?php echo __('Voota sobre')?> <?php echo $politico->getApellidos(); ?></h3>
        <div id="sf_review1">
        
      	<?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review1'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $politico->getId(),
				'reviewType' => Politico::NUM_ENTITY,
				'reviewBox' => 'sf_review1',
				'redirect' => false,
				'reviewValue' => $sfr_status['v'],
				'reviewText' => '',
				'reviewToFb' => false
			)); ?>
		<?php else: ?>
	        <?php include_component_slot('sfrPreview', array(
	        	'reviewId' => false,
				'reviewBox' => 'sf_review1', 
				'reviewType' => Politico::NUM_ENTITY, 
				'reviewEntityId' => $politico->getId()
			)); ?>
      	<?php endif ?>
        </div>
      </div>
    </div>

    <div title="info" id="description">
      <?php if ($politico->getAlias() != ''): ?>
  	    <p><?php echo $politico->getSexo()=='M'?__('Conocida como %1%', array('%1%' => $politico->getAlias())):__('Conocido como %1%', array('%1%' => $politico->getAlias()))?></p>
      <?php endif ?>

      <?php if (count($politico->getPoliticoInstitucions()) > 0 || $politico->getPartido()): ?>
  	    <p>
  	      <?php if ($politico->getPartido()):?>
  	        <?php echo link_to($politico->getPartido(), "partido/show?id=".$politico->getPartido()->getAbreviatura(), array()); ?><?php if (count($politico->getPoliticoInstitucions()) > 0): ?>, <?php endif ?>
  	      <?php endif ?>
  	      <?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?>
  	        <?php
  	  	      echo link_to(
  	 	          $politicoInstitucion->getInstitucion()->getNombre(),
  	 	          "politico/ranking?partido=all&institucion=".$politicoInstitucion->getInstitucion()->getVanity(),
                array()
              )
            ?><?php endforeach ?>
  	    </p>
      <?php endif ?>
  	<?php 
  	if ($politico->getsfGuardUser() && $politico->getsfGuardUser()->getProfile()->getFechaNacimiento()){
  		$fechaNacimiento = $politico->getsfGuardUser()->getProfile()->getFechaNacimiento();
  	}
  	else {
  		$fechaNacimiento = $politico->getFechaNacimiento();
  	}
  	$lugarNacimiento = $politico->getLugarNacimiento(); 
  	?>
      <?php if ($fechaNacimiento || $lugarNacimiento): ?>
  	    <p>
  	    	<?php echo ($politico->getSexo()=='M')?__('Nacida'):__('Nacido')?>
      		<?php if ($fechaNacimiento): ?>
  	    		<?php echo __(' el %1%', array('%1%' => format_date($fechaNacimiento, 'd')))?>
  	    	<?php endif ?>
      		<?php if ($lugarNacimiento): ?>
  	    		<?php echo __(' en %1%', array('%1%' => $lugarNacimiento))?>
  	    	<?php endif ?>
      <?php endif ?>

      <?php if ($politico->getResidencia() != ''): ?>
  	    <p><?php echo __('Residente en %1%', array('%1%' => $politico->getResidencia(), 'd' ))?></p>
      <?php endif ?>

      <?php if ($politico->getFormacion() != ''): ?>
  	    <p><?php echo $politico->getFormacion()?></p>
      <?php endif ?>

  	  <h3><?php echo __('Su biografía')?></h3>

      <div title="biografia" class="bio">
        <?php echo formatBio( ($politico->getsfGuardUser() && $politico->getsfGuardUser()->getProfile()->getPresentacion())?$politico->getsfGuardUser()->getProfile()->getPresentacion():$politico->getBio() ) ?>

        <?php foreach ( $listas as $politicoLista): ?>
          <p>
            <?php echo link_to(image_tag(S3Voota::getImagesUrl().'/elecciones/cc_s_'. $politicoLista->getLista()->getConvocatoria()->getImagen(), 'alt="'. $politicoLista->getLista()->getConvocatoria() .'"'), 'eleccion/show?vanity='.$politicoLista->getLista()->getConvocatoria()->getEleccion()->getVanity().'&convocatoria='.$politicoLista->getLista()->getConvocatoria()->getNombre()) ?>
            <?php echo __('Candidato a las %eleccion%',
                       array(
                         '%partido%' => link_to($politicoLista->getLista()->getPartido(), 'partido/show?id='.$politicoLista->getLista()->getPartido()->getAbreviatura()), 
                         '%eleccion%' => link_to($politicoLista->getLista()->getConvocatoria()->getEleccion()->getNombre() . ' '. $politicoLista->getLista()->getConvocatoria()->getNombre(), 'eleccion/show?vanity='.$politicoLista->getLista()->getConvocatoria()->getEleccion()->getVanity().'&convocatoria='.$politicoLista->getLista()->getConvocatoria()->getNombre()) 
                        )) ?>
          </p>
        <?php endforeach ?>

        <?php if ($sf_user->isAuthenticated() && $politico->getSfGuardUserId() && $politico->getSfGuardUserId() == $sf_user->getGuardUser()->getId()):  ?>
          <p>
            <?php echo link_to(__('Hacer cambios en tu perfil'), '@usuario_edit') ?>
          </p>
        <?php else: ?>
        	<?php if( !$politico->getsfGuardUser() ): ?>
          <p>
            <?php echo link_to(__('¿Eres %nombre_politico%? Edita esta información', array('%nombre_politico%' => $politico)), 'politico/take?id='.$politico->getId()) ?>
          </p>
        	<?php else: ?>
            <p><?php echo link_to(__('Ver su perfil en Voota'), "perfil/show?username=".$politico->getsfGuardUser()->getProfile()->getVanity()) ?></p>
        	<?php endif ?>
        <?php endif ?>
      </div>

    </div><!-- end of description -->

    <div class="reviews">
      <ul>
        <li><a rel="nofollow" href="#tab-all-reviews"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount))  ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $politico->getId() ?>&amp;value=1&amp;sfReviewType=<?php echo Politico::NUM_ENTITY ?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $politico->getId() ?>&amp;value=-1&amp;sfReviewType=<?php echo Politico::NUM_ENTITY ?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
      </ul>

      <div id="tab-all-reviews">
        <?php include_component_slot('review_list', array('entityId' => $politico->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Politico::NUM_ENTITY, 'entity' => $politico)) ?>
      </div>

    </div>

    <div class="vote">
      <h3><?php echo __('Voota sobre %1%', array('%1%' => $politico->getApellidos()))?></h3>
      <div id="sf_review2">
        <?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review2'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $politico->getId(),
				'reviewType' => Politico::NUM_ENTITY,
				'reviewBox' => 'sf_review2',
				'redirect' => false,
				'reviewValue' => $sfr_status['v'],
				'reviewText' => '',
				'reviewToFb' => false
			)); ?>
		<?php else: ?>
	        <?php include_component_slot('sfrPreview', array(
	        	'reviewId' => false,
				'reviewBox' => 'sf_review2', 
				'reviewType' => Politico::NUM_ENTITY, 
				'reviewEntityId' => $politico->getId()
			)); ?>
      	<?php endif ?>
        </div>
    </div>

    <?php if ($politicosPager): ?>
    	<?php include_partial('general/entity_pagination', array('position' => 'bottom', 'pager' => $politicosPager, 'id' => $politico->getId())) ?>
    <?php endif ?>
  </div>
  
  <div id="sidebar">  
    <?php if(count($activeEnlaces) > 0): ?>
      <div id="external-links">  
        <h3><?php echo __('Enlaces externos')?></h3>
        <ul>
          <?php foreach($activeEnlaces as $enlace): ?>
  		      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>

    <div id="report-error">
      <?php include_partial('global/report_error', array('entity' => $politico)) ?>
    </div>

    <div id="etiquetas">
    	<?php include_partial('global/etiquetas', array('entity' => $politico)) ?>
    </div>

    <div id="twitter">
      <?php if($twitterUser):?>
        <h3><?php echo __('Últimos comentarios en Twitter')?></h3>
  	    <?php include_partial('tuits', array('user' => $twitterUser)) ?>
      <?php endif ?>
    </div>

    <div id="rss">
      <img src="/images/rss.png" alt="RSS" />
      <a href="<?php echo url_for('politico/feed?id='.$politico->getVanity())?>"><?php echo __('RSS de %name%', array('%name%' => $politico)) ?></a>
    </div>

    <div id="google-ads">
      <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
    </div><!-- end of google-ads -->
  </div>
</div>

<script type="text/javascript">
	var tracker = Blueknow.getTracker('<?php echo sfConfig::get("sf_bknumber_". $sf_user->getCulture()) ?>');

	tracker.trackVisited(
	'<?php echo $politico->getId() ?>',
	'<?php echo $politico?>',
	'<?php echo cutToLength(sq(formatBio( $politico->getBio() )), 255, '')?>',
	'<?php echo url_for('politico/show?id='.$politico->getVanity(), true)?>',
	'<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>', 
	'0',
	{
		'categoria': 'Político',
		'partido': '<?php echo $politico->getPartido()?>'
	}
	);
</script>
