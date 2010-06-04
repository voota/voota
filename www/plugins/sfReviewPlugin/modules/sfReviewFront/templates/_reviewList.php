<?php use_helper('I18N') ?>

<?php if ($reviewsPager->getPage() == 1):?>
	<script type="text/javascript">
	  <!--
	  $(document).ready(function(){
		  $('#filterForm_f<?php echo (isset($value)?$value:'') ?>').change(function(){
			  var f = this.value;
			  var aUrl = '<?php echo url_for("sfReviewFront/filteredList?value=".(isset($value)?$value:''). (isset($entity)?"&entityId=".$entity->getId():''). (isset($entity)?"&sfReviewType=".$entity->getType():'') )?>' + (f!=''?("&filter="+f):'') ;
	
			  $('.reviews').tabs( "url" , <?php echo (isset($value) && $value)?$value==1?1:2:0?>, aUrl );
			  $('.reviews').tabs( "load" , <?php echo (isset($value) && $value)?$value==1?1:2:0?> );
			  FB.XFBML.Host.parseDomTree();
		  });
	  });
	  //-->
	</script>
		
	<form id="filterForm" method="get">
	  <p>
	    <label for="filterForm_f<?php echo (isset($value)?$value:'') ?>"><?php echo __("Filtrar Vootos:") ?></label>
	    <select id="filterForm_f<?php echo (isset($value)?$value:'') ?>" name="f">
	      <option value="" <?php echo (!isset($filter) || !$filter)?'selected="selected"':''?>><?php echo __("Todos los vootos") ?></option>
	      <option value="text" <?php echo (isset($filter) && $filter == "text")?'selected="selected"':''?>><?php echo __("Sólo vootos con texto") ?></option>
	    </select>
	  </p>
	</form>
<?php endif ?>

<?php if(!isset($lastReviewsPager) || $lastReviewsPager->getNbResults() > 0): ?>
	<?php if ($reviewsPager->getNbResults() > 0): ?>
	  <ol>
  	  <?php foreach($reviewsPager->getResults() as $review): ?>
  		  <?php include_partial('sfReviewFront/review', array('review' => $review, 'reviewable' =>  true, 'listValue' => str_replace  ('-', '_', (isset($value)?$value:'') ))) ?>
  		<?php endforeach ?>
	  </ol>
	<?php endif ?>
<?php else: ?>
	<p><?php echo __('Aún no hay ninguna opinión %1% sobre %2%', array('%1%' => ($value?($value==1?__('positiva'):__('negativa')):''), '%2%' => $entity))?></p>
<?php endif ?>

<?php if($reviewsPager->getPage() == 1): ?>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
	    $('.reviews ol').reviews_pagination({
	      url: "<?php echo url_for('sfReviewFront/filteredList') ?>",
	      total: <?php echo $reviewsPager->getNbResults() ?>,
	      data: { <?php if(isset($entityId)):?>entityId: "<?php echo $entityId ?>",<?php endif?>
	              <?php if(isset($value)):?>value: "<?php echo $value ?>",<?php endif?>
	              <?php if(isset($sfReviewType)):?>sfReviewType: "<?php echo $sfReviewType ?>",<?php endif?>
	              filter: "<?php echo (isset($filter) && $filter) ?>",
			      slot: "review_list"
	            }
	    });
	  });
	</script>
<?php endif ?>
