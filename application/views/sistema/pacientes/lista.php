<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th align="center">Código</th>
				<th align="center">Nombre</th>
				<th align="center">Email</th>
				<th align="center">Teléfono</th>
				<th align="center">Celular</th>
				<th id="thAcciones" style="display:none" align="center">Acciones</th>
			</tr>
		</thead>
		<tbody id= "tbodypaciente">

		</tbody>
		<tfoot id= "tfootpaciente">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
	<?php if(isset($buscar)): ?>
		<a href="<?= base_url('patient') ?>" class="abutton_cancel">Cancelar</a>
	<?php endif; ?>

    <?php if(!isset($buscar)): ?>
		<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('patient/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a class="abutton" href="<?= base_url('patient/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>

<script>
base_url = "<?= base_url(); ?>";
page     = 1;

jQuery(function() {
      jQuery( "#buscar" ).autocomplete({
            source: base_url + "patient/lista",
            minLength: 2,
                select: function( event, item ) {
                },
            change: function(event, ui) {
                    jQuery("#buscarId").val(ui.item ? ui.item.Id : "");
                }
        });

       grid();

});
</script>
<script>

function grid(){

	jQuery('#tbodypaciente').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"patient/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,paciente){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowPaciente  = '<tr class="'+classRow+'">';
		  			rowPaciente	+= '<td align="center">'+paciente.codigo+'</td>';
		  			rowPaciente	+= '<td align="center">'+paciente.nombre+'</td>';
		  			rowPaciente	+= '<td align="center">'+paciente.email+'</td>';
		  			rowPaciente	+= '<td align="center">'+paciente.telefono+'</td>';
		  			rowPaciente	+= '<td align="center">'+paciente.celular+'</td>';
		  					  			
		  			if(paciente.editar||paciente.activar||paciente.eliminar){

		  				jQuery('#thAcciones').show();		  				
		  				
		  				rowPaciente +=  '<td align="center">'; 

		  				if(paciente.editar){
		  					rowPaciente += '<a href="'+base_url+'patient/editar/'+paciente.id+'">'; 		
		  					rowPaciente += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowPaciente += '</a>'; 
		  				}
		  				
		  				if(paciente.activar){	
		  				
		  					if(paciente.estatus == 1){
		  					
		  						activo  ='active';
		  						funcion ='if(Valid.desactivaregistro()==false)return false';
		  				
		  					}else if(paciente.estatus == 0){
		  					
		  						activo ='inactive';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  				
		  					}else if(paciente.estatus == 2){
		  					
		  						activo ='active';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  					
		  					}
		  					
		  					rowPaciente += '<a onclick="'+funcion+'" href="'+base_url+'patient/status/'+paciente.id+'">'; 		
		  					rowPaciente += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowPaciente += '</a>'; 
		  				    }
		  						  			  				    
	 	  				if(paciente.eliminar){

	 	  					if(paciente.estatus!=2){
                       
		  					rowPaciente += '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'+base_url+'patient/eliminar/'+paciente.id+'">'; 		
		  					rowPaciente += '<img src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowPaciente += '</a>'; 
	 	  					}
	 	  				}


	 	  				rowPaciente += '</td>';
		  			}

		  			rowPaciente += '</tr>';

		  			
		  			jQuery('#tbodypaciente').append(rowPaciente);
		  			jQuery('#tfootpaciente').html("");

		  		});
				

				if(data.page_total > 1){

					rowFoot = '<tr><td colspan="100%"><div id="paging"><ul>';

					if(data.has_previous){
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage(1);">';
						rowFoot += '<span>Inicio</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.previous_page+');">';
						rowFoot += '<span>Anterior</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
					}

					for (var i=1;i<=data.page_total;i++)
					{ 

						if(data.page_actual == i){
							pagActiva = 'active';
						} else {
							pagActiva = '';
						}

						rowFoot += '<li>';
						rowFoot += '<a class="'+pagActiva+'" onClick="setPage('+i+')" >';
						rowFoot += '<span>'+i+'</span>';
						rowFoot += '</a>';
					}

					if(data.has_next){
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.next_page+');">';
						rowFoot += '<span>Siguente</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.page_total+');">';
						rowFoot += '<span>Fin</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
					}

					rowFoot += '</ul></div></td></tr>';

					jQuery('#tfootpaciente').append(rowFoot);
				}

			}else {

	 			rowPaciente = '<tr><td colspan="100%">No existen pacientees </td></tr>';
	 			jQuery('#tbodypaciente').append(rowPaciente);
	 			jQuery('#tfootpaciente').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>
			<!--<?php 
				/*$nRow = 1;
				foreach($pacientes as $paciente){
				if($paciente->estatus!=2){
					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}
				}
				else{
					 $rowClass ="borrado";
				}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$paciente->codigo.'</td>';
						echo '<td>'.$paciente->nombre.' '.$paciente->apellido_p.' '.$paciente->apellido_m.'</td>';
						echo '<td>'.$paciente->email.'</td>';
						echo '<td>'.$paciente->telefono.'</td>';
						echo '<td>'.$paciente->celular.'</td>';
						echo '<td align="center">';

						if(in_array($permisos,$aPermisos['Editar'])){ 
							if($paciente->estatus!=2){

							echo '<a href="'.base_url('patient/editar/'.$paciente->id).'">
									  <img src="'.base_url('assets/images/edit.png').'" title="Editar"/>
								  </a>';
							}						
						}		

						
						$title  = $paciente->estatus?'Desactivar':'Activar';

						if(in_array($permisos,$aPermisos['Editar']) ){
							if($paciente->estatus==1){
								$activo='active';
								$function='if(Valid.desactivaregistro()==false)return false';
							}
							else if($paciente->estatus==0){
								$activo='inactive';
								$function='if(Valid.activaregistro()==false)return false';

							}
							else if($paciente->estatus==2){
								$activo='inactive';
								$function='if(Valid.activaregistro()==false)return false';
							}
							echo '<a onclick="'.$function.'" href="'.base_url('patient/status/'.$paciente->id).'">
									<img src="'.base_url('assets/images/'.$activo.'.png').'" title="'.$title.'" />
								 </a>';

						}else{

							echo '<img src="'.base_url('assets/images/'.$activo.'.png').'" />';

						}

						if(in_array($permisos,$aPermisos['Eliminar'])){ 
							if($paciente->estatus!=2){

							echo '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'.base_url('patient/eliminar/'.$paciente->id).'">
									  <img src="'.base_url('assets/images/delete.png').'" title="Eliminar"/>
								  </a>';
						    }
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
<?php if(isset($buscar)): ?>
	<a href="<?= base_url('patient') ?>" class="abutton_cancel">Cancelar</a>
	<?php endif; ?>

<?php if(!isset($buscar)): ?>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('patient/agregar') ?>">Agregar</a>
	<?php endif; ?>
	<a class="abutton" href="<?= base_url('patient/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif; ?> -->*/
