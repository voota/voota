<script type="text/javascript">
<!--
$(".yeah").click(function(){
	loadReviewBox(
			1, 
			<?php echo $reviewEntityId; ?>, 
			1, 
			'form', 
			'<?php echo $reviewBox?$reviewBox:'sf_review' ?>'
	)
});
$(".buu").click(function(){
	loadReviewBox(
			1, 
			<?php echo $reviewEntityId; ?>, 
			-1, 
			'form', 
			'<?php echo $reviewBox?$reviewBox:'sf_review' ?>'
	)
});
//-->
</script>
	
<div id="sf_review">
	<div class="yeah">yeah</div>
	<div class="buu">buu</div>
</div>