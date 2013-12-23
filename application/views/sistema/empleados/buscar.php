<script>
	$(function(){ Find.empleados(); });
</script>
<?php
	$attributes = array('id' => 'empleadosForm');

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
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);

		 	echo form_label('Apellido Materno:');
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		'style' => 'width:85px'
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
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
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

	 	if(isset($empleados)){

	 		$this->load->view('sistema/empleados/lista');

	 	}
?>
<script>

function grid(){

	jQuery('#tbodyempleado').html("");
	jQuery('#wait_grid').show();
	jQuery('#agregar').hide(); 
	jQuery('#busavan').hide();


	var form_data = jQuery('#empleadosForm').serialize();
	jQuery.post( base_url+"employees/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,empleado){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowEmpleado  = '<tr class="'+classRow+'">';
		  			rowEmpleado	+= '<td align="center">'+empleado.codigo+'</td>';
		  			rowEmpleado	+= '<td align="center">'+empleado.nombre+'</td>';
		  			rowEmpleado	+= '<td align="center">'+empleado.email+'</td>';
		  			rowEmpleado	+= '<td align="center">'+empleado.telefono+'</td>';
		  			rowEmpleado	+= '<td align="center">'+empleado.celular+'</td>';
		  					  			
		  			if(empleado.editar||empleado.activar||empleado.eliminar){

		  				jQuery('#thAcciones').show();		  				
		  				
		  				rowEmpleado +=  '<td align="center">'; 

		  				if(empleado.editar){
		  					rowEmpleado += '<a href="'+base_url+'employees/editar/'+empleado.id+'">'; 		
		  					rowEmpleado += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowEmpleado += '</a>'; 
		  				}
		  				
		  				if(empleado.activar){	
		  				
		  					if(empleado.estatus == 1){
		  					
		  						activo  ='active';
		  						funcion ='if(Valid.desactivaregistro()==false)return false';
		  				
		  					}else if(empleado.estatus == 0){
		  					
		  						activo ='inactive';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  				
		  					}else if(empleado.estatus == 2){
		  					
		  						activo ='active';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  					
		  					}
		  					
		  					rowEmpleado += '<a onclick="'+funcion+'" href="'+base_url+'employees/status/'+empleado.id+'">'; 		
		  					rowEmpleado += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowEmpleado += '</a>'; 
		  				    }
		  						  			  				    
	 	  				if(empleado.eliminar){

	 	  					if(empleado.estatus!=2){
                       
		  					rowEmpleado += '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'+base_url+'employees/eliminar/'+empleado.id+'">'; 		
		  					rowEmpleado += '<img src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowEmpleado += '</a>'; 
	 	  					}
	 	  				}


	 	  				rowEmpleado += '</td>';
		  			}

		  			rowEmpleado += '</tr>';

		  			
		  			jQuery('#tbodyempleado').append(rowEmpleado);
		  			jQuery('#tfootempleado').html("");

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

					jQuery('#tfootempleado').append(rowFoot);
				}

			}else {

	 			rowEmpleado = '<tr><td colspan="100%">No hay registro de lo que Busca </td></tr>';
	 			jQuery('#tbodyempleado').append(rowEmpleado);
	 			jQuery('#tfootempleado').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>