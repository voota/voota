<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>


<script type="text/javascript">
<!--
$(document).ready(function(){
	loadReviewBox( 
			'<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>',
			1,
			<?php echo $politico->getId(); ?>,
			<?php echo isset($review_v)?$review_v:'0' ?>,
			'sf_review1'
		);
	loadReviewBox( 
			'<?php echo (isset($review_v) && $review_v != '')?url_for('@sf_review_form'):url_for('@sf_review_init')  ?>',
			1,
			<?php echo $politico->getId(); ?>,
			<?php echo isset($review_v)?$review_v:'0' ?>,
			'sf_review2'
		);	

	$("#help_dialog").dialog({autoOpen: false, resizable: false, position: 'top' });
});
//-->
</script>





<div id="backgroundPopup"></div>  
<?php // end Review system ?>




<div id="help_dialog" title="<?php echo __('Ayuda: Valoración de un político')?>">
	<p><?php echo __('Este número te indica el número de votos positivos que tiene esta persona. Creemos que puede servir de ayuda para comparar este dato con otros políticos.')?></p>
</div>


<!-- MAIN -->
<div id="mainInterior">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeft">

<?php /*
<h6><?php 
	echo link_to(__('Listado de políticos, (%1%, %2%)', array(
		'%1%' => $partido==''?__('Todos los partidos'):$partido
		, '%2%' => $institucion==''?__('Todas las instituciones'):$institucion
	)), $rankingUrl) ?>
</h6>
<p></p>
 */?>

<div title="ficha">
<span class="nombrePolitico"><?php echo $politico->getApellidos(); ?><?php if ($politico->getPartido()):?> (<?php 
	  	echo $politico->getPartido()  ?>)<?php endif ?></span>
<span class="nombrePeque negro">
<?php if ($politico->getSumU() == 1):?>
	<?php echo __('%1% voto positivo', array('%1%' => $politico->getSumU())) ?> 
<?php else: ?>
	<?php echo __('%1% votos positivos', array('%1%' => $politico->getSumU())) ?> 
<?php endif ?>
 <a href="javascript:showScoreHelp();">?</a>
</span> 
<div class="limpiar"></div>
<div title="<?php echo $politico->getNombre().' ' . $politico->getApellidos() ?>" class="izq fotoPolitico">
<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/'.$image, 'alt="'. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>

<div class="votaPolitico">
  <h5><?php echo __('Voota sobre')?> <?php echo $politico->getApellidos(); ?></h5>
</div>



<div id="sf_review1"></div>





</div>
<div title="info" class="izq textoPolitico">

<h6><?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?><?php if ($politico->getPartido()):?> - <?php 
	  	$url = "@ranking_".$sf_user->getCulture('es')."_partido";
	  	echo link_to(
	 	$politico->getPartido()
	 	, "$url?partido=".$politico->getPartido()
	 	, array());  ?><?php endif ?></h6>
<?php if ($politico->getAlias() != ''): ?>
	<h6><?php echo __($politico->getSexo()=='M'?'Conocida como %1%':'Conocido como %1%', array('%1%' => $politico->getAlias()))?></h6>
<?php endif ?>
<?php if (count($politico->getPoliticoInstitucions()) > 0): ?>
	<h6>
	<?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php 
	  	$url = '@ranking_'.$sf_user->getCulture('es');
	  	echo link_to(
	 	$politicoInstitucion->getInstitucion()->getNombre()
	 	, "$url?partido=all&institucion=".$politicoInstitucion->getInstitucion()->getVanity()
	 	, array())
	 
	?><?php endforeach ?>
	</h6>
<?php endif ?>
<?php if ($politico->getFechaNacimiento() != ''): ?>
	<h6><?php echo __($politico->getSexo()=='M'?'Nacida el %1%':'Nacido el %1%', array('%1%' => format_date( $politico->getFechaNacimiento(), 'd' )))?></h6>
<?php endif ?>
<?php if ($politico->getResidencia() != ''): ?>
	<h6><?php echo __('Residente en %1%', array('%1%' => $politico->getResidencia(), 'd' ))?></h6>
<?php endif ?>
<?php if ($politico->getFormacion() != ''): ?>
	<h6><?php echo $politico->getFormacion()?></h6>
<?php endif ?>

	  <div><h5><?php echo __('Su biografía')?></h5></div>

<div  title="biografia" class="margenPolitico">
  <h6><?php echo formatBio( $politico->getBio() ) ?></h6>
</div>
</div>
</div>
<div class="limpiar"></div>
<div class="contenedorPositivoNegativo">

<div class="izq positivoNegativo">
	<div class="izq"><h5><?php echo __('Positivos')?> <?php if($positives->getNbResults() > 0): ?><?php echo $positivePerc; ?>%<?php endif ?></h5></div>
	<div class="izq linePolitico"></div>
	<div class="limpiar"></div>
	
<?php if($positives->getNbResults() > 0): ?>
	<?php foreach($positives->getResults() as $review): ?>
		<?php include_partial('review', array('review' => $review)) ?>
	<?php endforeach ?>
<?php else: ?>
	<h6><br><?php echo __('Aún no hay ninguna opinión positiva de %1%', array('%1%' => $politico))?></h6>
<?php endif ?>
	
	<?php include_partial('pagination_full', array('pager' => $positives, 'url' => 'politico/show?id='.$politico->getVanity().'&', 'page_var' => "pageU")) ?>
	


</div>

<div class="der positivoNegativo">
	<div class="izq"><h5><?php echo __('Negativos')?> <?php if($negatives->getNbResults() > 0): ?><?php echo $negativePerc; ?>%<?php endif ?></h5></div>
	<div class="izq linePolitico"></div>
	<div class="limpiar"></div>
	
<?php if($negatives->getNbResults() > 0): ?>
	<?php foreach($negatives->getResults() as $review): ?>
		<?php include_partial('review', array('review' => $review)) ?>
	<?php endforeach ?>
<?php else: ?>
	<h6><br><?php echo __('Aún no hay ninguna opinión negativa de %1%', array('%1%' => $politico))?></h6>
<?php endif ?>
	<?php include_partial('pagination_full', array('pager' => $negatives, 'url' => 'politico/show?id='.$politico->getVanity().'&', 'page_var' => "pageD")) ?>
	
</div>

</div>

</div>
<!-- FIN CONTENT LEFT -->
<!-- CONTENT RIGHT -->
<div id="contentRight">
<div class="tituloColor">

<?php if(count($politico->getEnlaces()) > 0): ?>
  <h5><?php echo __('Enlaces externos')?></h5>
  <div class="margenPolitico">
	<?php foreach($politico->getEnlaces() as $enlace): ?>
	  <h6><a href="<?php echo $enlace->getUrl(); ?>"><?php echo $enlace->getUrl(); ?></a></h6>
	<?php endforeach ?>
  </div>
  <br>
	<?php endif ?>
</div>
<!-- fin enlaces externos -->

<div class="limpiar"></div>

<!-- codigo google -->
<div id="googleads">
<?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
</div>
<!-- fin codigo google -->

</div>
<!--  FIN CONTENT RIGHT -->


<div class="limpiar"></div>

<?php  ?>
<div class="fotoPolitico">
<div class="votaPolitico"><h5>Vota sobre <?php echo $politico->getApellidos(); ?></h5>
<div id="sf_review2" class="marensf_review2"></div>
</div>
</div>



<?php  ?>
<!-- FIN CONTENT -->
</div>
</div>
<!--FIN MAIN -->
<div class="limpiar"></div>
