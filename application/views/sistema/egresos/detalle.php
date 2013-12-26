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
				<th>Cantidad</th>
				<th>Costo</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
		
			$date_start_url = strtotime($date_start)*1000;
			$date_end_url   = strtotime($date_end)*1000;

				foreach($egresos as $key => $egreso){

				    $egreso->producto->get();
				    $egreso->servicio->get();
				    //$egreso->paciente->get();

				    $name_PS  = $egreso->producto->id?$egreso->producto->nombre:$egreso->servicio->nombre;
				    $id       = $egreso->producto->id?$egreso->producto->id:$egreso->servicio->id;
				    $tipo     = $egreso->producto->id?"producto":"servicio";

					if ((($key+1) % 2) == 0) {
						$rowClass = "even";
					} else  {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.date("d", strtotime($egreso->fecha_alta)) ."/". 
			   					    month(date("m", strtotime($egreso->fecha_alta)) - 1,false) ."/".
			   					    date("Y", strtotime($egreso->fecha_alta)) ." ".
			   					    date("H:i", strtotime($egreso->fecha_alta)).'</td>';
						echo '<td>'.$egreso->cantidad.'</td>';
						echo '<td align="right">$ '.number_format(($egreso->costo/$egreso->cantidad), 2, '.', ',').'</td>';
						echo '<td align="right">$ '.number_format(($egreso->costo), 2, '.', ',').'</td>';
						
					echo '</tr>';
				}
			?>
		</tbody>
		<?php if($egresos->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($egresos->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('expenses/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('expenses/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$egresos->paged->previous_page); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $egresos->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												
												<a href="<?= base_url('expenses/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($egresos->paged->has_next): ?>
									<li>
										<a href="<?= base_url('expenses/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$egresos->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('expenses/detail/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$egresos->paged->total_pages); ?>">
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

<a href="<?= base_url('expenses') ?>" class ="abutton_cancel" >Cancelar</a>

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

	jQuery.post( base_url+"expenses/getTotal", form_data , 

		function( data ) {

			$("#total").html("$ "+data);
      
      
	});
}

</script>
