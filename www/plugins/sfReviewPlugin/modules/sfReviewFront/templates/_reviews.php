<?php use_helper('I18N') ?>

<?php if ($reviewsPager->getPage() == 1):?>
  	<form id="filterForm" method="post" action="#">
  	  <p>
  	    <label for="filterForm_f"><?php echo __("Filtrar Vootos:") ?></label>
  	    <select id="filterForm_f" name="type_id">
  	      <option value=""><?php echo __("Todos los vootos") ?></option>
  	      <option value="1" <?php echo $sfReviewType==1?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre políticos") ?></option>
  	      <option value="2" <?php echo $sfReviewType==2?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre partidos") ?></option>
  	      <option value="3" <?php echo $sfReviewType==3?'selected="selected"':'' ?>><?php echo __("Sólo vootos sobre propuestas") ?></option>
  	      <option value="null" <?php echo $sfReviewType=="null"?'selected="selected"':'' ?>><?php echo __("Por respuestas a otros comentarios") ?></option>
  	    </select>
  	    <input id="filterForm_text" type="checkbox" name="t" value="text" <?php echo $filter=="text"?'checked="checked"':'' ?> /><label for="filterForm_text"><?php echo __('Sólo vootos con texto') ?></label>
  	  </p>
  	</form>
<?php endif ?>

<ol class="sf-reviews-list-brief">
  <?php foreach($reviewsPager->getResults() as $review): ?>
	<?php include_component_slot('review_for_list', array('review' => $review)) ?>
  <?php endforeach ?>
</ol>

<?php if($reviewsPager->getPage() == 1): ?>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
	    $('.reviews ol').reviews_pagination({
	      url: "<?php echo url_for('sfReviewFront/filteredList') ?>",
	      total: <?php echo $reviewsPager->getNbResults() ?>,
	      data: { <?php if(isset($entityId)):?>entityId: "<?php echo $entityId ?>",<?php endif?>
	              <?php if(isset($value)):?>value: "<?php echo $value ?>",<?php endif?>
	              <?php if(isset($sfReviewType)):?>sfReviewType: "<?php echo $sfReviewType ?>",<?php endif?>
	              filter: "<?php echo (isset($filter) && $filter)?$filter:'' ?>",
		          slot: "reviews"
	            }
	    });
	  });
	</script>
<?php endif ?>