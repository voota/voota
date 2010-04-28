<ol>
<?php foreach($entities as $entity):?>
	<li><img src="<?php echo $entity->image_s?>" alt="<?php echo $entity->name?>" /><?php echo $entity->name ?></li>	
<?php endforeach ?>
</ol>
