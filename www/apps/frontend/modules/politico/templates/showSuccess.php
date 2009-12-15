<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	

  	$("#help-dialog").dialog({autoOpen: false, resizable: false, position: 'top' });
    $('.sparkline').sparkline([<?php echo $sparklineData ?>], {normalRangeMin:0, normalRangeMax:5, fillColor:false});
  });


  //-->
</script>


<h2 class="name">
  <?php echo $politico->getApellidos(); ?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido()  ?>)<?php endif ?>
  <span class="sparkline"></span>
  
  
  <span class="rank">
    <?php if ($politico->getSumU() == 1):?>
	    <?php echo __('%1% voto positivo', array('%1%' => $politico->getSumU())) ?> 
    <?php else: ?>
	    <?php echo __('%1% votos positivos', array('%1%' => $politico->getSumU())) ?> 
    <?php endif ?>
    <a href="javascript:showScoreHelp();">?</a>
  </span>
  <div id="help-dialog" title="<?php echo __('Ayuda: Valoración de un político')?>">
  	<p><?php echo __('Este número te indica el número de votos positivos que tiene esta persona. Creemos que puede servir de ayuda para comparar este dato con otros políticos.')?></p>
  </div>
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
      <div id="sf_review1"></div>
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
	      <?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?>
	        <?php if($idx > 0):?>, <?php endif ?>
	        <?php
	  	      $url = '@ranking_'.$sf_user->getCulture('es');
	  	      echo link_to(
	 	          $politicoInstitucion->getInstitucion()->getNombre(),
	 	          "$url?partido=all&institucion=".$politicoInstitucion->getInstitucion()->getVanity(),
              array()
            )
          ?>
        <?php endforeach ?>
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
  	  <h3><?php echo __('Positivos')?> <?php if($lastPositives->getNbResults() > 0): ?><?php echo $positivePerc; ?>%<?php endif ?></h3>

  	  <?php include_partial('reviews', array('lastPager' => $lastPositives, 'pager' => $positives, 'politico' => $politico, 'reviewType' => __('positiva'), 't' => 1, 'pageU' => $pageU)) ?>
	
    </div>
	        
    <div class="negative-reviews">
	    <h3><?php echo __('Negativos')?> <?php if($lastNegatives->getNbResults() > 0): ?><?php echo $negativePerc; ?>%<?php endif ?></h3>
	
  	  <?php include_partial('reviews', array('lastPager' => $lastNegatives, 'pager' => $negatives, 'politico' => $politico, 'reviewType' => __('negativa'), 't' => -1, 'pageD' => $pageU)) ?>

    </div>
  </div>

  <div class="vote">
    <h3>Voota sobre <?php echo $politico->getApellidos(); ?></h3>
    <div id="sf_review2"></div>
  </div>

</div><!-- end of content -->

<div id="sidebar">
  <?php if(count($politico->getEnlaces()) > 0): ?>
    <div class="links">
      <h3><?php echo __('Enlaces externos')?></h3>
      <ul>
        <?php foreach($politico->getEnlaces() as $enlace): ?>
          <li><a href="<?php echo $enlace->getUrl(); ?>"><?php echo $enlace->getUrl(); ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
	<?php endif ?>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div><!-- end of google-ads -->

</div><!-- end of sidebar -->