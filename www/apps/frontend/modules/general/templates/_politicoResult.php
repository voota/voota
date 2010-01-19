<tr>
	<td class="photo">
            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj->getNombre().' ' . $obj->getApellidos() .'"') ?>
    </td>
    <td class="name">
		<?php echo link_to($obj, 'politico/show?id='.$obj->getVanity()) ?>
        <?php if ($obj->getPartido()):?> (<?php echo $obj->getPartido() ?>)<?php endif ?>
        <?php if (count($obj->getPoliticoInstitucions()) > 0): ?>, 
            <?php foreach ($obj->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo $politicoInstitucion->getInstitucion()->getNombre() ?><?php endforeach ?>
        <?php endif ?>
    </td>
    <td>
    	<?php echo $quote ?>
    </td>
</tr>
	        