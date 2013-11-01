<script>
	$(function(){ Valid.consultorio(); });
</script>
<?php

	$attributes = array('id' => 'consultorioForm');

	 	echo form_open(null,$attributes);

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}

	 		echo form_label('Nombre:');
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'value' => set_value('nombre', $consultorio->nombre),
		 		'style' => 'width:180px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Teléfono 1:');
		 	$data = array(
		 		'name'  => 'telefono1',
		 		'id'    => 'telefono1',
		 		'value' => set_value('telefono1', $consultorio->telefono1),
		 		'style' => 'width:180px'
		 	);

		 	echo form_input($data);

		 	echo form_label('Teléfono 2:');
		 	$data = array(
		 		'name'  => 'telefono2',
		 		'id'    => 'telefono2',
		 		'value' => set_value('telefono2', $consultorio->telefono2),
		 		'style' => 'width:180px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Email:');
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email', $consultorio->email),
		 		'style' => 'width:180px'
		 	);

		 	echo form_input($data);
		
		 	echo '<br />';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'value' => 'Editar'
		 	);

		 	echo form_submit($data);


	 	echo form_close();
?>