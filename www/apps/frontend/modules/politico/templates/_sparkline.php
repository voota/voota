$('#<?php echo isset($id)?$id:"sparkline_".$politico->getId() ?>').sparkline([<?php echo $sparklineData ?>], {width: 100});
