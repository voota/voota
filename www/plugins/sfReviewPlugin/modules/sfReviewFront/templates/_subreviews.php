<?php use_helper('jQuery') ?>
<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<div id="<?php echo "subreviews_box$id" ?>" class="subreviews <?php if($total == 0):?>hidden<?php endif ?> ">
  <ol>
    <li id="<?php echo "sf_review_c".$id ?>" class="review-new">

    </li>
    <?php foreach ($reviewLastList->getResults() as $review): ?>    
      <li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">
      	<?php include_partial('sfReviewFront/user_header', array('review' => $review, 'isSubreview' => true)) ?>
      
      	<p class="review-date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></p>
        <p class="review-body"><?php echo review_text( $review ) ?></p>
      </li>
    <?php endforeach ?>
	  <?php if($showCount > SfReviewManager::NUM_LAST_REVIEWS):?>
	    <?php foreach ($reviewList->getResults() as $review): ?>    
      <li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">
        
      	<?php include_partial('sfReviewFront/user_header', array('review' => $review, 'isSubreview' => true)) ?>

      	  <p class="review-date"><?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?></p>
          <p class="review-body"><?php echo review_text( $review ) ?></p>
        </li>
	    <?php endforeach ?>
	  <?php endif ?>
	  <?php if($total > 0):?>    
      <li class="subreviews-pagination">
      	<p><?php echo __('Mostrando <strong>%1%</strong> comentarios de <strong>%2%</strong>', array('%1%' => ($showCount<$total?$showCount:$total), '%2%' => ($total))) ?></p>
        <?php if($total > $showCount): ?>
          <?php echo jq_form_remote_tag(array('update' => "sf_review_sr_c${listValue}_".$id, 'url' => '@sf_review_list')) ?>
          		<input type="hidden" name="id" value="<?php echo $id?>" />
          		<input type="hidden" name="showCount" value="<?php echo $seeMoreCount?>" />
		        <p class="more"><input type="submit" value="<?php echo __('más')?>" /></p>
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