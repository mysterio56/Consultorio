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
				foreach($empleados as $empleado){

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$empleado->codigo.'</td>';
						echo '<td>'.$empleado->nombre.' '.$empleado->apellido_p.' '.$empleado->apellido_m.'</td>';
						echo '<td>'.$empleado->email.'</td>';
						echo '<td>'.$empleado->telefono.'</td>';
						echo '<td>'.$empleado->celular.'</td>';
						echo '<td>';

						if(in_array($permisos,$aPermisos['Editar'])){ 

							echo '<a href="'.base_url('employees/editar/'.$empleado->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" title="Editar"/>
								  </a>';

						}

						$activo = $empleado->estatus?'active':'inactive';
						$title  = $empleado->estatus?'Desactivar':'Activar';

						if(in_array($permisos,$aPermisos['Editar']) ){

							echo '<a href="'.base_url('employees/status/'.$empleado->id).'">
									<img src="'.base_url('assets/images/'.$activo.'.png').'" title="'.$title.'" />
								 </a>';

						}else{

							echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';

						}

						if(in_array($permisos,$aPermisos['Eliminar'])){ 

							echo '<a href="'.base_url('employees/eliminar/'.$empleado->id).'">
									  <img src="'.base_url('assets/images/delete.png').'" title="Eliminar"/>
								  </a>';

						}	

						echo '</td>';
					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($empleados->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($empleados->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('employees/index/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('employees/index/'.$empleados->paged->previous_page); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $empleados->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('employees/index/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($empleados->paged->has_next): ?>
									<li>
										<a href="<?= base_url('employees/index/'.$empleados->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('employees/index/'.$empleados->paged->total_pages); ?>">
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
<?php if(!isset($buscar)): ?>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('employees/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a class="abutton" href="<?= base_url('employees/buscar') ?>">Búsqueda Avanzada</a>
<?php endif; ?>