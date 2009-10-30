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
	
	  <img src="/images/icoUp.gif" alt="Icono Up" width="27" height="36" longdesc="Icono mano Up">
	
	  <br>
	  <h6>
		A favor, yeah
	  </h6>
	</div>
	<div class="der clickable <?php echo $reviewBox?$reviewBox:'sf_review' ?>buu">
	 <input type="radio" name="vooto" id="down" value="down">
	  <img src="/images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"> <br>
	
	  <h6>En contra, buu</h6>
	</div>
</div>