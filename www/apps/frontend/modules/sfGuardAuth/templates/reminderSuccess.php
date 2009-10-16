<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2>¿Olvidaste tu contraseña?</h2>

<div class="limpiar"></div>
<div class="formSing">
<h5>Danos tu email y te la enviamos ahora mismo</h5>
</div>
<div class="formSing">
<?php echo form_tag('@usuario_reminder_sent') ?>
<table>
  <tr>

    <td class="leftSing"><h5>Tu Email</h5></td>
    <td class="leftSing2">
	<?php echo input_tag('email', '', array("class" => "inputSign")) ?>
    </td>
    </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="alingBoton">
      <?php echo submit_tag('Enviar', array('class'   => 'button',)) ?>
    </td>
    </tr>
</table>
</form>
</div>

<div class="limpiar"></div>
<!--usuario -->
<div class="limpiar"></div>
<!--contraseña -->
</div>
</div>
</div>
<div class="limpiar"></div>
</div>
<!-- FIN CONTENT -->
</div>
