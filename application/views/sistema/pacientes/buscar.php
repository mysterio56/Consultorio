<script>
	$(function(){ Find.pacientes(); });
</script>
<?php
	$attributes = array('id' => 'pacientesForm');

	 	echo form_open(null,$attributes);

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}
	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo'<td  width="100" valing="top">'; 
	 		echo form_label('Código:');
	    echo'</td>';
	    echo'<td>';
		 	$data = array(
		 		'name'  => 'Codigo',
		 		'id'    => 'Codigo',
		 		'value' => set_value('Codigo'),
		 		'style' => 'width:80px'
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

		 	echo form_label('Apellido Paterno:');
		 	$data = array(
		 		'name'  => 'Apellido_p',
		 		'id'    => 'Apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('Apellido_p'),
		 		'style' => 'width:85px'
		 	);
		 	echo form_input($data);

		 	echo form_label('Apellido Materno:');
		 	$data = array(
		 		'name'  => 'Apellido_m',
		 		'id'    => 'Apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('Apellido_m'),
		 		'style' => 'width:85px'
		 	);
		 	echo form_input($data);
		 	echo'</td>';
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
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>'
			
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

	 	if(isset($pacientes)){

	 		$this->load->view('sistema/pacientes/lista');

	 	}
?>

<script>

function grid(){

	jQuery('#tbodypaciente').html("");
	jQuery('#wait_grid').show();
	jQuery('#agregar').hide(); 
	jQuery('#busavan').hide();

	var form_data = jQuery('#pacientesForm').serialize();
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
		  					
		  					rowPaciente += '<a id="cambio" onclick="'+funcion+'" href="'+base_url+'patient/status/'+paciente.id+'">'; 		
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

	 			rowPaciente = '<tr><td colspan="100%">No se encuentra lo que busca </td></tr>';
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
