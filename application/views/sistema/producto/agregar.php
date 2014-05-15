<script>
     $(function(){ Valid.producto();
     	$('.auto').autoNumeric('init');
     });
</script>
	<?php
        $attributes = array('id' =>'productoForm');
	 	echo form_open(null,$attributes);

	echo '<table class="table_form">';
	echo'<tr>'; 
	echo form_label('*Campos Requeridos','campo');
 	echo'<td>'; 
	 		echo form_label('*Código:');
	 echo'</td>';
     echo'<td>';
		 	$data = array(
             'name'  => 'codigo',
		 	 'id'    => 'codigo',
		 	'value' => set_value('codigo',$nCodigo),
		 	//'style' => 'width:200px'
		 	);
		 	 
             echo form_input($data);
      echo'</td>';
      echo '</tr>';
 		 
	echo'<tr>'; 
 	echo'<td>'; 
		 	echo form_label('*Nombre:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		//'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>';

   echo'<tr>'; 
 	echo'<td>'; 
		 	echo form_label('Descripcion:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'descripcion',
		 		'id'    => 'descripcion',
		 		'value' => set_value('descripcion'),
		 		//'style' => 'width:200px;height:50px'
		 	);
   echo form_textarea($data);
   echo'</td>';
   echo '</tr>';


   echo'<tr>'; 
 	echo'<td>'; 

		 	echo form_label('*Costo Compra:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_c',
		 		'id'    => 'costo_c',
		 		'class' => 'auto',
		 		'value' => set_value('costo_c'),
		 		//'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 


  echo'<tr>'; 
 	echo'<td>'; 
		 	echo form_label('Costo Venta:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_v',
		 		'id'    => 'costo_v',
		 		'class' => 'auto',
		 		'value' => set_value('costo_v'),
		 		//'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 

   echo'</table>'; 

		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'" onclick = "$(\'.screenLoad\').show();" class="abutton_cancel">Cancelar</a>';
			echo form_close();
?>

  </form>
</div> 
</table>

<script>
$(function(){
	
	$( "#productoForm" ).submit(function( event ) {
		if($('#productoForm').valid()){
  			$('.screenLoad').show();
  		}
	});

	$('.screenLoad').hide();

});
</script>