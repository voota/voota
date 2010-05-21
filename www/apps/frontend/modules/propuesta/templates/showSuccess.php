<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoUser'); ?>
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
  //-->
</script>

<?php if ($propuestasPager): ?>
	<?php include_partial('general/entity_pagination', array('position' => 'top', 'pager' => $propuestasPager, 'id' => $propuesta->getId())) ?>
<?php endif ?>

<h2 id="name">
  <?php echo $propuesta->getTitulo(); ?>
  <?php include_partial('general/sparkline_box', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>    
  <span class="rank">
    <?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $propuesta->getSumu()), $propuesta->getSumu()) ?>
  </span>
</h2>

<p id="author">
  <?php echo __('Sugerida por')?>
  <?php echo getAvatar( $propuesta->getSfGuardUser() )?>
	<a href="<?php echo url_for('perfil/show?username='.$propuesta->getSfGuardUser()->getProfile()->getVanity())?>"><?php echo $propuesta->getSfGuardUser()?></a>,
  <?php echo __('el %fecha%', array('%fecha%' => format_date($propuesta->getCreatedAt())))?>
</p>

<div id="content">
  <div title="<?php echo $propuesta->getTitulo() ?>" id="photo">
    <?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/cc_'.$propuesta->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' => $propuesta->getTitulo())) .'"') ?>
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> "<?php echo $propuesta->getTitulo(); ?>"</h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
    </div>
  </div>

  <div id="description">
    <?php echo formatPresentacion( $propuesta->getDescripcion() ) ?>
    
  <?php include_partial('doc', array('propuesta' => $propuesta)) ?>
  </div><!-- end of description -->

  <?php include_partial('enlaces', array('activeEnlaces' => $activeEnlaces, 'propuesta' => $propuesta)) ?>

  <div id="report-error">
    <?php include_partial('global/report_error', array('entity' => $propuesta)) ?>
  </div>
  
  <?php include_partial('general/boxPropuestas', array('propuestasCount' => $propuestasCount)) ?>
  
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
    <h3><?php echo __('Voota sobre %1%', array('%1%' => '"'.$propuesta->getTitulo().'"'))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>
  
  
<?php if ($propuestasPager): ?>
	<?php include_partial('general/entity_pagination', array('position' => 'top', 'pager' => $propuestasPager, 'id' => $propuesta->getId())) ?>
<?php endif ?>

</div>