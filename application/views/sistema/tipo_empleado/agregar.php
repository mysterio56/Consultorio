<script>

	$(function(){ Valid.tipoEmpleado(); });
</script>
	<?php
        $attributes = array('id' => 'tipoEmpleadoForm');
	 	echo form_open(null,$attributes);

	echo '<table class="table_form">';
	echo'<tr>'; 
	echo form_label('*Campos Requeridos','campo');
 	echo'<td  width="100" valing="top">'; 
	 		echo form_label('*Codigo:');
	 echo'</td>';
     echo'<td>';
		 	$data = array(
             'name'  => 'codigo',
		 	 'id'    => 'codigo',
		 	'value' => set_value('codigo',$nCodigo),
		 	'style' => 'width:200px'
		 	);
		 	 
             echo form_input($data);
      echo'</td>';

      echo'<td  width="100" valing="top">'; 
		 	echo form_label('Descripcion:'); 
		 	echo'</td>';
            echo'<td rowspan="2">';
		 	$data = array(
		 		'name'  => 'descripcion',
		 		'id'    => 'descripcion',
		 		'value' => set_value('descripcion'),
		 		'style' => 'width:200px;height:50px'
		 	);
   echo form_textarea($data);
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
		 		'value' => set_value('nombre'),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>';

   echo '<tr>';
	   echo '<td colspan="2" class="standOut">';
	   			echo form_label('Modulos y permisos:');
	   echo '</td>';
   echo '</tr>';

		 	foreach($modulos as $modulo){

		 		 echo'<tr>';
		 	     echo'<td colspan=100%>';
		 		echo form_label($modulo->nombre.':');
		 		$data = array(
				 		'name'     => 'modulos[]',
				 		'id'       => 'modulo_' + $modulo->id,
				 		'value'    => $modulo->id,
				 		'class'    => 'checkModulos',
				 		'onChange' => "showPermisos('".$modulo->id."', this.checked)"	
		 		);

		 		echo form_checkbox($data);
                echo'</td>';
		 	    echo'</tr>';

	
             	 echo'<tr class="hide trPermiso" id="trPermisos_'.$modulo->id.'">';
		 	     echo'<td colspan="2" class="standOut">';

			 	if($modulo->nombre != 'Consultorio'){
			 		echo form_label('Agregar:');
			 		$data = array(
					 		'name'    => 'permisos_'.$modulo->id.'[]',
					 		'value'   => 4,
					 		'checked' => true	
			 		);

			 		echo form_checkbox($data);
		 		}
		 		echo form_label('Editar:');
		 		$data = array(
				 		'name'    => 'permisos_'.$modulo->id.'[]',
				 		'value'   => 2,
				 		'checked' => true		
		 		);

		 		echo form_checkbox($data);
		 	
			 	if($modulo->nombre != 'Consultorio'){
			 		echo form_label('Eliminar:');
			 		$data = array(
					 		'name'    => 'permisos_'.$modulo->id.'[]',
					 		'value'   => 1,
					 		'checked' => true		
			 		);

			 		echo form_checkbox($data);

			 		$submodulos = $modulo->submodulo->get();
			 		
			 		foreach($submodulos as $submodulo){

			 			echo form_label($submodulo->nombre);

			 			$data = array(
					 		'name'    => 'submodulos_'.$modulo->id.'[]',
					 		'value'   => $submodulo->id,
					 		'checked' => true		
			 			);
		 				
		 				echo form_checkbox($data);

		 			}	
			 	}

                echo'</td>';
                echo'</tr>';

		 	}

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

</table>

<script>

$(function(){
	$.each($(".checkModulos"), function(key, check){
		if($(check).is(":checked")){
			showPermisos($(check).val(),true);
		}
	});

	$( "#tipoEmpleadoForm" ).submit(function( event ) {
		if($('#tipoEmpleadoForm').valid()){
  			$('.screenLoad').show();
  		}
	});

	$('.screenLoad').hide();

});

function showPermisos(id_modulo, checked){

	var trPermisos  = $('#trPermisos_' + id_modulo);
	var moduloCheck = $('#modulo_'+id_modulo);

		$.each(trPermisos , function (key, trPermiso){
			if(checked === true){
				$(trPermiso).show();
			} else {
				$(trPermiso).hide();
			}
		});
}

</script>
