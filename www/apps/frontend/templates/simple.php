<?php use_helper('I18N') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
<?php include_title() ?>
    <?php  include_http_metas() ?>
    <?php  include_metas() ?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META NAME="Title" CONTENT="Voota">
<META NAME="Author" CONTENT="Voota">
<META NAME="Subject" CONTENT="<?php echo __('Tú tienes la última palabra')?>">
<META NAME="Description" CONTENT="<?php echo __('Coomparte opiniones sobre los políticos de España')?>">
<META NAME="Keywords" CONTENT="<?php echo __('Política, Políticos, Partidos, Congreso, Senado, Parlamento de Cataluña')?>">
<META NAME="Language" CONTENT="<?php echo __('Spanish')?>">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
    <link rel="shortcut icon" href="/favicon.ico" >
</head>
<body>
 
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
<?php slot('langLink_ca') ?>
	català
	<?php echo link_to('español', '@homepage?sf_culture=es') ?>
<?php end_slot('langLink_ca') ?>

<?php slot('langLink_es') ?>
	<?php echo link_to('català', '@homepage?sf_culture=ca') ?>
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
