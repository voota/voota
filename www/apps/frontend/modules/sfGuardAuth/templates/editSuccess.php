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
    <?php echo $profileEditForm ?>


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