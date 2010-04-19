<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
    $('.reviews').tabs({
      load: function() {
	    FB.XFBML.Host.parseDomTree();
		}
	});

 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', <?php echo Propuesta::NUM_ENTITY ?>, <?php echo $propuesta->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', <?php echo Propuesta::NUM_ENTITY ?>, <?php echo $propuesta->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	
  });
  window.onload = function() {
    <?php include_component_slot('sparkline', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>
  }
  //-->
</script>

<h2 id="name">
  <?php echo $propuesta->getTitulo(); ?>
  <?php include_partial('general/sparkline_box', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>    
  <span class="rank">
    <?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $propuesta->getSumu()), $propuesta->getSumu()) ?>
  </span>
</h2>

<div id="content">
  <div title="<?php echo $propuesta->getTitulo() ?>" id="photo">
    <?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/'.$propuesta->getImagen(), 'alt="'. __('Logo de %1%', array('%1%' => $propuesta->getTitulo())) .'"') ?>
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> <?php echo $propuesta->getTitulo(); ?></h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
    </div>
  </div>

  <div id="description">
      <?php echo formatPresentacion( $propuesta->getDescripcion() ) ?>
  </div><!-- end of description -->

  <?php  if(count($activeEnlaces) > 0): ?>
    <div id="external-links">
      <h3><?php echo __('Enlaces externos de "%1%"', array('%1%' => $propuesta->getTitulo()))?></h3>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
  	      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif  ?>

  <div id="report-error">
    <?php include_partial('global/report_error', array('entity' => $propuesta)) ?>
  </div>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div>

  <div class="reviews">
    <ul>
      <li><a rel="nofollow" href="#tab-all-reviews"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount))  ?></a></li>
      <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$propuesta->getId().'&value=1&sfReviewType='.Propuesta::NUM_ENTITY)?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
      <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$propuesta->getId().'&value=-1&sfReviewType='.Propuesta::NUM_ENTITY)?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
    </ul>
    
    <div id="tab-all-reviews">
      <?php include_component_slot('review_list', array('entityId' => $propuesta->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Propuesta::NUM_ENTITY, 'entity' => $propuesta)) ?>
    </div>
    
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $propuesta->getTitulo()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>
</div>