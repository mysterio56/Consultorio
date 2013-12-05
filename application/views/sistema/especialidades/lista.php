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
 
				foreach($especialidades as $especialidad){
				  if($especialidad->estatus!=2){
					  if (($nRow % 2) == 0) {
						$rowClass = "even";
				  }else {
						$rowClass = "odd";
				  }
				  }else{
				  	$rowClass="borrado";
				  }
					echo '<tr class='.$rowClass.'>';
					
						echo '<td>'.$especialidad->codigo.'</td>';
						echo '<td>'.$especialidad->nombre.'</td>';
						echo '<td>'.date("d", strtotime($especialidad->fecha_alta)) .' / '. $aMeses[date("n", strtotime($especialidad->fecha_alta))-1] .' / '. date('Y').'</td>';
						
						if(in_array($permisos,$aPermisos['Editar'])){
							if($especialidad->estatus!=2){
							echo '<td align="center"><a href="'.base_url('specialism/editar/'.$especialidad->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" /></a></td>';
						    }
						}
						
								if(in_array($permisos,$aPermisos['Editar']) ){
									if ($especialidad->estatus==1){

										echo '<td align="center">';
										$activo= 'active';
										$function='if(Valid.desactivaregistro()==false)return false';

									} else if($especialidad->estatus==0){

										echo '<td align="center">';
										$activo= 'inactive';
										$function='if(Valid.activaregistro()== false)return false';

									} else if($especialidad->estatus==2){

										echo '<td align="center" colspan="3">';
										$activo='inactive';
										$function='if(Valid.activaregistro()==false)return false';

									}

									echo '<a onclick="'.$function.'" href="'.base_url('specialism/status/'.$especialidad->id).'">
											<img  src="'.base_url('assets/images/'.$activo.'.png').'" />
										 </a>';

								} else {

									$activo = $especialidad->estatus?'active':'inactive';
									echo' <img src="'.base_url('assets/images/'.$activo.'.png').'" />';

								}

						echo '</td>';

								if(in_array($permisos,$aPermisos['Eliminar']) ){
						
									if($especialidad->estatus!=2){

                    		            echo '<td align="center">';
										echo '<a onclick="if(Valid.eliminaregistro() ==false)return false"href="'.base_url('specialism/eliminar/'.$especialidad->id).'">
											  <img src="'.base_url('assets/images/delete.png').'"/>
                                    		 </a>';
                        echo '</td>';   

                                	}
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
	<?php if(isset($buscar)): ?>
	<a href="<?= base_url('specialism') ?>" class="abutton_cancel">Cancelar</a>
	<?php endif; ?>

    <?php if(!isset($buscar)): ?>
	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('specialism/agregar') ?>">Agregar</a>
	<?php endif; ?>
	<a class="abutton" href="<?= base_url('specialism/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>
