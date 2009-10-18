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
<h2>Define tu nueva contraseña</h2>

<div class="limpiar"></div>
<div class="formSing">
<?php echo form_tag('@usuario_change_password2') ?>
<table>
    <?php echo $form ?>
  
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
