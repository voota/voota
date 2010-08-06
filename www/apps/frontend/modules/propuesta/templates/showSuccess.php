<?php use_helper('I18N') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoUser'); ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'pro')) ?>
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

 	  //loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', <?php echo Propuesta::NUM_ENTITY ?>, <?php echo $propuesta->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  //loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', <?php echo Propuesta::NUM_ENTITY ?>, <?php echo $propuesta->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');
  });
  
  $(window).load(function(){
    <?php include_component_slot('sparkline', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>
  });
  
  $(document).ready(function(){
    $('.login-required_np').click(function(){
      <?php if (!$sf_user->isAuthenticated()): ?>
        ejem('<?php echo url_for('sfGuardAuth/signin');?>', 'propuesta/new');
        return false;
      <?php endif ?>
    });
  });

  function sfr_refresh( type ){
	$('.reviews').tabs( "select" , 0 );
	var aUrl = '<?php echo url_for("sfReviewFront/filteredList?value=&entityId=".$propuesta->getId(). "&sfReviewType=".$propuesta->getType() )?>';
	$(this).parent().append('<img src="/css/ui-voota/images/ui-anim_basic_16x16.gif" alt="..." />');
	$('.reviews').tabs( "url" , 0, aUrl );
	$('.reviews').tabs( "load" , 0 );
	//facebookParseXFBML();
  }
  //-->
</script>

<div class="entity-page">
  <?php if ($propuestasPager): ?>
  	<?php include_partial('general/entity_pagination', array('position' => 'top', 'pager' => $propuestasPager, 'id' => $propuesta->getId())) ?>
  <?php endif ?>

  <?php include_partial('titulo', array('propuesta' => $propuesta)) ?>

  <div id="content">
    <div title="<?php echo secureString($propuesta->getTitulo()) ?>" id="photo">
      <?php include_partial('photo', array('propuesta' => $propuesta)) ?>
      <div class="vote">
        <h3><?php echo __('Voota sobre')?> "<?php echo $propuesta->getTitulo(); ?>"</h3>
        <div id="sf_review1">
        <?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review1'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $propuesta->getId(),
				'reviewType' => Propuesta::NUM_ENTITY,
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
				'reviewType' => Propuesta::NUM_ENTITY, 
				'reviewEntityId' => $propuesta->getId()
			)); ?>
      	<?php endif ?>
        </div>
      </div>
    </div>

    <div id="description">
      <?php include_partial('descripcion', array('propuesta' => $propuesta)) ?>
      <?php include_partial('doc', array('propuesta' => $propuesta)) ?>
      <?php include_partial('videos', array('propuesta' => $propuesta)) ?>
    </div>

    <div class="reviews">
      <ul>
        <li><a rel="nofollow" href="#tab-all-reviews"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount))  ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $propuesta->getId() ?>&amp;value=1&amp;sfReviewType=<?php echo Propuesta::NUM_ENTITY ?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $propuesta->getId() ?>&amp;value=-1&amp;sfReviewType=<?php echo Propuesta::NUM_ENTITY ?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
      </ul>
    
      <div id="tab-all-reviews">
        <?php include_component_slot('review_list', array('entityId' => $propuesta->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Propuesta::NUM_ENTITY, 'entity' => $propuesta)) ?>
      </div>
    </div>

    <div class="vote">
      <h3><?php echo __('Voota sobre %1%', array('%1%' => '"'.$propuesta->getTitulo().'"'))?></h3>
      <div id="sf_review2">
        <?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review2'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $propuesta->getId(),
				'reviewType' => Propuesta::NUM_ENTITY,
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
				'reviewType' => Propuesta::NUM_ENTITY, 
				'reviewEntityId' => $propuesta->getId()
			)); ?>
      	<?php endif ?>      
      </div>
    </div>
  
    <?php if ($propuestasPager): ?>
  	  <?php include_partial('general/entity_pagination', array('position' => 'bottom', 'pager' => $propuestasPager, 'id' => $propuesta->getId())) ?>
    <?php endif ?>
  </div>
  
  <div id="sidebar">  
    <?php include_partial('enlaces', array('activeEnlaces' => $activeEnlaces, 'propuesta' => $propuesta)) ?>

    <div id="report-error">
      <?php include_partial('global/report_error', array('entity' => $propuesta)) ?>
    </div>
  
    <div id="etiquetas">
      <?php include_partial('global/etiquetas', array('entity' => $propuesta)) ?>
    </div>
  
    <?php include_partial('general/boxPropuestas', array('propuestasCount' => $propuestasCount)) ?>
  
    <div id="rss">
      <img src="/images/rss.png" alt="RSS" />
      <a href="<?php echo url_for('propuesta/feed?id='.$propuesta->getVanity())?>"><?php echo __('RSS de esta propuesta') ?></a>
    </div>
  
    <div id="google-ads">
      <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
    </div>
  </div>
</div>