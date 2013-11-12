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
		 		'style' => 'width:125px'
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
		 		'style' => 'width:125px'
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
		 		'style' => 'width:95px'
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
		 		'style' => 'width:95px'
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
		 	echo form_label('Teléfono:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono'),
		 		'style' => 'width:125px'
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
		 		'style' => 'width:125px'
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


	 	echo form_close();
?>