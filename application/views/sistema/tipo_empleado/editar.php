<script>

	$(function(){ Valid.tipoEmpleado(); });
</script>
	<?php
        $attributes = array('id' => 'tipoEmpleadosForm');
	 	echo form_open(null,$attributes);

	echo '<table class="table_form">';
	echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
	 		echo form_label('Codigo:');
	 echo'</td>';
     echo'<td>';
		 	$data = array(
             'name'  => 'codigo',
		 	 'id'    => 'codigo',
		 	'value' => set_value('codigo',$tipoEmpleado->codigo),
		 	'style' => 'width:80px'
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
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre',$tipoEmpleado->nombre),
		 		'style' => 'width:125px'
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
