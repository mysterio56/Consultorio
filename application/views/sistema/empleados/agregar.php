<script>
	$(function(){ Valid.empleados(); });
</script>
<?php
	$attributes = array('id' => 'empleadosForm');

	 	echo form_open(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';
			echo form_label('*Campos Requeridos','campo');
		echo '<td>';
	 		echo form_label('*Código:');
	 	echo '</td>';

		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo'),
		 		//'style' => 'width:100px'
		 	);

		 	echo '<td>';
		 		echo form_input($data);
		 	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Nombre:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Apellido Paterno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Apellido Materno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		//'style' => 'width:100px'
		 	);

	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Email:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email'),
		 		//'style' => 'width:200px'
		 	);
	echo '<td colspan="2">';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';

		 	echo form_label('*Password:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'password',
		 		'id'    => 'password',
		 		//'style' => 'width:80px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Confirme Password:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'passwordcheck',
		 		'id'    => 'passwordcheck',
		 		//'style' => 'width:80px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Teléfono:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono'),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Celular:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular'),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		echo form_label('*Tipo de empleado:');
	echo '</td>';
	?>
		<td>
		 	<select name="tipo_empleado" id="tipo_empleado">
		 		<option value="0">Seleccione...</option>
		 		<?php foreach($tipoEmpleado as $tipo): ?>
				  <option value="<?= $tipo->id; ?>"> <?= $tipo->nombre; ?></option>
				<?php endforeach; ?>
		    </select>
		 </td>
</tr>
<?php

echo '<tr>';
	echo '<td colspan="100%" class="hide standOut" id="tdEspecialidadesLabel">';
			echo form_label('*Especialidades:');
	echo '</td>';
echo '</tr>';

echo '<tr>';
	echo '<td colspan="100%" class="hide" id="tdEspecialidades">';
		foreach($especialidades as $especialidad){
				 		echo form_label($especialidad->nombre.':');
				 		$data = array(
				 			'name'  => 'especialidades[]',
				 			'id'    => 'especialidad_'.$especialidad->id,
				 			'value' => $especialidad->id
		 		 			);

				 		echo form_checkbox($data);
				 	}
	echo '</td>';
echo '</tr>';

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
		 <div id="wait_mun" class="wait hide">
	  	  	<p>Cargando Municipios, por favor espere</p>
	  	  	</div>
	</td>
</tr>
<tr>
    <td>
    <?= form_label('*Codigo Postal:');?>
    </td>
    <td colspan="2">
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    	 <div id="wait_cp" class="wait hide">
	  	  	<p>Cargando Codigos Postales, por favor espere</p>
	  	  	</div>
    </td>
</tr>
<tr>
    <td>
    	<?= form_label('*Colonia:'); ?>
	</td>
	<td colspan="2">
		<select name="colonia" id="colonia" class="hide"/></select>
		 <div id="wait_col" class="wait hide">
	  	  	<p>Cargando Colonias, por favor espere</p>
	  	  	</div>
	</td>
</tr>

    <?php
    echo '<tr>';
	echo '<td>';
		 	echo form_label('*Calle:');
	echo '</td>';

			 	$data = array(
		 		'name'  => 'calle',
		 		'id'    => 'calle',
		 		'value' => set_value('calle'),
		 		//'style' => 'width:210px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>';
		 	echo form_label('Número Exterior:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'numero_ext',
		 		'id'    => 'numero_ext',
		 		'value' => set_value('numero_ext'),
		 		//'style' => **'width:210px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('Número interior:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'numero_int',
		 		'id'    => 'numero_int',
		 		'value' => set_value('numero_int'),
		 		//'style' => 'width:210px'
		 	);
		 	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '</tr>';
 	echo '</table>';
            
		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close(); 
	 	
?>
<script>
$(function () {

	 $("#tipo_empleado").change(function(){
       showEspecialidades();
   	});

	base_url = "<?= base_url(); ?>";
	getFederalEntities();
});

function trim (myString)
{
return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

function showEspecialidades(){
   var tipo_empleado = $("#tipo_empleado option:selected").text();
   tipo_empleado = trim(tipo_empleado);
     if(tipo_empleado == 'Doctor' || tipo_empleado == 'doctor'){
       $("#tdEspecialidadesLabel").show();
       $("#tdEspecialidades").show();
     } else {
       $("#tdEspecialidadesLabel").hide();
       $("#tdEspecialidades").hide();
     }
 }

function getFederalEntities(){

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

		$('#estado').append('<option value="0">Seleccione un Estado</option>');

  		$.each( data, function( key, val ) {
  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

 	 	$('#estado').show();
 	 	$('#wait_estados').hide();
     	
	});
}

function getMunicipalities(){

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

     	$('#municipio').show();
     	$('#wait_mun').hide();
		
	});
	
}

function getPostalCodes(){

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

		$('#codigo_postal').show();
		$('#wait_cp').hide();
     		
	});
	
}

function getColonies(){

$("#colonia option").remove();
$('#colonia').hide();
$('#wait_col').show();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();
	$.getJSON( url, function( data ) {
		$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 $.each( data, function( key, val ) {
  			$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});
		
		$('#colonia').show();
		$('#wait_col').hide();
		
	});
	
}

</script>