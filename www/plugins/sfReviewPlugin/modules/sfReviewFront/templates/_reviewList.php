<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php if(!isset($lastReviewsPager) || $lastReviewsPager->getNbResults() > 0): ?>
	<?php if(isset($lastReviewsPager)): ?>
		<ol>
		  <?php foreach($lastReviewsPager->getResults() as $review): ?>
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

	
<div id="<?php echo "more_fr_".$reviewsPager->getPage()?>">
  <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
      <?php echo jq_form_remote_tag(array(
    	'update'   => "more_fr_".$reviewsPager->getPage(),
    	'url'      => "sfReviewFront/filteredList",
		),
        array('id' => "frm_fr"
      )) ?>
      <input type="hidden" id="entityId" name="entityId" value="<?php echo $entityId ?>" />
      <input type="hidden" id="value" name="value" value="<?php echo $value ?>" />
      <input type="hidden" id="value" name="sfReviewType" value="<?php echo $sfReviewType ?>" />
      <input type="hidden" id="page" name="page" value="<?php echo $reviewsPager->getPage()+1 ?>" />      
	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
	</form>
  <?php endif ?>
</div>
