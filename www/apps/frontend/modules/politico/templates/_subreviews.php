  <div class="subreviews">
    <ol>
<?php foreach ($reviewList->getResults() as $review): ?>    
      <li class="review">
      	<div class="review-avatar">
		    <?php if( $review->getsfGuardUser()->getProfile()->getImagen() ): ?>
		      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
		    <?php else: ?>
		      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
		    <?php endif ?>
        </div>
        <h4 class="review-name">    <?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?>
		    <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
		      <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
		    <?php endif ?>
		</h4>
      	<p class="review-date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></p>
        <p class="review-body"><?php echo review_text( $review ) ?></p>
      </li>  	        		      
<?php endforeach ?>    
      <li class="subreviews-pagination">
        Mostrando <strong>12</strong> comentarios de <strong>25</strong>
        <br />
        <input type="submit" value="Ver 10 comentarios más" />
      </li>
    </ol>
  </div>
  