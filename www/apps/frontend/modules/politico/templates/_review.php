<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>

<div title="comentario">
	<div class="margenPolitico">
		<h6>
<?php if( $review->getsfGuardUser()->getProfile()->getImagen() && $review->getsfGuardUser()->getProfile()->getImagen() != '' && file_exists(sfConfig::get('sf_web_dir')."/images/usuarios/cc_s_".( $review->getsfGuardUser()->getProfile()->getImagen()))): ?>
	<?php echo image_tag('usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), 'alt="'.  $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos() .'"') ?>
<?php endif ?>
			<a href="#"><?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?></a>
			 <?php /* ?>· <span class="lugar">Madrid<?php */ ?>
			 
			 <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
			 	· <?php echo (date(DATE_ATOM) - $review->getsfGuardUser()->getProfile()->getFechaNacimiento()) ?> <?php echo __('años')?></span>
			 <?php endif ?>
		</h6>
	</div>
	<div class="margenPolitico">
		<h6><?php echo review_text( $review ) ?></h6>
	</div>
</div>
