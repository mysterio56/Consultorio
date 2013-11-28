<?php 

	echo form_open(null);
	echo '<table class="table_form">';
	echo '<tr>';
			echo form_label('*Campos Requeridos','campo');
		echo '<td>';
	 		echo form_label('*Paciente:');
	 	echo '</td>';

		 	$data = array(
		 		'name'  => 'paciente',
		 		'id'    => 'paciente',
		 		'value' => set_value('paciente'),
		 		'style' => 'width:100px'
		 	);

		 	echo '<td>';
		 		echo form_input($data);
		 		echo '<input type="hidden" name="pacienteId" id="pacienteId"/>';
		 	echo '</td>';
			echo '</tr>';

	echo '<tr>';
		echo  '<td>';
			echo form_label('*Doctor: ');
		echo '</td>';
		$data = array(
		 		'name'  => 'doctor',
		 		'id'    => 'doctor',
		 		'value' => set_value('doctor'),
		 		'style' => 'width:100px'
		 	);

		 	echo '<td>';
		 		echo form_input($data);
		 		echo '<input type="hidden" name="doctorId" id="doctorId"/>';
		 	echo '</td>';
			echo '</tr>';

	echo '<tr>';
		echo '<td>';
			echo form_label('*Fecha y Hora');
		echo '</td>';

		$data=array(
					'name' =>'fecha' ,
					'id'   =>'fecha' ,
					'value'=>set_value('fecha'),
					'style'=>'width:100px'
					);
		echo '<td>';
			echo form_input($data);
		echo '</td>'; 
		?>

			<input type="hidden" name="fecha_alta" id="fecha_alta" />

			<?php
	echo '<tr>';
		echo '<td>';
			echo form_label('*Servicio:');
		echo '</td>';

		$data=array(
					'name' =>'servicio' ,
					'id'   =>'servicio' ,
					'value'=>set_value('servicio'),
					'style'=>'width:100px'
					);
		echo '<td>';
			echo form_input($data);
			echo '<input type="hidden" name="servicioId" id="servicioId"/>';
		echo '</td>'; 
	echo '</tr>';

	echo'</table>'; 

		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close();
?>

<script>
$(function () {
	
	base_url = "<?= base_url(); ?>";
	
        $( "#paciente" ).autocomplete({
      	source: base_url + "patient/lista",
      	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#pacienteId").val(ui.item ? ui.item.Id : "");
        	}
    	});

        $( "#doctor" ).autocomplete({
	    source: base_url + "employees/lista",
    	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#doctorId").val(ui.item ? ui.item.Id : "");
        	}
    	});

        $( "#servicio" ).autocomplete({
	    source: base_url + "service/lista",
    	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#servicioId").val(ui.item ? ui.item.Id : "");
        	}
    	});
});	

</script>