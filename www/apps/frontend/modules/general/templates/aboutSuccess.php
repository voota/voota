<?php use_helper('I18N') ?>

<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftNormas">
<h2><?php echo __('¿Quiénes somos? Algunos datos sobre Voota')?></h2>

<div class="limpiar"></div>
<div class="formSings"><h5>
<?php echo __('Somos una asociación sin ánimo de lucro. Nuestro objetivo es fomentar la participación ciudadana en la política del momento.') ?> 
<?php echo link_to('Voota.es', "@homepage")?> <?php echo __('es la web donde pretendemos que todos puedan informarse y publicar sus opiniones sobre políticos y partidos.')?></h5></div>
<div class="formSings">
  <h5><?php echo __('Equipo fundador de Voota')?></h5>
</div>

<?php include_partial('socioabout', array('socio' => $users[2])) ?>
<?php include_partial('socioabout', array('socio' => $users[1])) ?>
<?php include_partial('socioabout', array('socio' => $users[5])) ?>
<?php include_partial('socioabout', array('socio' => $users[22])) ?>

<div class="formSings">
  <h5><?php echo __('Otra gente muy implicada en el proyecto')?></h5>
</div>
<div class="limpiar"></div>

<?php include_partial('socioabout', array('socio' => $users[4])) ?>
<?php include_partial('socioabout', array('socio' => $users[7])) ?>
<?php include_partial('socioabout', array('socio' => $users[31])) ?>

<div class="formSings">
  <h5><?php echo __('Y, finalmente, nuestros datos sociales')?></h5>
</div>
<div class="limpiar"></div>
<div class="formSings">
    <h6><?php echo __('Asociación Voota,')?><br>
    <?php echo __('CIF: G85756625,')?><br>
    <?php echo __('Domicilio soical en C/ Ruiz de Alarcón 14 1ºD')?><br>
    <?php echo __('28014 Madrid')?></h6>
</div>
<div class="limpiar"></div>
<div class="formSings"></div>
</div>
<!-- FIN CONTENT LEFT-->
<!-- CONTENT RIGHT -->
<div id="contentRight2">
<div class="conColor">
  <h5><?php echo __('Más sobre Voota')?></h5>
</div>
<div class="formSings">
  <h6><a href="http://blog.voota.es/es/wp-content/uploads/2009/10/estatutos-voota-web.pdf"><?php echo __('Estatutos')?></a><br>
    <a href="http://blog.voota.es/es/socios/"><?php echo __('Socios')?></a><br>
    <a href="http://blog.voota.es/es/financiacion-voota/"><?php echo __('Financiación')?></a><br>
    <a href="http://blog.voota.es/es/junta-directiva/"><?php echo __('Junta directiva')?></a><br></h6>
</div>
<div class="conColor">
  <h5><?php echo __('Más sobre nosotros en ...')?></h5>
</div>
<div class="formSings">
  <h6>
    <a href="http://www.facebook.com/Voota">Facebook</a><br>
    <a href="http://twitter.com/Voota">Twitter</a><br>
    <a href="http://www.flickr.com/photos/voota">Flickr</a><br></h6>
</div>
<div class="conColor">
  <h5><?php echo __('Algunos Hitos de Voota')?></h5>
</div>
<div class="formSings">
  <h5><?php echo __('Abril 2009')?></h5>
  <h6><?php echo __('François comenta la idea con su amigo Sergio Viteri, que lo ve con buenos ojos.')?></h6>
</div>
<div class="formSings">
  <h5><?php echo __('Junio 2009')?></h5>
  <h6><?php echo __('Dos meses más tarde se lo cuentan a Juan Leal. Y más de lo mismo: Idea genial. María Ayuso también se apunta para llevar la gestión.')?></h6>
</div>
<div class="formSings">
  <h5><?php echo __('Julio 2009')?></h5>
  <h6><?php echo __('Voota se constituye como asociación sin ánimo de lucro.')?></h6>
</div>
<div class="formSings">
  <h5><?php echo __('Septiembre 2009')?></h5>
  <h6><?php echo __('El proyecto se presenta en sociedad. Varios Blogs y medios digitales se hacen eco de la noticia')?> 
(<?php echo link_to('Geekets', "http://www.geekets.com/2009/09/04/voota-haz-catarsis-con-tus-politicos")?>  
<?php echo __('y')?> 
<?php echo link_to('Ricard Espelt', "http://www.theplateishot.com/en/voota-tu-tienes-la-ultima-palabra/")?>  
<?php echo __('y varios más')?>).</h6>
</div>
<div class="formSings">
  <h5><?php echo __('Noviembre 2009')?> </h5>
  <h6><?php echo __('Una primera versión de la web, muy reducida, ve la luz.')?></h6>
</div>
</div>
<!-- FIN CONTENT RIGHT -->
</div>
<div class="limpiar"></div>
</div>
