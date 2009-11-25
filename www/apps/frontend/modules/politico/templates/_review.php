<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>

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
	</div>
</div>
