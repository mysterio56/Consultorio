<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Teléfono</th>
				<th>Celular</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($pacientes as $paciente){

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$paciente->codigo.'</td>';
						echo '<td>'.$paciente->nombre.' '.$paciente->apellido_p.' '.$paciente->apellido_m.'</td>';
						echo '<td>'.$paciente->email.'</td>';
						echo '<td>'.$paciente->telefono.'</td>';
						echo '<td>'.$paciente->celular.'</td>';
						echo '<td>';

						if(in_array($permisos,$aPermisos['Editar'])){ 

							echo '<a href="'.base_url('patient/editar/'.$paciente->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" title="Editar"/>
								  </a>';

						}		

						$activo = $paciente->estatus?'active':'inactive';
						$title  = $paciente->estatus?'Desactivar':'Activar';

						if(in_array($permisos,$aPermisos['Editar']) ){

							echo '<a href="'.base_url('patient/status/'.$paciente->id).'">
									<img src="'.base_url('assets/images/'.$activo.'.png').'" title="'.$title.'" />
								 </a>';

						}else{

							echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';

						}

						if(in_array($permisos,$aPermisos['Eliminar'])){ 

							echo '<a href="'.base_url('patient/eliminar/'.$paciente->id).'">
									  <img src="'.base_url('assets/images/delete.png').'" title="Eliminar"/>
								  </a>';

						}	

						echo '</td>';
					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($pacientes->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($pacientes->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('patient/index/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('patient/index/'.$pacientes->paged->previous_page); ?>">
											<span>Anteriro</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $pacientes->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('patient/index/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($pacientes->paged->has_next): ?>
									<li>
										<a href="<?= base_url('patient/index/'.$pacientes->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('patient/index/'.$pacientes->paged->total_pages); ?>">
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
	<a class="abutton" href="<?= base_url('patient/agregar') ?>">Agregar</a>
<?php endif; ?>