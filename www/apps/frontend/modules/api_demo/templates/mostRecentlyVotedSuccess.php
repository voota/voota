<table border="1">
<?php foreach($entities as $entity):?>
<tr>
<td><?php echo $entity->name ?></td><td><?php echo ($entity->recentPositives + $entity->recentNegatives) ?></td><td><?php echo $entity->recentPositives ?></td><td><?php echo $entity->recentNegatives ?></td>
</tr>
<?php endforeach ?>
</table>
