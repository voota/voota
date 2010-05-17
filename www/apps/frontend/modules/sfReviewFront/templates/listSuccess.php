<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#filterForm_f, #filterForm_text').change(function(){
        var n = $('#filterForm_f').val();
        var t = $('#filterForm_text').is(':checked');
        var theForm = $(this).closest('form');

		switch( n ){
		case "1":
			theForm.attr("action", '<?php echo url_for('sfReviewFront/list?type_id=1');?>'); 
			break;
		case "2":
			theForm.attr("action", '<?php echo url_for('sfReviewFront/list?type_id=2');?>'); 
			break;
		case "3":
			theForm.attr("action", '<?php echo url_for('sfReviewFront/list?type_id=3');?>'); 
			break;
		case "r":
			theForm.attr("action", '<?php echo url_for('sfReviewFront/list?type_id=r');?>'); 
			break;
		default:
			theForm.attr("action", '<?php echo url_for('sfReviewFront/list');?>');
		} 

		theForm.submit();
		return false;
    });
  });
</script>

<h2 class="title"><?php echo __('Todos los vootos sobre partidos, políticos y propuestas') ?></h2>
<h3 class="title"><?php echo __('Ya hay %politicos_count% sobre políticos, %partidos_count% sobre partidos y %propuestas_count% sobre propuestas', array(
	'%politicos_count%' => format_number($politicoReviewCount, 'es_ES'), 
	'%partidos_count%' => format_number($partidoReviewCount, 'es_ES'), 
	'%propuestas_count%' => format_number($propuestaReviewCount, 'es_ES'))) 
?></h3>

<div id="content">
  <?php if ($reviewsPager->getPage() == 1):?>		
  	<form id="filterForm" method="post">
  	  <p>
  	    <label for="filterForm_f"><?php echo __("Filtrar Vootos:") ?></label>
  	    <select id="filterForm_f" name="type_id">
  	      <option value=""><?php echo __("Todos los vootos") ?></option>
  	      <option value="1" <?php echo $sfReviewType==1?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre políticos") ?></option>
  	      <option value="2" <?php echo $sfReviewType==2?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre partidos") ?></option>
  	      <option value="3" <?php echo $sfReviewType==3?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre propuestas") ?></option>
  	      <option value="r" <?php echo $sfReviewType=="r"?'selected="selected"':'' ?>><?php echo __("Por respuestas a otros comentarios") ?></option>
  	    </select>
  	    <input id="filterForm_text" type="checkbox" name="t" value="1" <?php echo $text=="1"?'checked="checked"':'' ?> /><label for="filterForm_text"><?php echo __('Sólo vootos con texto') ?></label>
  	  </p>
  	</form>
  <?php endif ?>

  <?php if ($reviewsPager->getNbResults() > 0): ?>
    <ol class="reviews-list">
  	  <?php foreach($reviewsPager->getResults() as $review): ?>
    		<?php include_component_slot('review_for_list', array('review' => $review)) ?>
      <?php endforeach ?>
    </ol>
  <?php endif ?>

  <?php include_partial('listPagination', array('reviewsPager' => $reviewsPager, 'sfReviewType' => $sfReviewType, 'text' => $text)) ?>  
</div>

<div id="sidebar">
  <div id="ultimos-usuarios">
    <h3><?php echo __('Últimos en llegar a Voota') ?></h3>
    <ol>
    <?php foreach ($lastUsers as $user):?>
      <li>
        <?php echo getAvatar( $user, 19, 19 ) ?>
        <?php echo link_to(fullName( $user ), '@usuario?username='.$user->getProfile()->getVanity())?>
      </li>
    <?php endforeach?>
    </ol>
  </div>
</div>