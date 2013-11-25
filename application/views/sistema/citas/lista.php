<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Paciente</th>
				<th>Doctor</th>
				<th>Servicio</th>
				<th>Fecha y hora</th>
				<th>Estatus</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($citas as $cita){

					$cita->paciente->get();
					$cita->empleado->get();

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$cita->paciente->nombre.' '.$cita->paciente->apellido_p .' '.$cita->paciente->apellido_m.'</td>';
						echo '<td>'.$cita->empleado->nombre.' '.$cita->empleado->apellido_p .' '.$cita->empleado->apellido_m.'</td>';
					    echo '<td>'.$cita->fecha_hora.'</td>';
						echo '<td>'.$cita->fecha_hora.'</td>';
						echo '<td>'.$cita->fecha_hora.'</td>';
						echo '<td>'.$cita->fecha_hora.'</td>';	
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
