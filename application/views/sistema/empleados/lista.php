<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid" >
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
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
	<?php if(isset($buscar)): ?>
		<a href="<?= base_url('employees') ?>" class="abutton_cancel">Cancelar</a>
	<?php endif; ?>

    <?php if(!isset($buscar)): ?>
		<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('employees/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a class="abutton" href="<?= base_url('employees/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>

<script>
base_url = "<?= base_url(); ?>";
page     = 1;

jQuery(function() {
      jQuery( "#buscar" ).autocomplete({
            source: base_url + "employees/lista",
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

	jQuery('#tbodyempleado').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
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