<table>
<?php foreach ( $form->listaPoliticos as $politicoLista):	?>

<tr>
  <td> <?php echo $politicoLista->getPolitico() ?> </td>
  <td><input size="3" name="lista[politico<?php echo $politicoLista->getPoliticoId() ?>][orden]" value="<?php echo $politicoLista->getOrden() ?>" id="lista_politico<?php echo $politicoLista->getPoliticoId() ?>_orden" type="text">
  <input name="lista[politico<?php echo $politicoLista->getPoliticoId() ?>][lista_id]" value="<?php echo $politicoLista->getListaId() ?>" id="lista_politico<?php echo $politicoLista->getPoliticoId() ?>_lista_id" type="hidden">
  <input name="lista[politico<?php echo $politicoLista->getPoliticoId() ?>][politico_id]" value="<?php echo $politicoLista->getPoliticoId() ?>" id="lista_politico<?php echo $politicoLista->getPoliticoId() ?>_politico_id" type="hidden">
  <a href="/backend_dev.php/lista/deleteInstitucion/action.html?idm=<?php echo $politicoLista->getListaId() ?>&amp;idi=<?php echo $politicoLista->getPoliticoId() ?>" onclick="if (confirm('sure?')) { return true; };return false;"><img src="/sfPropelPlugin/images/delete.png" alt="borrar"></a>
  </td>
</tr>


<?php endforeach ?>
</table>