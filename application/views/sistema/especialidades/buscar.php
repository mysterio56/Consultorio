<script>
	$(function(){ Find.especialidades(); });
</script>
<?php
	$attributes = array('id' => 'especialidadesForm');

	 	echo form_open(null,$attributes);

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}
	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo'<td  width="100" valing="top">'; 
	 		echo form_label('Código:');
	    echo'</td>';
	    echo'<td>';
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo'),
		 		'style' => 'width:80px'
		 	);
		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

            echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Nombre:');
            echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		'style' => 'width:125px'
		 	);

		 	echo form_input($data);
		 	echo '</td>';
            echo '</tr>';
		 	
			echo'<tr>'; 
 	        echo'<td  width="100" valing="top">'; 
		 	echo form_label('Fecha de alta:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'fecha_alta_value',
		 		'id'    => 'fecha_alta_value',
		 		'value' => set_value('fecha_alta_value'),
		 		'style' => 'width:85px'
		 	);

		 	echo form_input($data);
			echo '</td>';
            echo '</tr>';
			?>

			<input type="hidden" name="fecha_alta" id="fecha_alta" />

			<?php
			echo'<tr>'; 
            echo'<td colspan= 1>';
		 	$data = array(
		 		'name'  => 'buscar',
		 		'id'    => 'buscar',
		 		'class' => 'abutton',
		 		'value' => 'Buscar'
		 	);

		 	echo form_submit($data);
		 	echo'</td>';
		 	echo '</tr>';
		 	echo '</table>';

	 	echo form_close();

	 	if(isset($especialidades)){

	 		$this->load->view('sistema/especialidades/lista');

	 	}
?>