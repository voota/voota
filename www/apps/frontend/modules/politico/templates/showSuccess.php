<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>





<script>  


$(document).ready(function(){
	politicoReady( <?php echo $politico->getId(); ?> );

<?php if (isset($review_v) && $review_v != '') { ?>
	loadReviewBox(1, <?php echo $politico->getId(); ?>, <?php echo $review_v ?>);
<?php } ?>
});
  
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
<?php echo image_tag('politicos/'. (file_exists(sfConfig::get('sf_upload_dir').'/politicos/'.($politico->getImagen()))?$image:'cc_p_unknown.png'), 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>

  <div class="votaPolitico">
  <h5>Voota sobre <?php echo $politico->getApellidos(); ?></h5>

</div>



<div id="sf_review">
	<div class="izq yeah" id="buttona">
	  <input name="vooto" type="radio" id="up" value="up">
	
	  <img src="/images/icoUp.gif" alt="Icono Up" width="27" height="36" longdesc="Icono mano Up">
	
	  <br>
	  <h6>
		A favor, yeah
	  </h6>
	</div>
	<div class="der buu">
	 <input type="radio" name="vooto" id="down" value="down">
	  <img src="/images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"> <br>
	
	  <h6>En contra, buu</h6>
	</div>
</div>





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
  <h5>Enlaces externos</h5>
  <div class="margenPolitico">

<?php foreach($politico->getEnlaces() as $enlace): ?>
  <h6><a href="<?php echo $enlace->getUrl(); ?>"><?php echo $enlace->getUrl(); ?></a></h6>
<?php endforeach ?>

  </div>

</div>
<!-- fin enlaces externos -->

<!-- codigo google -->

<!-- fin codigo google -->

</div>
<!--  FIN CONTENT RIGHT -->
<div class="limpiar"></div>
<div class="votaSobre"><h5>Vota sobre <?php echo $politico->getApellidos(); ?></h5></div>
<div class="votaSobre">
<div class="izq yeah">

  <input name="vooto" type="radio" value="up">
  <img src="/images/icoUp.gif" alt="Icono Up" width="27" height="36" longdesc="Icono mano Up">
  <br>
  <h6>A favor, yeah</h6> </div>

<div class="izq buu">
 <input type="radio" name="vooto" value="down">
  <img src="/images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"> <br>

  <h6>En contra, buu</h6>
</div></div>




<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
<div class="limpiar"></div>
