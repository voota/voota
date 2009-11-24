<?php use_helper('I18N') ?>
<script type="text/javascript">
<!--
$(".<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>yeah").click(function(){
	loadReviewBox(
			'<?php echo url_for('@sf_review_form') ?>',
			1, 
			<?php echo $reviewEntityId; ?>, 
			1, 
			'<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>'
	)
});
$(".<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>buu").click(function(){
	loadReviewBox(
			'<?php echo url_for('@sf_review_form') ?>',
			1, 
			<?php echo $reviewEntityId; ?>, 
			-1, 
			'<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>'
	)
});
//-->
</script>
	
<div id="sf_review">
	<div class="clickable sfr_margin <?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>yeah" id="buttona">
	  <input name="vooto" type="radio" id="up" value="up">
	
		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
	
	  <br>
	  <span class="sfr">
		<?php echo __('A favor, yeah')?>
	  </span>
	</div>
	<div class="clickable <?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>buu">
	 <input type="radio" name="vooto" id="down" value="down">
		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		 <br>
	
	  <span class="sfr"><?php echo __('En contra, buu')?></span>
	</div>
</div>