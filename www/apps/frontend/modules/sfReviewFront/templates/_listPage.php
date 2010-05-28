	<?php // LISTA ?>
  	<?php if ($reviewsPager->getNbResults() > 0): ?>
  	  <ol class="sf-reviews-list-brief">
    	  <?php foreach($reviewsPager->getResults() as $review): ?>
      		<?php include_component_slot('review_for_list', array('review' => $review)) ?>
		  <?php endforeach ?>
  	  </ol>
  	<?php endif ?>
  	
	<?php // BOTON MAS ?>
	<div class="pagination_" id="<?php echo "more_fr_".$reviewsPager->getPage()?>">
	    <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
		<script type="text/javascript">
		<!--//
		  $(document).ready(function(){
			  $('#frm_more').submit(function(){
				  jQuery.ajax({
					  type:'POST',
					  dataType:'html',
					  data:jQuery($('#frm_more')).serialize(),
					  success:function(data, textStatus){jQuery('#<?php echo "more_fr_".$reviewsPager->getPage()?>').html(data);facebookParseXFBML()},
						url: "<?php echo url_for('sfReviewFront/listPage') ?>",
						update: '<?php echo "more_fr_".$reviewsPager->getPage() ?>',
						before: re_loading( '<?php echo "more_fr_". $reviewsPager->getPage() ?>' )
					 });
					
					return false;
			  });
		  });
		//-->
		</script>
	    <form action="#" id="frm_more">
	      <input type="hidden" id="type_id" name="type_id" value="<?php echo $sfReviewType ?>" />
	      <input type="hidden" id="page" name="page" value="<?php echo $reviewsPager->getPage()+1 ?>" />      
	      <input type="hidden" id="t" name="t" value="<?php echo $text?'text':'' ?>" />      
	  	  <input type="submit" value="<?php echo __('más') ?>" />
	  	</form>
	    <?php endif ?>
	</div>