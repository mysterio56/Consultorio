<?php $aPermisos = unserialize (PERMISOS); ?>
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
		 	'value' => set_value('codigo',$tipoEmpleado->codigo),
		 	'style' => 'width:80px'
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
		 		'value' => set_value('descripcion',$tipoEmpleado->descripcion),
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
		 		'value' => set_value('nombre',$tipoEmpleado->nombre),
		 		'style' => 'width:125px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>';

   echo '<tr>';
	   echo '<td colspan="2" class="standOut">';
	   			echo form_label('Modulos y permisos:');
	   echo '</td>';
   echo '</tr>';

			$tipoEmpleado->modulo->get();

			foreach($tipoEmpleado->modulo->all as $tipo_empleado_modulo){
             			$aChecked[$tipo_empleado_modulo->id] = $tipo_empleado_modulo->id;
             }

             $aCheckedSub = array();

             foreach($oSubmodulos as $tipo_empleado_submodulo){
             			$aCheckedSub[$tipo_empleado_submodulo->id] = $tipo_empleado_submodulo->id;
             }
             
             if(!isset($aChecked))
             	$aChecked[0] = 0;

		 	foreach($modulos as $modulo){
		 		 echo'<tr>';
		 	     echo'<td colspan=100%>';
		 		echo form_label($modulo->nombre.':');
		 		$data = array(
				 		'name'     => 'modulos[]',
				 		'id'       => 'modulo_' + $modulo->id,
				 		'value'    => $modulo->id,
				 		'class'    => 'checkModulos',
				 		'checked'  => (in_array($modulo->id,$aChecked))?true:false,
				 		'onChange' => "showPermisos('".$modulo->id."', this.checked)"	
		 		);

		 		echo form_checkbox($data);
                echo'</td>';
		 	    echo'</tr>';
		 		$printPermiso = 0;

		 		foreach($permisos as $permiso){
		 			if($modulo->id == $permiso->modulo_id){
		 				$printPermiso = $permiso->permiso;
		 			}
		 		}
             		 echo'<tr class="hide trPermiso" id="trPermisos_'.$modulo->id.'">';
		 	     echo'<td colspan="2" class="standOut">';

			 	if($modulo->nombre != 'Consultorio'){
			 		echo form_label('Agregar:');
			 		$data = array(
					 		'name'    => 'permisos_'.$modulo->id.'[]',
					 		'value'   => 4,
					 		'checked' => (in_array($printPermiso,$aPermisos['Agregar']))?true:false,		
			 		);

			 		echo form_checkbox($data);
		 		}
		 		echo form_label('Editar:');
		 		$data = array(
				 		'name'    => 'permisos_'.$modulo->id.'[]',
				 		'value'   => 2,
				 		'checked' => (in_array($printPermiso,$aPermisos['Editar']))?true:false,		
		 		);

		 		echo form_checkbox($data);
		 	
			 	if($modulo->nombre != 'Consultorio'){
			 		echo form_label('Eliminar:');
			 		$data = array(
					 		'name'    => 'permisos_'.$modulo->id.'[]',
					 		'value'   => 1,
					 		'checked' => (in_array($printPermiso,$aPermisos['Eliminar']))?true:false,		
			 		);

			 		echo form_checkbox($data);

			 		$submodulos = $modulo->submodulo->get();
			 		
			 		foreach($submodulos as $submodulo){

			 			echo form_label($submodulo->nombre);

			 			$data = array(
					 		'name'    => 'submodulos_'.$modulo->id.'[]',
					 		'value'   => $submodulo->id,
					 		'checked' => (in_array($submodulo->id,$aCheckedSub))?true:false 		
			 			);
		 				
		 				echo form_checkbox($data);

		 			}	
			 	}

                echo'</td>';
                echo'</tr>';

		 	}


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
