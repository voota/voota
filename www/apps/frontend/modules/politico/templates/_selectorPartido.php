<h2>
  <label><?php echo $pageTitle ?></label>
  <span id="selector_partido">
    <?php // TODO: Sustituir "Todos los partidos" por las siglas del partido si se está filtrando por uno ?>
	  <a href="#" id="selector_partido_actual">Todos los partidos</a>
	  <div id="selector_partido_area" style="display: none">
			<input type="text" id="selector_partido_buscador" />
		</div>
  </span>
</h2>

<script type="text/javascript">  
  $(document).ready(function(){
	  var partidos = '<?php echo url_for( '@partido_filter', true ); ?>';

    var favoritos = [
<?php foreach ($favoritos as $abreviatura => $nombre): ?>
      ["<?php echo $nombre?>", "<?php echo $abreviatura?>"],
<?php endforeach ?>
    ];
    
    $("#selector_partido_buscador").autocomplete(partidos, {
  		matchContains: true,
  		minChars: 0,
  		width: 168,
  		matchCase: false,
  		matchContains: "word",
  		autoFill: false,
  		selectFirst: false,
  		favorites: favoritos,
  		resultsContainer: $("#selector_partido_area"),
      formatItem: function(row, i, max) {
        return row[0];
      },
      formatMatch: function(row, i, max) {
        return row[0];
      },
      formatResult: function(row) {
        return row[1];
      }

  	});

  	$("#selector_partido_actual").click(function (event){
  	  $("#selector_partido_actual").toggleClass('selected');
  	  $("#selector_partido_area").toggle();
  	  $('#selector_partido_buscador').attr("value","");
  	  return false;
  	});

  	$("#selector_partido_buscador").result(function(event, data, formatted) {
  	  $("#selector_partido_actual").html(formatted);
  	  $("#selector_partido_actual").toggleClass('selected');
  	  $("#selector_partido_area").toggle();
      var separator = "?";
    	var dest = "" + document.location; 
    	if(dest.indexOf("?") != -1){
    		separator = "&";
    	}
    	document.location = document.location + separator + "p=" + data[1];
  	});

  	var offset = $("#selector_partido_actual").offset();
  	$("#selector_partido_area").css({
  	  position: "absolute",
  	  width: 168
  	}).offset({
  	  top: offset.top + $("#selector_partido_actual").offsetHeight,
  		left: offset.left
  	});
  });
</script>