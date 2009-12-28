<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	

  	$("#help-dialog").dialog({autoOpen: false, resizable: false, position: 'top' });
  	<?php include_component_slot('sparkline', array('politico' => $politico)) ?>
  });


  //-->
</script>


<h2 class="name">
  <?php echo $politico->getApellidos(); ?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido()  ?>)<?php endif ?>
  	<?php include_partial('sparkline_box', array('politico' => $politico)) ?>
  
  
  <span class="rank">
    <?php if ($politico->getSumU() == 1):?>
	    <?php echo __('%1% voto positivo', array('%1%' => $politico->getSumU())) ?> 
    <?php else: ?>
	    <?php echo __('%1% votos positivos', array('%1%' => $politico->getSumU())) ?> 
    <?php endif ?>
    <?php /* ?><a href="javascript:showScoreHelp();">?</a><?php */ ?>
  </span>
  <?php /* ?>
  <div id="help-dialog" title="<?php echo __('Ayuda: Valoración de un político')?>">
  	<p><?php echo __('Este número te indica el número de votos positivos que tiene esta persona. Creemos que puede servir de ayuda para comparar este dato con otros políticos.')?></p>
  </div>
  <?php */ ?>
</h2>

<div id="content">

  <?php /*
    <?php 
    	echo link_to(__('Listado de políticos, (%1%, %2%)', array(
    		'%1%' => $partido==''?__('Todos los partidos'):$partido
    		, '%2%' => $institucion==''?__('Todas las instituciones'):$institucion
    	)), $rankingUrl) ?>
   */?>

  <div title="<?php echo $politico->getNombre().' ' . $politico->getApellidos() ?>" class="photo">
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/'.$image, 'alt="'. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> <?php echo $politico->getApellidos(); ?></h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', __('cargando'))?></div>
    </div>
  </div>
    
  <div title="info" class="description">
    <p>
      <?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?>
      <?php if ($politico->getPartido()):?>
        - 
        <?php $url = "@ranking_".$sf_user->getCulture('es')."_partido"; ?>
        <?php echo link_to($politico->getPartido(), "$url?partido=".$politico->getPartido(), array()); ?>
      <?php endif ?>
    </p>

    <?php if ($politico->getAlias() != ''): ?>
	    <p><?php echo __($politico->getSexo()=='M'?'Conocida como %1%':'Conocido como %1%', array('%1%' => $politico->getAlias()))?></p>
    <?php endif ?>

    <?php if (count($politico->getPoliticoInstitucions()) > 0): ?>
	    <p>
	      <?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?>
	        <?php
	  	      $url = '@ranking_'.$sf_user->getCulture('es');
	  	      echo link_to(
	 	          $politicoInstitucion->getInstitucion()->getNombre(),
	 	          "$url?partido=all&institucion=".$politicoInstitucion->getInstitucion()->getVanity(),
              array()
            )
          ?><?php endforeach ?>
	    </p>
    <?php endif ?>

    <?php if ($politico->getFechaNacimiento() != ''): ?>
	    <p><?php echo __($politico->getSexo()=='M'?'Nacida el %1%':'Nacido el %1%', array('%1%' => format_date($politico->getFechaNacimiento(), 'd')))?></p>
    <?php endif ?>

    <?php if ($politico->getResidencia() != ''): ?>
	    <p><?php echo __('Residente en %1%', array('%1%' => $politico->getResidencia(), 'd' ))?></p>
    <?php endif ?>

    <?php if ($politico->getFormacion() != ''): ?>
	    <p><?php echo $politico->getFormacion()?></p>
    <?php endif ?>

	  <h3><?php echo __('Su biografía')?></h3>

    <div title="biografia" class="bio">
      <p><?php echo formatBio( $politico->getBio() ) ?></p>
    </div>

  </div><!-- end of description -->

  <div class="reviews">
    <div class="positive-reviews">
  	  <h3>  	  
  	  <?php echo format_number_choice('[0]Positivos|[1]%1% positivo &#40;%2%%&#41;|(1,+Inf]%1% positivos &#40;%2%%&#41;', 
  	  		array('%1%' => format_number($politico->getSumU(), 'es_ES'), '%2%' => format_number($positivePerc, 'es_ES'))
  	  		, $politico->getSumU()) 
  	  ?>
  	  </h3>

  	  <?php include_partial('reviews', array('lastPager' => $lastPositives, 'pager' => $positives, 'politico' => $politico, 'reviewType' => __('positiva'), 't' => 1, 'pageU' => $pageU)) ?>
	
    </div>
	        
    <div class="negative-reviews">
	    <h3>
	  	  <?php echo format_number_choice('[0]Negativos|[1]%1% negativo &#40;%2%%&#41;|(1,+Inf]%1% negativos &#40;%2%%&#41;', 
	  	  		array('%1%' => format_number($politico->getSumD(), 'es_ES'), '%2%' => format_number($negativePerc, 'es_ES'))
	  	  		, $politico->getSumD()) 
	  	  ?>
	    </h3>
	
  	  <?php include_partial('reviews', array('lastPager' => $lastNegatives, 'pager' => $negatives, 'politico' => $politico, 'reviewType' => __('negativa'), 't' => -1, 'pageD' => $pageU)) ?>

    </div>
  </div>

  <div class="vote">
    <h3>Voota sobre <?php echo $politico->getApellidos(); ?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', __('cargando'))?></div>
  </div>

</div><!-- end of content -->

<div id="sidebar">
  <?php if(count($politico->getEnlaces()) > 0): ?>
    <div class="links">
      <h3><?php echo __('Enlaces externos')?></h3>
      <ul>
        <?php foreach($politico->getEnlaces() as $enlace): ?>
          <li><a href="<?php echo $enlace->getUrl(); ?>"><?php echo urldecode($enlace->getUrl()) ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
	<?php endif ?>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div><!-- end of google-ads -->

</div><!-- end of sidebar -->