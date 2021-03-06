<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'par')) ?>
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
 	  //loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  //loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	
  });
  
  $(window).load(function(){
    <?php include_component_slot('sparkline', array('reviewable' => $partido, 'id' => 'sparkline_pt_'.$partido->getId())) ?>
  });

  function sfr_refresh( type ){
	$('.reviews').tabs( "select" , 0 );
	var aUrl = '<?php echo url_for("sfReviewFront/filteredList?value=&entityId=".$partido->getId(). "&sfReviewType=".$partido->getType() )?>';
	$(this).parent().append('<img src="/css/ui-voota/images/ui-anim_basic_16x16.gif" alt="..." />');
	$('.reviews').tabs( "url" , 0, aUrl );
	$('.reviews').tabs( "load" , 0 );
	//facebookParseXFBML();
  }

  //-->
</script>

<div class="entity-page">
  <?php if ($partidosPager): ?>
  	<?php include_partial('general/entity_pagination', array('position' => 'top', 'pager' => $partidosPager, 'id' => $partido->getId())) ?>
  <?php endif ?>

  <h2 id="name">
    <?php echo $partido->getNombre(); ?>
    (<?php echo $partido->getAbreviatura() ?>)
    <?php include_partial('general/sparkline_box', array('reviewable' => $partido, 'id' => 'sparkline_pt_'.$partido->getId())) ?>    
    <span class="rank">
      <?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $partido->getSumu()), $partido->getSumu()) ?>
      <?php echo format_number_choice('[0] y %1% votos negativos|[1] y 1 voto negativo|(1,+Inf] y %1% votos negativos', array('%1%' => $partido->getSumd()), $partido->getSumd()) ?>
    </span>
  </h2>

  <div id="content">
    <div title="<?php echo secureString($partido->getNombre()) ?>" id="photo">
      <?php echo image_tag(S3Voota::getImagesUrl().'/partidos/'.$image, 'alt="'. __('Logo de %1%', array('%1%' => $partido->getAbreviatura())) .'"') ?>
      <div class="vote">
        <h3><?php echo __('Voota sobre')?> <?php echo $partido->getAbreviatura(); ?></h3>
        <div id="sf_review1">
        <?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review1'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $partido->getId(),
				'reviewType' => Partido::NUM_ENTITY,
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
				'reviewType' => Partido::NUM_ENTITY, 
				'reviewEntityId' => $partido->getId()
			)); ?>
      	<?php endif ?>
        </div>
      </div>
    </div>

    <div id="description">
        <?php if ($partido->getPresentacion()): ?>
          <?php echo formatPresentacion( $partido->getPresentacion() ) ?>
        <?php else: ?>
          <p>
            <?php echo __('Vaya, parece ser que no tenemos texto de presentación para este partido. Si sabes algo sobre este partido, ¿qué te parece si nos lo envías tú?') ?>
            <?php echo link_to(__('Enviar información sobre este partido'), "@contact") ?>
          </p>
        <?php endif ?>

        <?php if($listas && !$convocatoria->getClosedAt()):?>
          <div id="elecciones">
            <h3><?php echo $convocatoria->getEleccion()->getNombre() ?> <?php echo $convocatoria->getNombre() ?></h3>
            <ul>
              <?php foreach($listas as $lista):?>
        	   <?php if(!$lista->getConvocatoria()->getClosedAt()):?>
                <li><a href="<?php echo url_for('lista/show?partido='.$lista->getPartido()->getAbreviatura().'&convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().'&geo='.$lista->getCircunscripcion()->getGeo())?>"><?php echo __('Lista en %1% &raquo;', array('%1%' => $lista->getCircunscripcion()->getGeo())) ?></a></li>
               <?php endif ?>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>
        
        <?php if (count($instituciones) > 0): ?>
          <p id="instituciones">
            <strong><?php echo __('Instituciones')?>:</strong>
            <?php include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido->getAbreviatura(), 'institucion' => $institucion)) ?>
          </p>
        <?php endif ?>
        <?php if ($listasGenerales || $listasAutonomicas || $listasMunicipales): ?>
          <p id="listas">
            <strong><?php echo __('Listas electorales') ?>:</strong>
          </p>
        	<?php if ($listasGenerales): ?>
          <p>
        	  <a href="<?php echo url_for('lista/list')?>"><?php echo __('Listas en las elecciones generales')?> &raquo;</a>
          </p>
        	<?php endif ?>
        	<?php if ($listasAutonomicas): ?>
          <p>
        	  <a href="<?php echo url_for('lista/list?a=1&partido='.$partido->getAbreviatura())?>"><?php echo __('Listas en las elecciones autonómicas')?> &raquo;</a>
          </p>
        	<?php endif ?>
        	<?php if ($listasMunicipales): ?>
          <p>
        	  <a href="<?php echo url_for('lista/list?m=1&partido='.$partido->getAbreviatura())?>"><?php echo __('Listas en las elecciones municipales')?> &raquo;</a>
          </p>
        	<?php endif ?>
        <?php endif ?>
    </div><!-- end of description -->

    <div class="reviews">
      <ul>
        <li><a rel="nofollow" href="#tab-all-reviews"><?php echo __('Todos los vootos, %votes_count%', array('%votes_count%' => $totalCount))  ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $partido->getId() ?>&amp;value=1&amp;sfReviewType=<?php echo Partido::NUM_ENTITY ?>"><?php echo __('Sólo positivos, %positive_votes_perc%%', array('%positive_votes_perc%' => $positivePerc)) ?></a></li>
        <li><a rel="nofollow" href="<?php echo url_for('sfReviewFront/filteredList') ?>?entityId=<?php echo $partido->getId() ?>&amp;value=-1&amp;sfReviewType=<?php echo Partido::NUM_ENTITY ?>"><?php echo __('Sólo negativos, %negative_votes_perc%%', array('%negative_votes_perc%' => $negativePerc)) ?></a></li>
      </ul>

      <div id="tab-all-reviews">
        <?php include_component_slot('review_list', array('entityId' => $partido->getId(), 'value' => '', 'page' => 1, 'sfReviewType' => Partido::NUM_ENTITY, 'entity' => $partido)) ?>
      </div>

    </div>

    <div class="vote">
      <h3><?php echo __('Voota sobre %1%', array('%1%' => $partido->getNombre()))?></h3>
      <div id="sf_review2">
        <?php if($sf_user->isAuthenticated() && $sfr_status && $sfr_status['b'] == 'sf_review2'):?>
	        <?php include_component_slot('sfrForm', array(
				'reviewId' => false,
				'reviewEntityId' => $partido->getId(),
				'reviewType' => Partido::NUM_ENTITY,
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
				'reviewType' => Partido::NUM_ENTITY, 
				'reviewEntityId' => $partido->getId()
			)); ?>
      	<?php endif ?>
      </div>
    </div>

    <?php if ($partidosPager): ?>
    	<?php include_partial('general/entity_pagination', array('position' => 'bottom', 'pager' => $partidosPager, 'id' => $partido->getId())) ?>
    <?php endif ?>
  </div>

  <div id="sidebar">  
    <div id="politicos-mas-votados" class="entities-list-mini">
      <h3><?php echo __("Los más votados") ?></h3>
      <?php if ($politicos->getNbResults() > 0): ?>
        <ul>
      	  <?php foreach ($politicos->getResults() as $politico): ?>
    		    <?php include_partial('home/politico_top', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => true, 'showSparkline' => false)) ?>
      	  <?php endforeach ?>
        </ul>
      <?php else: ?>
        <p><?php echo __('El partido %1% aun no tiene ningún político inscrito en Voota.', array('%1%' => $partido->getAbreviatura())) ?></p>
      <?php endif ?>
    </div>
    
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
    
    <div id="etiquetas">
      <?php include_partial('global/etiquetas', array('entity' => $partido)) ?>
    </div>
    
    <div id="twitter">
      <?php if($twitterUser):?>
        <h3><?php echo __('Comentarios en Twitter')?></h3>
  	    <?php include_partial('politico/tuits', array('user' => $twitterUser)) ?>
      <?php endif ?>
    </div>

    <div id="rss">
      <img src="/images/rss.png" alt="RSS" />
      <a href="<?php echo url_for('partido/feed?id='.$partido->getVanity())?>"><?php echo __('RSS de %name%', array('%name%' => $partido)) ?></a>
    </div>

    <div id="report-error">
      <?php include_partial('global/report_error', array('entity' => $partido)) ?>
    </div>

    <div id="google-ads">
      <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
    </div>
  </div>
</div>