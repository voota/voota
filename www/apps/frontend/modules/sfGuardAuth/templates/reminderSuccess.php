<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<?php use_helper('VoNotice') ?>

<?php echo showNotices( $sf_user ) ?>

<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('¿Olvidaste tu contraseña?')?></h2>

<div class="limpiar"></div>
<div class="formSing">
<h5><?php echo __('Danos tu email y te la enviamos ahora mismo')?></h5>
</div>
<div class="formSing">
<?php echo form_tag('@usuario_reminder') ?>
<table>
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Tu Email') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $form['username']->renderError() ?>
      <?php echo $form['username']->render() ?>
    </td>    
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td class="alingBoton">
      <?php echo submit_tag(__('Enviar'), array('class'   => 'button',)) ?>
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
