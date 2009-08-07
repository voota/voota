<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
<?php include_title() ?>
    <?php // include_http_metas() ?>
    <?php // include_metas() ?>
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
</head>
<body>
<!-- CONTAINER -->
<div id="container">
<!-- HEADER -->
<div id="header">
<h1>Voota</h1>
<h6><?php echo __('Tú tienes la última palabra') ?></h6>
</div>
<!-- FIN HEADER -->

    <?php echo $sf_content ?>


<!-- FOOTER -->
<div id="footer">
<div class="cC"><a href="http://es.creativecommons.org/"><img src="/images/icoCc.gif" alt="Creative Commons" width="34" height="34" longdesc="Creative Commons"></a><?php echo __('Voota y <a href="http://es.creativecommons.org/">Creative Commons</a> son amigos de toda la vida') ?></div>
<div id="line"></div>
<h6>Voota.es 2009</h6>
</div>
<!--FIN FOOTER -->
</div>
<!-- FIN CONTAINER -->
</body>
</html> 
