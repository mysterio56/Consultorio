<script>
     $(function(){ Valid.servicio();
     	 $('.auto').autoNumeric('init');
     	});
     
</script>
	<?php
        $attributes = array('id' =>'servicioForm');
	 	echo form_open(null,$attributes);

	echo '<table class="table_form">';
	echo'<tr>'; 
	echo form_label('*Campos Requeridos','campo');
 	echo'<td  width="100" valing="top">'; 
	 		echo form_label('*Codigo:');
	 echo'</td>';
     echo'<td>';
		 	$data = array(
             'name'  => 'codigo',
		 	 'id'    => 'codigo',
		 	'value'  => set_value('codigo',$nCodigo),
		 	'style' => 'width:200px'
		 	);
		 	 
             echo form_input($data);
      echo'</td>';
      echo '</tr>';
 		 
	echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('*Nombre:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>';

    echo'<tr>'; 
 	echo'<td  width="100" valing="top">'; 
		 	echo form_label('Descripcion:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'descripcion',
		 		'id'    => 'descripcion',
		 		'value' => set_value('descripcion'),
		 		'style' => 'width:200px;height:50px'
		 	);
   echo form_textarea($data);
   echo'</td>';
   echo '</tr>';


echo '<tr>';
 	echo'<td colspan="100%">'; 
		 	echo form_label('Servicios:'); 
		 	
		 	$data = array(
		 		'name'    => 'servicios',
		 		'id'      => 'servicios',
		 		'value'   => 1,
		 		'checked' => true,
		 		'style'   => 'width:16px'
		 	);

             echo form_radio($data);

 		 	echo form_label('Servicios Externos:'); 
		 
		 	$data = array(
		 		'name'    => 'servicios',
		 		'id'      => 'servicios',
		 		'value'   => 2,
		 		'checked' => false,
		 		'style'   => 'width:16px'
		 	);
             echo form_radio($data);
 
		 	echo form_label('Ambos:'); 
		 	
		 	$data = array(
		 		'name'    => 'servicios',
		 		'id'      => 'servicios',
		 		'value'   => 3,
		 		'checked' => false,
		 		'style'   => 'width:16px'
		 	);

             echo form_radio($data);

   echo '</td>';
   echo '</tr>'; 
  
 echo'<tr id="trCostoCompra">'; 
 	echo'<td>';  
		 	echo form_label('*Costo Compra:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_c',
		 		'id'    => 'costo_c',
		 		'class' => 'auto',
		 		'value' => set_value('costo_c'),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
   echo'</td>';
   echo '</tr>'; 

echo'<tr id="trCostoVenta">'; 
 	echo'<td>'; 
		 	echo form_label('*Costo Venta:'); 
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'costo_v',
		 		'id'    => 'costo_v',
		 		'class' => 'auto',
		 		'value' => set_value('costo_v'),
		 		'style' => 'width:200px'
		 	);
   echo form_input($data);
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

  </form>
</div> 
</table>
<script>

$(function(){
	showCostos(1); 

	$("input:radio[name=servicios]").click(function() {
	    var value = $(this).val();
	  	showCostos(value);  
	});

});

function showCostos(costos){
	
		if(costos == 1){
			$("#trCostoCompra").hide();
			$("#trCostoVenta").show();
		} 
	if(costos == 2){
			
			$("#trCostoVenta").hide();
			$("#trCostoCompra").show();
		} 

			if(costos == 3){
			$("#trCostoCompra").show();
			$("#trCostoVenta").show();
		}
}
</script>
