      	<div class="review-avatar">
		      <?php if( $review->getsfGuardUser()->getProfile()->getImagen() ): ?>
		        <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
		      <?php else: ?>
		        <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
		      <?php endif ?>
        </div>
        <h4 class="review-name">
          <?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?>
		      <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
		        <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
		      <?php endif ?>
		      <?php
            switch ($review->getValue()) {
              case -1:
                echo ' · ' . image_tag('icoMiniDown.png', 'alt="buu"');
                break;
              case 1:
                echo ' · ' . image_tag('icoMiniUp.png', 'alt="yeah"');
                break;
            }
          ?>
		    </h4>
