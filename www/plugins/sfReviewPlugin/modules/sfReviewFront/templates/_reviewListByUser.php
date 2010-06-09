<?php use_helper('I18N') ?>

<?php if ($reviewsPager->getPage() == 1):?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#filterForm_f, #filterForm_text').change(function(){
        var n = $('#filterForm_f').val();
        var t = $('#filterForm_text').is(':checked');
        var theForm = $(this).closest('form');

		theForm.submit();
		return false;
    });
  });
</script>
	
	<form id="filterForm" method="post" action="<?php echo url_for( '@'.sfContext::getInstance()->getRouting()->getCurrentRouteName(). (isset($user) && $sf_request->getParameter('action') == 'show'?'?username='.$user->getProfile()->getVanity():'') )?>#filterForm">
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


<?php if($reviewsPager->getPage() == 1): ?><ol class="sf-reviews-list-brief"><?php endif ?>
  <?php foreach($reviewsPager->getResults() as $review): ?>
	<?php include_component_slot('profileReview', array('review' => $review)) ?>
  <?php endforeach ?>
<?php if($reviewsPager->getPage() == 1): ?></ol><?php endif ?>

<?php if($reviewsPager->getPage() == 1): ?>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
	    $('.reviews ol:first').reviews_pagination({
	      url: "<?php echo url_for('sfReviewFront/filteredList') ?>",
	      total: <?php echo $reviewsPager->getNbResults() ?>,
	      data: { <?php if(isset($entityId)):?>entityId: "<?php echo $entityId ?>",<?php endif?>
	              <?php if(isset($value)):?>value: "<?php echo $value ?>",<?php endif?>
	              <?php if(isset($sfReviewType)):?>sfReviewType: "<?php echo $sfReviewType ?>",<?php endif?>
	              <?php if(isset($user	)):?>userId: "<?php echo $user->getId() ?>",<?php endif?>
	              filter: "<?php echo (isset($filter) && $filter)?$filter:'' ?>",
		          slot: "review_list_by_user"
	            }
	      , summaryTemplate: '<?php echo '<p>'. __('Mostrando %1% comentarios de %2%', array('%1%' => '<strong class="reviews_count"></strong>', '%2%' => '<strong class="reviews_total"></strong>')) .'</p>' ?>'
		  , buttonText: '<?php echo __('más') ?>'
	    });
	  });
	</script>
<?php endif ?>