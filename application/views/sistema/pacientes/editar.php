<script>
	$(function(){ Valid.paciente(); });
</script>
<?php
	$aPermisos  = unserialize(PERMISOS);
	$attributes = array('id' => 'pacienteForm');

	 	echo form_open(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';

		echo '<td>';
	 		echo form_label('Código:');
	 	echo '</td>';

		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo',$paciente->codigo),
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
		 		'value' => set_value('nombre',$paciente->nombre),
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
		 		'value' => set_value('apellido_p',$paciente->apellido_p),
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
		 		'value' => set_value('apellido_m',$paciente->apellido_m),
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
		 		'value' => set_value('email',$paciente->email),
		 		'style' => 'width:200px'
		 	);
	echo '<td colspan="2">';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('Teléfono:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono',$paciente->telefono),
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
		 		'value' => set_value('celular',$paciente->celular),
		 		'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '</tr>';
?>
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
		<select  name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
	</td>
</tr>
<tr>
    <td>
    <?= form_label('Codigo Postal:');?>
    </td>
    <td>
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    </td>
</tr>
<tr>
    <td>
    	<?= form_label('Colonia:'); ?>
	</td>
	<td>
		<select name="colonia" id="colonia" class="hide"/></select>
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
		 		'value' => set_value('calle',$paciente->direccion->calle),
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
		 		'value' => set_value('numero_ext',$paciente->direccion->numero_ext),
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
		 		'value' => set_value('numero_int',$paciente->direccion->numero_ext),
		 		//'style' => 'width:210px'
		 	);
		 	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo'<td colspan= 1>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);
		 	echo '</div>';
			echo '</table>';
		 		echo form_submit($data);

	 	echo form_close();
	?>
<script>

$(function (nStart) {
	$("input[type=submit]").attr("disabled", "disabled");
	base_url = "<?= base_url(); ?>";
	getFederalEntities(1);
});

function getFederalEntities(nStart){

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

		$('#estado').append('<option value="0">Seleccione un Estado</option>');
echo '</div>';
  		$.each( data, function( key, val ) {
  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

 	 	if(nStart){
 	 		$('#estado').val("<?= $paciente->direccion->estado_id; ?>");
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
 	 		$('#municipio').val("<?= $paciente->direccion->municipio_id; ?>");
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
 	 		$('#codigo_postal').val("<?= $paciente->direccion->codigo_postal_id; ?>");
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

 	 		$('#colonia').val("<?= $paciente->direccion->colonia_id; ?>");
 	 		$('#wait').hide();
			$('#address').show();
			$("input[type=submit]").removeAttr("disabled");
 	 	}
		
		$('#colonia').show();
		
	});
	
}

</script>
