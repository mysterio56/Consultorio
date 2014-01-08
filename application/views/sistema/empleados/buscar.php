<?php $aPermisos = unserialize (PERMISOS); ?>
<script>
	$(function(){ Find.empleados(); $('.screenLoad').hide(); });
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
			</table>
           	 <a name='Buscar' id='Buscar' class="abutton" onclick= "grid();" value='Buscar'> Buscar</a>

			<?php
			echo '<a href="'.base_url($return).'" onclick = "$(\'.screenLoad\').show();" class="abutton_cancel">Cancelar</a>';
	 		echo form_close();

?>
<div id="tabla">
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
		<tbody id= "tbodyempleado">

		</tbody>
		<tfoot id= "tfootempleado">
			
		</tfoot>	
		</table>
		</div>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>

</section>
<script>

base_url = "<?= base_url(); ?>";
page     = 1;

$("#tabla").hide();

	$("#Buscar").click(function(){
		if($("#Codigo").val() != "" ){
             $('#tabla').show(); 
           }else if ($("#Nombre").val() != ""){
           	 $('#tabla').show(); 
           }else if($("#fecha_alta_value").val() != ""){
           	 $('#tabla').show();
           }else if($("input:checked").prop("checked")){
           	 $('#tabla').show();
           }
        });

function grid(){

	jQuery('#tbodyempleado').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#empleadosForm').serialize();
	jQuery.post( base_url+"employees/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,empleado){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowEmpleado  = '<tr class="'+classRow+'" id="tr_employees_'+empleado.id+'" >';
		  			rowEmpleado	+= '<td>'+empleado.codigo+'</td>';
		  			rowEmpleado	+= '<td>'+empleado.nombre+'</td>';
		  			rowEmpleado	+= '<td>'+empleado.email+'</td>';
		  			rowEmpleado	+= '<td>'+empleado.telefono+'</td>';
		  			rowEmpleado	+= '<td>'+empleado.celular+'</td>';
		  			jQuery('#thAcciones').show();
	  							
		  					if(empleado.estatus == 1){
		  					
		  						activo  ='active';
		  						
		  					}else{
		  					
		  						activo ='inactive';
		  						 					
		  					}
		  					  			
		  			if(empleado.editar||empleado.eliminar){
	  				
		  				rowEmpleado +=  '<td>'; 

		  				if(empleado.editar){
		  					rowEmpleado += '<a href="'+base_url+'employees/editar/'+empleado.id+'">'; 		
		  					rowEmpleado += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowEmpleado += '</a>'; 
		  				
		  					
		  					funcion = 'Valid.changeStatus(\''+base_url+'employees/status/'+empleado.id+'\',\''+base_url+'\',\'employees\',\''+empleado.id+'\');';
		  					 		
		  					rowEmpleado += '<img id="employees_'+empleado.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowEmpleado += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+empleado.id+'" width="25" height="25" style="display:none">';
		  				 
		  				}else{
		  				    rowEmpleado += '<img src="'+base_url+'assets/images/active.png'+'"style="width:25px;height:25px;" />';
		  				}
		  						  			  				    
	 	  				if(empleado.eliminar){

	 	  					if(empleado.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'employees/eliminar/'+empleado.id+'\',\'employees\',\''+empleado.id+'\');';
	 		
		  					rowEmpleado += '<img id="employees_delete_'+empleado.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowEmpleado += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+empleado.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  				}
	 	  				rowEmpleado += '</td>';
		  			}else{
		  				rowEmpleado += '<td align="center">'; 
						rowEmpleado += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
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

	 			rowEmpleado = '<tr><td colspan="100%">No existen empleadoes </td></tr>';
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