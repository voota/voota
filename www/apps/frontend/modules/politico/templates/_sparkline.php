$('#<?php echo "sparkline_".$politico->getId() ?>').sparkline([<?php echo $sparklineData ?>], {normalRangeMin:0, normalRangeMax:5, fillColor:false, height:30, width:100 });
