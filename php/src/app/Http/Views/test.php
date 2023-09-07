<h2>Maria DB</h2>
<?php foreach ($mariaDbData as $row): ?>
<p><strong>Minute: </strong><?php echo $row['minute'] ?></p>
<p><strong>Count rows: </strong><?php echo $row['count'] ?></p>
<p><strong>Avg content length: </strong><?php echo $row['avg_content_length'] ?></p>
<p><strong>Min time: </strong><?php echo $row['min'] ?></p>
<p><strong>Max time: </strong><?php echo $row['max'] ?></p>
<p> </p>
<?php endforeach; ?>
