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
				<?php endif; ?>	
				</tr>
		</thead>
		<tbody id= "tbodyproducto">

		</tbody>
		<tfoot id= "tfootproducto">
			
		</tfoot>	
		</table>
		<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>
</section>
<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a id="agregar" class="abutton" href="<?= base_url('product/agregar') ?>">Agregar</a>
	<?php endif; ?>
		<a id="busavan" class="abutton" href="<?= base_url('product/buscar') ?>">Búsqueda Avanzada</a>
		<a id="cancela" display:none href="<?= base_url('product') ?>" class="abutton">Cancelar</a>
   


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
            source: base_url + "product/lista",
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

	jQuery('#tbodyproducto').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"product/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,producto){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowproducto  = '<tr class="'+classRow+'" id="tr_product_'+producto.id+'" >';
		  			rowproducto	+= '<td>'+producto.codigo+'</td>';
		  			rowproducto	+= '<td>'+producto.nombre+'</td>';
		  			rowproducto	+= '<td>'+producto.fecha_alt+'</td>';

		  			if(producto.estatus == 1){
		  					
		  						activo  ='active';
		  						
		  					}else {
		  					
		  						activo ='inactive';
		  					}
		  			
		  			if(producto.editar||producto.eliminar){
		  				
		  				rowproducto +=  '<td align="center">'; 

		  				if(producto.editar){
		  					rowproducto += '<a href="'+base_url+'product/editar/'+producto.id+'">'; 		
		  					rowproducto += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowproducto += '</a>'; 
		  				
		  				rowproducto +=  '<td align="center">';

		  					funcion = 'Valid.changeStatus(\''+base_url+'product/status/'+producto.id+'\',\''+base_url+'\',\'product\',\''+producto.id+'\');';
		  					 		
		  					rowproducto += '<img id="product_'+producto.id+'" onclick="'+funcion+'" src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowproducto += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+producto.id+'" width="25" height="25" style="display:none">';
		  				 
		  				    }else{
		  				    	rowproducto += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  				    }
		  				    		  						  			  				    
	 	  			 

	 	  				if(producto.eliminar){

	 	  					rowproducto +=  '<td align="center">';

	 	  					if(producto.estatus!=2){
                       
		  					funcion_delete = 'Valid.eliminaregistro(\''+base_url+'product/eliminar/'+producto.id+'\',\'product\',\''+producto.id+'\');';
	 		
		  					rowproducto += '<img id="product_delete_'+producto.id+'"  onclick="'+funcion_delete+'" src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowproducto += '<img src="'+base_url+'assets/images/wait.gif" id="wait_delete_'+producto.id+'" width="25" height="25" style="display:none">';
		  				 
	 	  					}
	 	  				   rowproducto += '</td>';
	 	  				}
	 	  				
		  			}else{
							rowproducto += '<td align="center">'; 
							rowproducto += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
							rowproducto += '</td>';
					}

		  			rowproducto += '</tr>';

		  			
		  			jQuery('#tbodyproducto').append(rowproducto);
		  			jQuery('#tfootproducto').html("");

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

					jQuery('#tfootproducto').append(rowFoot);
				}

			}else {

	 			rowproducto = '<tr><td colspan="100%">No existen productos </td></tr>';
	 			jQuery('#tbodyproducto').append(rowproducto);
	 			jQuery('#tfootproducto').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}
</script>