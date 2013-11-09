<script>
	$(function(){ Valid.consultorio(); });
</script>
<?php
	$aPermisos = unserialize (PERMISOS);
	$attributes = array('id' => 'consultorioForm');

	 	echo form_open_multipart(null,$attributes);

	 		echo form_label('Nombre:');
	 		echo form_label($consultorio->nombre);

 			$consultorio->tipo_consultorio->get();

	 		echo form_label('Tipo de consultorio:');
	 		echo form_label($consultorio->tipo_consultorio->nombre);
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
		 		'style' => 'width:210px'
		 	);

		 	echo form_input($data);
		 	echo '<br />';

			echo form_label('Logo:');
		 	?>

		 	<input type="file" name="userfile" size="20" />

		 	<?php
		
		 	echo '<br />';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Editar'
		 	);

		 	?>

		 	<select name="estado">
		 		<option value="0">Seleccione...</option>
		 		<?php foreach($estados as $estado): ?>
				  <option value="<?= $tipo->id; ?>" 
				  	      <?= //($empleado->tipo_empleado_id == $tipo->id)?'selected':''; ?> >
				  	      <?= $estado->nombre; ?></option>
				<?php endforeach; ?>
		    </select>

		 	<?php
		 	if(in_array($permisos,$aPermisos['Editar']) ){
		 		echo form_submit($data);
		 	}

	 	echo form_close();
?>