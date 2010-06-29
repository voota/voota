<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
		<?php echo image_tag(S3Voota::getImagesUrl().'/partidos/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
      <?php echo link_to(highlightWords($obj, $q), 'partido/show?id='.$obj->getAbreviatura()) ?>, <?php echo highlightWords($obj->getNombre(), $q) ?>
        <?php if($counts):?>
	        <?php echo $q ?> (<?php echo $counts[$obj->getId()] ?>)
        <?php endif ?>
      <br />
    	<?php echo $quote ?>
    </td>
</tr>

	        