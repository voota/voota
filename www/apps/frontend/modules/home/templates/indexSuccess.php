<?php use_helper('Form') ?>
<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">
<ul id="nav">
<li>Coomparte opiniones sobre los políticos de España.</li>
<li>De momento: Congreso, Senado y Parlamento de Cataluña.</li>
<li>Estamos preparando todo el tinglado, muy proonto en tu pantalla.</li>
</ul>
<ul id="navi">
<li><a href="http://blog.voota.es">Voota tiene un blog</a> <img src="images/icoBlog.gif" alt="Icono Blog Voota" name="icono" id="icono" longdesc="Enlace Blog Voota"></li>
<li><a href="http://twitter.com/voota">Voota en Twitter</a> <img src="images/icoTwitter.gif" alt="Icono Twitter" longdesc="Enlace Voota en Twitter"></li>
<li><a href="http://www.facebook.com/pages/Voota/120100006457">Voota en Facebook</a> <img src="images/icoFacebook.gif" alt="Icono Facebook" width="16" height="15" longdesc="Enlace Voota en Facebook"></li>
</ul>
<?php slot('hands') ?>
<?php echo form_tag('/es', 'name="theForm"') ?>
<ul id="caja">
<li><h2>¿Te gusta la idea?</h2> </li>
<li>
  <input name="v" type="radio" id="up" value="2" checked onClick="thumb_up()">
  <a href="#" onClick="thumb_up()"><img src="images/icoUp.gif" alt="Icono Up" width="27" height="36" longdesc="Icono mano Up"></a>
  <br>
  <h6>A favor, yeah</h6> </li>

<li>
 <input name="v" type="radio" id="down" value="1" onClick="thumb_down()">
  <a href="#" onClick="thumb_down()"><img src="images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"></a> <br>
  <h6>En contra, buu</h6>
</li>
<li>
<h5>Positivos 2% / Negativos 98%</h5>
</li>
</ul>
</form>
<?php end_slot('hands') ?>

<?php slot('feedback') ?>
<h2>¿Te gusta la idea? Aceptamos sugerencias en <a href="http://www.facebook.com/pages/Voota/120100006457">facebook.com/voota</a> o <a href="http://twitter.com/voota">twitter.com/voota</a></h2>
<?php end_slot('feedback') ?>

<?php include_slot( $main_slot ); ?>

</div>
<div id="clearFix"></div>
<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
