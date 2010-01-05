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
		<?php if($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $review->getSfGuardUser()->getId()):?>
	        <?php echo link_to(__('Hacer cambios'), "@usuario_votos?o=e&t=".$review->getSfReviewTypeId()."&e=".($review->getSfReviewType()?$review->getEntityId():$review->getSfReviewRelatedBySfReviewId()->getId())."&r=". $review->getId()); ?>
        <?php else: ?>
	        <?php echo link_to(__('Ir a su comentario'), "@usuario_votos?o=v&t=".$review->getSfReviewTypeId()."&e=".($review->getSfReviewType()?$review->getEntityId():$review->getSfReviewRelatedBySfReviewId()->getId())."&r=". $review->getId()); ?>
        <?php endif ?>
	</td>
</tr>
