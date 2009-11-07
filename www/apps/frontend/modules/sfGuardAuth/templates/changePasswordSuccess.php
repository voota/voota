<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Validation') ?>

<?php use_helper('VoNotice') ?>


<!-- MAIN -->
<div id="main">
<!-- CONTENT -->
<div id="content">

<?php echo showNotices( $sf_user ) ?>

<!-- CONTENT LEFT-->
<div id="contentLeftSing2">
<div title="ficha">
<h2><?php echo __('Define tu nueva contraseña')?></h2>

<div class="limpiar"></div>
<div class="formSing">
<?php echo form_tag('@usuario_change_password2') ?>
<?php echo input_hidden_tag('codigo', $codigo) ?>
<table>


  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Contraseña') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $form['password']->renderError() ?>
      <?php echo $form['password']->render() ?>
    </td>    
  </tr>
  <tr>
    <td class="anchoColumna tituloCampo tdperfil">
      <?php echo __('Otra vez') ?>
    </td>
    <td class="leftSing tdperfil" >
      <?php echo $form['password_again']->renderError() ?>
      <?php echo $form['password_again']->render() ?>
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

