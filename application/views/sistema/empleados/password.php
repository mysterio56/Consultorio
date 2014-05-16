<script>
	$(function(){ 
		Valid.password(); 
		$('.screenLoad').hide(); 

		 if(window.name == "employees_edit"){

      		$('#perfil').val('true');
      		$('#cancel').attr('href','<?= base_url("employees/editar/".$id_employee); ?>');

    		}
	});
</script>
<?php
	$attributes = array('id' => 'passwordForm');

	 	echo form_open(null,$attributes);

	 	if(isset($error)){
			echo '<div class="error">'.$error."</div>";
		}

		 ?>

		 <input type="hidden" name="perfil" id="perfil" value="false" />

		 <?php
echo '<table class="table_form">';
echo '<tr>';
echo '<td>';
			echo form_label('*Campos Requeridos','campo');
			echo '</td>';
				echo '</tr>';
		echo '<tr>';
	
echo '<td>';
		 	echo form_label('*Contraseña Anterior:');
	echo '</td>';
	$data = array(
		 		'name'  => 'passwordOld',
		 		'id'    => 'passwordOld',
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
	echo '</tr>';

echo '<tr>';
	echo '<td>';

		 	echo form_label('*Contraseña Nueva:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'password',
		 		'id'    => 'password',
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';

	echo '</tr>';

echo '<tr>';

	echo '<td>';
		 	echo form_label('*Confirme Constraseña:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'passwordcheck',
		 		'id'    => 'passwordcheck',
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_password($data);
	echo '</td>';
echo '</tr>';

echo '</table>';

		 	$data = array(
		 		'name'  => 'Actualizar',
		 		'id'    => 'Actializar',
		 		'class' => 'abutton',
		 		'value' => 'Actualizar'
		 	);

		 	echo form_submit($data);
		 	echo '<a href="'.base_url($return).'" id="cancel" class="abutton_cancel">Cancelar</a>';
	 		echo form_close();

?>