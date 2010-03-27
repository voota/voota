<ol>
<?php foreach($reviews as $review):?>
	<li><?php echo $review->value ?> <?php echo $review->type ?> <?php echo $review->text ?></li>	
<?php endforeach ?>
</ol>
