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

<table>
  <tr>
      <td class="leftSing"><h5><?php echo __('Tu email') ?></h5></td>
    <td>
      <?php echo $registrationform['username']->renderError() ?>
      <?php echo $registrationform['username']->render() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Nombre') ?>
    </h5></td>
    <td>
      <?php echo $registrationform['nombre']->renderError() ?>
      <?php echo $registrationform['nombre']->render() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Apellidos') ?>
    </h5></td>
    <td>
      <?php echo $registrationform['apellidos']->renderError() ?>
      <?php echo $registrationform['apellidos']->render() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="leftSing"><h5>
      <?php echo __('Contraseña') ?>
    </h5></td>
    <td>
      <?php echo $registrationform['password']->renderError() ?>
      <?php echo $registrationform['password']->render() ?>
    </td>    
    <td>&nbsp;</td>
  </tr>


  <tr>
    <td>&nbsp;</td>
    <td><h6><a href="javascript:showHidePass('registration_password')" ><?php echo __('Ver la contraseña')?></a></h6></td>
    <td>&nbsp;</td>

  </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td class="alingBoton">
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
<table>
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
 	__('Olvidaste tu contraseña')
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


