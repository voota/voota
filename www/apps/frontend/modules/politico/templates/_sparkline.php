$('#<?php echo isset($id)?$id:"sparkline_".$politico->getId() ?>').sparkline([<?php echo $sparklineData ?>], {width: 100, lineColor: '#CC0000', fillColor:'#999999', spotColor:'#FF0000'});
