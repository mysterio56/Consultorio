<script>
	$(function(){ Find.fecha_alta_value(); });
</script>
<?php
	$attributes = array('id' => 'servicioForm');
		
	 	echo form_open(null,$attributes);

	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo'<td  width="100" valing="top">'; 
	 		echo form_label('Codigo:');
	    echo'</td>';
	    echo'<td>';
		 	$data = array(
		 		'name'  => 'Codigo',
		 		'id'    => 'Codigo',
		 		'value' => set_value('Codigo'),
		 		'style' => 'width:125px'
		 	);
		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

             echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Nombre:');
            echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'Nombre',
		 		'id'    => 'Nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('Nombre'),
		 		'style' => 'width:125px'
		 	);

		 	echo form_input($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Activo');	
 	        echo '<td>';
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 1,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);

		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Inactivo');
 	        echo '<td>';	
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 0,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Eliminado');
 	        echo '<td>';	
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 2,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Fecha de alta:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'fecha_alta_value',
		 		'id'    => 'fecha_alta_value',
		 		'value' => set_value('fecha_alta_value'),
		 		'style' => 'width:125px',
		 		
		 	);
		 	echo '<div>';
		 	echo form_input($data);
		 	echo '</div>';
		 	echo '</td>';
            echo '</tr>';
			
			?>

			<input type="hidden" name="fecha_alta" id="fecha_alta" />

			<?php
			echo'</table>'; 
			
		 	$data = array(
		 		'name'  => 'buscar',
		 		'id'    => 'buscar',
		 		'class' => 'abutton',
		 		'value' => 'Buscar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close(); 

	 	if(isset($servicios)){
	 		
	 		$this->load->view('sistema/servicio/lista');

	 	}
?>

<script>

base_url = "<?= base_url(); ?>";

function grid(){

	jQuery('#tbodyservicio').html("");
	jQuery('#wait_grid').show();
	jQuery('#agregar').hide(); 
	jQuery('#busavan').hide();

	var form_data = jQuery('#servicioForm').serialize();
	jQuery.post( base_url+"service/grid/"+page, form_data , 

	 
	

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,servicio){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowservicio  = '<tr class="'+classRow+'">';
		  			rowservicio	+= '<td align="center">'+servicio.codigo+'</td>';
		  			rowservicio	+= '<td align="center">'+servicio.nombre+'</td>';
		  			rowservicio	+= '<td align="center">'+servicio.fecha_alt+'</td>';
		  			
		  			if(servicio.editar||servicio.activar||servicio.eliminar){
		  				
		  				rowservicio +=  '<td align="center">'; 

		  				if(servicio.editar){
		  					rowservicio += '<a href="'+base_url+'service/editar/'+servicio.id+'">'; 		
		  					rowservicio += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowservicio += '</a>'; 
		  				}
		  				rowservicio +=  '<td align="center">';

		  				if(servicio.activar){	
		  				
		  					if(servicio.estatus == 1){
		  					
		  						activo  ='active';
		  						funcion ='if(Valid.desactivaregistro()==false)return false';
		  				
		  					}else if(servicio.estatus == 0){
		  					
		  						activo ='inactive';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  				
		  					}else if(servicio.estatus == 2){
		  					
		  						activo ='active';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  					
		  					}
		  					
		  					rowservicio += '<a onclick="'+funcion+'" href="'+base_url+'service/status/'+servicio.id+'">'; 		
		  					rowservicio += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowservicio += '</a>'; 
		  				    }
		  						  			  				    
	 	  				rowservicio +=  '<td align="center">'; 

	 	  				if(servicio.eliminar){

	 	  					if(servicio.estatus!=2){
                       
		  					rowservicio += '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'+base_url+'service/eliminar/'+servicio.id+'">'; 		
		  					rowservicio += '<img src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowservicio += '</a>'; 
	 	  					}
	 	  				}


	 	  				rowservicio += '</td>';
		  			}

		  			rowservicio += '</tr>';

		  			
		  			jQuery('#tbodyservicio').append(rowservicio);
		  			jQuery('#tfootservicio').html("");

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

					jQuery('#tfootservicio').append(rowFoot);
				}

			}else {

	 			rowservicio = '<tr><td colspan="100%">No existen servicioes </td></tr>';
	 			jQuery('#tbodyservicio').append(rowservicio);
	 			jQuery('#tfootservicio').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>