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

<img class   = "action" 
     src     = "<?= base_url('assets/images/return.png')?>" 
     onClick = "Valid.return('<?= $return; ?>');"
     title   = "Regresar" />

<?php endif; ?>

<img class   = "action" 
     src     = "<?= base_url('assets/images/reload.png')?>" 
     onClick = "Valid.carga();"
     title   = "Recargar pestaña" />

<div class="subir">

<?php
 if(!isset($return) && $view != 'sistema/consultorio/editar'){

    echo form_open();
    echo form_label('Código:','codigo');
    echo form_input(array('name'  => 'codigo' , 
                          'id'    => 'codigo' , 
                          'size'  => '20', 
                          'value' => set_value('codigo')));

    echo form_label('Nombre:','nombre');
    echo form_input(array('name'  => 'nombre', 
                          'id'    => 'nombre', 
                          'size'  => '20', 
                          'value' => set_value('nombre')));
   

    echo form_submit(array('name'  => 'buscar', 
                           'id'    => 'buscar',
                           'class' => 'abutton',
                           'value' => 'Buscar',
                           'style' => 'margin:0px'));
    echo form_close();

  }
?> 
</div>

<?php   
    $this->load->view($view);     
?>