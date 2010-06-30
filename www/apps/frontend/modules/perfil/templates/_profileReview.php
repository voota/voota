<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>

<li class="review">
	<div class="photo">    
		<?php echo image_tag(S3Voota::getImagesUrl().'/'.$entity->getImagePath().'/cc_s_'.$entity->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' => $entity)) .'"') ?>
    </div>
    
	<div class="name">
		<?php echo $review->getValue() == 1?__('A favor de'):__('En contra de')?> 
		<?php if( ! $review->getSfReviewType()): ?>
            <?php echo __('otro comentario sobre')?> <?php echo link_to($entity->getLongName(), $entity->getModule().'/show?id='.$entity->getVanity())?>, <span class="date"><?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), 'sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review))?></span>
		<?php else: ?>
                <?php echo link_to($entity->getLongName(), $entity->getModule().'/show?id='.$entity->getVanity())?>, <span class="date"><?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), 'sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review))?></span>
		<?php endif ?>
	</div>
              
	<div class="body">
    	<?php echo review_text( $review, array(), false ) ?>
    </div>
    
	<div class="actions">
		<?php if($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $review->getSfGuardUser()->getId()):?>
	        <?php echo link_to(__('Hacer cambios'), "@usuario_votos?o=e&t=".$review->getSfReviewTypeId()."&e=".($review->getSfReviewType()?$review->getEntityId():$review->getSfReviewRelatedBySfReviewId()->getId())."&r=". $review->getId()); ?>
        <?php else: ?>
	        <?php echo link_to(__('Ir a su comentario'), 'sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review)); ?>
        <?php endif ?>
	</div>
</li>  
