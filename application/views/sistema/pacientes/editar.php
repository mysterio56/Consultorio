<script>
	$(function(){ Valid.paciente(); });
</script>
<?php

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
echo'<td colspan= 1>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	echo form_submit($data);
		 	echo'</td>';
		 	echo '</tr>';
		 	echo '</table>';
	 	echo form_close();
?>
	