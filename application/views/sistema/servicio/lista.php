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
				<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
				<th>Eliminar</th>
				<?php endif;?>
			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($servicios as $servicio){
					if($servicio->estatus!=2){
					   if (($nRow % 2) == 0) {
						  $rowClass = "even";
					   }else {
						  $rowClass = "odd";
					   }
				    }else{
						  $rowClass="borrado";
					}

						echo '<tr class='.$rowClass.'>';
						  echo '<td>'.$servicio->codigo.'</td>';
						  echo '<td>'.$servicio->nombre.'</td>';
						
						if(in_array($permisos,$aPermisos['Editar'])){  
							if($servicio->estatus!=2){
							echo '<td align="center"><a href="'.base_url('service/editar/'.$servicio->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" /></a></td>';
						    }			  
					    }
						
								if(in_array($permisos,$aPermisos['Editar']) ){
									if($servicio->estatus==1){

										echo '<td align="center">';
										$activo='active';
										$function='if(Valid.desactivaregistro()==false)return false';
									
									}else if($servicio->estatus==0){

										echo '<td align="center">';
										$activo='inactive';
										$function='if(Valid.activaregistro()== false)return false';
									
									}else if($servicio->estatus==2){
										echo '<td align="center" colspan="3">';
										$activo='inactive';
										$function='if(Valid.activaregistro()== false)return false';
									}

									echo '<a onclick="'.$function.'" href="'.base_url('service/status/'.$servicio->id).'">
											<img src="'.base_url('assets/images/'.$activo.'.png').'" />
										 </a>';
								}
                      			else{
                      				$activo = $servicio->estatus?'active':'inactive';
									echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';
								}
						if(in_array($permisos,$aPermisos['Eliminar']) ){								
                          if($servicio->estatus!=2){
                        echo '<td align="center">';
									echo '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'.base_url('service/eliminar/'.$servicio->id).'">
									  <img src="'.base_url('assets/images/delete.png').'"/>
                                     </a>';
                        
						echo '</td>';

							}
						}


					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($servicios->paged->total_pages > 1):?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($servicios->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('service/index/1'); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('service/index/'.$servicios->paged->previous_page); ?>">
											<span>Anteriro</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $servicios->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('service/index/'.$x); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($servicios->paged->has_next): ?>
									<li>
										<a href="<?= base_url('service/index/'.$servicios->paged->next_page); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('service/index/'.$servicios->paged->total_pages); ?>">
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
		<a class="abutton" href="<?= base_url('service/agregar') ?>">Agregar</a>
	<?php endif; ?>
	<a class="abutton" href="<?= base_url('service/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>