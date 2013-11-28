<?php 
define ("MESES", serialize (array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic")));
$aMeses    = unserialize (MESES); 
?>
<div style="max-height:150px;overflow-y: auto;">
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Estatus</th>
				<th>Fecha y hora</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($historial as $historia){

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td><img src="'.base_url('assets/images/'.estatus($historia->estatus).'_point.png').'" width="25" height="25" ></td>';

						echo '<td>'.date("d", strtotime($historia->fecha_alta)) .' '. 
									$aMeses[date("n", strtotime($historia->fecha_alta))-1]. 
									//.'/'. date("Y", strtotime($cita->fecha_hora)) 
									' '. date("H:i", strtotime($historia->fecha_alta)).
							 '</td>';

						
					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
	</table>
</div>