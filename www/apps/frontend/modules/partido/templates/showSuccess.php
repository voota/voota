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
		, selected: -1
	});

 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	

  	<?php include_component_slot('sparkline', array('partido' => $partido)) ?>

  	<?php foreach($politicos->getResults() as $politico): ?>
	  		<?php include_component_slot('sparkline_politico', array('politico' => $politico)) ?>
  	<?php endforeach?>
  });
  //-->
</script>

<h2 id="name">
  <?php echo $partido->getNombre(); ?>
  (<?php echo $partido->getAbreviatura() ?>)
  <?php include_partial('sparkline_box', array('partido' => $partido)) ?>    
  <span class="rank">
    <?php echo format_number_choice('[0]0|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $partido->getSumu()), $partido->getSumu()) ?>
  </span>
</h2>

<div id="content">
  <div title="<?php echo $partido->getNombre() ?>" id="photo">
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/'.$image, 'alt="'. __('Logo de %1%', array('%1%' => $partido->getAbreviatura())) .'"') ?>
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> <?php echo $partido->getAbreviatura(); ?></h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
    </div>
  </div>

  <div id="description">
      <?php echo formatPresentacion( $partido->getPresentacion() ) ?>
  </div><!-- end of description -->

  <?php if(count($activeEnlaces) > 0): ?>
    <div id="external-links">
      <h3><?php echo __('Enlaces externos del ')?><?php echo $partido->getAbreviatura() ?></h3>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
  	      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div>
  
  <div id="report-error">
    <?php include_partial('report_error') ?>
  </div>
  
  <div id="politicians-most-voted" class="list-mini">
    <h3><?php echo __("Políticos más votados") ?> (<?php echo $partido->getAbreviatura() ?>)</h3>
    <?php if ($politicos->getNbResults() > 0): ?>
	  <?php include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido->getAbreviatura(), 'institucion' => $institucion)) ?>

      <ul>
    	<?php foreach ($politicos->getResults() as $politico): ?>
			<?php include_partial('home/politico_top', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
    	<?php endforeach ?>
      </ul>
    <?php else: ?>
      <p><?php echo __('El partido %1% aun no tiene ningún político inscrito en Voota.', array('%1%' => $partido->getAbreviatura())) ?></p>
    <?php endif ?>
  </div>

  <div class="reviews">
    <ul>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$partido->getId().'&sfReviewType='.Partido::NUM_ENTITY)?>"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount)) // TODO: sustituir número de vootos ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$partido->getId().'&value=1&sfReviewType='.Partido::NUM_ENTITY)?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
      <li><a href="<?php echo url_for('sfReviewFront/filteredList?entityId='.$partido->getId().'&value=-1&sfReviewType='.Partido::NUM_ENTITY)?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
    </ul>
    
    <?php include_component_slot('review_list', array('entityId' => $partido->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Partido::NUM_ENTITY, 'entity' => $partido)) ?>
    
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $partido->getNombre()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>
</div>