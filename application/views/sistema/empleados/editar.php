<script>
	$(function(){ Valid.empleados(); });
</script>
<?php

	$aPermisos = unserialize (PERMISOS);
	$attributes = array('id' => 'empleadosForm');
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
		 		'value' => set_value('codigo', $empleado->codigo),
		 		//'style' => 'width:100px'
		 	);

            echo form_input($data);
		 	echo'</td>';
            echo '</tr>';


            echo'<tr>'; 
 	        echo'<td>';
		 	echo form_label('*Nombre:');
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre' , $empleado->nombre),
		 		//'style' => 'width:180px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td>';
		 	echo form_label('*Apellido Paterno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p', $empleado->apellido_p),
		 		//'style' => 'width:100px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td>';
		 	echo form_label('*Apellido Materno:');
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m', $empleado->apellido_m),
		 		//'style' => 'width:100px'
		 	);


		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

            echo'<td>';
		 	echo form_label('*Email:');
		 	echo'</td>';
            echo'<td colspan="2">';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email', $empleado->email),
		 		//'style' => 'width:200px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

			echo'<td>';
		 	echo form_label('*Teléfono:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono', $empleado->telefono)
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo'<td>';
		 	echo form_label('*Celular:');
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
            	echo'<td>';
            			echo form_label('*Tipo de empleado:');
            	echo'</td>';
      
		 	?>
             <td>
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
	        echo '<td colspan="100%" class="hide standOut" id="tdEspecialidadesLabel">';
			echo form_label('*Especialidades:');
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
		 		echo'<td colspan ="100%" class="standOut">';
		 			echo form_label('Dirección:');
		 		echo'</td>';
		 	echo'</tr>';

?>
		 	<tr>
	<td>
		<?= form_label('*Estado:'); ?>
	</td>
	    <td colspan="2">
	  	   <select name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	  	   <div id="wait_estados" class="wait">
				<p>Cargando Estados, por favor espere</p>
	 		</div>
	    </td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Municipio:'); ?>
	</td>
	<td colspan="2">
		<select  name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
		<div id="wait_mun" class="wait">
		<p>Cargando Municipio, por favor espere</p>
	 	</div>
	</td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Codigo Postal:'); ?>
	</td>
    <td colspan="2">
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    	<div id="wait_cp" class="wait">
			<p>Cargando Codigo Postal, por favor espere</p>
	 	</div>
    </td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Colonia:'); ?>
	</td>
	<td colspan="2">
		<select name="colonia" id="colonia" class="hide" onchange=""/></select>
		<div id="wait_col" class="wait">
		<p>Cargando Colonia, por favor espere</p>
	 	</div>
	</td>
</tr>

<?php

echo '</tr>';
echo '</table>';
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
	
<script>

$(function () {
	$("input[type=submit]").attr("disabled", "disabled");
	base_url = "<?= base_url(); ?>";
	getFederalEntities(1);
});

function getFederalEntities(nStart){

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

		$('#estado').append('<option value="0">Seleccione un Estado</option>');

  		$.each( data, function( key, val ) {

  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

 	 	if(nStart){
 	 		$('#estado').val("<?= $empleado->direccion->estado_id; ?>");
 	 		getMunicipalities(1);
 	 	}

 	 	$('#estado').show();
     	$('#wait_estados').hide();

	});
}

function getMunicipalities(nStart){

$("#municipio option").remove();
$('#municipio').hide();
$("#codigo_postal option").remove();
$('#codigo_postal').hide();
$("#colonia option").remove();
$('#colonia').hide();
$('#wait_mun').show();

   var url = base_url + "address/getMunicipalities/"+$("#estado").val();

	$.getJSON( url, function( data ) {

	$('#municipio').append('<option value="0">Seleccione un Municipio</option>');

    $.each( data, function( key, val ) {

  	$('#municipio').append('<option value="' + val.id + '">' + val.name + '</option>');

 	 	});

		 if(nStart){

 	 		$('#municipio').val("<?= $empleado->direccion->municipio_id; ?>");
 	 		getPostalCodes(1);
 	 	}

     	$('#municipio').show();
     	$('#wait_mun').hide();
		
	});
	
}

function getPostalCodes(nStart){

$("#codigo_postal option").remove();
$('#codigo_postal').hide();
$("#colonia option").remove();
$('#colonia').hide();
$('#wait_cp').show();

var url = base_url + "address/getPostalCodes/"+$("#municipio").val();

$.getJSON( url, function( data ) {
		
$('#codigo_postal').append('<option value="0">Seleccione un Código Postal</option>');
		
 $.each( data, function( key, val ) {
  			
  $('#codigo_postal').append('<option value="' + val.id + '">' + val.name + '</option>');

 	 	});

	   if(nStart){
 	 		$('#codigo_postal').val("<?= $empleado->direccion->codigo_postal_id; ?>");
 	 		getColonies(1);
 	 	}

		$('#codigo_postal').show();
		$('#wait_cp').hide();
     		
	});
	
}

function getColonies(nStart){

$("#colonia option").remove();
$('#colonia').hide();
$('#wait_col').show();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();

$.getJSON( url, function( data ) {

$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 
$.each( data, function( key, val ) {
  			
$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

		if(nStart){

 	 		$('#colonia').val("<?= $empleado->direccion->colonia_id; ?>");
 	 		$('#wait_col').hide();
			$('#address').show();
			$("input[type=submit]").removeAttr("disabled");

 	 	}
		
		$('#colonia').show();
		$('#wait_col').hide();
		
	});
	
}

</script>
