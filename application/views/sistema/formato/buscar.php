<?php $aPermisos = unserialize (PERMISOS); ?>
<script>
	$(function(){ Find.fecha_alta_value(); });
</script>
<?php
	$attributes = array('id' => 'formatoForm');
		
	 	echo form_open(null,$attributes);

	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo'<td  width="100" valing="top">'; 
	 		echo form_label('Codigo:');
	    echo'</td>';
	    echo'<td>';
		 	$data = array(
		 		'name'  => 'Codigo',
		 		'id'    => 'Codigo',
		 		'value' => set_value('Codigo'),
		 		'style' => 'width:125px'
		 	);
		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

             echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Nombre:');
            echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'Nombre',
		 		'id'    => 'Nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('Nombre'),
		 		'style' => 'width:125px'
		 	);

		 	echo form_input($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Activo');	
 	        echo '<td>';
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 1,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);

		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Inactivo');
 	        echo '<td>';	
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 0,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="50" valing="top">'; 
 	        echo form_label('Eliminado');
 	        echo '<td>';	
		 	$data = array(
		 		'name'  => 'estatus[]',
		 		'id'    => 'estatus',
		 		'class' => 'capitalize',
		 		'value' => 2,
		 		'style' => 'width:125px'
		 	);
		 	echo form_checkbox($data);
		 	echo '</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Fecha de alta:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'fecha_alta_value',
		 		'id'    => 'fecha_alta_value',
		 		'value' => set_value('fecha_alta_value'),
		 		'style' => 'width:125px'
		 	);
		 	echo '<div>';
		 	echo form_input($data);
		 	echo '</div>';
		 	echo '</td>';
            echo '</tr>';
			
			?>

			<input type="hidden" name="fecha_alta" id="fecha_alta" />
			</table>
			<a name='Buscar' id='Buscar' class="abutton" onclick= "grid();" value='Buscar'> Buscar</a>

			<?php
			
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close(); 
?>
<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th width="100" align="center">Código</th>
				<th width="100" align="center">Nombre</th>
				<th width="100" align="center">Fecha Alta</th>
			    <?php if(in_array($permisos,$aPermisos['Editar']) ): ?>
					<th width="100" align="center">Editar</th>
				<?php endif; ?>
				<th width="100" align="center">Activo</th>
				<?php if(in_array($permisos,$aPermisos['Eliminar']) ): ?>
				<th width="100" align="center">Eliminar</th>
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
<script>

base_url = "<?= base_url(); ?>";
page =1;

function grid(){

	jQuery('#tbodyformato').html("");
	jQuery('#wait_grid').show();
	

	var form_data = jQuery('#formatoForm').serialize();
	jQuery.post( base_url+"format/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,formato){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowformato  = '<tr class="'+classRow+'">';
		  			rowformato	+= '<td align="center">'+formato.codigo+'</td>';
		  			rowformato	+= '<td align="center">'+formato.nombre+'</td>';
		  			rowformato	+= '<td align="center">'+formato.fecha_alt+'</td>';
		  			
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