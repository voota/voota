	<?php // LISTA ?>
  	<?php if ($reviewsPager->getNbResults() > 0): ?>
  	  <ol class="reviews-list">
    	  <?php foreach($reviewsPager->getResults() as $review): ?>
      		<?php include_component_slot('review_for_list', array('review' => $review)) ?>
		  <?php endforeach ?>
  	  </ol>
  	<?php endif ?>
  	
	<?php // BOTON MAS ?>
	<div id="<?php echo "more_fr_".$reviewsPager->getPage()?>">
	    <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
		<script type="text/javascript">
		<!--//
		  $(document).ready(function(){
			  $('#frm_more').submit(function(){
				  jQuery.ajax({
					  type:'POST',
					  dataType:'html',
					  data:jQuery($('#frm_more')).serialize(),
					  success:function(data, textStatus){jQuery('#<?php echo "more_fr_".$reviewsPager->getPage()?>').html(data);},
						url: "<?php echo url_for('sfReviewFront/listPage') ?>",
						update: '<?php echo "more_fr_".$reviewsPager->getPage() ?>',
						before: re_loading( '<?php echo "more_fr_". $reviewsPager->getPage() ?>' ),
						complete: FB.XFBML.Host.parseDomTree()
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
	  	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
	  	</form>
	    <?php endif ?>
	</div>