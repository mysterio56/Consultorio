<?php $aPermisos = unserialize (PERMISOS); ?>
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
 	       echo'<td width="100" valing="top">'; 
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

		 	echo '<tr>';
		 	echo '<td>';
		 	echo form_label('Apellido Paterno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'Apellido_p',
		 		'id'    => 'Apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('Apellido_p'),
		 		'style' => 'width:100px'
		 	);
		 	echo form_input($data);
		 	echo '</td>';
		 	echo'<td>';
		 	echo form_label('Apellido Materno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'Apellido_m',
		 		'id'    => 'Apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('Apellido_m'),
		 		'style' => 'width:100px'
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
			</table>
			 <a name='Buscar' id='Buscar' class="abutton" onclick= "grid();" value='Buscar'> Buscar</a>
			<?php
			
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close(); 

	 	
?>
<div id="tabla">
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="4%">Código</th>
				<th width="100%">Nombre</th>
				<th width="100%">Email</th>
				<th width="6%">Teléfono</th>
				<th width="6%">Celular</th>
				<th id="thAcciones" style="display:none" width="6%">Acciones</th>
			
			</tr>
		</thead>
		<tbody id= "tbodypaciente">

		</tbody>
		<tfoot id= "tfootpaciente">
			
		</tfoot>	
		</table>
		</div>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

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

	jQuery('#tbodypaciente').html("");
	jQuery('#wait_grid').show();
	

	var form_data = jQuery('#pacientesForm').serialize();
	jQuery.post( base_url+"patient/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,paciente){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowPaciente  = '<tr class="'+classRow+'" id="tr_patient_'+paciente.id+'" >';
		  			rowPaciente	+= '<td>'+paciente.codigo+'</td>';
		  			rowPaciente	+= '<td>'+paciente.nombre+'</td>';
		  			rowPaciente	+= '<td>'+paciente.email+'</td>';
		  			rowPaciente	+= '<td>'+paciente.telefono+'</td>';
		  			rowPaciente	+= '<td>'+paciente.celular+'</td>';

		  			jQuery('#thAcciones').show();
					  					
		  					if(paciente.estatus == 1){
		  					
		  						activo  ='active';
		  					
		  				
		  					}else{
		  					
		  						activo ='inactive';
		  				
		  					}
		  							  					  			
		  			if(paciente.editar||paciente.eliminar){

		  				rowPaciente +=  '<td align="center">'; 

		  				if(paciente.editar){
		  					rowPaciente += '<a href="'+base_url+'patient/editar/'+paciente.id+'">'; 		
		  					rowPaciente += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowPaciente += '</a>'; 
		  					  				
		  					funcion = 'Valid.changeStatus(\''+base_url+'patient/status/'+paciente.id+'\',\''+base_url+'\',\'patient\',\''+paciente.id+'\');';
		  					 		
		  					rowPaciente += '<img id="patient_'+paciente.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowPaciente += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+paciente.id+'" width="25" height="25" style="display:none">';
		  				 
		  				}else{

		  				    	rowPaciente += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  				}
		  						  			  				    
	 	  				if(paciente.eliminar){

	 	  					if(paciente.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'patient/eliminar/'+paciente.id+'\',\'patient\',\''+paciente.id+'\');';
	 		
		  					rowPaciente += '<img id="patient_delete_'+paciente.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowPaciente += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+paciente.id+'" width="25" height="25" style="display:none">';
		  				 	}
	 	  				}
	 	  				rowPaciente += '</td>';
		  			}else{
		  				rowPaciente += '<td align="center">'; 
						rowPaciente += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
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
