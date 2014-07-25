<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Email</th>
				<th>Teléfono 1</th>
				<th>Teléfono 2</th>
				<th id="thAcciones" style="display:none" align="center">Acciones</th>
			</tr>
		</thead>
		<tbody id= "tbodyconsultorio">

		</tbody>
		<tfoot id= "tfootconsultorio">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
	
		<a id="agregar" class="abutton" onclick = "$('.screenLoad').show();" href="<?= base_url('employees/agregar') ?>">Agregar</a>
	
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
            source: base_url + "surgery_admin/lista_all",
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

	jQuery('#tbodyconsultorio').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"surgery_admin/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,cosultorio){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowConsultorio  = '<tr class="'+classRow+'" id="tr_consultorio_'+cosultorio.id+'" >';
		  			rowConsultorio	+= '<td>'+cosultorio.nombre+'</td>';
		  			rowConsultorio	+= '<td>'+cosultorio.email+'</td>';
		  			rowConsultorio	+= '<td>'+cosultorio.telefono1+'</td>';
		  			rowConsultorio	+= '<td>'+cosultorio.telefono2+'</td>';

		  			jQuery('#thAcciones').show();

		  			if(cosultorio.estatus == 1){
		  					
		  				activo  ='active';
		  						
		  			}else{
		  					
		  				activo ='inactive';
		  				 					
		  			}

		  			rowConsultorio +=  '<td>'; 

		  				
		  					rowConsultorio += '<a href="'+base_url+'surgery_admin/editar/'+cosultorio.id+'">'; 		
		  					rowConsultorio += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowConsultorio += '</a>'; 
		  				
		  				
		  					funcion = 'Valid.changeStatus(\''+base_url+'surgery_admin/status/'+cosultorio.id+'\',\''+base_url+'\',\'surgery_admin\',\''+cosultorio.id+'\');';
		  					 		
		  					rowConsultorio += '<img id="employees_'+cosultorio.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowConsultorio += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+cosultorio.id+'" width="25" height="25" style="display:none">';
		  				 
		  				      				    
	 	  				

	 	  					if(cosultorio.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'surgery_admin/eliminar/'+cosultorio.id+'\',\'surgery_admin\',\''+cosultorio.id+'\');';
	 		
		  					rowConsultorio += '<img id="surgery_admin_delete_'+cosultorio.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowConsultorio += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+cosultorio.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  				
	 	  				rowConsultorio += '</td>';

		  					  			

		  			rowConsultorio += '</tr>';

		  			
		  			jQuery('#tbodyconsultorio').append(rowConsultorio);
		  			jQuery('#tfootconsultorio').html("");

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

					jQuery('#tfootconsultorio').append(rowFoot);
				}

			}else {

	 			rowEmpleado = '<tr><td colspan="100%">No existen consultorios </td></tr>';
	 			jQuery('#tbodyconsultorio').append(rowEmpleado);
	 			jQuery('#tfootconsultorio').html("");

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