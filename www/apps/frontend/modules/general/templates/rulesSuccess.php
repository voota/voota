<?php use_helper('I18N') ?>

<div id="contentLeftNormas">
<h2><?php echo __('Normas de publicación en Voota')?></h2>
<h5>&nbsp;</h5>

<div class="limpiar"></div>
<div class="formSings">
<h5><?php echo __('En pocas palabras ...') ?></h5>
<h5><?php echo __('Las opiniones son libres, publica todo lo que quieras, a favor o en contra, salvo lo que esté prohibido por ley.') ?></h5>
<h5>&nbsp;</h5>
</div>

<div class="limpiar"></div>
<div class="formSings">
<h5><?php echo __('¿Qué es lo que está prohibido por ley? (ojo, lista no exhaustiva)') ?></h5>

<ul>
<li><h6><?php echo __('Publicar datos personales de terceros (políticos u otros usuarios)') ?></h6></li>
<li><h6><?php echo __('Insultar o amenazar.') ?></h6></li>
<li><h6><?php echo __('Incitar al odio, la violencia o la difamación.') ?></h6></li>
<li><h6><?php echo __('Incitar a la discriminación por razones de sexo, raza, religión, afiliación, política, creencias, edad o condición.') ?></h6></li>
<li><h6><?php echo __('Enlazar a páginas con contenidos ilegales.') ?></h6></li>
<li><h6><?php echo __('Incluir contenidos protegidos por derechos de propiedad de terceros sin autorización.') ?></h6></li>
</ul>
<h6><?php echo __('¿Más detalles?') ?>   <?php 
  	echo link_to(
 	__('Date una vuelta por nuestro aviso legal')
 	, __('http://blog.voota.es/es/aviso-legal')
 	, array()
 ) ?></h6>
<h6><strong><?php echo __('Ayúdanos a mejorar Voota') ?>:</strong> <?php echo link_to(__('Contáctanos si ves algún contenido ilegal'), "@contact")?></h6>

</div>




<div class="limpiar"></div>
<div class="formSings"></div>
</div>
<!-- FIN CONTENT LEFT-->
<!-- CONTENT RIGHT -->
<div id="contentRight2">



</div>
<!-- FIN CONTENT RIGHT -->
