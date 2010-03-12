//$('#<?php echo isset($id)?$id:"sparkline_".$politico->getId() ?>').sparkline([<?php echo $sparklineData ?>], {width: 100});

d<?php echo $id ?> = [<?php echo $sparklineData ?>];

var options = {
	xaxis: { ticks:0 },
	yaxis: { ticks:0 },
  selection: { mode: "x" },
  series: {lines: { show: true }, points: { show: true }},
  grid: { hoverable: true, show: true, backgroundColor: "#f6f6f6", borderWidth: 0 }
};
    
$.plot($("#<?php echo $id ?>"), [{data: d<?php echo $id ?>}], options);
previousPoint = null;   

$("#<?php echo $id ?>").bind("plothover", function (event, pos, item) {
  if (item) {
    if (previousPoint != item.datapoint) {
      previousPoint = item.datapoint;
      showTooltip(item.pageX, item.pageY, "" + item.datapoint[0] + ": "+ item.datapoint[1] + " vootos positivos");
    }
  } else {
    $("#tooltip").remove();
    previousPoint = null;            
  }
});

function showTooltip(x, y, contents) {
  $('<div id="tooltip">' + contents + '</div>').css({
    position: 'absolute',
    display: 'none',
    top: y + 5,
    left: x + 20,
    border: '1px solid #fdd',
    padding: '2px',
    'background-color': '#fee',
    opacity: 0.80
  }).appendTo("body").fadeIn(200);
}