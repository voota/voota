<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>





<?php // Review system ?>
<script>  

var popupStatus = 0;  

$(document).ready(function(){
	$(".yeah").click(function(){
		loadReviewBox(1, <?php echo $politico->getId(); ?>, 1);
	});
	$(".buu").click(function(){
		loadReviewBox(1, <?php echo $politico->getId(); ?>, -1);
	});

	politicoReady();

<?php if (isset($review_v) && $review_v != '') { ?>
	loadReviewBox(1, <?php echo $politico->getId(); ?>, <?php echo $review_v ?>);
<?php } ?>
});
  
</script>


  
<div id="popupContact">  
    <a id="popupContactClose">x</a>  


	<div id="sf_review">
	    
	</div>


</div>  


<div id="backgroundPopup"></div>  
<?php // end Review system ?>






<!-- MAIN -->
<div id="mainInterior">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeft">

<div title="ficha">
<span class="nombrePolitico"><?php echo $politico->getApellidos(); ?> (<?php echo $politico->getPartido(); ?>)</span> <span class="nombrePeque">6/10 <a href="#">?</a></span> 
<div class="limpiar"></div>
<div title="foto" class="izq fotoPolitico">

<?php echo image_tag('politicos/'. $image, 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>

  <div class="votaPolitico">
  <h5>Voota sobre <?php echo $politico->getApellidos(); ?></h5>

</div>
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

<div class="izq"><h5>Positivos 2%</h5></div>
<div class="izq linePolitico"></div>
<div class="limpiar"></div>

<?php foreach($positives as $review): ?>
	<div title="comentario">
	<div class="margenPolitico">
		<h6><img src="/images/icoUser.jpg" alt="Icono usuario"> <a href="#"><?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?></a> · <span class="lugar">Madrid · 33 años</span></h6>
	</div>
	<div class="margenPolitico">
	<h6><?php echo $review->getText(); ?></h6>
	  </div>
	</div>
<?php endforeach ?>




</div>
<div class="der positivoNegativo">
<div class="izq"><h5>Negativos 98%</h5></div>
<div class="izq linePolitico"></div>
<div class="limpiar"></div>

<?php foreach($negatives as $review): ?>
	<div title="comentario">
	<div class="margenPolitico">
		<h6><img src="/images/icoUser.jpg" alt="Icono usuario"> <a href="#"><?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?></a> · <span class="lugar">Madrid · 33 años</span></h6>
	</div>
	<div class="margenPolitico">
	<h6><?php echo $review->getText(); ?></h6>
	  </div>
	</div>
<?php endforeach ?>


</div>
</div>
<div class="limpiar"></div>
<div class="totalComentarios"><h6><a href="#">Todos los comentarios que <?php echo $politico->getApellidos(); ?> tiene hasta ahora (112)</a></h6>
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

<div class="izq">
 <input type="radio" name="vooto" value="down">
  <img src="/images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"> <br>

  <h6>En contra, buu</h6>
</div></div>




<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
<div class="limpiar"></div>
