<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php use_helper('jQuery') ?>

<h2>Resultados</h2>

	<p> 
  	  <?php echo format_number_choice('[0]No se han encontrado resultados para "%2%"|[1]%1% resultado encontrado buscando "%2%"|(1,+Inf]%1% resultados encontrados buscando "%2%"', 
  	  		array('%1%' => format_number($total, 'es_ES'), '%2%' => strip_tags( $q )), $total) 
  	  ?>
	</p>

<?php if ( $total > 0):?>
  <table border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <?php foreach($results as $idx => $obj): ?>
        <?php if ($obj instanceof Partido): ?>
			<?php include_component_slot('partidoResult', array('obj' => $obj, 'q' => $q, 'ext' => $ext, 'counts' => $partidoCounts)) ?>
        <?php endif ?>
        <?php if ($obj instanceof Institucion): ?>
			<?php include_component_slot('institucionResult', array('obj' => $obj, 'q' => $q)) ?>
        <?php endif ?>
        
        <?php if ($obj instanceof Politico): ?>
			<?php include_component_slot('politicoResult', array('obj' => $obj, 'q' => $q, 'counts' => $politicoCounts)) ?>
        <?php endif ?>
        
        <?php if ($obj instanceof Propuesta): ?>
			<?php include_component_slot('propuestaResult', array('obj' => $obj, 'q' => $q, 'ext' => $ext, 'counts' => $propuestaCounts)) ?>
        <?php endif ?>
        
        <?php if ($obj instanceof sfGuardUser): ?>
			<?php include_component_slot('usuarioResult', array('obj' => $obj, 'q' => $q)) ?>
        <?php endif ?>
      <?php endforeach ?>
      
    </tbody>
  </table>
<?php endif ?>

<?php if ( intval($total / 15) > 1 ):?>
  <p class="pagination">
    <?php include_partial('global/array_pager', array('results' => $results, 'total' => $total, 'url' => "@search?q=$q", 'page' => $page)) ?>
  </p>
<?php endif ?>