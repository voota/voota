<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>





<script type="text/javascript">
<!--
$(document).ready(function(){
	politicoReady( 
			<?php echo $politico->getId(); ?>,
			'<?php echo (isset($review_v) && $review_v != '')?'form':'init';  ?>',
			'sf_review1'
		);
	politicoReady( 
			<?php echo $politico->getId(); ?>,
			'<?php echo (isset($review_v) && $review_v != '')?'form':'init';  ?>',
			'sf_review2'
		);
});
//-->
</script>







<div id="backgroundPopup"></div>  
<?php // end Review system ?>






<!-- MAIN -->
<div id="mainInterior">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeft">

<div title="ficha">
<span class="nombrePolitico"><?php echo $politico->getApellidos(); ?> (<?php echo $politico->getPartido(); ?>)</span>
<span class="nombrePeque">
<?php echo $politico->getSumU() ?> <a href="#">?</a>
</span> 
<div class="limpiar"></div>
<div title="foto" class="izq fotoPolitico">
<?php echo image_tag('https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/'.$image, 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>

  <div class="votaPolitico">
  <h5>Voota sobre <?php echo $politico->getApellidos(); ?></h5>

</div>



<div id="sf_review1"></div>





</div>
<div title="info" class="izq textoPolitico">
<h6><?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?> - <?php echo $politico->getPartido(); ?></h6>

  <div><h5>Su biografía</h5></div>

<div  title="biografia" class="margenPolitico">
  <h6><?php echo $politico->getBio(); ?></h6>
</div>
</div>
</div>
<div class="limpiar"></div>
<div class="votaSobre">

<div class="izq positivoNegativo">
<?php if($positives->getNbResults() > 0): ?>
	<div class="izq"><h5>Positivos <?php echo $positivePerc; ?>%</h5></div>
	<div class="izq linePolitico"></div>
	<div class="limpiar"></div>
	
	<?php foreach($positives->getResults() as $review): ?>
		<?php include_partial('review', array('review' => $review)) ?>
	<?php endforeach ?>
	
	<?php include_partial('pagination_full', array('pager' => $positives, 'url' => 'politico/show?id='.$politico->getId().'&', 'page_var' => "pageU")) ?>
	
<?php endif ?>


</div>

<div class="der positivoNegativo">
<?php if($negatives->getNbResults() > 0): ?>
	<div class="izq"><h5>Negativos <?php echo $negativePerc; ?>%</h5></div>
	<div class="izq linePolitico"></div>
	<div class="limpiar"></div>
	
	<?php foreach($negatives->getResults() as $review): ?>
		<?php include_partial('review', array('review' => $review)) ?>
	<?php endforeach ?>

	<?php include_partial('pagination_full', array('pager' => $positives, 'object' => $politico, 'page' => "pageD")) ?>
	
<?php endif ?>
</div>

</div>

</div>
<!-- FIN CONTENT LEFT -->
<!-- CONTENT RIGHT -->
<div id="contentRight">
<div class="tituloColor">

<?php if(count($politico->getEnlaces()) > 0): ?>
  <h5>Enlaces externos</h5>
  <div class="margenPolitico">
	<?php foreach($politico->getEnlaces() as $enlace): ?>
	  <h6><a href="<?php echo $enlace->getUrl(); ?>"><?php echo $enlace->getUrl(); ?></a></h6>
	<?php endforeach ?>
  </div>
<?php endif ?>

</div>
<!-- fin enlaces externos -->

<!-- codigo google -->
<?php include_partial('google_ads') ?>
<!-- fin codigo google -->

</div>
<!--  FIN CONTENT RIGHT -->
<div class="limpiar"></div>
<div class="votaSobre"><h5>Vota sobre <?php echo $politico->getApellidos(); ?></h5></div>


<div class="votaSobre">
	<div id="sf_review2"></div>
</div>





<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
<div class="limpiar"></div>
