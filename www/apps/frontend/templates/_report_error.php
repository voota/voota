<h3><?php echo __('¿Algún error? ¡Te escuchamos!')?></h3>
<?php //TODO: Asignar acción a formulario ?>
<form>
  <div>
    <select name="tipo" id="tipo" multiple size="6">
      <option value="incompleto">Faltan datos o son incorrectos</option>
      <option value="suplantacion">Suplantación de identidad</option>
      <option value="ofensivo">Hay algo ofensivo</option>
      <option value="repetido">El político está repetido</option>
      <option value="fallo">Todo falla. ¡Protesto!</option>
      <option value="donacion">Todo perfecto. Invitar a cañas</option>
    </select>
  </div>
  <div class="submit">
    <input type="submit" value="Enviar" />
  </div>
</form>