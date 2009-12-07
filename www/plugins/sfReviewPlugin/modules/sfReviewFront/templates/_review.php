<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>

<?php $reviewable = isset($reviewable)?$reviewable:false ?>
<div title="comentario">
	<div class="margenPolitico">
		<div class="review_img">
			<?php if( $review->getsfGuardUser()->getProfile()->getImagen() ): ?>
				<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), 'alt="'.  $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos() .'"') ?>
			<?php else: ?>
				<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', 'alt="'.  $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos() .'"') ?>
			<?php endif ?>
		</div>
		<h6><?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?>
			 <?php /* ?>· <span class="lugar">Madrid<?php */ ?>
			 <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
			 	· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?>
			 <?php endif ?>
			 <br>
			 <span class="review_date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></span>
			 <br>
			<?php echo review_text( $review ) ?>
		</h6>
<?php if ($reviewable): ?>
		<div id="<?php echo "sf_review_c".$review->getId() ?>" >
			<span class="sfr"><a href="#" 
				onclick="return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $review->getId() ?>,  0, '<?php echo "sf_review_c".$review->getId() ?>' )">
					<?php echo _('Opinar sobre este comentario')?>				
			</a></span>
			<span class="sfr">&nbsp;
					<?php echo jq_link_to_remote(__('Ver comentarios'), array(
					    'update'   => "sf_rereviews_c". $review->getId(),
					    'url'    => "@sf_review_init?e=".$review->getId()."&t=&b=sf_rereviews_c".$review->getId(),
					)) ?>
			</span>
		</div>
		<div id='<?php echo "sf_rereviews_c".$review->getId() ?>' style="border:1px solid grey">
			<?php if (count($review->getSfReviewsRelatedBySfReviewId()) > 0): ?>
				<?php foreach ($review->getSfReviewsRelatedBySfReviewId() as $reReview):?>
					<?php include_partial('review', array('review' => $reReview, 'reviewable' => false)) ?>
				<?php endforeach ?>
			<?php endif ?>
		</div>
		
	
<?php endif ?>
	</div>
</div>
