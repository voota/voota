<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>


<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">



<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('Hola %1%, estas son tus preferencias', array('%1%' => $sf_user->getProfile()->getNombre())) ?></h2>
<?php echo showNotices( $sf_user ) ?>

<div class="limpiar"></div>
<div class="formSing">
<?php echo form_tag('@usuario_edit', 'multipart=true autocomplete=off') ?>
<table>   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['nombre']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Tu nombre') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['nombre']->renderError() ?>
      <?php echo $profileEditForm['nombre']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['apellidos']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Tus apellidos') ?> <?php echo __('(opcional)') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['apellidos']->renderError() ?>
      <?php echo $profileEditForm['apellidos']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['presentacion']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Presentación') ?> <?php echo __('(opcional)') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['presentacion']->renderError() ?>
      <?php echo $profileEditForm['presentacion']->render() ?>
    </td>    
  </tr>

  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['fecha_nacimiento']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Fecha de nacimiento') ?> <?php echo __('(opcional)') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['fecha_nacimiento']->renderError() ?>
      <?php echo $profileEditForm['fecha_nacimiento']->render() ?>
    </td>    
  </tr>
  
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['vanity']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Tu página en Voota') ?> 
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['vanity']->renderError() ?>
      <span class="nombrePeque"><?php echo __('http://voota.es/') ?></span><?php echo $profileEditForm['vanity']->render() ?>
    </td>    
  </tr>
  
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['imagen']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Tu avatar') ?> <?php echo __('(opcional)') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['imagen']->renderError() ?>
      <?php echo $profileEditForm['imagen']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['username']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Tu Email') ?>
    </td>
    <td class="wider tdperfil" >
      <?php echo $profileEditForm['username']->renderError() ?>
      <?php echo $profileEditForm['username']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['passwordNew']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('¿Nueva contraseña?') ?> <?php echo __('(opcional)') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordNew']->renderError() ?>
      <?php echo $profileEditForm['passwordNew']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['passwordBis']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Repítela nuevamente') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordBis']->renderError() ?>
      <?php echo $profileEditForm['passwordBis']->render() ?>
    </td>    
  </tr>
   
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php if ($profileEditForm['passwordOld']->hasError()): ?><ul class="error_list"><li>&nbsp;</li></ul><?php endif ?>
      <?php echo __('Contraseña actual') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $profileEditForm['passwordOld']->renderError() ?>
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
<div class="limpiar footerEspacio"></div>
</div>
<!-- FIN CONTENT -->
<!--FIN MAIN -->