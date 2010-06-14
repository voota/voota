<?php use_helper('I18N') ?>

<?php if ($allTagsPager->getNbResults() > 0): ?>
    <?php foreach ($allTagsPager->getResults() as $etiqueta): ?>
      <li class="review">
        <a href="<?php echo url_for('general/search?tag='.$etiqueta)?>"><?php echo $etiqueta  ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
      </li>
    <?php endforeach ?>
<?php endif ?>

<?php if($allTagsPager->getPage() == 1): ?>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
		    $('#taglist ul:first').reviews_pagination({
			      url: "<?php echo url_for('general/tagList') ?>",
			      total: <?php echo $allTagsPager->getNbResults() ?>,
			      data: { entityId: "<?php echo $entity->getId() ?>",
			              type: "<?php echo $entity->getType() ?>",
					      slot: "taglist"
			            }
			      , summaryTemplate: '<?php echo '<p>'. __('Mostrando %1% comentarios de %2%', array('%1%' => '<strong class="reviews_count"></strong>', '%2%' => '<strong class="reviews_total"></strong>')) .'</p>' ?>'
				  , buttonText: '<?php echo __('más') ?>'
			    });
	  });
	</script>
<?php endif ?>
