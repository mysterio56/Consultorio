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
		 	'style' => 'width:80px'
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
		 		'style' => 'width:125px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 

   echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('*Costo:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo',
		 		'id'    => 'costo',
		 		'class' => 'auto',
		 		'value' => set_value('costo',$producto->costo),
		 		'style' => 'width:125px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 

   echo'<tr>'; 
   echo'<td colspan= 1>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	echo form_submit($data);
		 	echo'</td>';
		 	echo '</tr>'; 
	 	echo form_close();
?>

  </form>
</div> 
</table>
