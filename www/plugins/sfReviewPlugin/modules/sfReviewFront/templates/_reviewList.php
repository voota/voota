
	
	
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php if(!isset($lastPager) || $lastPager->getNbResults() > 0): ?>
	<?php if(isset($lastPager)): ?>
		<ol>
		  <?php foreach($lastPager->getResults() as $review): ?>
		    <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true)) ?>
		  <?php endforeach ?>
		</ol>
	<?php endif ?>
	<?php if ($reviewsPager->getNbResults() > 0): ?>
	  <ol>
  	  <?php foreach($reviewsPager->getResults() as $review): ?>
  		  <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true)) ?>
  		<?php endforeach ?>
	  </ol>
	<?php endif ?>
<?php else: ?>
	<p><?php echo __('Aún no hay ninguna opinión %1% sobre %2%', array('%1%' => $reviewType, '%2%' => $politico))?></p>
<?php endif ?>

	
<div id="more_fr">
  <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
      <?php echo jq_form_remote_tag(array(
    	'update'   => "more_fr",
    	'url'      => "@politico_more_comments",
		),
        array('id' => "frm_fr"
      )) ?>
      <input type="hidden" id="entityId" name="id" value="<?php echo $entityId ?>" />
      <input type="hidden" id="page" value="<?php echo $page ?>" />      
	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
	</form>
  <?php endif ?>
</div>
