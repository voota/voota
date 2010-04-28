<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>

<?php if($entity->getType() != Propuesta::NUM_ENTITY || $sf_user->getCulture() == $entity->getCulture()): ?>
  <tr>
	<td class="photo">    
		<?php echo image_tag(S3Voota::getImagesUrl().'/'.$entity->getImagePath().'/cc_s_'.$entity->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' => $entity)) .'"') ?>
    </td>
    
	<td class="name">
		<?php if( ! $review->getSfReviewType()): ?>
            <?php echo __('Otro comentario sobre')?> <?php echo link_to($entity->getLongName(), $entity->getModule().'/show?id='.$entity->getVanity())?>, <span class="date"><?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?></span>
		<?php else: ?>
                <?php echo link_to($entity->getLongName(), $entity->getModule().'/show?id='.$entity->getVanity())?>, <span class="date"><?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?></span>
		<?php endif ?>
	</td>
	
    <td class="vote">
    	<?php if($review->getValue() == 1): ?>
        	<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
		<?php else: ?>
        	<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
        <?php endif ?>
	</td>
              
	<td class="body">
    	<?php echo review_text( $review, array(), true ) ?>
    </td>
    
	<td class="actions">
		<?php if($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $review->getSfGuardUser()->getId()):?>
	        <?php echo link_to(__('Hacer cambios'), "@usuario_votos?o=e&t=".$review->getSfReviewTypeId()."&e=".($review->getSfReviewType()?$review->getEntityId():$review->getSfReviewRelatedBySfReviewId()->getId())."&r=". $review->getId()); ?>
        <?php else: ?>
	        <?php echo link_to(__('Ir a su comentario'), "sfReviewFront/show?id=".($review->getId())); ?>
        <?php endif ?>
	</td>
  </tr>
<?php endif ?>  
