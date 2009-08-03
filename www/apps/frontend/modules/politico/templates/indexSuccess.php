<h1>Politico List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Alias</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Sexo</th>
      <th>Fecha nacimiento</th>
      <th>Pais</th>
      <th>Formacion</th>
      <th>Residencia</th>
      <th>Presentacion</th>
      <th>Usuario</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($politico_list as $politico): ?>
    <tr>
      <td><a href="<?php echo url_for('politico/show?id='.$politico->getId()) ?>"><?php echo $politico->getId() ?></a></td>
      <td><?php echo $politico->getAlias() ?></td>
      <td><?php echo $politico->getNombre() ?></td>
      <td><?php echo $politico->getApellidos() ?></td>
      <td><?php echo $politico->getSexo() ?></td>
      <td><?php echo $politico->getFechaNacimiento() ?></td>
      <td><?php echo $politico->getPais() ?></td>
      <td><?php echo $politico->getFormacion() ?></td>
      <td><?php echo $politico->getResidencia() ?></td>
      <td><?php echo $politico->getPresentacion() ?></td>
      <td><?php echo $politico->getUsuarioId() ?></td>
      <td><?php echo $politico->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('politico/new') ?>">New</a>
