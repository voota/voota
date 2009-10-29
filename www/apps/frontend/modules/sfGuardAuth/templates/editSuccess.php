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
<?php if ($sf_user->hasFlash('notice')): ?>
<h4><?php echo $sf_user->getFlash('notice') ?></h4>
<?php endif; ?>

<div class="limpiar"></div>
<div class="formSing">
<?php echo form_tag('@usuario_edit', 'multipart=true') ?>
<table>
    <?php echo $profileEditForm ?>


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