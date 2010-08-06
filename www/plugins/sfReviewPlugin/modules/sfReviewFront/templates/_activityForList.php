<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser'); ?>
<?php use_helper('VoSmartJS'); ?>

<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $uc->add(SfReviewPeer::IS_ACTIVE, true); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1); $dc->add(SfReviewPeer::IS_ACTIVE, true);  ?>
<?php $listValue = isset($listValue)?$listValue:''?>

<li class="review" id="<?php echo "sf_review_c_m".$activity->getId() ?>">
  <?php if ($activity->getMode() == 1): ?>
	  <div class="review-avatar">
		  <?php if(!$activity->getAnonymous()): ?>
		    <?php echo getAvatar( $activity->getsfGuardUser() ) ?>
		  <?php else: ?>
		  	<?php echo image_tag(S3Voota::getImagesUrl().'/usuarios/v.png', array('alt' => __('Vooto secreto (está en su derecho)'), 'width' => 36, 'height' => 36)); ?>
		  <?php endif ?>
	  </div>
  <?php endif ?>
  <div class="review-name">
	<?php if ($activity->getMode() == 1): ?>
		<?php if(!$activity->getAnonymous()): ?>
  			<a title='<?php echo $activity->getsfGuardUserId() ?>' href="<?php echo url_for('@usuario?username='.$activity->getsfGuardUser()->getProfile()->getVanity())?>"><?php echo fullName( $activity->getsfGuardUser(), 15 ) ?></a>
		<?php else: ?>
  			<?php echo __('Vooto secreto') ?> <?php echo __('(está en su derecho)')?>
		<?php endif ?>
    <?php endif ?>
    <?php if ($activity->getMode() == 1): ?>
	    <?php if ($activity->getValue() == -1): ?>
	  		<?php echo __('voota en contra de') ?>
	  	<?php endif ?>
	  	<?php if ($activity->getValue() == 1): ?>
	  		<?php echo __('voota a favor de') ?>
	  	<?php endif ?>
  	<?php endif ?>
  	<?php if ($activity->getMode() == 1): ?>
	    <?php echo (!$activity->getType())?__('otro comentario sobre ') ." ":'' ?><a title='<?php echo sfVoUtil::secureString($activity->getEntity(), "&#39;") ?>' href="<?php echo url_for($activity->getEntity()->getModule().'/show?id='.$activity->getEntity()->getVanity())?>"><?php echo sfVoUtil::cutToLength(sfVoUtil::secureString($activity->getEntity(), "&#39;"), 32, '...')?></a>.
	    <span class="review-date"><?php echo link_to(ago(strtotime( $activity->getDate() )), 'sfReviewFront/show?id='.SfVoUtil::reviewPermalink($activity)) ?>.</span>
  	<?php endif ?>
  	<?php if ($activity->getMode() == 2): ?>
	  		<?php echo __('A %1% le han puesto la etiqueta "%2%".', array(
	  		'%1%' => "<a title='". sfVoUtil::secureString($activity->getEntity(), "&#39;") ."' href= \"". url_for($activity->getEntity()->getModule().'/show?id='.$activity->getEntity()->getVanity()) ."\">". sfVoUtil::cutToLength(sfVoUtil::secureString($activity->getEntity(), "&#39;"), 32, '...') ."</a>",
	  		'%2%' => review_text( $activity ))) ?>
	<?php endif ?>
  </div>
  
  <?php if ($activity->getMode() == 1): ?>
	  <?php if ($activity->getText() && $activity->getCulture() == $sf_user->getCulture()): ?>
	  	<p class="review-body">
	    	<?php echo review_text( $activity ) ?>
	  	</p>
	  <?php endif ?>
  <?php endif ?>
</li>