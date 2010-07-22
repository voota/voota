<?php use_helper('I18N') ?>
<?php use_helper('VoFormat') ?>

<?php if ($allTagsPager->getNbResults() > 0): ?>
    <?php foreach ($allTagsPager->getResults() as $etiqueta): ?>
      <li class="review">
        <a href="<?php echo url_for('general/search?tag='.armorTag( $etiqueta ))?>"><?php echo $etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
      </li>
    <?php endforeach ?>
<?php endif ?>

<?php if($allTagsPager->getPage() == 1): ?>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
		    $('#taglist ul:first').reviews_pagination({
			      url: "<?php echo url_for('general/tagList') ?>",
			      total: <?php echo $myCount + $allTagsPager->getNbResults() ?>,
			      data: { entityId: "<?php echo $entity->getId() ?>",
			              type: "<?php echo $entity->getType() ?>",
					      slot: "taglist"
			            }
			      , summaryTemplate: '<?php echo '<p>'. format_number_choice('[1]Mostrando %1% etiqueta de %2%|(1,+Inf]Mostrando %1% etiquetas de %2%', array('%1%' => '<strong class="reviews_count"></strong>', '%2%' => '<strong class="reviews_total"></strong>'), $myCount + $allTagsPager->getNbResults()) .'</p>' ?>'
				  , buttonText: '<?php echo __('más') ?>'
			    });
	  });
	</script>
<?php endif ?>
