<script>
	$(function(){ Valid.consultorio(); });
</script>
<?php
	$aPermisos  = unserialize(PERMISOS);
	$attributes = array('id' => 'consultorioForm');

	 	echo form_open_multipart(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';
	echo form_label('*Campos Requeridos','campo');
		echo '<td>';
	 		echo form_label('*Nombre:');
	 	echo '</td>';
	 	echo '<td>';
	 		echo form_label($consultorio->nombre);
		echo '</td>';

 			$consultorio->tipo_consultorio->get();
 		echo '<td>';
	 		echo form_label('*Tipo:');
	 	echo '</td>';
	 	echo '<td>';
	 		echo form_label($consultorio->tipo_consultorio->nombre);
	 	echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
		 	echo form_label('*Teléfono 1:');
		echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono1',
		 		'id'    => 'telefono1',
		 		'value' => set_value('telefono1', $consultorio->telefono1),
		 		//'style' => 'width:180px'
		 	);

		echo '<td>';
		 	echo form_input($data);
		echo '</td>';
		echo '<td>';
		 	echo form_label('Teléfono 2:');
		echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono2',
		 		'id'    => 'telefono2',
		 		'value' => set_value('telefono2', $consultorio->telefono2),
		 		//'style' => 'width:180px'
		 	);

		 echo '<td>';
		 	echo form_input($data);
		 echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
		 	echo form_label('*Email:');
		echo '</td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email', $consultorio->email),
		 		//'style' => 'width:210px'
		 	);
		echo '<td>';
		 	echo form_input($data);
		echo '</td>';
		
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
			echo form_label('Logo:');
		echo '</td>';
		echo '<td>';
		 	?>

		 	<input type="file" name="userfile" size="20" />

		 	<?php
		
		echo '</td>';
	echo '</tr>';
	
	echo '<tr>';
	        echo '<td colspan="100%" class="standOut">';
			echo form_label('Especialidades:');
	        echo '</td>';
            echo '</tr>';
            
		 	$consultorio->especialidad->get();

			foreach($consultorio->especialidad->all as $consultorio_especialidad){
             			$aChecked[$consultorio_especialidad->id] = $consultorio_especialidad->id;
             }

             if(!isset($aChecked))
             	$aChecked[0] = 0;

			echo '<tr>';
	        echo '<td colspan="100%">';
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
 	 		$('#estado').val("<?= $consultorio->direccion->estado_id; ?>");
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

 	 		$('#municipio').val("<?= $consultorio->direccion->municipio_id; ?>");
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
 	 		$('#codigo_postal').val("<?= $consultorio->direccion->codigo_postal_id; ?>");
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

 	 		$('#colonia').val("<?= $consultorio->direccion->colonia_id; ?>");
 	 		$('#wait_col').hide();
			$('#address').show();
			$("input[type=submit]").removeAttr("disabled");

 	 	}
		
		$('#colonia').show();
		$('#wait_col').hide();
		
	});
	
}

</script>