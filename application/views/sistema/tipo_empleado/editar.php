<script>
	$(function(){ Valid.tipoEmpleado(); });
</script>
<?php
	$attributes = array('id' => 'tipoEmpleadoForm');

	 	echo form_open(null,$attributes);

	 		echo form_label('Codigo del tipo de empleado:');
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo',$tipoEmpleado->codigo),
		 		'style' => 'width:80px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

		 	echo form_label('Nombre:');
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre',$tipoEmpleado->nombre),
		 		'style' => 'width:125px'
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