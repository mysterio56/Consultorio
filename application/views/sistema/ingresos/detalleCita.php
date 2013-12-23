<label> Fecha/Hora: </label> <label style="color:black;font-size: 13px;"><?= date("d", strtotime($cita->fecha_hora)) ."/". 
														   					    month(date("m", strtotime($cita->fecha_hora)) - 1,true) ."/".
														   					    date("Y", strtotime($cita->fecha_hora)) ." ".
														   					    date("H:i", strtotime($cita->fecha_hora)) ?></label>

<?php 
$cita->servicio->get(); 
$cita->paciente->get(); 
$cita->empleado->get(); 
?>

<label> Servicio: </label><label style="color:black;font-size: 13px;"><?= $cita->servicio->nombre; ?> - $ <?= $cita->costo; ?></label>
<br />
<label> Doctor: </label><label style="color:black;font-size: 13px;"><?= $cita->empleado->nombre; ?> <?= $cita->empleado->apellido_p; ?> <?= $cita->empleado->apellido_m; ?> </label>
<br />
<label> Paciente: </label><label style="color:black;font-size: 13px;"><?= $cita->paciente->nombre; ?> <?= $cita->paciente->apellido_p; ?> <?= $cita->paciente->apellido_m; ?> </label>
<br />
<label> Total: </label><label id="total" style="color:black;font-size: 13px;"><?= $total; ?></label>
<br />
<br />
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Producto/Servicio</th>
				<th>Cantidad</th>
				<th>Costo</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 

				foreach($ingresos->all as $key => $ingreso){

					$val = true;

					if ((($key+1) % 2) == 0) {
						$rowClass = "even";
					} else  {
						$rowClass = "odd";
					}

					$ingreso->producto->get();
					$ingreso->servicio->get();

					$prod_serv = $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre;

					echo '<tr class='.$rowClass.'>';
					echo '<td>'.$prod_serv.'</td>';
					echo '<td>'.$ingreso->sumCantidad.'</td>';
					echo '<td align="right">$ '.number_format(($ingreso->sumCosto/$ingreso->sumCantidad), 2, '.', ',').'</td>';
					echo '<td align="right">$ '.number_format(($ingreso->sumCosto), 2, '.', ',').'</td>';
					echo '</tr>';
				}

				if(!isset($val)){
					echo '<tr><td colspan="100%">No hay Adicionales para mostrar</td></tr>';
				}

			?>
		</tbody>
	</table>
</section>

<a href="<?= base_url('income') ?>" class ="abutton_cancel" >Cancelar</a>

<script>
 

</script>
