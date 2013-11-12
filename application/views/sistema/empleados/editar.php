<script>
	$(function(){ Valid.empleados(); });
</script>
<?php

	$aPermisos = unserialize (PERMISOS);
	$attributes = array('id' => 'empleadosForm');
     echo form_open(null,$attributes);
     if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}
	     echo '<table class="table_form">';
         echo'<tr>'; 
 	     echo'<td  width="100" valing="top">';
            echo form_label('Codigo:');
	 		echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo', $empleado->codigo),
		 		'style' => 'width:100px'
		 	);

            echo form_input($data);
		 	echo'</td>';
            echo '</tr>';


            echo'<tr>'; 
 	        echo'<td valing="top">';
		 	echo form_label('Nombre:');
		 	echo'<td  valing="top">';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre' , $empleado->nombre),
		 		'style' => 'width:100px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td>';
		 	echo form_label('Apellido Paterno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p', $empleado->apellido_p),
		 		'style' => 'width:100px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td valing="top">';
		 	echo form_label('Apellido Materno:');
		 	echo'<td  valing="top">';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m', $empleado->apellido_m),
		 		'style' => 'width:100px'
		 	);


		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

            echo'<td  width="100" valing="top">';
		 	echo form_label('Email:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email', $empleado->email),
		 		'style' => 'width:200px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

echo'<td  width="100" valing="top">';
		 	echo form_label('Teléfono:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono', $empleado->telefono)
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td  width="100" valing="top">';
		 	echo form_label('Celular:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular', $empleado->celular)
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

		 	echo'<tr>'; 
            	echo'<td valing="top">';
            			echo form_label('Tipo de empleado:');
            	echo'</td>';
      
		 	?>
             <td valing="top">
			 	<select name="tipo_empleado" id="tipo_empleado">
			 		<option value="0">Seleccione...</option>
			 		<?php foreach($tipoEmpleado as $tipo): ?>
					  <option value="<?= $tipo->id; ?>" 
					  	      <?= ($empleado->tipo_empleado_id == $tipo->id)?'selected':''; ?> >
					  	      <?= $tipo->nombre; ?></option>
					  	  
					<?php endforeach; ?>

			    </select>
			</td>
		 	<?php
			echo'</tr>';
		 	echo '<tr>';
	        echo '<td colspan="100%" class="hide" id="tdEspecialidadesLabel">';
			echo form_label('Especialidades:');
	        echo '</td>';
            echo '</tr>';

            
		 	$empleado->especialidad->get();

			foreach($empleado->especialidad->all as $empleado_especialidad){
             			$aChecked[$empleado_especialidad->id] = $empleado_especialidad->id;
             }

             if(!isset($aChecked))
             	$aChecked[0] = 0;

			echo '<tr>';
	        echo '<td colspan="100%" class="hide" id="tdEspecialidades">';
		 	foreach($especialidades as $especialidad){
		 		echo form_label($especialidad->nombre.':');

		 		$data = array(
		 			'name'  => 'especialidades[]',
		 			'id'    => 'especialidad_'.$especialidad->id,
		 			'value' => $especialidad->id,
		 			'checked' => (in_array($especialidad->id,$aChecked))?true:false
 		 			);

		 		echo form_checkbox($data);
		 		
		 	}

		 	echo'</td>';
		 	echo'</tr>';

            echo'<tr>';
		 	echo'<td colspan ="100%" >';
		 	echo form_label('Activar como usuario del sistema:');
		 	
		 	$data = array(
		 		'name'    => 'act_sistema',
		 		'id'      => 'act_sistema',
		 		'value'   => 1,
		 		'checked' => ($act_usuario)?"checked":"",
		 	);

		 	echo form_checkbox($data);
		 	echo'</td>';
		 	echo'</tr>';

			$usuario->modulo->get();

			foreach($usuario->modulo->all as $usuario_modulo){
             			$aChecked[$usuario_modulo->id] = $usuario_modulo->id;
             }

             if(!isset($aChecked))
             	$aChecked[0] = 0;

		 	foreach($modulos as $modulo){
		 		 echo'<tr class="hide trModulos" id="trModulos">';
		 	     echo'<td colspan=100%>';
		 		echo form_label($modulo->nombre.':');
		 		$data = array(
				 		'name'    => 'modulos[]',
				 		'id'      => $modulo->nombre,
				 		'value'   => $modulo->id,
				 		'checked' => (in_array($modulo->id,$aChecked))?true:false,		
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
             		 echo'<tr class="hide">';
		 	     echo'<td colspan="2" id="tdPermisos">';

		 		echo form_label('Agregar:');
		 		$data = array(
				 		'name'    => 'permisos_'.$modulo->id.'[]',
				 		'value'   => 4,
				 		'checked' => (in_array($printPermiso,$aPermisos['Agregar']))?true:false,		
		 		);

		 		echo form_checkbox($data);
		 		echo form_label('Editar:');
		 		$data = array(
				 		'name'    => 'permisos_'.$modulo->id.'[]',
				 		'value'   => 2,
				 		'checked' => (in_array($printPermiso,$aPermisos['Editar']))?true:false,		
		 		);

		 		echo form_checkbox($data);
		 	
		 		echo form_label('Eliminar:');
		 		$data = array(
				 		'name'    => 'permisos_'.$modulo->id.'[]',
				 		'value'   => 1,
				 		'checked' => (in_array($printPermiso,$aPermisos['Eliminar']))?true:false,		
		 		);

		 		echo form_checkbox($data);
                echo'</td>';
                echo'</tr>';

		 	}

            echo'<tr>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	echo form_submit($data);
            echo'</tr>';
		 	echo'</td>';

	 	echo form_close();
?>
<script>

$(function(){
	showEspecialidades();

	$("#tipo_empleado").change(function(){
			showEspecialidades();
	});

	$("#act_sistema").change(function(){
			showModulos();
	});

});

function showEspecialidades(){
	var tipo_empleado = $("#tipo_empleado").val();
		if(tipo_empleado == 1){
			$("#tdEspecialidadesLabel").show();
			$("#tdEspecialidades").show();
		} else {
			$("#tdEspecialidadesLabel").hide();
			$("#tdEspecialidades").hide();
		}
}

function showModulos(){
	
	var trModulos = $('.trModulos');
	$.each(trModulos , function (key, trModule){
		if($('#act_sistema').is(':checked') === true){
			$(trModule).show();
		} else {
			$(trModule).hide();
		}
	});
}

</script>
