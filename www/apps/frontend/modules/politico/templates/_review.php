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
				<?php if (count($review->getSfReviewsRelatedBySfReviewId()) > 0): ?>
					<?php echo jq_link_to_remote(__('Ver comentarios'), array(
					    'update'   => "sf_rereviews_l". $review->getId(),
					    'url'    => "@sf_review_list?e=".$review->getId()."&t=&b=sf_rereviews_l".$review->getId(),
					)) ?>
				<?php endif ?>
			</span>
		</div>
		<div id='<?php echo "sf_rereviews_l".$review->getId() ?>'>
		</div>
		
	
<?php endif ?>
	</div>
  <h4 class="review-name">
    <?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?>
    <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
      <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
    <?php endif ?>
  </h4>
	<p class="review-date">
	  <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
	</p>
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
  <p class="review-actions">
    <a href="#">Opinar sobre este comentario</a> (Lleva 1 <img alt="a favor" src="/images/icoMiniUp.png" />)
  </p>
  
  <div class="subreviews">
    <ol>
      <li class="review">
      	<div class="review-avatar">
          <img alt="Dummy User" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/v.png" />
        </div>
        <h4 class="review-name">Carlos Paramio</h4>
      	<p class="review-date">Hace 3 días</p>
        <p class="review-body">Militante del Partit Socialista d'Alliberament Nacional desde 1970, fue encarcelado en 1973 por su pertenencia a la Asamblea de Cataluña. En 1977 dejó el PSAN, y en 1980 encabezó la candidatura de Nacionalistes d'Esquerra en la circunscripción de Tarragona.</p>
      </li>  	        		      
      <li class="review">
      	<div class="review-avatar">
      	  <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/v.png" />
      	</div>
        <h4 class="review-name">Juan Leal<span class="review-years">· 32 años</span></h4>
      	<p class="review-date">Hace 3 días</p>
        <p class="review-body">El inventor taiwanés Pen Yu-Lun ha presentado un prototipo donde concibe un tren que no se detiene en las estaciones. Con este nuevo concepto los trenes serían muchísimo más eficientes (y puntuales), puesto que no tendrían que estar parando en cada una de las estaciones, descargando y recogiendo pasajeros.</p>
      </li>
      <li class="subreviews-pagination">
        Mostrando <strong>12</strong> comentarios de <strong>25</strong>
        <br />
        <input type="submit" value="Ver 10 comentarios más" />
      </li>
    </ol>
  </div>
</li>