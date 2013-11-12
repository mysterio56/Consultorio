<script>
	$(function(){ Valid.consultorio(); });
</script>
<?php
	$aPermisos  = unserialize(PERMISOS);
	$attributes = array('id' => 'consultorioForm');

	 	echo form_open_multipart(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';
		echo '<td>';
	 		echo form_label('Nombre:');
	 	echo '</td>';
	 	echo '<td>';
	 		echo form_label($consultorio->nombre);
		echo '</td>';

 			$consultorio->tipo_consultorio->get();
 		echo '<td>';
	 		echo form_label('Tipo:');
	 	echo '</td>';
	 	echo '<td>';
	 		echo form_label($consultorio->tipo_consultorio->nombre);
	 	echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
		 	echo form_label('Teléfono 1:');
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
		 	echo form_label('Email:');
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
		 
		 	?>
<tr>
	<td colspan="100%">
		 	<div id="wait" class="wait">
		 		<p>Cargando dirección, por favor espere</p>
		 	</div>
	</td>
</tr>

		 	<div id="address" class="hide" >
<tr>
	<td>
		 	<?= form_label('Estado:'); ?>
	</td>
	<td>
		 	<select name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	</td>
</tr>
<tr>
	<td>
		 	<?= form_label('Municipio:'); ?>
	</td>
	<td>
		    <select name="municipio" id="municipio" class="hide" onChange="getPostalCodes();" /> </select>
	</td>
</tr>
<tr>	
	<td>
		 	<?= form_label('Codigo Postal:'); ?>
	</td>
	<td>
		    <select name="codigo_postal" id="codigo_postal" class="hide"  onChange="getColonies();"/></select>
	</td>
</tr>
<tr>
	<td>
		 	<?= form_label('Colonia:'); ?>
	</td>
	<td>
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
		 		'value' => set_value('calle',$consultorio->direccion->calle),
		 		//'style' => 'width:210px'
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
		 		'value' => set_value('numero_ext',$consultorio->direccion->numero_ext),
		 		//'style' => 'width:210px'
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
		 		'value' => set_value('numero_int',$consultorio->direccion->numero_int),
		 		//'style' => 'width:210px'
		 	);
    echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	echo '</div>';
echo '<table>';

		 	if(in_array($permisos,$aPermisos['Editar']) ){
		 		echo form_submit($data);
		 	}

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
     	
	});
}

function getMunicipalities(nStart){

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

		 if(nStart){
 	 		$('#municipio').val("<?= $consultorio->direccion->municipio_id; ?>");
 	 		getPostalCodes(1);
 	 	}

     	$('#municipio').show();
		
	});
	
}

function getPostalCodes(nStart){

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

		 if(nStart){
 	 		$('#codigo_postal').val("<?= $consultorio->direccion->codigo_postal_id; ?>");
 	 		getColonies(1);
 	 	}

		$('#codigo_postal').show();
     		
	});
	
}

function getColonies(nStart){

$("#colonia option").remove();
$('#colonia').hide();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();
	$.getJSON( url, function( data ) {
		$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 $.each( data, function( key, val ) {
  			$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

		if(nStart){

 	 		$('#colonia').val("<?= $consultorio->direccion->colonia_id; ?>");
 	 		$('#wait').hide();
			$('#address').show();
			$("input[type=submit]").removeAttr("disabled");
 	 	}
		
		$('#colonia').show();
		
	});
	
}

function showComplements(){


	
}

</script>