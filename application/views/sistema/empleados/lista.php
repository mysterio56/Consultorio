<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Teléfono</th>
				<th>Celular</th>
				<th id="thAcciones" style="display:none" align="center">Acciones</th>
			</tr>
		</thead>
		<tbody id= "tbodyempleado">

		</tbody>
		<tfoot id= "tfootempleado">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" onclick = "$('.screenLoad').show();" href="<?= base_url('employees/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" onclick = "$('.screenLoad').show();" href="<?= base_url('employees/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none onclick = "$('.screenLoad').show();" href="<?= base_url('employees') ?>" class="abutton">Cancelar</a>
<script>
base_url = "<?= base_url(); ?>";
page     = 1;

jQuery(function() {


	$('#cancela').hide(); 

	$("#busqueda").click(function(){
		if($("#buscar").val() != "" ){
            $('#agregar').hide(); //oculto mediante id
            $('#busavan').hide(); //muestro mediante clase
            $('#cancela').show(); 
           }
        });
      jQuery( "#buscar" ).autocomplete({
            source: base_url + "employees/lista",
            minLength: 1,
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

	jQuery('#tbodyempleado').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
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
		  					  			
		  			if(empleado.editar||empleado.activar||empleado.eliminar){
		  				
		  				rowEmpleado +=  '<td>'; 

		  				if(empleado.editar){
		  					rowEmpleado += '<a href="'+base_url+'employees/editar/'+empleado.id+'">'; 		
		  					rowEmpleado += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowEmpleado += '</a>'; 
		  				
		  				
		  					funcion = 'Valid.changeStatus(\''+base_url+'employees/status/'+empleado.id+'\',\''+base_url+'\',\'employees\',\''+empleado.id+'\');';
		  					 		
		  					rowEmpleado += '<img id="employees_'+empleado.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowEmpleado += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+empleado.id+'" width="25" height="25" style="display:none">';
		  				 
		  				    }else{
		  				    	rowEmpleado += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
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
	 		$('.screenLoad').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>