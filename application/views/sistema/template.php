<?php
    /** funcion para validar que la pagina se habra en un iframe **/

    IframeRedirect();

    define ("PERMISOS", serialize (array("Agregar"  => array(4,5,6,7),
                                         "Editar"   => array(2,3,6,7),
                                         "Eliminar" => array(1,3,5,7)
                                         )
                                  )
           );
    

    define ("MESES", serialize (array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic")));

    define ("CONSULTORIOID", $this->session->userdata('id_consultorio'));
    
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

 if(!isset($return) && $view != 'sistema/consultorio/editar'){
  
    $attributes = array('id' => 'busquedaForm');
    echo form_open(null,$attributes);
    
    echo form_label('Código / Nombre:');
   
    $data =array(
                'name'  => 'buscar' , 
                'id'    => 'buscar' , 
                'size'  => '20', 
                'value' => set_value('buscar'),
                'class' => 'color_form'
                );

    echo form_input($data);


  ?>
    <input type="hidden" name="buscarId" id="buscarId"/>
    <a id='busqueda' class="abutton" onclick= "grid();"> Buscar</a>
  </div>
  </table>

  <? 
      
  echo form_close();
  }

?> 

<?php   
    $this->load->view($view); 

?>