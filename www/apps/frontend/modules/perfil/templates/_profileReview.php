<tr>
	<td class="photo">    
		<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
    </td>
    
	<td class="name">
		<?php if( ! $review->getSfReviewType() ): ?>
                <?php echo __('Otro comentario sobre %1%', array('%1%' => $politico))?>, <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
		<?php elseif ($review->getSfReviewType()->getId() == 1): ?>
                <?php echo $politico?> (<?php echo __('Político')?>), <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
		<?php endif ?>
	</td>
	
    <td class="vote">
    	<?php if($review->getValue() == 1): ?>
        	<?php echo image_tag('icoUp.gif', 'yeah') ?>
		<?php else: ?>
        	<?php echo image_tag('icoDown.gif', 'buu') ?>
        <?php endif ?>
	</td>
              
	<td class="body">
    	<?php echo review_text( $review ) ?>
    </td>
    
              <td class="actions">
                <a href="#">Hacer cambios</a>
                
                <a href="#">Ir a su comentario</a>
              </td>
</tr>
