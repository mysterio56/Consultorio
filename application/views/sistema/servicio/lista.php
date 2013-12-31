<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="5">Código</th>
				<th width="auto">Nombre</th>
				<th width="auto">Fecha Alta</th>
			<?php if(in_array($permisos,$aPermisos['Editar'])): ?>
					<th width="6">Editar</th>
				<?php endif; ?>
				<th width="6">Activo</th>
				<?php if(in_array($permisos,$aPermisos['Eliminar'])):?>
				<th width="6">Eliminar</th>
				<?php endif;?>
			</tr>
		</thead>
		<tbody id= "tbodyservicio">

		</tbody>
		<tfoot id= "tfootservicio">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>
<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" href="<?= base_url('service/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" href="<?= base_url('service/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none href="<?= base_url('service') ?>" class="abutton">Cancelar</a>
	

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
            source: base_url + "service/lista",
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

	jQuery('#tbodyservicio').html("");
	jQuery('#wait_grid').show();
	
	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"service/grid/"+page, form_data , 
	 
		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,servicio){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowservicio  = '<tr class="'+classRow+'" id="tr_service_'+servicio.id+'" >';
		  			rowservicio	+= '<td>'+servicio.codigo+'</td>';
		  			rowservicio	+= '<td>'+servicio.nombre+'</td>';
		  			rowservicio	+= '<td>'+servicio.fecha_alt+'</td>';

		  			if(servicio.estatus == 1){
		  					
		  						activo  ='active';
		  						
		  					}else{
		  					
		  						activo ='inactive';
		  				
		  					}

		  			if(servicio.editar||servicio.eliminar){
		  				
		  				rowservicio +=  '<td align="center">'; 

		  				if(servicio.editar){
		  					rowservicio += '<a href="'+base_url+'service/editar/'+servicio.id+'">'; 		
		  					rowservicio += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowservicio += '</a>'; 
		  				

		  				rowservicio +=  '<td align="center">';

		  					funcion = 'Valid.changeStatus(\''+base_url+'service/status/'+servicio.id+'\',\''+base_url+'\',\'service\',\''+servicio.id+'\');';
		  					 		
		  					rowservicio += '<img id="service_'+servicio.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowservicio += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+servicio.id+'" width="25" height="25" style="display:none">';
		  				 
		  				    }else{

		  				rowservicio += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  				
		  			}		  						  			  				    
	 	  				

	 	  				if(servicio.eliminar){
	 	  					rowservicio +=  '<td align="center">'; 
	 	  					
	 	  					if(servicio.estatus!=2){
                       		
                       		funcion_delete = 'Valid.eliminaregistro(\''+base_url+'service/eliminar/'+servicio.id+'\',\'service\',\''+servicio.id+'\');';
	 		
		  					rowservicio += '<img id="service_delete_'+servicio.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowservicio += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+servicio.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  					rowservicio += '</td>';
	 	  				}
	 	  			}else{
	 	  				rowservicio += '<td align="center">'; 
	 	  				rowservicio += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
	 	  				rowservicio += '</td>';
	 	  			}
	 	  			
		  			rowservicio += '</tr>';

		  			
		  			jQuery('#tbodyservicio').append(rowservicio);
		  			jQuery('#tfootservicio').html("");

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

					jQuery('#tfootservicio').append(rowFoot);
				}

			}else {

	 			rowservicio = '<tr><td colspan="100%">No se encuantra lo que Busca </td></tr>';
	 			jQuery('#tbodyservicio').append(rowservicio);
	 			jQuery('#tfootservicio').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}


</script>