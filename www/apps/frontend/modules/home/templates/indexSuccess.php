<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
	  <?php include_component_slot('sparkline', array('politico' => $politico)) ?>
	  <?php endforeach ?>
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
        <li><?php echo __('Coomparte opiniones sobre los políticos de España.') ?></li>
        <li><?php echo __('De momento: Congreso, Senado y Parlamento de Cataluña.') ?></li>
        <li><?php echo __('Los políticos más votados de hoy:') ?></li>
      </ul>
    </h2>

    <div id="content">
      <div id="politicians-most-voted" class="list-mini">
        <?php if(count($politicosMasVotadosUltimamente) == 0):?>
    	    <h2><?php echo __('Todavía no hay comentarios hoy, ¿quieres ser el primero?')?></h2>
        <?php else:?>
          <ul>
            <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
  	  			<?php include_partial('politico_li', array('politico' => $politico, 'showVotes' => true)) ?>
  	        <?php endforeach?>
    <?php if(count($politicosMasVotadosUltimamente) < 6):?>
    	<?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
  	  			<?php include_partial('politico_li', array('politico' => $politico, 'showVotes' => false)) ?>
    	<?php endforeach?>
    <?php endif ?>
          </ul>
    <?php endif?>
      </div>

      <div class="search">
        <?php echo form_tag('@search') ?>
          <p>
            <label for="q_1">¡Buusca!</label>
          </p>
          <p>
            <?php echo input_tag('q', $sf_params->get('q'), array('id' => 'q_1')) ?>
            <br />
            <span class="hints">Político, partido o institución</span>
          </p>
          <p>
            <?php echo submit_tag('Buscar', array('class' => 'button')) ?>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="block">
  <div class="block-inner">
    Segundo bloque
  </div>
</div>

<div class="block last">
  <div class="block-inner">
    Último bloque
  </div>
</div>