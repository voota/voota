<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>
<?php use_helper('VoNotice') ?>


<div id="main">
<!-- CONTENT -->
<div id="content">


<?php echo showNotices( $sf_user ) ?>


<!-- CONTENT LEFT-->
<div id="contentLeftSing">
<div title="ficha">
<span class="tituloAzul"><?php echo __('¿Nuevo en Voota? Empieza aquí')?></span>
<div class="limpiar"></div>
<!--tu email -->
<div class="formSing">
<?php echo form_tag('@sf_guard_signin') ?>
	<?php echo input_hidden_tag('op', 'r') ?>

<table id="signin">
  <tr>
      <td class="leftSing"><h5><?php echo __('Tu email') ?></h5></td>
    <td class="campo">
      <?php echo $registrationform['username']->render() ?>
      <?php echo $registrationform['username']->renderError() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Nombre') ?>
    </h5></td>
    <td class="campo">
      <?php echo $registrationform['nombre']->render() ?>
      <?php echo $registrationform['nombre']->renderError() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Apellidos') ?>
    </h5></td>
    <td class="campo">
      <?php echo $registrationform['apellidos']->render() ?>
      <?php echo $registrationform['apellidos']->renderError() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Contraseña') ?>
    </h5></td>
    <td class="campo">
      <?php echo $registrationform['password']->render() ?>
      <?php echo $registrationform['password']->renderError() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>


  <tr>
    <td>&nbsp;</td>
    <td>
    	<h6>
    		<span id="show_pass_label"><a href="#" onclick="return showHidePass('registration_password')"><?php echo __('Ver la contraseña')?></a></span>
    		<span id="hide_pass_label" class="hidden"><a href="#" onclick="return showHidePass('registration_password')"><?php echo __('Ocultar la contraseña')?></a></span>
    	</h6>
    	</td>
    <td>&nbsp;</td>

  </tr>
  
  <tr>
    <td class="leftSing"></td>
    <td class="legal">He leído y acepto el <?php echo link_to(__('aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array()) ?><?php echo $registrationform['accept']->render() ?>
    <?php echo $registrationform['accept']->renderError() ?></td>    
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td class="boton">
      <?php echo submit_tag(__('Registrate en Voota'), array('class'   => 'button',)) ?>
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
  <div title="ficha"> <span class="tituloAzul"><?php echo __('¿Ya estás registrado? Adelante :)')?></span>
  
    <div class="formSing">
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
<table id="login">
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Tu Email') ?>
    </h5></td>
    <td>
      <?php echo $signinform['username']->renderError() ?>
      <?php echo $signinform['username']->render() ?>
    </td>    
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Contraseña') ?>
    </h5></td>
    <td>
      <?php echo $signinform['password']->renderError() ?>
      <?php echo $signinform['password']->render() ?>
    </td>    
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Recordar') ?>
    </h5></td>
    <td>
      <?php echo $signinform['remember']->renderError() ?>
      <?php echo $signinform['remember']->render() ?>
    </td>    
  </tr>


  <tr>
    <td>&nbsp;</td>
    <td><h6>

 <?php echo link_to(
 	__('¿Olvidaste tu contraseña?')
 	, 'sfGuardAuth/reminder'
 ) ?>
      
    </h6></td>
    </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td class="boton">
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


