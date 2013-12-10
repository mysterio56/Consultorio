<script>
	$(function(){ Valid.cita(); });
</script>

<?php 

  $attributes = array('id' => 'citaForm');
  	echo form_open(null,$attributes); 
	
	echo '<table class="table_form">';
	echo '<tr>';
		echo'<td>';

			echo form_label('*Campos Requeridos','campo');
		echo'</td>';
	echo '</tr>';
	
	echo '<tr>';
		echo '<td>';
	 		echo form_label('*Paciente:');
	 	
	 	echo '<td>';

		 	$data = array(
		 		'name'  => 'paciente',
		 		'id'    => 'paciente',
		 		'value' => set_value('paciente'),
		 		'style' => 'width:150px'
		 	);

		 	echo form_input($data);
		 		echo '<input type="hidden" name="pacienteId" id="pacienteId"/>';
		echo '</td>';
		echo '</td>';
				
		echo  '<td>';
			echo form_label('*Doctor: ');
		
		echo '<td>';
		$data = array(
		 		'name'  => 'doctor',
		 		'id'    => 'doctor',
		 		'value' => set_value('doctor'),
		 		'style' => 'width:150px'
		 	);
			echo form_input($data);
		 	echo '<input type="hidden" name="doctorId" id="doctorId"/>';
		 	echo '</td>';
		 	echo '</td>';
	echo '</tr>';

	echo '<tr>';
		echo '<td>';
			echo form_label('*Fecha y Hora:');
		
		echo '<td>';

		$data=array(
					'name' =>'fecha' ,
					'id'   =>'fecha' ,
					'value'=>set_value('fecha'),
					'style'=>'width:150px'
					);
		
			echo form_input($data);

		echo '<input type="hidden" name="fecha_alt" id="fecha_alt"/>';

		echo '</td>';
		echo '</td>'; 
	

		echo '<td>';
			echo form_label('*Servicio:');
		echo '<td>';

		$data=array(
					'name' =>'servicio' ,
					'id'   =>'servicio' ,
					'value'=>set_value('servicio'),
					'style'=>'width:150px'
					);
		
			echo form_input($data);
			echo '<input type="hidden" name="servicioId" id="servicioId"/>';
		echo '</td>'; 
		echo'</td>';
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

    	fecha_ahora = "<?= date('D M d Y H:i:s O'); ?>";
		fecha_ahora = new Date(fecha_ahora);

    	var myControl=  {
	create: function(tp_inst, obj, unit, val, min, max, step){
		$('<input class="ui-timepicker-input" value="'+val+'" style="width:50%">')
			.appendTo(obj)
			.spinner({
				min: min,
				max: max,
				step: step,
				change: function(e,ui){ // key events
						// don't call if api was used and not key press
						if(e.originalEvent !== undefined)
							tp_inst._onTimeChange();
						tp_inst._onSelectHandler();
					},
				spin: function(e,ui){ // spin events
						tp_inst.control.value(tp_inst, obj, unit, ui.value);
						tp_inst._onTimeChange();
						tp_inst._onSelectHandler();
					}
			});
		return obj;
	},
	options: function(tp_inst, obj, unit, opts, val){
		if(typeof(opts) == 'string' && val !== undefined)
			return obj.find('.ui-timepicker-input').spinner(opts, val);
		return obj.find('.ui-timepicker-input').spinner(opts);
	},
	value: function(tp_inst, obj, unit, val){
		if(val !== undefined)
			return obj.find('.ui-timepicker-input').spinner('value', val);
		return obj.find('.ui-timepicker-input').spinner('value');
	}
};

$('#fecha').datetimepicker({
	controlType: myControl,
	altField: "#fecha_alt",
	altFieldTimeOnly: false,
	altFormat: "yy-mm-dd",
	altTimeFormat: "HH:mm",
	minDate: fecha_ahora,
	timeText:    '',
	hourText:    'Hora',
	minuteText:  'Minuto',
	currentText: 'Fecha actual',
	closeText:   'Aceptar',
});
});	

</script>