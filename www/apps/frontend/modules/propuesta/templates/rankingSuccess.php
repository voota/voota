<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('Date') ?>
<?php use_helper('VoFormat') ?>

<?php include_partial('sfReviewFront/dialog') ?>

<script type="text/javascript">    
  $(document).ready(function(){
    $('.login-required_np').click(function(){
      <?php if (!$sf_user->isAuthenticated()): ?>
        //$("#sfr_dialog_form_ub").val("propuesta/new");
        //$("#sfr_dialog").dialog('open');
        ejem('<?php echo url_for('sfGuardAuth/signin');?>', 'propuesta/new');
        return false;
      <?php endif ?>
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function (){
    $('a.tooltip_propuesta').tooltip_propuesta();
  });
</script>

<h2><?php echo __('Ranking de propuestas: de momento %count%', array('%count%' => $propuestasPager->getNbResults())) ?></h2>

<p><a class="login-required_np" href="<?php echo url_for('propuesta/new')?>"><?php echo __('Dar de alta tu propuesta política') ?></a></p>

<table class="rankings" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
        <a href="<?php echo url_for("$route".($order=='pd'?(!preg_match("/\?/",$route)?'?':'&')."o=pa":''))?>"
        	title="<?php echo __('Ordenar por votos positivos: Las más votadas primero / las menos votadas primero') ?>" 
        	rel="nofollow"><?php echo __('Votos +')?></a>
      	<?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
        <a href="<?php echo url_for("$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='nd'?'na':'nd'))?>"
        	title="<?php echo __('Ordenar por votos negativos: Las más votadas primero / las menos votadas primero') ?>" 
        	rel="nofollow"><?php echo __('Votos -')?></a>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php if (strpos($order, 'n') === 0):?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif?>
      </th>
      <th class="date">
        <a href="<?php echo url_for("$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='fd'?'fa':'fd'))?>"
        	title="<?php echo __('Ordenar por fecha: Las más recientes primero / las más antiguas primero') ?>" 
        	rel="nofollow"><?php echo __('Fecha')?></a>
      	<?php if (strpos($order, 'f') === 0):?>
      		<?php echo image_tag($order=='fd'?'flechaDown.gif':'flechaUp.gif', $order=='fd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif?>
      </th>
    </tr>
  </thead>

  <tfoot>
    <tr>
      <td class="position"></td>
      <td class="photo"></td>
      <td class="name"></td>
      <td class="voto"></td>
      <td class="positive-votes">
        <?php echo __('Total:') ?>
    	  <?php echo format_number($totalUp, 'es_ES')?>
      </td>
      <td class="negative-votes">
      	<?php echo format_number($totalDown, 'es_ES')?>
      </td>
      <td class="date"></td>
    </tr>
  </tfoot>

  <tbody>
    <?php foreach($results = $propuestasPager->getResults() as $idx => $propuesta): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="position"><?php echo format_number($propuestasPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo link_to(image_tag(S3Voota::getImagesUrl().'/'.$propuesta->getImagePath().'/cc_s_'.$propuesta->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $propuesta)) .'"'), 'propuesta/show?id='.$propuesta->getVanity()) ?>
  	    </td>
        <td class="name">
          <?php echo link_to( $propuesta->getTitulo(), 'propuesta/show?id='.$propuesta->getVanity(), array('class' => 'tooltip_propuesta', 'title' => secureString(__('Sobre esta propuesta').'|'.__('Creada el %1%', array('%1%' => format_date($propuesta->getCreatedAt()))) .'|'.cutToLength($propuesta->getDescripcion(), 200, '...', true)))) ?>
        </td>
        <td class="voto">
            <?php include_component_slot('quickvote', array('entity' => $propuesta)) ?>
        </td>
        <td class="positive-votes"><?php echo sumu($propuesta)?></td>
        <td class="negative-votes"><?php echo sumd($propuesta)?></td>
        <td class="date">
          <?php echo format_date($propuesta->getCreatedAt()) ?>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>  
</table>

<p><a class="login-required_np" href="<?php echo url_for('propuesta/new')?>"><?php echo __('Dar de alta tu propuesta política') ?></a></p>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $propuestasPager, 'url' => "$route", 'page_var' => "page", 'order' => $order)) ?>
</p>

<div class="search">
  <form method="get" action="<?php echo url_for('@search')?>">
    <fieldset>
      <input type="text" name="q" id="q2" value="<?php echo $sf_params->get('q') ?>" />
      <button type="submit"><?php echo __('Buscar') ?></button>
    </fieldset>
  </form>
</div>