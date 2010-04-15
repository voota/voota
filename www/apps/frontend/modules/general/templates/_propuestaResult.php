<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
            <?php echo image_tag(S3Voota::getImagesUrl().'/'.$obj->getImagePath().'/cc_s_'.$obj->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
		<?php echo link_to(highlightWords($obj, $q), 'propuesta/show?id='.$obj->getVanity()) ?>
      <br />
    	<?php echo $quote ?>
      
    </td>
</tr>
	        