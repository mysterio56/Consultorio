<script>
	$(function(){ Valid.paciente(); });
</script>
<?php

	$attributes = array('id' => 'pacienteForm');

	 	echo form_open(null,$attributes);

	 		echo form_label('Codigo del paciente:');
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo',$paciente->codigo),
		 		'style' => 'width:80px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Nombre:');
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre',$paciente->nombre),
		 		'style' => 'width:125px'
		 	);

		 	echo form_input($data);

		 	echo form_label('Apellido paterno:');
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p',$paciente->apellido_p),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);

		 	echo form_label('Apellido materno:');
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m',$paciente->apellido_m),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Email:');
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email',$paciente->email),
		 		'style' => 'width:200px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Teléfono:');
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono',$paciente->telefono)
		 	);

		 	echo form_input($data);

		 	echo form_label('Celular:');
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular',$paciente->celular)
		 	);

		 	echo form_input($data);

		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	echo form_submit($data);

	 	echo form_close();
?>