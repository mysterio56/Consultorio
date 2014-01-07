<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>

<section id="especialidad"class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="6">Código</th>
				<th width="auto">Nombre</th>
				<th width="auto">Fecha Alta</th>
					<?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
				<th width="6">Editar</th>
					<?php endif; ?>
				<th width="6">Activo</th>
					<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
				<th width="7">Eliminar</th>
			    	<?php endif;?>
			</tr>
		</thead>
		<tbody id= "tbodyspecialidad">

		</tbody>
		<tfoot id= "tfootspecialidad">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" onclick = "$('.screenLoad').show();" href="<?= base_url('specialism/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" onclick = "$('.screenLoad').show();" href="<?= base_url('specialism/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none  onclick = "$('.screenLoad').show();" href="<?= base_url('specialism') ?>" class="abutton">Cancelar</a>

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
            source: base_url + "specialism/lista",
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

	jQuery('#tbodyspecialidad').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"specialism/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,especialidad){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowEspecialidad  = '<tr class="'+classRow+'" id="tr_specialism_'+especialidad.id+'" >';
		  			rowEspecialidad	+= '<td>'+especialidad.codigo+'</td>';
		  			rowEspecialidad	+= '<td>'+especialidad.nombre+'</td>';
		  			rowEspecialidad	+= '<td>'+especialidad.fecha_alt+'</td>';


		  			if(especialidad.estatus == 1){
		  					
		  				activo  ='active';
		  						
		  			}else {
		  					
		  				activo ='inactive';
		  								  					
		  			}
		  			
		  			if(especialidad.editar||especialidad.eliminar){
		  				
		  				rowEspecialidad +=  '<td>'; 

		  				if(especialidad.editar){
		  					rowEspecialidad += '<a href="'+base_url+'specialism/editar/'+especialidad.id+'">'; 		
		  					rowEspecialidad += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowEspecialidad += '</a>'; 
		  			
		  				rowEspecialidad +=  '<td>';

		  					funcion = 'Valid.changeStatus(\''+base_url+'specialism/status/'+especialidad.id+'\',\''+base_url+'\',\'specialism\',\''+especialidad.id+'\');';
		  					 		
		  					rowEspecialidad += '<img id="specialism_'+especialidad.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowEspecialidad += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+especialidad.id+'" width="25" height="25" style="display:none">';
		  				 
		  				    }else{
		  				    	rowEspecialidad += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  				    }
		  						  			  				    
	 	  				
	 	  				if(especialidad.eliminar){
	 	  					rowEspecialidad +=  '<td>'; 

	 	  					if(especialidad.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'specialism/eliminar/'+especialidad.id+'\',\'specialism\',\''+especialidad.id+'\');';
	 		
		  					rowEspecialidad += '<img id="specialism_delete_'+especialidad.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowEspecialidad += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+especialidad.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  				   rowEspecialidad += '</td>';
	 	  				}
 	  				
		  			}else{
						rowEspecialidad += '<td align="center">'; 
						rowEspecialidad += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
						rowEspecialidad += '</td>';
					}

		  			rowEspecialidad += '</tr>';

		  			
		  			jQuery('#tbodyspecialidad').append(rowEspecialidad);
		  			jQuery('#tfootspecialidad').html("");

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

					jQuery('#tfootspecialidad').append(rowFoot);
				}

			}else {

	 			rowEspecialidad = '<tr><td colspan="100%">No existen especialidades </td></tr>';
	 			jQuery('#tbodyspecialidad').append(rowEspecialidad);
	 			jQuery('#tfootspecialidad').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>





		 