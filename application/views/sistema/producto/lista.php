<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th align="center">Código</th>
				<th align="center">Nombre</th>
				<th align="center">Fecha Alta</th>
				<?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
					<th align="center">Editar</th>
				<?php endif; ?>
				<th align="center">Activo</th>
				<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
					<th align="center">Eliminar</th>
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
<?php if(isset($buscar)): ?>
	<a href="<?= base_url('format') ?>" class="abutton_cancel">Cancelar</a>
	<?php endif; ?>
	
	<?php if(!isset($buscar)): ?>
	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('format/agregar') ?>">Agregar</a>
	<?php endif; ?>
	<a class="abutton" href="<?= base_url('format/buscar') ?>">Búsqueda Avanzada</a>
    <?php endif;?>
<script>

base_url = "<?= base_url(); ?>";
page     = 1;

jQuery(function() {

      jQuery( "#buscar" ).autocomplete({
            source: base_url + "product/lista_add",
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

	jQuery('#tbodyproducto').html("");
	jQuery('#wait_grid').show();

	var form_data = jQuery('#busquedaForm').serialize();
	jQuery.post( base_url+"product/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,producto){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowproducto  = '<tr class="'+classRow+'">';
		  			rowproducto	+= '<td align="center">'+producto.codigo+'</td>';
		  			rowproducto	+= '<td align="center">'+producto.nombre+'</td>';
		  			rowproducto	+= '<td align="center">'+producto.fecha_alt+'</td>';
		  			
		  			if(producto.editar||producto.activar||producto.eliminar){
		  				
		  				rowproducto +=  '<td align="center">'; 

		  				if(producto.editar){
		  					rowproducto += '<a href="'+base_url+'product/editar/'+producto.id+'">'; 		
		  					rowproducto += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
		  					rowproducto += '</a>'; 
		  				}
		  				rowproducto +=  '<td align="center">';

		  				if(producto.activar){	
		  				
		  					if(producto.estatus == 1){
		  					
		  						activo  ='active';
		  						funcion ='if(Valid.desactivaregistro()==false)return false';
		  				
		  					}else if(producto.estatus == 0){
		  					
		  						activo ='inactive';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  				
		  					}else if(producto.estatus == 2){
		  					
		  						activo ='active';
		  						funcion='if(Valid.activaregistro()==false)return false';
		  					
		  					}
		  					
		  					rowproducto += '<a onclick="'+funcion+'" href="'+base_url+'product/status/'+producto.id+'">'; 		
		  					rowproducto += '<img src="'+base_url+'assets/images/'+activo+'.png'+'"style="width:25px;height:25px;" />';
		  					rowproducto += '</a>'; 
		  				    }
		  						  			  				    
	 	  				rowproducto +=  '<td align="center">'; 

	 	  				if(producto.eliminar){

	 	  					if(producto.estatus!=2){
                       
		  					rowproducto += '<a onclick="if(Valid.eliminaregistro() ==false)return false" href="'+base_url+'product/eliminar/'+producto.id+'">'; 		
		  					rowproducto += '<img src="'+base_url+'assets/images/delete.png" style="width:25px;height:25px;" />';
		  					rowproducto += '</a>'; 
	 	  					}
	 	  				}


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