<script>
	$(function(){ Valid.paciente(); });
</script>
<?php

	$attributes = array('id' => 'pacienteForm');

	 	echo form_open(null,$attributes);
	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo form_label('* Campos Requeridos','campo');
	    echo'<td  width="100" valing="top">'; 
	 		echo form_label('* Código:');
	 		 echo'</td>';
	   		 echo'<td>';
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo'),
		 		'style' => 'width:80px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';
	
        echo'<tr>'; 
 	    echo'<td  valing="top">'; 
		 	echo form_label('*Nombre:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		'style' => 'width:125px'
		 	);

		 	echo form_input($data);
            echo'</td>';
            echo'<td valing="top">';
		 	echo form_label('*Apellido paterno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
		 	echo'<td>';

		 	echo form_label('*Apellido materno:');
		 	echo'</td>';
		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

		 echo'<tr>'; 
 	     echo'<td valing="top">';
		 	echo form_label('*Email:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email'),
		 		'style' => 'width:200px'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';


		 echo'<tr>'; 
 	     echo'<td  width="100" valing="top">';
		 	echo form_label('*Teléfono:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono')
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
		 		'value' => set_value('celular')
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';
            ?>
 <tr>
	<td>
		 	<?= form_label('*Estado:'); ?>
	</td>
	<td>
	  	 <select name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	</td>
</tr>
<tr>
	<td>
		 	<?= form_label('*Municipio:'); ?>
	</td>
	<td> 
		<select  name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
	</td>
</tr>
<tr>
    <td>
    <?= form_label('*Codigo Postal:');?>
    </td>
    <td>
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    </td>
</tr>
<tr>
    <td>
    	<?= form_label('*Colonia:'); ?>
	</td>
	<td>
		<select name="colonia" id="colonia" class="hide"/></select>
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

            echo'<tr>'; 
            echo'<td colspan= 1>';
		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);
		 	echo'</td>';
		 	echo '</tr>';
		 	echo '</table>';

	 	echo form_close();
?>
<script>
$(function () {
	base_url = "<?= base_url(); ?>";
	getFederalEntities();
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