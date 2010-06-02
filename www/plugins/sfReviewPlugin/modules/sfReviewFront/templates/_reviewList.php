<?php use_helper('I18N') ?>

<?php if ($reviewsPager->getPage() == 1):?>
	<script type="text/javascript">
	  <!--
	  $(document).ready(function(){
		  $('#filterForm_f<?php echo $value ?>').change(function(){
			  var f = this.value;
			  var aUrl = '<?php echo url_for("sfReviewFront/filteredList?entityId=".$entity->getId()."&value=$value&sfReviewType=".$entity->getType() )?>' + (f!=''?("&filter="+f):'') ;
	
			  $('.reviews').tabs( "url" , <?php echo $value?$value==1?1:2:0?>, aUrl );
			  $('.reviews').tabs( "load" , <?php echo $value?$value==1?1:2:0?> );
			  FB.XFBML.Host.parseDomTree();
		  });
	  });
	  //-->
	</script>
		
	<form id="filterForm" method="get">
	  <p>
	    <label for="filterForm_f<?php echo $value ?>"><?php echo __("Filtrar Vootos:") ?></label>
	    <select id="filterForm_f<?php echo $value ?>" name="f">
	      <option value="" <?php echo (!isset($filter) || !$filter)?'selected="selected"':''?>><?php echo __("Todos los vootos") ?></option>
	      <option value="text" <?php echo (isset($filter) && $filter == "text")?'selected="selected"':''?>><?php echo __("Sólo vootos con texto") ?></option>
	    </select>
	  </p>
	</form>
<?php endif ?>

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

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('.reviews ol').reviews_pagination({
      url: "<?php echo url_for('sfReviewFront/filteredList') ?>",
      total: 100,
      data: { entityId: "<?php echo $entityId ?>",
              value: "<?php echo $value ?>",
              sfReviewType: "<?php echo $sfReviewType ?>",
              filter: "<?php echo (isset($filter) && $filter) ?>"
            }
    });
  });
</script>