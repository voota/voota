<h1>Partido List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Abreviatura</th>
      <th>Color</th>
      <th>Web</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($partido_list as $partido): ?>
    <tr>
      <td><a href="<?php echo url_for('partido/show?id='.$partido->getId()) ?>"><?php echo $partido->getId() ?></a></td>
      <td><?php echo $partido->getNombre() ?></td>
      <td><?php echo $partido->getAbreviatura() ?></td>
      <td><?php echo $partido->getColor() ?></td>
      <td><?php echo $partido->getWeb() ?></td>
      <td><?php echo $partido->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

