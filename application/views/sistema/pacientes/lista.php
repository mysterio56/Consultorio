<?php $aPermisos = unserialize (PERMISOS); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="40">Código</th>
				<th width="auto">Nombre</th>
				<th width="auto">Email</th>
				<th width="40">Teléfono</th>
				<th width="40">Celular</th>
				<th width="30" id="thAcciones" style="display:none" align="center">Acciones</th>
			
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
	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" href="<?= base_url('patient/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" href="<?= base_url('patient/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none href="<?= base_url('patient') ?>" class="abutton">Cancelar</a>
   


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
		  			rowPaciente	+= '<td>'+paciente.codigo+'</td>';
		  			rowPaciente	+= '<td>'+paciente.nombre+'</td>';
		  			rowPaciente	+= '<td>'+paciente.email+'</td>';
		  			rowPaciente	+= '<td>'+paciente.telefono+'</td>';
		  			rowPaciente	+= '<td>'+paciente.celular+'</td>';
		  					  			
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
			