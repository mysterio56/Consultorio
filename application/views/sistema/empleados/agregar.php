<script>
	$(function(){ Valid.empleados(); });
</script>
<?php
	$attributes = array('id' => 'empleadosForm');

	 	echo form_open(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';

		echo '<td>';
	 		echo form_label('Código:');
	 	echo '</td>';

		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo'),
		 		'style' => 'width:100px'
		 	);

		 	echo '<td>';
		 		echo form_input($data);
		 	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Nombre:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('Apellido Paterno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('Apellido Materno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		'style' => 'width:100px'
		 	);

	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Email:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email'),
		 		'style' => 'width:200px'
		 	);
	echo '<td colspan="2">';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Password:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'password',
		 		'id'    => 'password',
		 		'style' => 'width:80px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('Confirme Password:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'passwordcheck',
		 		'id'    => 'passwordcheck',
		 		'style' => 'width:80px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Teléfono:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono'),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('Celular:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular'),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		echo form_label('Tipo de empleado:');
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
	echo '<td colspan="100%" class="hide" id="tdEspecialidadesLabel">';
			echo form_label('Especialidades:');
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

?>
<tr>
	<td>
		 	<?= form_label('Estado:'); ?>
	</td>
	<td colspan = 2>
		 	<select name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	</td>
</tr>
<tr>
	<td>
		 	<?= form_label('Municipio:'); ?>
	</td>
	<td colspan = 2>
		    <select name="municipio" id="municipio" class="hide" onChange="getPostalCodes();" /> </select>
	</td>
</tr>
<tr>	
	<td>
		 	<?= form_label('Codigo Postal:'); ?>
	</td>
	<td colspan = 2>
		    <select name="codigo_postal" id="codigo_postal" class="hide"  onChange="getColonies();"/></select>
	</td>
</tr>
<tr>
	<td>
		 	<?= form_label('Colonia:'); ?>
	</td>
	<td colspan = 2>
		    <select name="colonia" id="colonia" class="hide"  onChange="showComplements();"/></select>
	</td>
</tr>

	<?php
echo '<tr>';
	echo '<td>';
		 	echo form_label('Calle:');
	echo '</td>';

			 	$data = array(
		 		'name'  => 'calle',
		 		'id'    => 'calle',
		 		'value' => set_value('calle'),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Número Exterio:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'numero_ext',
		 		'id'    => 'numero_ext',
		 		'value' => set_value('numero_ext'),
		 		'style' => 'width:100px'
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
		 		'style' => 'width:100px'
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
	base_url = "<?= base_url(); ?>";
	getFederalEntities();

	$("#tipo_empleado").change(function(){
			showEspecialidades();
		});

	$("#agregar").click(function(){
        $(".error").hide();
        var hasError = false;
        var passwordVal = $("#password").val();
        var checkVal = $("#passwordcheck").val();
        
        if (passwordVal != checkVal ) {
            $("#passwordcheck").after('<span class="error">Passwords no coincide.</span>');
            hasError = true;
        }

        if(hasError == true) {return false;}
    });

    $('#empleadosForm').validate({
        rules:{
            password:{
                required:true,
                 minlength: 5
            },
            passwordcheck:{
                required:true,
                 minlength: 5
            },
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });

});

function getFederalEntities(){

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

		$('#estado').append('<option value="0">Seleccione un Estado</option>');

  		$.each( data, function( key, val ) {
  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

 	 	$('#estado').show();
     	
	});
}

function getMunicipalities(){

$("#municipio option").remove();
$('#municipio').hide();
$("#codigo_postal option").remove();
$('#codigo_postal').hide();
$("#colonia option").remove();
$('#colonia').hide();


var url = base_url + "address/getMunicipalities/"+$("#estado").val();
	$.getJSON( url, function( data ) {
		$('#municipio').append('<option value="0">Seleccione un Municipio</option>');
		 $.each( data, function( key, val ) {
  			$('#municipio').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

     	$('#municipio').show();
		
	});
	
}

function getPostalCodes(){

$("#codigo_postal option").remove();
$('#codigo_postal').hide();
$("#colonia option").remove();
$('#colonia').hide();

var url = base_url + "address/getPostalCodes/"+$("#municipio").val();
	$.getJSON( url, function( data ) {
		$('#codigo_postal').append('<option value="0">Seleccione un Código Postal</option>');
		 $.each( data, function( key, val ) {
  			$('#codigo_postal').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

		$('#codigo_postal').show();
     		
	});
	
}

function getColonies(){

$("#colonia option").remove();
$('#colonia').hide();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();
	$.getJSON( url, function( data ) {
		$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 $.each( data, function( key, val ) {
  			$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});
		
		$('#colonia').show();
		
	});
	
}

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

</script>