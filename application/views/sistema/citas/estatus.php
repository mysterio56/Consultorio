<?php
echo form_open();
	if($estatus_act != 1 ){

		echo '<label for="estatus-y" >
				<img src="'.base_url('assets/images/yellow_point.png').'" title ="Pendiente" style="cursor:pointer" width="25" height="25" >

				</label>';
		echo '<input type="radio" name="estatus" id="estatus-y" onchange="this.form.submit()" value="1" style="display:none">';

	} 
	if($estatus_act != 2){
		echo '<label for="estatus-g" >
				<img src="'.base_url('assets/images/green_point.png').'" title ="Realizada" style="cursor:pointer" width="25" height="25" >

				</label>';
		echo '<input type="radio" name="estatus" id="estatus-g" onchange="this.form.submit()" value="2" style="display:none">';
	} 
	if($estatus_act != 3){
		echo '<label for="estatus-r" >
				<img src="'.base_url('assets/images/red_point.png').'" title ="Inacistencia" style="cursor:pointer" width="25" height="25" >

				</label>';
		echo '<input type="radio" name="estatus" id="estatus-r" onchange="this.form.submit()" value="3" style="display:none">';
	} 
	if($estatus_act != 4){
		echo '<label for="estatus-o" >
				<img src="'.base_url('assets/images/orange_point.png').'" title ="Pendiente" style="cursor:pointer" width="25" height="25" >

				</label>';
		echo '<input type="radio" name="estatus" id="estatus-o" onchange="this.form.submit()" value="4" style="display:none">';
	}
	echo form_close();
?>

