<?php
    /** funcion para validar que la pagina se habra en un iframe **/
    IframeRedirect();

    define ("PERMISOS", serialize (array("Agregar"  => array(4,5,6,7),
                                         "Editar"   => array(2,3,6,7),
                                         "Eliminar" => array(1,3,5,7)
                                         )
                                  )
           );
    
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

    if(isset($return)):
?>

<a class="action" href="<?= base_url($return) ?>">
    <img class   = "action" 
         src     = "<?= base_url('assets/images/return.png')?>" 
         onClick = "Valid.carga();"
         title   = "Regresar" />
 </a>

<?php endif; ?>

<img class   = "action" 
     src     = "<?= base_url('assets/images/reload.png')?>" 
     onClick = "Valid.carga();"
     title   = "Recargar pestaña" />

<?php   
    $this->load->view($view);     
?>