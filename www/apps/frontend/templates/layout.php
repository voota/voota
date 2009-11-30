<?php use_helper('I18N') ?>
<?php use_helper('Form') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
<?php include_title() ?>
    <?php  include_http_metas() ?>
    <?php  include_metas() ?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="/favicon.ico" >
</head>
<body id="<?php echo $sf_context->getModuleName()."-". $sf_context->getActionName() ?>"> 
 
<!-- CONTAINER -->
<div id="container">

<!-- HEADER -->
<div id="header">
<div class="izq">

<a href="<?php echo url_for('@homepage') ?>">
<?php echo image_tag('logoVoota.gif', 'alt=Voota, size=112x31, longdesc=Voota, class=logoImg') ?>
</a>
<h6><?php echo __('Tú tienes la última palabra')?></h6>
</div>
<div class="der login">

<?php slot('not_logged') ?>
	<h6><?php echo link_to(__('Acceso usuarios'), 'sfGuardAuth/signin') ?></h6>
<?php end_slot('not_logged') ?>

<?php slot('logged') ?>
<h6>


<?php if($sf_user->getProfile() && $sf_user->getProfile()->getImagen() &&  $sf_user->getProfile()->getImagen() != '' ): ?>
	<?php echo image_tag(
		'http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($sf_user->getProfile()->getImagen()), 'alt="Foto '. $sf_user->getProfile()->getNombre().' ' . $sf_user->getProfile()->getApellidos() .'"') ?>
<?php endif ?>

 <?php echo link_to($sf_user->isAuthenticated()?($sf_user->getProfile()->getNombre(). " " .$sf_user->getProfile()->getApellidos()):'', '@usuario_edit') ?>
 · 
 <?php echo link_to(__('salir'), '@sf_guard_signout') ?>
 </h6>
<?php end_slot('logged') ?>

<?php include_slot($sf_user->isAuthenticated()?'logged':'not_logged') ?>

</div>
<?php  ?>
<div class="limpiar"></div>
<div class="der">

<?php echo form_tag('@search') ?>

  <div>
	<?php echo input_tag('q', $sf_params->get('q'), array('class' => 'inputSign')) ?>
	<?php echo submit_tag('Buscar', array('class' => 'button')) ?>
  </div>
</form>

<?php 
/*
?>
<form action="<?php echo url_for('@search', true) ?>" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="009755620675690774762:o64jyt7ee5g" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="31"  class="inputSign" />
    <input type="submit" name="sa" value="Buscar" class="button" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=<?php echo $sf_user->getCulture('es')?>"></script>
<?php 
*/
?>

</div>
<?php  ?>
</div>
<div class="limpiar"></div>
<!-- FIN HEADER -->




    <?php echo $sf_content ?>





<!-- FOOTER -->
<div id="footer">
<div class="cC"><a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es"><img src="/images/icoCc.gif" alt="Creative Commons" width="34" height="34" longdesc="Creative Commons"></a>
<?php echo __('Voota y <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es">Creative Commons</a> son amigos de toda la vida')?></div>
<!-- ENLACES PIE -->
<!--  div class="enlacesPie">
<h6>
<a href="partidos.html" class="enlacesPie">Partidos</a>
<a href="instituciones.html" class="enlacesPie">Instituciones</a>
<a href="senado.html" class="enlacesPie">Senado</a>
<a href="congreso.html" class="enlacesPie">Congreso</a>
<a href="politicos.html" class="enlacesPie">Políticos</a>
<a href="topUsuarios.html" class="enlacesPie">Top usuarios</a>
</h6>
</div -->
<div class="limpiar"></div>
<div class="enlacesPie">
<h6>
<?php echo link_to(__('Quiénes somos'), '@about', array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Blog'), 'http://blog.voota.es/'. $sf_user->getCulture('es'), array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Socios'), 'http://blog.voota.es/es/socios/', array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Financiación'), 'http://blog.voota.es/es/financiacion-voota', array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Twitter'), __('http://twitter.com/Voota'), array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Facebook'), __('http://www.facebook.com/Voota'), array('class' => "enlacesPie")) ?>
<?php echo link_to(__('Aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array('class' => "enlacesPie")) ?>

</h6>
<h6>
<?php slot('langLink_ca') ?>
	català
	<?php echo link_to('español', '@homepage?sf_culture=es', array('class' => "enlacesPie")) ?>
<?php end_slot('langLink_ca') ?>

<?php slot('langLink_es') ?>
	<?php echo link_to('català', '@homepage?sf_culture=ca', array('class' => "enlacesPie")) ?>
	español
<?php end_slot('langLink_es') ?>
<?php include_slot( "langLink_".$sf_user->getCulture('es') ); ?>
</h6>
</div>
<!-- FIN ENLACES PIE -->

<div id="line"></div>
<h6>Voota.es 2009 </h6>
</div>
<!--FIN FOOTER -->


</div>
<!-- FIN CONTAINER -->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10529881-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html> 
