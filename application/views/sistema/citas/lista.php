<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Paciente</th>
				<th>Doctor</th>
				<th>Servicio</th>
				<th>Fecha y hora</th>
				<th>Estatus</th>
				<?php if ($permisosSub): ?>
					<th>Acciones</th>
				<?php elseif(in_array($permisos,$aPermisos['Editar'])): ?>
					<th>Acciones</th>
				<?php endif; ?>


			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($citas as $cita){

					$cita->paciente->get();
					$cita->empleado->get();
					$cita->servicio->get();

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$cita->paciente->nombre.' '.$cita->paciente->apellido_p .' '.$cita->paciente->apellido_m.'</td>';
						echo '<td>'.$cita->empleado->nombre.' '.$cita->empleado->apellido_p .' '.$cita->empleado->apellido_m.'</td>';
					    echo '<td>'.$cita->servicio->nombre.'</td>';
						echo '<td>'.date("d", strtotime($cita->fecha_hora)) .' '. 
									$aMeses[date("n", strtotime($cita->fecha_hora))-1]. 
									//.'/'. date("Y", strtotime($cita->fecha_hora)) 
									' '. date("H:i", strtotime($cita->fecha_hora)).
							 '</td>';
						echo '<td>';

						if(in_array($permisos,$aPermisos['Editar'])){ 
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" id="estatus_'.$cita->id.'" style="cursor:pointer" width="25" height="25" onclick="createTooltip('.$cita->id.')">';
						} else {
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" width="25" height="25" >';
						}

						echo '</td>';


						if ($permisosSub){

							echo '<td>';
								if(in_array($permisos,$aPermisos['Editar'])){ 
									echo '<a href="'.base_url('appointment/editar/'.$cita->id).'">';
									echo '<img src="'.base_url('assets/images/edit.png').'" width="25" height="25" >';
								}
								if (isset($permisosSub['Histórico'])){
									echo '<img src="'.base_url('assets/images/history.jpg').'" id="historia_'.$cita->id.'"  width="25" height="25" onclick="createTooltipHistoria('.$cita->id.')">';
								}
								if (isset($permisosSub['Adicionales'])){
									echo '<img src="'.base_url('assets/images/add.png').'" width="25" height="25" >';
								}
								if (isset($permisosSub['Costo'])){
									echo '<img src="'.base_url('assets/images/money.png').'" width="25" height="25" >';
								}
							echo '</td>';

						} else {

								if(in_array($permisos,$aPermisos['Editar'])){ 
									echo '<td>';
									echo '<img src="'.base_url('assets/images/edit.png').'" width="25" height="25" >';
									echo '</td>';
								}

						}	

					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($citas->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($citas->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('appointment/index/1/'.$estatusActual); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->previous_page.'/'.$estatusActual); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $citas->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('appointment/index/'.$x.'/'.$estatusActual); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($citas->paged->has_next): ?>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->next_page.'/'.$estatusActual); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->total_pages.'/'.$estatusActual); ?>">
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


	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('appointment/agregar') ?>">Agregar</a>
	<?php endif; ?>

<script>

	base_url = "<?= base_url(); ?>";

function createTooltip(id_cita){ 

	new Tip('estatus_'+id_cita, {
			    title : 'Actualizar estatus',
				//target: $('estatus').up('li'),
				ajax: {
					url: base_url+'appointment/estatus/'+id_cita,
					options: {
						onComplete: function(transport) {
							
						}
					}
				},
				closeButton: true,
				hideOn: { element: '.close', event: 'click' },
				showOn: 'click',
				width: '120', 
				hook: { target: 'bottomMiddle', tip: 'topRight' },
				stem: 'topRight',
				offset: { x: 6, y: 3 }
			});

	$('estatus_'+id_cita).prototip.show();

}


function createTooltipHistoria(id_cita){ 

	new Tip('historia_'+id_cita, {
			    title : 'Historia de la cita',
				//target: $('estatus').up('li'),
				ajax: {
					url: base_url+'appointment/historia/'+id_cita,
					options: {
						onComplete: function(transport) {
							
						}
					}
				},
				closeButton: true,
				hideOn: { element: '.close', event: 'click' },
				showOn: 'click',
				width: '200', 
				hook: { target: 'bottomMiddle', tip: 'topRight' },
				stem: 'topRight',
				offset: { x: 6, y: 3 }
			});

	$('historia_'+id_cita).prototip.show();

}

	//});

</script>