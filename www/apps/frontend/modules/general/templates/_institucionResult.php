<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
		<?php echo image_tag(S3Voota::getImagesUrl().'/instituciones/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
		<?php echo link_to(highlightWords($obj->getNombre(), $q), 'politico/ranking?partido=all&institucion='.$obj->getVanity()) ?>      
    </td>
</tr>
	        
	        
	        