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
    <?php foreach ($partidoPager->getResults() as $partido): ?>
    <tr>
      <td><a href="<?php echo url_for('partido/show?id='.$partido->getAbreviatura()) ?>"><?php echo $partido->getAbreviatura() ?></a></td>
      <td><?php echo $partido->getNombre() ?></td>
      <td><?php echo $partido->getColor() ?></td>
      <td><?php echo $partido->getWeb() ?></td>
      <td><?php echo $partido->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

