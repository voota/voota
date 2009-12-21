<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

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

<div class="block">
  <div class="block-inner">
    <h2 id="summary">
      <ul>
        <li><?php echo __('Comparte opiniones sobre políticos de España.') ?></li>
        <li><?php echo __('De momento llevamos x.xxx opiniones (xxx positivas y xxx negativas), de xxx personas, sobre xxx políticos') ?></li>
        <li><?php echo __('Los políticos más votados de hoy:') ?></li>
      </ul>
    </h2>

    <div id="politicians-most-voted" class="list-mini">
        <ul>
          <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
	        <?php endforeach?>
          <?php if(count($politicosMasVotadosUltimamente) < 6):?>
    	      <?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
  	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => false)) ?>
            <?php endforeach?>
          <?php endif ?>
        </ul>
    </div>

    <div class="search">
      <?php echo form_tag('@search') ?>
        <p><label for="q_1">¡Buusca!</label></p>
        <p>
          <?php echo input_tag('q', $sf_params->get('q'), array('id' => 'q_1')) ?>
          <br />
          <span class="hints"><?php echo __('Político') ?></span>
        </p>
        <p><?php echo submit_tag('Buscar', array('class' => 'button')) ?></p>
      </form>
    </div>
  </div>
</div>

<div class="block">
  <div class="block-inner">
    <div id="rankings">
      <div id="politicians-top5" class="list-mini">
        <h3>Top 5 políticos</h3>
        <ol>
          <?php foreach($topPoliticos as $politico): ?>
	  			  <?php include_partial('politico_top', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
	      <?php endforeach?>
        </ol>
        <p><?php echo link_to(__('Ranking general de políticos'), 'politico/ranking')?></p>
      </div>

      <div id="political-groups" class="list-mini">
        <h3>Top 5 partidos</h3>
        <ol>
          <?php foreach($partidosMasVotados as $partido): ?>
	  	  	<?php include_partial('partido_top', array('partido' => $partido)) ?>
	      <?php endforeach?>
        </ol>
        <p><?php echo link_to(__('Todos los partidos'), 'politico/ranking')?></p>
      </div>

      <div id="institutions" class="list-mini">
        <h3>Instituciones en Voota</h3>
        <ol>
          <?php foreach($institucionesMasVotadas as $institucion): ?>
	  	  	<?php include_partial('institucion_top', array('institucion' => $institucion)) ?>
	      <?php endforeach?>
        </ol>
        <p><?php echo link_to(__('Listado de instituciones'), 'politico/ranking')?></p>
      </div>
    </div>
  </div>
</div>

<div class="block last">
  <div class="block-inner">
    <p class="signup"><?php echo link_to(__('¿Te gusta Voota? Registrarse en un plis'), '@sf_guard_signin')?></p>
    
    <div class="search">
      <?php echo form_tag('@search') ?>
        <p><label for="q_2">¡Buusca!</label></p>
        <p>
          <?php echo input_tag('q', $sf_params->get('q'), array('id' => 'q_2')) ?>
          <br />
          <span class="hints"><?php echo __('Político') ?></span>
        </p>
        <p><?php echo submit_tag('Buscar', array('class' => 'button')) ?></p>
      </form>
    </div>
  </div>
</div>