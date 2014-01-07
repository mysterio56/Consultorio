<script>
	$(function(){ Valid.especialidad(); });
</script>
<?php
	$attributes = array('id' => 'especialidadesForm');
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
		 	'value' => set_value('codigo',$especialidad->codigo),
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
		 		'value' => set_value('nombre',$especialidad->nombre),
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
		 		'value' => set_value('descripcion',$especialidad->descripcion),
		 		'style' => 'width:200px;height:50px'
		 	);
   echo form_textarea($data);

   echo'</table>'; 

		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Actualizar'
		 	);

		 	echo form_submit($data);
		 	echo '<a href="'.base_url($return).'" onclick = "$(\'.screenLoad\').show();" class="abutton_cancel">Cancelar</a>';
	 		echo form_close();
?>

  </form>
</div> 
</table>

<script>
$(function () {

	$( "#especialidadesForm" ).submit(function( event ) {
		if($('#especialidadesForm').valid()){
  			$('.screenLoad').show();
  		}
	});
	
});
</script>
