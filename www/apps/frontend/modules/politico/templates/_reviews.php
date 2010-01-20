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
	<?php if ($pager->getNbResults() > 0): ?>
	  <ol>
  	  <?php foreach($pager->getResults() as $review): ?>
  		  <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true)) ?>
  		<?php endforeach ?>
	  </ol>
	<?php endif ?>
<?php else: ?>
	<p><?php echo __('Aún no hay ninguna opinión %1% sobre %2%', array('%1%' => $reviewType, '%2%' => $politico))?></p>
<?php endif ?>

	
<div id="<?php echo "more_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD) ?>">
  <?php if ($pager->haveToPaginate() && $pager->getLastPage() > $pager->getPage()): ?>
      <?php echo jq_form_remote_tag(array(
    	'update'   => "more_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD),
    	'url'      => "@politico_more_comments",
		),
        array('id' => "frm_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD)
      )) ?>
      <input type="hidden" id="t" name="t" value="<?php echo $t ?>" />
      <input type="hidden" id="id" name="id" value="<?php echo $politico->getId() ?>" />
      <input type="hidden" id="<?php echo $t==1?'pageU':'pageD' ?>" name="<?php echo $t==1?'pageU':'pageD' ?>" value="<?php echo $t==1?$pageU:$pageD ?>" />      
	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
	</form>
  <?php endif ?>
</div>

