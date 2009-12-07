<?php use_helper('I18N') ?>
<?php use_helper('Jquery') ?>

<span class="sfr"><a href="#" 
				onclick="return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $reviewEntityId ?>,  0, '<?php echo "sf_review_c".$reviewEntityId ?>' )">
					<?php echo _('Opinar sobre este comentario')?>				
</a></span>
<span class="sfr">&nbsp;
		<?php echo jq_link_to_remote(__('Ver comentarios'), array(
		    'update'   => "sf_rereviews_c". $review->getId(),
		    'url'    => "@sf_review_init?e=".$review->getId()."&t=&b=sf_rereviews_c".$review->getId(),
		)) ?>
</span>
