<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>
<?php use_helper('SfReview') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
    $('.reviews').tabs();

 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 1, <?php echo $politico->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	

  	$("#help-dialog").dialog({autoOpen: false, resizable: false, position: 'top' });
  	<?php include_component_slot('sparkline', array('politico' => $politico)) ?>
  });


  //-->
</script>

<h2 id="name">
  <?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?>
  <?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido()  ?>)<?php endif ?>
	<?php include_partial('sparkline_box', array('politico' => $politico)) ?>
  <span class="rank">
    <?php if ($politico->getSumU() == 1):?>
	    <?php echo __('%1% voto positivo', array('%1%' => $politico->getSumU())) ?> 
    <?php else: ?>
	    <?php echo __('%1% votos positivos', array('%1%' => $politico->getSumU())) ?> 
    <?php endif ?>
  </span>
</h2>

<div id="content">
  <div title="<?php echo $politico->getNombre().' ' . $politico->getApellidos() ?>" id="photo">
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/'.$image, 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> <?php echo $politico->getApellidos(); ?></h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
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

    <?php if ($politico->getFechaNacimiento() != ''): ?>
	    <p><?php echo ($politico->getSexo()=='M')?__('Nacida el %1%', array('%1%' => format_date($politico->getFechaNacimiento(), 'd'))):__('Nacido el %1%', array('%1%' => format_date($politico->getFechaNacimiento(), 'd')))?></p>
    <?php endif ?>

    <?php if ($politico->getResidencia() != ''): ?>
	    <p><?php echo __('Residente en %1%', array('%1%' => $politico->getResidencia(), 'd' ))?></p>
    <?php endif ?>

    <?php if ($politico->getFormacion() != ''): ?>
	    <p><?php echo $politico->getFormacion()?></p>
    <?php endif ?>

	  <h3><?php echo __('Su biografía')?></h3>

    <div title="biografia" class="bio">
      <?php echo formatBio( $politico->getBio() ) ?>
    </div>

  </div><!-- end of description -->

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

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div><!-- end of google-ads -->

  <div class="reviews">
    <ul>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$politico->getId().'&sfReviewType='.Politico::NUM_ENTITY)?>"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => 999)) // TODO: sustituir número de vootos ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$politico->getId().'&value=1&sfReviewType='.Politico::NUM_ENTITY)?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$politico->getId().'&value=-1&sfReviewType='.Politico::NUM_ENTITY)?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
    </ul>
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $politico->getApellidos()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>

</div><!-- end of content -->