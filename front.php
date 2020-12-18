<?php
require('find.php');

?>
<table class='table table-responsive' >
	<thead>
		<tr>
			<th>CÓDIGO</th>
			<th>DESCRIÇÃO</th>
			<th>UNIDADE</th>
			<th>CUSTO UNITÁRIO</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<?php
	for($i = 0 ; $i <= $iTotal-1 ; $i++) {?>
	<tr>
		<td><?= $linha[$i][3] ?></td>
		<td><?= $linha[$i][2] ?></td>
		<td><?= $linha[$i][1] ?></td>
		<td><?= $linha[$i][0] ?></td>
	</tr>
	<?php } ?>

	</tr>
	</tbody>
</table>	

