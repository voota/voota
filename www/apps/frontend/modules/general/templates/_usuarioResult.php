<?php use_helper('VoFormat') ?>
<tr>
	<td class="photo">
		<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($obj->getProfile()->getImagen()!=''?$obj->getProfile()->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
      <?php echo link_to(highlightWords($obj, $q), '@usuario?username='.$obj->getProfile()->getVanity()) ?>, <?php echo highlightWords($obj->getProfile()->getVanity(), $q) ?>, <?php echo __('%1% votos', array('%1%' => $numReviews))?>
      <br />
    	<?php echo $quote ?>
    </td>
</tr>
