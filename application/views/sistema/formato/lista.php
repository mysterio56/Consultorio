<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>
<section class="datagrid">
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
				<th width="6">Eliminar</th>
				<?php endif;?>
			</tr>
		</thead>
		<tbody id= "tbodyformato">

		</tbody>
		<tfoot id= "tfootformato">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>
</section>
<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" href="<?= base_url('format/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" href="<?= base_url('format/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none href="<?= base_url('format') ?>" class="abutton">Cancelar</a>
   


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
            source: base_url + "format/lista",
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

	jQuery('#tbodyformato').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"format/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,formato){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowformato  = '<tr class="'+classRow+'">';
		  			rowformato	+= '<td>'+formato.codigo+'</td>';
		  			rowformato	+= '<td>'+formato.nombre+'</td>';
		  			rowformato	+= '<td>'+formato.fecha_alt+'</td>';
		  			
		  			if(formato.editar||formato.activar||formato.eliminar){
		  				
		  				rowformato +=  '<td align="center">'; 

		  				if(formato.editar){
		  					rowformato += '<a href="'+base_url+'format/editar/'+formato.id+'">'; 		
		  					rowformato += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowformato += '</a>'; 
		  				}
		  				rowformato +=  '<td align="center">';

		  				if(formato.activar){	
		  				
		  					if(formato.estatus == 1){
		  					
		  						activo  ='active';
		  						funcion ='if(Valid.desactivaregistro()==false)return false';
		  				
		  					}else if(formato.estatus == 0){
		  					
		  						activo ='inactive';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  				
		  					}else if(formato.estatus == 2){
		  					
		  						activo ='active';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  					
		  					}
		  					
		  					rowformato += '<a onclick="'+funcion+'" href="'+base_url+'format/status/'+formato.id+'">'; 		
		  					rowformato += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowformato += '</a>'; 
		  				    }
		  						  			  				    
	 	  				rowformato +=  '<td align="center">'; 

	 	  				if(formato.eliminar){

	 	  					if(formato.estatus!=2){
                       
		  					rowformato += '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'+base_url+'format/eliminar/'+formato.id+'">'; 		
		  					rowformato += '<img src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowformato += '</a>'; 
	 	  					}
	 	  				}


	 	  				rowformato += '</td>';
		  			}

		  			rowformato += '</tr>';

		  			
		  			jQuery('#tbodyformato').append(rowformato);
		  			jQuery('#tfootformato').html("");

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

					jQuery('#tfootformato').append(rowFoot);
				}

			}else {

	 			rowformato = '<tr><td colspan="100%">No existen formatos </td></tr>';
	 			jQuery('#tbodyformato').append(rowformato);
	 			jQuery('#tfootformato').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>