<label> Producto/Servicio: </label><label id="name_PS" style="color:black"><?= $nombre; ?></label>
<br />
<br />
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Fecha/Hora</th>
				<?php if($tipo == "ingreso"): ?>
				<th>Por Cita</th>
				<?php endif; ?>
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

			$total = 0;


				foreach($detail as $key => $detalle){

					if ((($key+1) % 2) == 0) {
						$rowClass = "even";
					} else  {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.date("d", strtotime($detalle->fecha_alta)) ."/". 
			   					    month(date("m", strtotime($detalle->fecha_alta)) - 1,false) ."/".
			   					    date("Y", strtotime($detalle->fecha_alta)) ." ".
			   					    date("H:i", strtotime($detalle->fecha_alta)).'</td>';

			   			if($tipo == "ingreso"){

			   				$porCita = $detalle->cita_id?'Si':'';
			   				echo '<td>'.$porCita.'</td>';		

			   			}   
			   			 
						echo '<td>'.$detalle->cantidad.'</td>';
						echo '<td align="right">$ '.number_format(($detalle->costo/$detalle->cantidad), 2, '.', ',').'</td>';
						echo '<td align="right">$ '.number_format(($detalle->costo), 2, '.', ',').'</td>';
						
					echo '</tr>';

					$total = $total + $detalle->costo;
				}
			?>
		</tbody>
		<?php if($detail->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($detail->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('balance_sheet/detail'.$typeDetail.'/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('balance_sheet/detail'.$typeDetail.'/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$detail->paged->previous_page); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $detail->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												
												<a href="<?= base_url('balance_sheet/detail'.$typeDetail.'/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($detail->paged->has_next): ?>
									<li>
										<a href="<?= base_url('balance_sheet/detail'.$typeDetail.'/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$detail->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('balance_sheet/detail'.$typeDetail.'/'.$id.'/'.$tipo.'/'.$date_start_url.'/'.$date_end_url.'/'.$detail->paged->total_pages); ?>">
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

<label> Total: </label><label id="total" style="color:black"></label>

<a href="<?= base_url('balance_sheet') ?>" class ="abutton_cancel" >Cancelar</a>

<script>
	$(function(){

		base_url   = "<?= base_url(); ?>";
		date_start = "<?= ($date_start != 'false')?date('Y-m', strtotime($date_start)):""; ?>";
		date_end   = "<?= ($date_end != 'false')?date('Y-m', strtotime($date_end)):"" ?>";

		getTotal();

	});
   

   function getTotal(){

   	if("<?= $typeDetail; ?>"== "Producto"){

		var form_data = { type_aux   : "<?= $tipo ?>",
	                      producto   : <?= $id ?>,
	                      date_start : date_start,
	                      date_end   : date_end
	                    };

	    var url = "balance_sheet/getTotalProducto";

    } else {

    	var form_data = { type_aux   : "<?= $tipo ?>",
	                      servicio   : <?= $id ?>,
	                      date_start : date_start,
	                      date_end   : date_end
	                    };

	    var url = "balance_sheet/getTotalServicio";                

    }

	jQuery.post( base_url+url, form_data , 

		function( data ) {

			$("#total").html("$ "+data);
      
      
	});
}

</script>