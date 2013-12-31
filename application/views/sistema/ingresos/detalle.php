<label> Producto/Servicio: </label><label id="name_PS" style="color:black"></label>
<br />
<label> Total: </label><label id="total" style="color:black"></label>
<br />
<br />
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Fecha/Hora</th>
				<th>Publico/Paciente</th>
				<th>Cantidad</th>
				<th>Costo</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
		
			$date_start_url = strtotime($date_start)*1000;
			$date_end_url   = strtotime($date_end)*1000;

			$date_start_url = $date_start_url?$date_start_url:"false";
			$date_end_url   = $date_end_url?$date_end_url:"false";

				foreach($ingresos as $key => $ingreso){

				    $ingreso->producto->get();
				    $ingreso->servicio->get();
				    $ingreso->paciente->get();

				    $name_PS  = $ingreso->producto->id?$ingreso->producto->nombre:$ingreso->servicio->nombre;
				    $id       = $ingreso->producto->id?$ingreso->producto->id:$ingreso->servicio->id;
				    $tipo     = $ingreso->producto->id?"producto":"servicio";
				    $paciente = $ingreso->paciente_id?$ingreso->paciente->nombre." ".$ingreso->paciente->apellido_p." ".$ingreso->paciente->apellido_m:'Publico';

					if ((($key+1) % 2) == 0) {
						$rowClass = "even";
					} else  {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.date("d", strtotime($ingreso->fecha_alta)) ."/". 
			   					    month(date("m", strtotime($ingreso->fecha_alta)) - 1,false) ."/".
			   					    date("Y", strtotime($ingreso->fecha_alta)) ." ".
			   					    date("H:i", strtotime($ingreso->fecha_alta)).'</td>';
			   			echo '<td>'.$paciente.'</td>';
						echo '<td>'.$ingreso->cantidad.'</td>';
						echo '<td align="right">$ '.number_format(($ingreso->costo/$ingreso->cantidad), 2, '.', ',').'</td>';
						echo '<td align="right">$ '.number_format(($ingreso->costo), 2, '.', ',').'</td>';
						
					echo '</tr>';
				}
			?>
		</tbody>
		<?php if($ingresos->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($ingresos->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('income/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('income/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$ingresos->paged->previous_page); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $ingresos->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												
												<a href="<?= base_url('income/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($ingresos->paged->has_next): ?>
									<li>
										<a href="<?= base_url('income/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$ingresos->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('income/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$ingresos->paged->total_pages); ?>">
											<span>Fin</span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</tr>
				</tfoot>
		<?php endif; ?>
	</table>
</section>

<a href="<?= base_url('income') ?>" class ="abutton_cancel" >Cancelar</a>

<script>
	$(function(){

		base_url   = "<?= base_url(); ?>";
		name_PS    = "<?= $name_PS; ?>";
		tipo       = "<?= $tipo; ?>";
		date_start = "<?= ($date_start != 'false')?date('d/m/Y', strtotime($date_start)):""; ?>";
		date_end   = "<?= ($date_end != 'false')?date('d/m/Y', strtotime($date_end)):"" ?>";

		$('#name_PS').html(name_PS);

		getTotalPS();
	});
   

   function getTotalPS(){

   	if(tipo=="producto"){

		var form_data = { type       : 1,
	                      producto   : <?= $id ?>,
	                      servicio   : "",
	                      date_start : date_start,
	                      date_end   : date_end
	                    };

    } else {

    	var form_data = { type       : 1,
    					  producto   : "",
	                      servicio   : <?= $id ?>,
	                      date_start : date_start,
	                      date_end   : date_end
	                    };

    }

	jQuery.post( base_url+"income/getTotal", form_data , 

		function( data ) {

			$("#total").html("$ "+data);
      
      
	});
}

</script>
