<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
					<th>Editar</th>
				<?php endif; ?>
				<th>Activo</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($especialidades as $especialidad){

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$especialidad->codigo.'</td>';
						echo '<td>'.$especialidad->nombre.'</td>';
						if(in_array($permisos,array(2,6,7))){ 
							echo '<td><a href="'.base_url('specialism/editar/'.$especialidad->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" /></a></td>';
						}			  
						$activo = $especialidad->estatus?'active':'inactive';
						echo '<td>';
								if(in_array($permisos,$aPermisos['Eliminar']) ){
									echo '<a href="'.base_url('specialism/status/'.$especialidad->id).'">
											<img src="'.base_url('assets/images/'.$activo.'.png').'" />
										 </a>';
										}
                                echo '<td>';
								if(in_array($permisos,$aPermisos['Eliminar']) ){
									echo '<a href="'.base_url('specialism/eliminar/'.$especialidad->id).'">
									  <img src="'.base_url('assets/images/delete.png').'"/>
                                     </a>';


								}else{
									echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';
								}

						echo '</td>';
					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($especialidades->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($especialidades->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('specialism/index/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('specialism/index/'.$especialidades->paged->previous_page); ?>">
											<span>Anteriro</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $especialidades->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('specialism/index/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($especialidades->paged->has_next): ?>
									<li>
										<a href="<?= base_url('specialism/index/'.$especialidades->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('specialism/index/'.$especialidades->paged->total_pages); ?>">
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
	<a class="abutton" href="<?= base_url('specialism/agregar') ?>">Agregar</a>
<?php endif; ?>