<?php use_helper('I18N') ?>
<script type="text/javascript">
<!--
$(".<?php echo $reviewBox?$reviewBox:'sf_review' ?>yeah").click(function(){
	loadReviewBox(
			'<?php echo url_for('@sf_review_form') ?>',
			1, 
			<?php echo $reviewEntityId; ?>, 
			1, 
			'<?php echo $reviewBox?$reviewBox:'sf_review' ?>'
	)
});
$(".<?php echo $reviewBox?$reviewBox:'sf_review' ?>buu").click(function(){
	loadReviewBox(
			'<?php echo url_for('@sf_review_form') ?>',
			1, 
			<?php echo $reviewEntityId; ?>, 
			-1, 
			'<?php echo $reviewBox?$reviewBox:'sf_review' ?>'
	)
});
//-->
</script>
	
<div id="sf_review">
	<div class="izq clickable <?php echo $reviewBox?$reviewBox:'sf_review' ?>yeah" id="buttona">
	  <input name="vooto" type="radio" id="up" value="up">
	
		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
	
	  <br>
	  <h6>
		<?php echo __('A favor, yeah')?>
	  </h6>
	</div>
	<div class="clickable <?php echo $reviewBox?$reviewBox:'sf_review' ?>buu">
	 <input type="radio" name="vooto" id="down" value="down">
		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		 <br>
	
	  <h6><?php echo __('En contra, buu')?></h6>
	</div>
</div>