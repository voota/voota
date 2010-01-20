<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj->getNombre().' ' . $obj->getApellidos() .'"') ?>
    </td>
    <td>
      
		<?php echo link_to(highlightWords($obj, $q), 'politico/show?id='.$obj->getVanity()) ?>
        <?php if ($obj->getPartido()):?> (<?php echo highlightWords($obj->getPartido(), $q) ?>)<?php endif ?>
        <?php if (count($obj->getPoliticoInstitucions()) > 0): ?>, 
            <?php foreach ($obj->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo highlightWords($politicoInstitucion->getInstitucion()->getNombre(), $q) ?><?php endforeach ?>
        <?php endif ?>
      <br />
    	<?php echo $quote ?>
      
    </td>
</tr>
	        