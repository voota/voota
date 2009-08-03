<h1>Usuario List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Email</th>
      <th>Clave</th>
      <th>Acepta mensajes</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Fecha nacimiento</th>
      <th>Pais</th>
      <th>Formacion</th>
      <th>Residencia</th>
      <th>Presentacion</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usuario_list as $usuario): ?>
    <tr>
      <td><a href="<?php echo url_for('usuario/show?id='.$usuario->getId()) ?>"><?php echo $usuario->getId() ?></a></td>
      <td><?php echo $usuario->getEmail() ?></td>
      <td><?php echo $usuario->getClave() ?></td>
      <td><?php echo $usuario->getAceptaMensajes() ?></td>
      <td><?php echo $usuario->getNombre() ?></td>
      <td><?php echo $usuario->getApellidos() ?></td>
      <td><?php echo $usuario->getFechaNacimiento() ?></td>
      <td><?php echo $usuario->getPais() ?></td>
      <td><?php echo $usuario->getFormacion() ?></td>
      <td><?php echo $usuario->getResidencia() ?></td>
      <td><?php echo $usuario->getPresentacion() ?></td>
      <td><?php echo $usuario->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('usuario/new') ?>">New</a>
