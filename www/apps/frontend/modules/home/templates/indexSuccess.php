<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript">
  $(window).load(function(){
    <?php /*if(count($politicosMasVotadosUltimamente) < 6):?>
    	<?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
	  		<?php include_component_slot('sparkline', array('reviewable' => $politico, 'id' => "sparkline_".$politico->getId())) ?>
    	<?php endforeach?>
	  <?php endif */?>
    <?php foreach($reviewables as $reviewable): ?>
	    <?php include_component_slot('sparkline', array('reviewable' => $reviewable, 'id' => "sl_t6_". $reviewable->getType() ."_".$reviewable->getId())) ?>
	  <?php endforeach ?>
	  <?php foreach($topPoliticos as $politico): ?>
  		<?php include_component_slot('sparkline', array('id' => "sparkline_t_".$politico->getId(), 'reviewable' => $politico)) ?>
	  <?php endforeach?>
    <?php foreach($partidosMasVotados as $partido): ?>
  		<?php include_component_slot('sparkline', array('id' => "sparkline_tp_".$partido->getId(), 'reviewable' => $partido)) ?>
	  <?php endforeach?>
    <?php foreach($propuestasMasVotadas as $p): ?>
  		<?php include_component_slot('sparkline', array('id' => "sparkline_tpr_".$p->getId(), 'reviewable' => $p)) ?>
	  <?php endforeach?>
  });
</script>

<?php slot('header-extra') ?>
  <div id="contact-links">
    <ul>
      <li class="blog"><a href="<?php echo __('http://blog.voota.es') ?>"><?php echo __('Voota tiene un blog') ?></a></li>
      <li class="twitter"><a href="<?php echo __('http://twitter.com/Voota') ?>"><?php echo __('Voota en Twitter') ?></a></li>
      <li class="facebook"><a href="<?php echo __('http://www.facebook.com/Voota') ?>"><?php echo __('Voota en Facebook') ?></a></li>
    </ul>
  </div>
<?php end_slot('logged') ?>

<div class="block" id="summary">
  <div class="block-inner">

      <ul>
        <li><h2><?php echo __('Opiniones sobre políticos, partidos y propuestas políticas en España.') ?></h2></li>
        <li><h2>
        	<?php echo __('%1% opiniones, de %4% personas, sobre ', array(
        					'%1%' => format_number($totalUpReviews+$totalDownReviews, 'es_ES'),
        					//'%2%' => format_number($totalUpReviews, 'es_ES'),
        					//'%3%' => format_number($totalDownReviews, 'es_ES'),
                			'%4%' => format_number($topTotalUsers, 'es_ES')
        	)) ?>
        	<a href="<?php echo url_for('politico/ranking') ?>" title="<?php echo __('Ranking de políticos')?>">
        	<?php echo __('%5% políticos', array(
                			'%5%' => format_number($topTotalPoliticos, 'es_ES')
        	)) ?></a>,
        	<a href="<?php echo url_for('partido/ranking') ?>" title="<?php echo __('Ranking de partidos')?>">
        	<?php echo __('%5% partidos', array(
                			'%5%' => format_number($topTotalPartidos, 'es_ES')
        	)) ?></a>
        	<?php echo __('y')?>
        	<a href="<?php echo url_for('propuesta/ranking') ?>" title="<?php echo __('Ranking de propuestas')?>">
        	<?php echo __('%5% propuestas', array(
                			'%5%' => format_number($topTotalPropuestas, 'es_ES')
        	)) ?></a>.
        				
        </h2></li>
        <li class="lo-mas-votado">
          <h2><?php echo __('Lo más votado de esta semana:') ?></h2>
          <ol class="entities">
            <?php foreach($reviewables as $reviewable): ?>
  	  			  <?php include_partial('reviewable_li', array('id' => "sl_t6_". $reviewable->getType() ."_".$reviewable->getId(), 'reviewable' => $reviewable, 'showVotes' => true)) ?>
  	        <?php endforeach?>
            <?php /* if(count($reviewables) < 6):?>
      	      <?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
    	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => false)) ?>
              <?php endforeach?>
            <?php endif */ ?>
          </ol>
        </li>
      </ul>
  </div>
</div>

