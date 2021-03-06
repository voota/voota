<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoUser') ?>

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
        <li><h2><?php echo __('Lo que se dice sobre los políticos, partidos y propuestas políticas en España (ya llevamos %1% opiniones).', array('%1%' => format_number(SfVoCounter::countReviews(), 'es_ES'))) ?></h2></li>
        <li><h2><?php echo __('¿Y tu qué piensas?')?>
        <a href="<?php echo url_for('politico/ranking') ?>" title="<?php echo __('Ranking de políticos') ?>"><?php echo __('sobre políticos')?></a>,
        <a href="<?php echo url_for('partido/ranking') ?>" title="<?php echo __('Ranking de partidos') ?>"><?php echo __('sobre partidos')?></a>,
        <a href="<?php echo url_for('propuesta/ranking') ?>" title="<?php echo __('Ranking de propuestas') ?>"><?php echo __('sobre propuestas')?></a>
        o <a href="<?php echo url_for('eleccion/list') ?>" title="<?php echo __('Elecciones') ?>"><?php echo __('vota en las elecciones')?></a>.</h2></li>
        <li class="lo-mas-votado">
          <h2><?php echo __('Lo más votado de esta semana:') ?></h2>
          <ol class="entities">
            <?php foreach($reviewables as $reviewable): ?>
  	  			  <?php include_partial('reviewable_li', array('id' => "sl_t6_". $reviewable->getType() ."_".$reviewable->getId(), 'reviewable' => $reviewable, 'showVotes' => true, 'showSparkline' => false)) ?>
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
    <ol class="sf-reviews-list-brief"> 
      <?php //foreach($topReviews as $review): ?>
      <?php //include_component_slot('review_for_list', array('review' => $review)) ?>
      <?php //endforeach ?>
      <?php foreach($activities as $activity): ?>
      	<?php include_component_slot('activity_for_list', array('activity' => $activity)) ?>
      <?php endforeach ?>
    </ol>
    <p class="ranking-link"><strong><a href="<?php echo url_for('sfReviewFront/list')?>"><?php echo __('¡Tachán! Todos los vootos sobre partidos, políticos y propuestas') ?></a> (<?php echo format_number($totalUpReviews+$totalDownReviews, 'es_ES') ?>)</strong></p>
  </div>
</div>

<div class="block" id="rankings">
  <div class="block-inner">
    <div id="top5-politicos" class="entities-list-mini">
      <h3><?php echo __('Top 5 políticos')?></h3>
      <ol class="entities">
        <?php foreach($topPoliticos as $politico): ?>
  			  <?php include_partial('politico_top', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico, 'showVotes' => true, 'showSparkline' => false)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de políticos'), 'politico/ranking')?> (<?php echo format_number(SfVoCounter::countPoliticos(), 'es_ES')?>)</strong></p>
    </div>

    <div id="top5-partidos" class="entities-list-mini">
      <h3><?php echo __('Top 5 partidos')?></h3>
      <ol class="entities">
        <?php foreach($partidosMasVotados as $partido): ?>
  	  	<?php include_partial('partido_top', array('partido' => $partido, 'showSparkline' => false)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de partidos'), 'partido/ranking')?> (<?php echo format_number(SfVoCounter::countPartidos(), 'es_ES')?>)</strong></p>
    </div>

    <div id="top5-propuestas" class="entities-list-mini">
      <h3><?php echo __('Top 5 propuestas')?></h3>
      <ol class="entities">
        <?php foreach($propuestasMasVotadas as $p): ?>
  	  		<?php include_partial('propuesta_top', array('p' => $p, 'showSparkline' => false)) ?>
      	<?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de propuestas'), 'propuesta/ranking')?> (<?php echo format_number(SfVoCounter::countPropuestas(), 'es_ES')?>)</strong></p>
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
        <p><label for="q_2"><?php echo __('¡Buusca!')?></label></p>
        <p>
          <input type="text" name="q" id="q_2" value="<?php echo $sf_request->getAttribute('q') ?>" />
        </p>
        <p><button type="submit"><?php echo __('Buscar') ?></button></p>
      </form>
    </div>
  </div>
</div>