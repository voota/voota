<?php use_helper('I18N') ?>

<?php echo __('<p>Hola %1%,</p>

<p>Pues eso, que %2% ha puesto un nuevo comentario sobre tu vooto. Esto es lo que piensa él:</p>

<p>"%3%"</p>

<p>Esto es lo que opinaste sobre %4%:</p>

<p>"%5%"</p>

<p>Ver tu vooto y sus comentarios en estado natural: <a href="%6%">%6%</a></p>

<p>Dejar de recibir estos avisos (simplemente pincha en este link):  %7%</p>

<p>Un abrazo, Comunidad Voota</p>

<p>Blog de Voota:  http://blog.voota.es Voota en Twitter:  http://twitter.com/voota Voota en Facebook:  http://facebook.com/voota</p>',
array(
	'%1%' => $nombre
	, '%2%' => $usuario
	, '%3%' => $comentario
	, '%4%' => $politico
	, '%5%' => $texto_ori
	, '%6%' => url_for('politico/show?id='.$vanity, true)
	, '%7%' => url_for('@usuario_unsubscribe?codigo='.$codigo.'&n=1', true)
))?>