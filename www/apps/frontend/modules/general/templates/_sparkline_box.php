<span id="canvas_<?php echo $id ?>"></span>
<script type="text/javascript" charset="utf-8">
  var canvas = document.createElement("canvas");
  canvas.setAttribute('class', 'sparkline');
  canvas.setAttribute('id', '<?php echo $id ?>');
  canvas.setAttribute('width', '100');
  canvas.setAttribute('height', '25');
  $('#canvas_<?php echo $id ?>').append(canvas);
</script>