<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  
    $('.reviews').tabs({
      load: function() {
	      FB.XFBML.Host.parseDomTree();
		  }
		});
	
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
	    <?php echo image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/bw_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
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
	<?php 
	if ($politico->getsfGuardUser() && $politico->getsfGuardUser()->getProfile()->getFechaNacimiento()){
		$fechaNacimiento = $politico->getsfGuardUser()->getProfile()->getFechaNacimiento();
	}
	else {
		$fechaNacimiento = $politico->getFechaNacimiento();
	} 
	?>
    <?php if ($fechaNacimiento != ''): ?>
	    <p><?php echo ($politico->getSexo()=='M')?__('Nacida el %1%', array('%1%' => format_date($fechaNacimiento, 'd'))):__('Nacido el %1%', array('%1%' => format_date($fechaNacimiento, 'd')))?></p>
    <?php endif ?>

    <?php if ($politico->getResidencia() != ''): ?>
	    <p><?php echo __('Residente en %1%', array('%1%' => $politico->getResidencia(), 'd' ))?></p>
    <?php endif ?>

    <?php if ($politico->getFormacion() != ''): ?>
	    <p><?php echo $politico->getFormacion()?></p>
    <?php endif ?>

	  <h3><?php echo __('Su biografía')?></h3>

    <div title="biografia" class="bio">
      <?php echo formatBio( $politico->getsfGuardUser()?$politico->getsfGuardUser()->getProfile()->getPresentacion():$politico->getBio() ) ?>
      
      <?php if ($sf_user->isAuthenticated() && $politico->getSfGuardUserId() && $politico->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): //TODO: Cambiar true por "y es el usuario correspondiente al político" ?>
        <p>
          <?php echo link_to(__('Hacer cambios en tu perfil'), '@usuario_edit') ?>
        </p>
      <?php else: ?>
      	<?php if(!$sf_user->isAuthenticated() || ($sf_user->isAuthenticated() && !isPolitico( $sf_user->getGuardUser() ))): ?>
        <p>
          <?php echo link_to(__('¿Eres %nombre_politico%? Edita esta información', array('%nombre_politico%' => $politico)), 'politico/take?id='.$politico->getId()) ?>
        </p>
      	<?php elseif(true): // TODO: Añadir condición "si el político tiene usuario en Voota" ?>
          <p><?php echo link_to(__('Ver su perfil en Voota'), "@homepage") // TODO: Enlazar con página de perfil del usuario asociado al político ?></p>
      	<?php endif ?>
      <?php endif ?>
    </div>

  </div><!-- end of description -->

  <div id="external-links">
    <?php if(count($activeEnlaces) > 0): ?>
      <h3><?php echo __('Enlaces externos')?></h3>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
		      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    <?php endif ?>
  </div>

  <div id="report-error">
    <?php include_partial('global/report_error', array('entity' => $politico)) ?>
  </div>
	
  <div id="twitter">
    <?php if($twitterUser):?>
      <h3><?php echo __('Últimos comentarios en Twitter')?></h3>
	    <?php include_partial('tuits', array('user' => $twitterUser)) ?>
    <?php endif ?>
  </div>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div><!-- end of google-ads -->

  <div class="reviews">
    <ul>
      <li><a href="#tab-all-reviews"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount))  ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$politico->getId().'&value=1&sfReviewType='.Politico::NUM_ENTITY)?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$politico->getId().'&value=-1&sfReviewType='.Politico::NUM_ENTITY)?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
    </ul>
    
    <div id="tab-all-reviews">
      <?php include_component_slot('review_list', array('entityId' => $politico->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Politico::NUM_ENTITY, 'entity' => $politico)) ?>
    </div>
    
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $politico->getApellidos()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>

</div><!-- end of content -->