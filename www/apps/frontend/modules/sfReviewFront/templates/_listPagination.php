<div class="pagination" id="<?php echo "more_fr_".$reviewsPager->getPage()?>">
  <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
  	<script type="text/javascript">
  	<!--//
  	  $(document).ready(function(){
  		  $('#frm_more').submit(function(){
  			  jQuery.ajax({
  				  type:'POST',
  				  dataType:'html',
  				  data:jQuery($('#frm_more')).serialize(),
  				  success:function(data, textStatus){
  				    $('.spinner').hide();
  				    $('.reviews-list').append(data);
  				    $('#page').val(parseInt($('#page').val()) + 1)
  				    FB.XFBML.Host.parseDomTree();
  				  },
  					url: "<?php echo url_for('sfReviewFront/listPage') ?>",
  					beforeSend: function(){ $('.spinner').show() }
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
	  <div class="spinner" style="display: none">
	    <img src="/images/spinner.gif" alt="cargando">
	  </div>
  <?php endif ?>
</div>