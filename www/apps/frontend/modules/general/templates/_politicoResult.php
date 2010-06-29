<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
            <?php echo image_tag(S3Voota::getImagesUrl().'/'.$obj->getImagePath().'/cc_s_'.$obj->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
		<?php echo link_to(highlightWords($obj, $q), 'politico/show?id='.$obj->getVanity()) ?>
        <?php if ($obj->getPartido()):?> (<?php echo highlightWords($obj->getPartido(), $q) ?>)<?php endif ?>
        <?php if (count($obj->getPoliticoInstitucions()) > 0): ?>, 
            <?php foreach ($obj->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo highlightWords($politicoInstitucion->getInstitucion()->getNombre(), $q) ?><?php endforeach ?>
        <?php endif ?>
        <?php if($counts):?>
	        <?php echo $q ?> (<?php echo $counts[$obj->getId()] ?>)
        <?php endif ?>
      <br />
    	<?php echo $quote ?>
      
    </td>
</tr>
	        