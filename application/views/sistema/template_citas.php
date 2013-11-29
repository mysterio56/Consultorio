<?php

define ("PERMISOS", serialize (array("Agregar"  => array(4,5,6,7),
                                         "Editar"   => array(2,3,6,7),
                                         "Eliminar" => array(1,3,5,7)
                                         )
                                  )
        );

 define ("MESES", serialize (array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic")));

	if(isset($cssFiles) && is_array($cssFiles)){
		foreach($cssFiles as $cssFile) {
        	echo '<link href="'.base_url('assets/css/'.$cssFile).'" rel="stylesheet" type="text/css" />';
        } 
    }

    if(isset($jsFiles) && is_array($jsFiles)){
		foreach($jsFiles as $jsFile) {
			echo '<script src="'.base_url('assets/js/'.$jsFile).'" type="text/javascript"></script>';
        }
    }
?>

<div class="subir">

<?php
 
    echo form_open();
?>

<div class="citas">
<input id="chk_act" checked="true" type="checkbox" name="estatus_citas[]" class="vis-hidden" value="1" />
<label for="chk_act">Actuales</label>

<input id="chk_prox" type="checkbox" name="estatus_citas[]" class="vis-hidden" value="2" />
<label for="chk_prox">Proximas</label>

<input id="chk_pas" type="checkbox" name="estatus_citas[]" class="vis-hidden" value="3" />
<label for="chk_pas">Pasadas</label>
</div>

<?php
    echo form_close();
?> 

</div>

<?php   
    $this->load->view($view);   
?>