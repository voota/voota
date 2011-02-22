<?php use_helper('VoFormat') ?>
<?php use_helper('VoUser'); ?>

<tr>
	<td class="photo">
        <?php echo !$obj->getImagen()?'':image_tag(S3Voota::getImagesUrl().'/elecciones/cc_s_'. $obj->getImagen(), ' width="36" height="36" alt="'. __('Imagen de %1%', array('%1%' =>  $obj->getEleccion()->getNombre())) .'"') ?>
  </td>
  <td class="name">
   <?php echo link_to(	cutToLength("" .$obj->getEleccion()->getNombre()." ".$obj->getNombre() ."" , 105), 'eleccion/show?vanity='. $obj->getEleccion()->getVanity() .'&convocatoria='.$obj->getNombre()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
   ) ?>
  </td>
</tr>
