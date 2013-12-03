<?php
echo form_open(null); 
	
	echo '<table class="table_form">';
	echo '<tr>';
		echo '<tr>';
		echo '<td>';
	 		echo form_label('Producto:');
	 	
	 	echo '<td>';

		 	$data = array(
		 		'name'  => 'producto',
		 		'id'    => 'producto',
		 		'value' => set_value('producto'),
		 		'style' => 'width:150px'
		 	);

		 	echo form_input($data);
		 		echo '<input type="hidden" name="productoId" id="productoId"/>';
		echo '</td>';
		echo '</td>';
				
		echo  '<td>';
			echo form_label('Servicio: ');
		
		echo '<td>';
		$data = array(
		 		'name'  => 'servicio',
		 		'id'    => 'servicio',
		 		'value' => set_value('servicio'),
		 		'style' => 'width:150px'
		 	);
			echo form_input($data);
			echo '<input type="hidden" name="servicioId" id="servicioId"/>';
		 	echo '</td>';
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
	
        $( "#producto" ).autocomplete({
      	source: base_url + "product/lista",
      	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#productoId").val(ui.item ? ui.item.Id : "");
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
</script>
