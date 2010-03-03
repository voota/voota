<?php use_helper('VoFormat') ?>
<?php use_helper('VoUser'); ?>

<tr>
	<td class="photo">
		<?php echo image_tag(S3Voota::getImagesUrl().'/usuarios/cc_s_'.($obj->getProfile()->getImagen()!=''?$obj->getProfile()->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $obj)) .'"') ?>
    </td>
    <td class="name">
      <?php echo link_to(highlightWords($obj, $q), '@usuario?username='.$obj->getProfile()->getVanity()) ?>, <?php echo highlightWords($obj->getProfile()->getVanity(), $q) ?>, 
      <?php echo format_number_choice('[0]%1% votos|[1]%1% voto|(1,+Inf]%1% votos', array('%1%' => $numReviews), $numReviews)?>
      <br />
    	<?php echo $quote ?>
    </td>
</tr>
