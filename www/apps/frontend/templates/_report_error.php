<script type="text/javascript">
  <!--
  $(document).ready(function(){
    $('#feedback_form').submit(function(){
    	if (this.t.value == 'donacion'){
        	document.location = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10999422';
        	return false;
    	}
    	return true;
	})
  });
  //-->
</script>

<h3><?php echo __('¿Ves algún error?')?></h3>
<form action="<?php echo url_for('@contact') ?>" id="feedback_form" method="post">
  <input type="hidden" name="e" value="<?php echo $entity ?>" />
  <div>
    <select name="t" id="tipo" size="6">
      <option value="<?php echo __('Faltan datos o son incorrectos')?>"><?php echo __('Faltan datos o son incorrectos')?></option>
      <option value="<?php echo __('Suplantación de identidad')?>"><?php echo __('Suplantación de identidad')?></option>
      <option value="<?php echo __('Hay algo ofensivo')?>"><?php echo __('Hay algo ofensivo')?></option>
      <option value="<?php echo __('El político está repetido')?>"><?php echo __('El político está repetido')?></option>
      <option value="<?php echo __('Todo falla. ¡Protesto!')?>"><?php echo __('Todo falla. ¡Protesto!')?></option>
      <option value="donacion"><?php echo __('Todo perfecto. Invitar a cañas')?></option>
    </select>
  </div>
  <div class="submit">
    <input type="submit" value="<?php echo __('Enviar')?>" />
  </div>
</form>