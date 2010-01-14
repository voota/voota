$('#<?php echo isset($id)?$id:"sparkline_".$partido->getId() ?>').sparkline([<?php echo $sparklineData ?>], {width: 100});
