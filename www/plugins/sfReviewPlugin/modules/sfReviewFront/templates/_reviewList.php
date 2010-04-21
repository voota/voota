<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#f').change(function(){
		  $('#filterForm').submit();
	  });
  });
  //-->
</script>

<?php // TODO: Incluir URL de action al formulario ?>
<form id="filterForm">
  <p>
    <label for="f"><?php echo __("Filtrar Vootos:") ?></label>
    <select id="f" name="f">
      <option value="all" <?php echo $f!="all"?'':'selected="selected"'?>><?php echo __("Todos los vootos") ?></option>
      <option value="text" <?php echo $f!="text"?'':'selected="selected"'?>><?php echo __("Sólo vootos con texto") ?></option>
    </select>
  </p>
</form>

<?php if(!isset($lastReviewsPager) || $lastReviewsPager->getNbResults() > 0): ?>
	<?php if(isset($lastReviewsPager)): ?>
		<ol>
		  <?php foreach($lastReviewsPager->getResults() as $review): ?>
		    <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true, 'listValue' => str_replace  ('-', '_', $value ))) ?>
		  <?php endforeach ?>
		</ol>
	<?php endif ?>
	<?php if ($reviewsPager->getNbResults() > 0): ?>
	  <ol>
  	  <?php foreach($reviewsPager->getResults() as $review): ?>
  		  <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true, 'listValue' => str_replace  ('-', '_', $value ))) ?>
  		<?php endforeach ?>
	  </ol>
	<?php endif ?>
<?php else: ?>
	<p><?php echo __('Aún no hay ninguna opinión %1% sobre %2%', array('%1%' => ($value?($value==1?__('positiva'):__('negativa')):''), '%2%' => $entity))?></p>
<?php endif ?>

	
<div id="<?php echo "more_fr_${value}_".$reviewsPager->getPage()?>">
  <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
      <?php echo jq_form_remote_tag(array(
    	'update'   => "more_fr_${value}_".$reviewsPager->getPage(),
    	'url'      => "sfReviewFront/filteredList",
      	'before'   => "re_loading( 'more_fr_". $value ."_". $reviewsPager->getPage() ."' )",
        'complete'	   => "FB.XFBML.Host.parseDomTree()"
		),
        array('id' => "frm_fr_${value}_"
      )) ?>
      <input type="hidden" id="entityId" name="entityId" value="<?php echo $entityId ?>" />
      <input type="hidden" id="value" name="value" value="<?php echo $value ?>" />
      <input type="hidden" id="value" name="sfReviewType" value="<?php echo $sfReviewType ?>" />
      <input type="hidden" id="page" name="page" value="<?php echo $reviewsPager->getPage()+1 ?>" />      
	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
	</form>
  <?php endif ?>
</div>
