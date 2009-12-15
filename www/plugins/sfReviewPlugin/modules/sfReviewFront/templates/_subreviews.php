<?php use_helper('jQuery') ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Form') ?>

<a name="<?php echo "sf_review_c_a".$id ?>"></a>
<div id="<?php echo "subreviews_box$id" ?>" class="subreviews <?php if($total == 0):?>hidden<?php endif ?> ">
  <ol>
    <li id="<?php echo "sf_review_c".$id ?>" class="review-new">

    </li>
    <?php foreach ($reviewLastList->getResults() as $review): ?>    
      <li class="review">
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
      	<p class="review-date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></p>
        <p class="review-body"><?php echo review_text( $review ) ?></p>
      </li>
    <?php endforeach ?>
	  <?php if($showCount > SfReviewManager::NUM_LAST_REVIEWS):?>
	    <?php foreach ($reviewList->getResults() as $review): ?>    
        <li class="review">
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
		      </h4>
      	  <p class="review-date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></p>
          <p class="review-body"><?php echo review_text( $review ) ?></p>
        </li>
	    <?php endforeach ?>
	  <?php endif ?>
	  <?php if($total > 0):?>    
      <li class="subreviews-pagination">
      	<p><?php echo __('Mostrando <strong>%1%</strong> comentarios de <strong>%2%</strong>', array('%1%' => ($showCount<$total?$showCount:$total), '%2%' => ($total))) ?></p>
        <?php if($total > $showCount): ?>
          <?php echo jq_form_remote_tag(array('update' => "sf_review_sr_c".$id, 'url' => '@sf_review_list')) ?>
		        <?php echo input_hidden_tag('id', "$id")?>
		        <?php echo input_hidden_tag('showCount', "$seeMoreCount")?>
		        <p class="more"><?php echo submit_tag(__('más')) ?></p>
		      </form>
        	<?php /*?><input type="submit" value="Ver 10 comentarios más" /><?php */ ?>
        <?php endif ?>
      </li>
    <?php endif ?>
  </ol>
</div>

<?php if (isset($review_c) && $review_c == $id): ?>
  <script type="text/javascript">
    <!--
  	document.getElementById('<?php echo "subreviews_box$id" ?>').className = 'subreviews shown';
  	loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $id ?>,  0, '<?php echo "sf_review_c".$id ?>' );
    //-->
  </script>
  <?php $sf_user->setAttribute('review_c', ''); ?>
<?php endif ?>