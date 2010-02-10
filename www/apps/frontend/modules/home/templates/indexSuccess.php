<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
	    <?php include_component_slot('sparkline', array('politico' => $politico)) ?>
	  <?php endforeach ?>
    <?php if(count($politicosMasVotadosUltimamente) < 6):?>
    	<?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
	  		<?php include_component_slot('sparkline', array('politico' => $politico)) ?>
    	<?php endforeach?>
	  <?php endif ?>
    <?php foreach($topPoliticos as $politico): ?>
  		<?php include_component_slot('sparkline', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico)) ?>
	  <?php endforeach?>
  });
  //-->
</script>

<?php slot('header-extra') ?>
  <div id="contact-links">
    <ul>
      <li class="blog"><a href="<?php echo __('http://blog.voota.es/es') ?>"><?php echo __('Voota tiene un blog') ?></a></li>
      <li class="twitter"><a href="<?php echo __('http://twitter.com/Voota') ?>"><?php echo __('Voota en Twitter') ?></a></li>
      <li class="facebook"><a href="<?php echo __('http://www.facebook.com/Voota') ?>"><?php echo __('Voota en Facebook') ?></a></li>
    </ul>
  </div>
<?php end_slot('logged') ?>

<div class="block" id="summary">
  <div class="block-inner">

      <ul>
        <li><h2><?php echo __('Comparte opiniones sobre políticos de España.') ?></h2></li>
        <li><h2><?php echo __('De momento llevamos %1% opiniones, de %4% personas, sobre %5% políticos.', array(
        					'%1%' => format_number($totalUpReviews+$totalDownReviews, 'es_ES'),
        					//'%2%' => format_number($totalUpReviews, 'es_ES'),
        					//'%3%' => format_number($totalDownReviews, 'es_ES'),
                			'%4%' => format_number($totalUsers, 'es_ES'),
                			'%5%' => format_number($totalPoliticos, 'es_ES'),
        				)) ?></h2></li>
        <li>
          <h2><?php echo __('Los políticos más votados de hoy:') ?></h2>
          <ol class="entities">
            <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
  	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
  	        <?php endforeach?>
            <?php if(count($politicosMasVotadosUltimamente) < 6):?>
      	      <?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
    	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => false)) ?>
              <?php endforeach?>
            <?php endif ?>
          </ol>
        </li>
      </ul>

    <div class="search">
      <form method="get" action="<?php echo url_for('@search')?>">
        <p><label for="q_1"><?php echo __('¡Buusca!')?></label></p>
        <p>
          <input type="text" name="q" id="q_1" value="<?php echo $sf_params->get('q') ?>" />
          <br />
          <span class="hints"><?php echo __('Político, partido, institución o usuario') ?></span>
        </p>
        <p><input type="submit" value="<?php echo __('Buscar') ?>" class="button" /></p>
      </form>
    </div>
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
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking general de políticos'), 'politico/ranking')?></strong></p>
    </div>

    <div id="political-groups" class="list-mini">
      <h3><?php echo __('Top 5 partidos')?></h3>
      <ol class="entities">
        <?php foreach($partidosMasVotados as $partido): ?>
  	  	<?php include_partial('partido_top', array('partido' => $partido)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Ranking de partidos'), 'partido/ranking')?></strong></p>
    </div>

    <div id="institutions" class="list-mini">
      <h3><?php echo __('Instituciones en Voota')?></h3>
      <ol class="entities">
        <?php foreach($institucionesMasVotadas as $institucion): ?>
  	  	<?php include_partial('institucion_top', array('institucion' => $institucion)) ?>
      <?php endforeach?>
      </ol>
      <p class="ranking-link"><strong><?php echo link_to(__('Listado de instituciones'), 'politico/ranking')?></strong></p>
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
          <br />
          <span class="hints"><?php echo __('Político, partido, institución o usuario') ?></span>
        </p>
        <p><input type="submit" value="<?php echo __('Buscar') ?>" class="button" /></p>
      </form>
    </div>
  </div>
</div>