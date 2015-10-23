<table>
  <thead>
    <th>ID</th><th>width</th><th>height</th>
    <th>x</th><th>y</th><th>area_id</th>
    <th>date</th>
  </thead>
  <?php foreach($posters as $poster): ?>
  <tr>
    <td><?php echo h($poster['Poster']['id']) ?></td>
    <td><?php echo h($poster['Poster']['width']) ?></td>
    <td><?php echo h($poster['Poster']['height']) ?></td>
    <td><?php echo h($poster['Poster']['x']) ?></td>
    <td><?php echo h($poster['Poster']['y']) ?></td>
    <td><?php echo h($poster['Poster']['area_id']) ?></td>
    <td><?php echo h($poster['Poster']['date']) ?></td>
  </tr>
  <?php endforeach; ?>
</table>