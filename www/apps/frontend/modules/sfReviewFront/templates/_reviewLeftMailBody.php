<?php use_helper('I18N') ?>

<?php echo __('
  <p>Hola %1%,</p> 
  %saludo%
  <p>
    Esto es lo que opinaste sobre %4%:
    <br />
    "%5%"
  </p>
  <p>
    Ver tu vooto y sus comentarios en estado natural:
    <br />
    <a href="%6%">%6%</a>
  </p>

  <p>
    Dejar de recibir estos avisos (simplemente pincha en este link):
    <br />
    <a href="%7%">%7%</a>
  </p>',
  array(
	  '%1%'      => $nombre,
	  '%2%'      => $usuario,
    '%3%'      => $comentario,
	  '%4%'      => $entity,
	  '%5%'      => $texto_ori,
	  '%6%'      => url_for("$module/show?id=".$vanity, true),
	  '%7%'      => url_for('@usuario_unsubscribe?codigo='.$codigo.'&n=1', true),
    '%saludo%' => ($comentario != "" ?
      __('<p>Pues eso, que %2% ha puesto un nuevo comentario sobre tu vooto. Esto es lo que piensa él:<br />"%3%"</p>',
        array(
    	    '%voto%' => ($voto == 1 ? __('a favor') : __('en contra')),
		      '%2%' => $usuario,
		      '%3%' => $comentario
		    )
		  )
      :
      __('<p>Pues eso, que %2% está %voto% de tu vooto. Aunque de momento no ha incluído ninguna opinión.</p>',
        array(
    	    '%voto%' => ($voto == 1 ? __('a favor') : __('en contra')),
		      '%2%' => $usuario,
		      '%3%' => $comentario
		    )
		  )
    )
  )
) ?>

<?php include_partial('global/mailFooter') ?>