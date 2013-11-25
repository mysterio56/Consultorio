<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Fecha Alta</th>
			    <?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
					<th>Editar</th>
				<?php endif; ?>
				<th>Activo</th>
				<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
				<th>Eliminar</th>
				<?php endif;?>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($formatos as $formato){

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$formato->codigo.'</td>';
						echo '<td>'.$formato->nombre.'</td>';
						echo '<td>'.date("d", strtotime($formato->fecha_alta)) .' / '. $aMeses[date("n", strtotime($formato->fecha_alta))-1] .' / '. date("Y", strtotime($formato->fecha_alta)) .'</td>';
						if(in_array($permisos,array(2,6,7))){ 
							echo '<td><a href="'.base_url('format/editar/'.$formato->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" /></a></td>';
						}			  
						$activo = $formato->estatus?'active':'inactive';
						echo '<td>';
								if(in_array($permisos,$aPermisos['Editar']) ){
									echo '<a href="'.base_url('format/status/'.$formato->id).'">
											<img src="'.base_url('assets/images/'.$activo.'.png').'" />
										 </a>';


								}else{
									echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';
								}

						echo '</td>';

						if(in_array($permisos,$aPermisos['Eliminar']) ){								
							
	                        echo '<td>';
										echo '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'.base_url('format/eliminar/'.$formato->id).'">
										  <img src="'.base_url('assets/images/delete.png').'"/>
	                                     </a>';
	                        
							echo '</td>';

						}


					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($formatos->paged->total_pages > 1):?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($formatos->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('format/index/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('format/index/'.$formatos->paged->previous_page); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $formatos->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('format/index/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($formatos->paged->has_next): ?>
									<li>
										<a href="<?= base_url('format/index/'.$formatos->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('format/index/'.$formatos->paged->total_pages); ?>">
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
		<a class="abutton" href="<?= base_url('format/agregar') ?>">Agregar</a>
	<?php endif; ?>
	<a class="abutton" href="<?= base_url('format/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>