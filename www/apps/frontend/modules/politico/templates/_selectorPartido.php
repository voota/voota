<h2>
  <label><?php echo $pageTitle ?></label>
  <span id="selector_partido">
	  <a href="#" id="selector_partido_actual">Todos los partidos</a>
	  <div id="selector_partido_area" style="display: none">
			<input type="text" id="selector_partido_buscador" />
		</div>
  </span>
</h2>

<script type="text/javascript">  
  $(document).ready(function(){
    var partidos = [
    	{ nombre: "Partido Socialista Obrero Español", siglas: "PSOE", id: "PSOE" },
    	{ nombre: "Partido Popular", siglas: "PP", id: "PP" },
    	{ nombre: "Aralar", siglas: "", id: "Aralar" },
    	{ nombre: "Bloc", siglas: "", id: "Bloc" },
    	{ nombre: "BNG", siglas: "", id: "BNG" },
    	{ nombre: "BpM", siglas: "", id: "BpM" },
    	{ nombre: "Partido Pirata", siglas: "", id: "Partido-Pirata" },
    	{ nombre: "Partido de los Partidos", siglas: "", id: "Partido-de-Partidos" },
    ];
    
    var favoritos = [
      { nombre: "Partido Socialista Obrero Español", siglas: "PSOE", id: "PSOE" },
    	{ nombre: "Partido Popular", siglas: "PP", id: "PP" }
    ];
    
    $("#selector_partido_buscador").autocomplete(partidos, {
  		matchContains: true,
  		minChars: 0,
  		width: 168,
  		matchContains: "word",
  		autoFill: false,
  		selectFirst: false,
  		favorites: favoritos,
  		resultsContainer: $("#selector_partido_area"),
  		formatItem: function(row, i, max) {
  			return row.nombre;
  		},
  		formatMatch: function(row, i, max) {
  			return row.nombre + " " + row.siglas;
  		},
  		formatResult: function(row) {
  			return row.nombre;
  		}

  	});

  	$("#selector_partido_actual").click(function (event){
  	  $("#selector_partido_actual").toggleClass('selected');
  	  $("#selector_partido_area").toggle();
  	  $('#selector_partido_buscador').attr("value","");
  	});

  	$("#selector_partido_buscador").result(function(event, data, formatted) {
  	  $("#selector_partido_actual").html(data.nombre);
  	  $("#selector_partido_actual").toggleClass('selected');
  	  $("#selector_partido_area").toggle();
      var separator = "?";
    	var dest = "" + document.location; 
    	if(dest.indexOf("?") != -1){
    		separator = "&";
    	}
    	document.location = document.location + separator + "p=" + data.id;
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