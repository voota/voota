<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>


<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2>Hola <?php echo $sf_user->getProfile()->getNombre() ?>, estas son tus preferencias</h2>

<div class="limpiar"></div>
<div class="formSings">
<?php echo form_tag('@usuario_edit', 'multipart=true') ?>
<table>

  
  <tr>
    <td><h5>Fecha de nacimiento</h5></td>
    <td class="leftSings">
      <input name="input3" type="text" class="inputSignPeq" value="dia" maxlength="2">
    /
    <input name="input" type="text" class="inputSignPeq" value="mes" maxlength="2">
    /
    
    <input name="input2" type="text" class="inputSignPeq" value="año" maxlength="2">
    </td>
  </tr>
  <tr>
    <td class="leftSings"><h5>Tu dirección</h5></td>
    <td><h5>voota.es/
      <?php echo input_tag('vanity', $sf_user->getProfile()->getVanity(), array('class'  => 'inputSign')) ?>
      
      </h5>
    </td>
  </tr>
  <tr>
    <td><h5>Tu avatar</h5></td>
    <td  class="leftSings">
    
	<?php if ($sf_user->getProfile()->getImagen() != ''){ 
		echo image_tag('usuarios/cc_'. $sf_user->getProfile()->getImagen() , 'alt="Foto '. $sf_user->getUsername() .'"') ;
	} else {
		echo image_tag('icoAvatar.gif' , 'alt="Foto '. $sf_user->getUsername() .'"') ; 
	}?>
      <?php echo input_file_tag('image', 'Examinar', array('class'  => 'button')) ?>
      
      <br>
    <h6>No te pases con el peso de la imagen (máx. 1 Mb)</h6></td>
  </tr>
  <tr>
    <td><h5>Tu email</h5></td>
    <td  class="leftSings">
      <?php echo input_tag('email', $sf_user->getUsername(), array('class'  => 'inputSign')) ?>
      </td>
  </tr>
  <tr>
    <td><h5>¿Nueva contraseña?</h5></td>
    <td  class="leftSings">
      <input name="input6" type="text" class="inputSign">
      </td>
  </tr>
  <tr>
    <td><h5>Repítela nuevamente</h5></td>
    <td  class="leftSings">
      <input name="input7" type="text" class="inputSign">
    </td>
  </tr>
  <tr>
    <td><h5>Antigua contraseña</h5></td>
    <td  class="leftSings">
      <input name="input8" type="text" class="inputSign">
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="alingBoton">
    <?php echo submit_tag('Guardar cambios', array('class'  => 'button')) ?>
    
    </td>
    </tr>
</table>
</form>
</div>
</div>
</div>
</div>
<div class="limpiar"></div>
</div>
<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->