<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>


<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">

<?php echo showNotices( $sf_user ) ?>

<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('Hola %1%, estas son tus preferencias', array('%1%' => $sf_user->getProfile()->getNombre())) ?></h2>

<div class="limpiar"></div>
<div class="formSing">
<?php echo form_tag('@usuario_edit', 'multipart=true') ?>
<table>
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Fecha de nacimiento') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['fecha_nacimiento']->render() ?>
    </td>    
  </tr>
  
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      Url: http://voota.es/
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['vanity']->render() ?>
    </td>    
  </tr>
  
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Imagen Principal') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['imagen']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      Email
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['username']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Nombre') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['nombre']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Apellidos') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['apellidos']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Password') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordNew']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Password (otra vez)') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordBis']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Password actual)') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordOld']->render() ?>
    </td>    
  </tr>
  


  <tr>
    <td>&nbsp;</td>
    <td class="alingBoton">
    <?php echo submit_tag(__('Guardar cambios'), array('class'  => 'button')) ?>
    
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
<!--FIN MAIN -->