<script>

	$(function(){ Valid.producto(); 
		$('.auto').autoNumeric('init');
	});
</script>
	<?php
        $attributes = array('id' => 'productoForm');
        
	 	echo form_open(null,$attributes);

	echo '<table class="table_form">';
	echo'<tr>'; 
	echo form_label('*Campos Requeridos','campo');
 	echo'<td  width="100" valing="top">'; 
	 		echo form_label('*Código:');
	 echo'</td>';
     echo'<td>';
		 	$data = array(
             'name'  => 'codigo',
		 	 'id'    => 'codigo',
		 	'value' => set_value('codigo',$producto->codigo),
		 	'style' => 'width:200px'
		 	);
		 	 
             echo form_input($data);
      echo'</td>';
      echo '</tr>';
 		 
	echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('*Nombre:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre',$producto->nombre),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>';

    echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('Descripcion:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'descripcion',
		 		'id'    => 'descripcion',
		 		'value' => set_value('descripcion',$producto->descripcion),
		 		'style' => 'width:200px;height:50px'
		 	);
   echo form_textarea($data);
   echo'</td>';
   echo '</tr>'; 

   echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('*Costo Compra:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_c',
		 		'id'    => 'costo_c',
		 		'class' => 'auto',
		 		'value' => set_value('costo_c',$producto->costo_compra),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 

echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('*Costo Venta:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_v',
		 		'id'    => 'costo_v',
		 		'class' => 'auto',
		 		'value' => set_value('costo_v',$producto->costo_venta),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 
   echo'</table>'; 

		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Actualizar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close();
?>

  </form>
</div> 
</table>
