<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">
<ul id="nav">
<li><?php echo __('Coomparte opiniones sobre los políticos de España.') ?></li>
<li><?php echo __('De momento: Congreso, Senado y Parlamento de Cataluña.') ?></li>
<li><?php echo __('Estamos preparando todo el tinglado, muy proonto en tu pantalla.') ?></li>
</ul>
<ul id="navi">
<li><a href="<?php echo __('http://blog.voota.es/es') ?>"><?php echo __('Voota tiene un blog') ?></a> <img src="/images/icoBlog.gif" alt="<?php echo __('Icono Blog Voota') ?>" name="icono" id="icono" longdesc="<?php echo __('Enlace Blog Voota') ?>"></li>
<li><a href="<?php echo __('http://twitter.com/voota') ?>"><?php echo __('Voota en Twitter') ?></a> <img src="/images/icoTwitter.png" alt="<?php echo __('Icono Twitter') ?>" longdesc="<?php echo __('Enlace Voota en Twitter') ?>"></li>
<li><a href="<?php echo __('http://www.facebook.com/pages/Voota/120100006457') ?>"><?php echo __('Voota en Facebook') ?></a> <img src="/images/icoFacebook.png" alt="<?php echo __('Icono Facebook') ?>" width="16" height="15" longdesc="<?php echo __('Enlace Voota en Facebook') ?>"></li>
</ul>
<?php slot('hands') ?>
<?php echo form_tag('/es', 'name="theForm"') ?>
<ul id="caja">
<li><h2><?php echo __('¿Te gusta la idea?') ?></h2> </li>
<li>
  <input name="v" type="radio" id="up" value="2" onClick="thumb_up()">
  <a href="#" onClick="thumb_up()"><img src="/images/icoUp.gif" alt="<?php echo __('Icono Up') ?>" width="27" height="36" longdesc="<?php echo __('Icono mano Up') ?>"></a>
  <br>
  <h6><label for="up"><?php echo __('A favor, yeah') ?></label></h6> </li>

<li>
 <input name="v" type="radio" id="down" value="1" onClick="thumb_down()">
  <a href="#" onClick="thumb_down()"><img src="/images/icoDown.gif" alt="<?php echo __('Icono Down') ?>" width="27" height="36" longdesc="<?php echo __('Icono mano Down') ?>"></a> <br>
  <h6><label for="down"><?php echo __('En contra, buu') ?></label></h6>
</li>
<li>blog
<h5><?php echo __('Positivos') ?> <?php echo $up_per?>% / <?php echo __('Negativos') ?> <?php echo $down_per?>%</h5>
</li>
</ul>
</form>
<?php end_slot('hands') ?>

<?php slot('feedback') ?>
<h2><?php echo __('¿Te gusta la idea? Aceptamos sugerencias en') ?> <a href="<?php echo __('http://www.facebook.com/pages/Voota/120100006457') ?>">facebook.com/voota</a> <?php echo __('o') ?> <a href="<?php echo __('http://twitter.com/voota') ?>"><?php echo __('twitter.com/voota') ?></a></h2>
<?php end_slot('feedback') ?>

<?php include_slot( $main_slot ); ?>

</div>
<div id="clearFix"></div>
<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
