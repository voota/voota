<?php foreach($instituciones as $idx => $i): 
?><?php echo $idx!=0?', ':''?><?php echo link_to($i->getNombreCorto(), "partido/ranking?institucion=" . $i->getVanity(), $i == $institucion ? array('class' => 'active') : null) ?><?php 
endforeach ?>