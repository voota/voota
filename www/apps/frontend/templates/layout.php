<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
<?php include_title() ?>
    <?php  include_http_metas() ?>
    <?php  include_metas() ?>
<?php echo javascript_include_tag('voota') ?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META NAME="Title" CONTENT="Voota">
<META NAME="Author" CONTENT="Voota">
<META NAME="Subject" CONTENT="Tú tienes la última palabra">
<META NAME="Description" CONTENT="Coomparte opiniones sobre los políticos de España">
<META NAME="Keywords" CONTENT="Política, Políticos, Partidos, Congreso, Senado, Parlamento de Cataluña">
<META NAME="Generator" CONTENT="NOTEPAD">
<META NAME="Language" CONTENT="Spanish">
<META NAME="Revisit" CONTENT="15 days">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
    <link rel="shortcut icon" href="/favicon.ico" >
<link rel="stylesheet" type="text/css" media="screen" href="/css/voota.css" >
<link rel="stylesheet" type="text/css" media="screen" href="/css/interior.css" >
</head>
<body>
 
<!-- CONTAINER -->
<div id="container">

<!-- HEADER -->
<div id="header">
<div class="izq"><a href="/"><img src="/images/logoVoota.gif" alt="Logo Voota" width="141" height="55" longdesc="Enlace Home Voota"></a>
<h6>Tú tienes la última palabra</h6>
</div>
<div class="der login">

<?php slot('not_logged') ?>
	<h6><?php echo link_to('Acceso usuarios', 'sfGuardAuth/signin') ?></h6>
<?php end_slot('not_logged') ?>

<?php slot('logged') ?>
<h6>

<img src="image/icoBlog.gif" alt="Ico Voota"> 
 <?php echo link_to($sf_user->isAuthenticated()?$sf_user->getUsername():'', '@usuario_edit') ?>
 · 
 <?php echo link_to('salir', '@sf_guard_signout') ?>
 </h6>
<?php end_slot('logged') ?>

<?php include_slot($sf_user->isAuthenticated()?'logged':'not_logged') ?>

</div>
<?php /* ?>
<div class="limpiar"></div>
<div class="der">
  <input name="buscar2" type="text" class="input">
  <input name="buscar" type="button" class="button" value="Buscar">
</div>
<?php */ ?>
</div>
<div class="limpiar"></div>
<!-- FIN HEADER -->


    <?php echo $sf_content ?>







<!-- FOOTER -->
<div id="footer">
<div class="cC"><a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es"><img src="/images/icoCc.gif" alt="Icono Creative Commons" width="34" height="34" longdesc="Enlace Creative Commons"></a> Voota y <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es">Creative Commons</a> son amigos de toda la vida<a href="/"><img src="/images/icoVoota.png" alt="Icono Voota" width="34" height="34" longdesc="Enlace Voota"></a></div>
<!-- ENLACES PIE -->
<div class="enlacesPie">
<h6>
<a href="partidos.html" class="enlacesPie">Partidos</a>
<a href="instituciones.html" class="enlacesPie">Instituciones</a>
<a href="senado.html" class="enlacesPie">Senado</a>
<a href="congreso.html" class="enlacesPie">Congreso</a>
<a href="politicos.html" class="enlacesPie">Políticos</a>
<a href="topUsuarios.html" class="enlacesPie">Top usuarios</a>
</h6>
</div>
<div class="limpiar"></div>
<div class="enlacesPie">
<h6>
<a href="quienesSomos.html" class="enlacesPie">Quienes somos</a>
<a href="contactar.html" class="enlacesPie">Contactar</a>
<a href="avisoLegal.html" class="enlacesPie">Aviso legal</a>
<a href="blog.html" class="enlacesPie">Blog</a>
</h6>
</div>
<div class="limpiar"></div>
<div class="enlacesPie">
<h6>
<?php slot('langLink_ca') ?>
	català
	<a href="/es">español</a>
<?php end_slot('langLink_ca') ?>

<?php slot('langLink_es') ?>
	<a href="/ca">català</a>
	español
<?php end_slot('langLink_es') ?>
<?php include_slot( $sf_request->getAttribute('langLink_slot') ); ?>
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
