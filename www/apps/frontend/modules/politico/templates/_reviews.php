<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php if(!isset($lastPager) || $lastPager->getNbResults() > 0): ?>
	<?php if(isset($lastPager)): ?>
		<ol>
		      <?php foreach($lastPager->getResults() as $review): ?>
		  		<?php include_partial('review', array('review' => $review, 'reviewable' =>  true)) ?>
		  	<?php endforeach ?>
		</ol>
	<?php endif ?>
	<ol>
  	    <?php foreach($pager->getResults() as $review): ?>
  			<?php include_partial('review', array('review' => $review, 'reviewable' =>  true)) ?>
  		<?php endforeach ?>
	</ol>
<?php else: ?>
	<p><?php echo __('Aún no hay ninguna voto %1% de %2%', array('%1%' => $reviewType, '%2%' => $politico))?></p>
<?php endif ?>

	
<div id="<?php echo "more_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD) ?>">
  <?php if ($pager->haveToPaginate() && $pager->getLastPage() > $pager->getPage()): ?>
      <?php echo jq_form_remote_tag(array(
    	'update'   => "more_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD),
    	'url'      => "@politico_more_comments",
		),
        array('id' => "frm_".($t==1?'positives':'negatives')."_".($t==1?$pageU:$pageD)
      )) ?>
	  <?php echo input_hidden_tag('t', $t)?>
	  <?php echo input_hidden_tag('id', $politico->getId())?>
	  <?php echo input_hidden_tag($t==1?'pageU':'pageD', $t==1?$pageU:$pageD)?>
	  <center><?php echo submit_tag(__('más')) ?></center>
	</form>
  <?php endif ?>
</div>