<div class="block" id="ultimos-vootos">
  <div class="block-inner">
    <h3><?php echo __('Últimos 5 vootos')?></h3>
    <ol class="reviews-list"> 
      <?php // TODO: Eliminar reviews de ejemplo y cargarlas usando el foreach y partial comentado más abajo ?>
      <li class="review" id="sf_review_c_m9"> 
        <p class="review-body"> 
            </p> 
        <p class="review-author"> 
          <img alt="Herick Manuel Campos Arteseros" width="36" height="36" src="http://images.voota.es/usuarios/v.png" />    <a href="/frontend_dev.php/Carlos-Paramio">Herick Manuel Campos Arteseros</a>    ,
          sobre        <a href="#">Partido Socialista (PSOE)</a> 
          ,
          <a href="/frontend_dev.php/r/9">Hace 6 días</a>      	  		<img alt="yeah" src="/images/icoMiniUp.png" />  	  </p> 
      </li>    		    		  

      <li class="review" id="sf_review_c_m11"> 
        <p class="review-body"> 
          Opino lo mismo  </p> 
        <p class="review-author"> 
          <img alt="Carlos Test1" width="36" height="36" src="http://images.voota.es/usuarios/v.png" />    <a href="/frontend_dev.php/Carlos-Test01">Carlos Test1</a>    ,
          sobre        <a href="#">Partido Socialista (PSOE)</a> 
          ,
          <a href="/frontend_dev.php/r/11">Hace 2 semanas</a>      	  		<img alt="yeah" src="/images/icoMiniUp.png" />  	  </p> 
      </li>    		    		  

      <li class="review" id="sf_review_c_m10"> 
        <p class="review-body"> 
          Test  </p> 
        <p class="review-author"> 
          <img alt="Carlos Test1" width="36" height="36" src="http://images.voota.es/usuarios/v.png" />    <a href="/frontend_dev.php/Carlos-Test01">Carlos Test1</a>    ,
          sobre        <a href="#">Partido Socialista (PSOE)</a> 
          ,
          <a href="/frontend_dev.php/r/10">Hace 3 semanas</a>      		<img alt="buu" src="/images/icoMiniDown.png" />  	  	  </p> 
      </li>    		    		  

      <li class="review" id="sf_review_c_m8"> 
        <p class="review-body"> 
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p> 
        <p class="review-author"> 
          <img alt="Herick Manuel Campos Arteseros" width="36" height="36" src="http://images.voota.es/usuarios/v.png" />    <a href="/frontend_dev.php/Carlos-Paramio">Herick Manuel Campos Arteseros</a>    ,
          sobre        <a href="#">Partido Socialista (PSOE)</a> 
          ,
          <a href="/frontend_dev.php/r/8">Hace 3 semanas</a>      	  		<img alt="yeah" src="/images/icoMiniUp.png" />  	  </p> 
      </li>
      <?php //foreach($topReviews as $review): ?>
        <?php //include_partial('sfReviewFront/reviewForList', array('review' => $review)) ?>
      <?php //endforeach ?>
    </ol>
  </div>
</div>

<div class="block" id="rankings">
  <div class="block-inner">
    <div id="politicians-top5" class="list-mini">
      <h3><?php echo __('Top 5 políticos')?></h3>
      <ol class="entities">
        <?php foreach($topPoliticos as $politico): ?>
  			  <?php include_partial('politico_top', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de políticos'), 'politico/ranking')?> (<?php echo format_number($totalPoliticos, 'es_ES')?>)</strong></p>
    </div>

    <div id="political-groups" class="list-mini">
      <h3><?php echo __('Top 5 partidos')?></h3>
      <ol class="entities">
        <?php foreach($partidosMasVotados as $partido): ?>
  	  	<?php include_partial('partido_top', array('partido' => $partido)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de partidos'), 'partido/ranking')?> (<?php echo format_number($totalPartidos, 'es_ES')?>)</strong></p>
    </div>

    <div id="proposals-top5" class="list-mini">
      <h3><?php echo __('Top 5 propuestas')?></h3>
      <ol class="entities">
        <?php foreach($propuestasMasVotadas as $p): ?>
  	  		<?php include_partial('propuesta_top', array('p' => $p)) ?>
      	<?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de propuestas'), 'propuesta/ranking')?> (<?php echo format_number($totalPropuestas, 'es_ES')?>)</strong></p>
    </div>
  </div>
</div>

<div class="block last">
  <div class="block-inner">
    <?php if (!$sf_user->isAuthenticated()): ?>
      <p class="signup"><?php echo link_to(__('¿Te gusta Voota? Registrarse en un plis'), '@sf_guard_signin')?></p>    
    <?php endif ?>

    <div class="search">
      <form method="get" action="<?php echo url_for('@search')?>">
        <p><label for="q_1"><?php echo __('¡Buusca!')?></label></p>
        <p>
          <input type="text" name="q" id="q_2" value="<?php echo $sf_params->get('q') ?>" />
        </p>
        <p><button type="submit"><?php echo __('Buscar') ?></button></p>
      </form>
    </div>
  </div>
</div>