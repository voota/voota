<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>



<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftSing">
<div title="ficha">
<span class="tituloAzul">¿Nuevo en Voota? Empieza aquí</span>
<div class="limpiar"></div>
<!--tu email -->
<div class="formSing">
<?php echo form_tag('@sf_guard_signin') ?>
	<?php echo input_hidden_tag('op', 'r') ?>

<table>
    <?php echo $registrationform ?>


  <tr>
    <td>&nbsp;</td>
    <td><h6><a href="#">Ver la contraseña</a></h6></td>
    <td>&nbsp;</td>

  </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td class="alingBoton">
      <?php echo submit_tag('Registrate en Voota', array('class'   => 'button',)) ?>
      </td>
    <td>&nbsp;</td>
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
<!-- FIN CONTENT LEFT -->
<!-- CONTENT RIGHT -->
<div id="contentRightSing">
  <div title="ficha"> <span class="tituloAzul">¿Ya estás registrado? Adelante :)</span>
  
    <div class="formSing">
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
<table>
    <?php echo $signinform ?>


  <tr>
    <td>&nbsp;</td>
    <td><h6>

 <?php echo link_to(
 	"Olvidaste tu contraseña"
 	, 'sfGuardAuth/reminder'
 ) ?>
      
    </h6></td>
    </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td style="text-align:right">
      <input name="button" type="submit" class="button" value="Entrar">     </td>

    </tr>
</table>
</form>
</div>


</div>
  <!-- politico1 -->
</div>
<!--  FIN CONTENT RIGHT -->
<div class="limpiar"></div>
<div title="formulario" class="votaSobre">
  <!-- confirmar -->
  <!-- fin confirmar -->
  <!-- login -->

  <!-- fin login -->
</div>
</div>
<!-- FIN CONTENT -->
</div>
