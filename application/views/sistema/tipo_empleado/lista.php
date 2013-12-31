<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="5">Código</th>
				<th width="auto">Nombre</th>
				<th width="auto">Fecha Alta</th>
					<?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
				<th width="6">Editar</th>
					<?php endif; ?>
				<th width="6">Activo</th>
					<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
				<th width="6">Eliminar</th>
			    	<?php endif;?>
			</tr>
		</thead>
		<tbody id= "tbodytipoempleado">

		</tbody>
		<tfoot id= "tfoottipoempleado">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
	
		<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" href="<?= base_url('type_employee/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" href="<?= base_url('type_employee/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none href="<?= base_url('type_employee') ?>" class="abutton_cancel">Cancelar</a>
   


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
            source: base_url + "type_employee/lista_add",
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

	jQuery('#tbodytipoempleado').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"type_employee/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,tipoempleado){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowtipoempleado  = '<tr class="'+classRow+'" id="tr_type_employee_'+tipoempleado.id+'" >';
		  			rowtipoempleado	+= '<td>'+tipoempleado.codigo+'</td>';
		  			rowtipoempleado	+= '<td>'+tipoempleado.nombre+'</td>';
		  			rowtipoempleado	+= '<td>'+tipoempleado.fecha_alt+'</td>';

		  			if(tipoempleado.estatus == 1){
		  					
		  						activo  ='active';
		  					}else{
		  					
		  						activo ='inactive';
		  					}
		  			
		  			if(tipoempleado.editar||tipoempleado.eliminar){
		  				
		  				rowtipoempleado +=  '<td align="center">'; 

		  				if(tipoempleado.editar){
		  					rowtipoempleado += '<a href="'+base_url+'type_employee/editar/'+tipoempleado.id+'">'; 		
		  					rowtipoempleado += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowtipoempleado += '</a>'; 
		  				
		  				rowtipoempleado +=  '<td align="center">';

		  					funcion = 'Valid.changeStatus(\''+base_url+'type_employee/status/'+tipoempleado.id+'\',\''+base_url+'\',\'type_employee\',\''+tipoempleado.id+'\');';
		  					 		
		  					rowtipoempleado += '<img id="type_employee_'+tipoempleado.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowtipoempleado += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+tipoempleado.id+'" width="25" height="25" style="display:none">';
		  				 
		  				    }else{
		  				    	rowtipoempleado += rowPaciente += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  				    }
		  						  			  				    
	 	  				
	 	  				if(tipoempleado.eliminar){

	 	  				rowtipoempleado +=  '<td align="center">'; 

	 	  					if(tipoempleado.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'type_employee/eliminar/'+tipoempleado.id+'\',\'type_employee\',\''+tipoempleado.id+'\');';
	 		
		  					rowtipoempleado += '<img id="type_employee_delete_'+tipoempleado.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowtipoempleado += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+tipoempleado.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  				rowtipoempleado += '</td>';
	 	  				}
	 	  			}

		  			rowtipoempleado += '</tr>';

		  			
		  			jQuery('#tbodytipoempleado').append(rowtipoempleado);
		  			jQuery('#tfoottipoempleado').html("");

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

					jQuery('#tfoottipoempleado').append(rowFoot);
				}

			}else {

	 			rowtipoempleado = '<tr><td colspan="100%">No existen ningun tipo de empleado </td></tr>';
	 			jQuery('#tbodytipoempleado').append(rowtipoempleado);
	 			jQuery('#tfoottipoempleado').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>
