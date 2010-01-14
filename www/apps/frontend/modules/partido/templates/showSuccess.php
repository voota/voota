<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
 	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review1');
	  loadReviewBox('<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>', 2, <?php echo $partido->getId(); ?>, <?php echo isset($review_v)?$review_v:'0' ?>, 'sf_review2');	

  	<?php include_component_slot('sparkline', array('partido' => $partido)) ?>
  });
  //-->
</script>
<h2 id="name">
  <?php echo $partido->getNombre(); ?>
  (<?php echo $partido->getAbreviatura() ?>)
  <?php include_partial('sparkline_box', array('partido' => $partido)) ?>    
  <span class="rank">
    18 <?php echo __('votos positivos') ?> 
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

  <div id="politicians-most-voted" class="list-mini">
    <h3><?php echo __("Políticos más votados") ?> (<?php echo $partido->getAbreviatura() ?>)</h3>
    <?php // Probablemente quieras aquí algo parecido a lo que hay en politico/rankingSuccess. ?>
    <?php // Hay que pasar las variables $instituciones e $institucion ?>
    <ul>
      <li>
      	<div class="avatar">
        	<img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" />
        </div>
      	<h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
        <p class="votes">
      	  <span title="Evolución del número de votos positivos por mes (último punto = mes
       actual)" id="sparkline_t_238"><img src="/images/proto/sparkline.png"></span>
      		<span class="votes-count">3&nbsp;positivos</span>
      	</p>
      </li>
      <li>
      	<div class="avatar">
        	<img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" />
        </div>
      	<h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
        <p class="votes">
      	  <span title="Evolución del número de votos positivos por mes (último punto = mes
       actual)" id="sparkline_t_238"><img src="/images/proto/sparkline.png"></span>
      		<span class="votes-count">3&nbsp;positivos</span>
      	</p>
      </li>
      <li>
      	<div class="avatar">
        	<img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" />
        </div>
      	<h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
        <p class="votes">
      	  <span title="Evolución del número de votos positivos por mes (último punto = mes
       actual)" id="sparkline_t_238"><img src="/images/proto/sparkline.png"></span>
      		<span class="votes-count">3&nbsp;positivos</span>
      	</p>
      </li>
      <li>
      	<div class="avatar">
        	<img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" />
        </div>
      	<h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
        <p class="votes">
      	  <span title="Evolución del número de votos positivos por mes (último punto = mes
       actual)" id="sparkline_t_238"><img src="/images/proto/sparkline.png"></span>
      		<span class="votes-count">3&nbsp;positivos</span>
      	</p>
      </li>
    </ul>
  </div>

  <div class="reviews">
    <div class="positive-reviews">
  	  <h3>
    	  <?php echo format_number_choice('[0]0 positivo|[1]%1% positivo &#40;%2%%&#41;|(1,+Inf]%1% positivos &#40;%2%%&#41;', 
    	  		array('%1%' => format_number($partido->getSumu(), 'es_ES'), '%2%' => format_number($positivePerc, 'es_ES'))
    	  		, $partido->getSumu()) 
    	  ?>
  	  </h3>

  	  <?php include_partial('reviews', array('lastPager' => $lastPositives, 'pager' => $positives, 'partido' => $partido, 'reviewType' => __('positiva'), 't' => 1, 'pageU' => $pageU, $type_id = 2)) ?>
	
    </div>
	        
    <div class="negative-reviews">
	    <h3>
	  	  <?php echo format_number_choice('[0]0 negativo|[1]%1% negativo &#40;%2%%&#41;|(1,+Inf]%1% negativos &#40;%2%%&#41;', 
	  	  		array('%1%' => format_number($partido->getSumD(), 'es_ES'), '%2%' => format_number($negativePerc, 'es_ES'))
	  	  		, $partido->getSumD()) 
	  	  ?>
	    </h3>
	
  	  <?php include_partial('reviews', array('lastPager' => $lastNegatives, 'pager' => $negatives, 'partido' => $partido, 'reviewType' => __('negativa'), 't' => -1, 'pageD' => $pageU, $type_id = 2)) ?>

    </div>
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $partido->getNombre()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>
</div>