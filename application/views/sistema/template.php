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



    echo form_open();
    echo '<table class="table_form">';
    echo'<tr>'; 
    echo'<td>';
    echo form_label('Código:','codigo');
    echo'</td>';
    echo'<td>';
    echo form_input(array('name'  => 'codigo' , 
                          'id'    => 'codigo' , 
                          'size'  => '20', 
                          'value' => set_value('codigo')));
    echo'</td>';
    echo'<td>';
    echo form_label('Nombre:','nombre');
    echo'</td>';
    echo'<td>';
    echo form_input(array('name'  => 'nombre', 
                          'id'    => 'nombre', 
                          'size'  => '20', 
                          'value' => set_value('nombre')));
   echo'</td>';

echo'<td>';
    echo form_submit(array('name'  => 'buscar', 
                           'id'    => 'buscar',
                           'class' => 'abutton',
                           'value' => 'Buscar',
                           'style' => 'margin:0px'));
    echo'</td>';
    echo'</tr>';
    echo form_close();
  }

?> 

</div>
</table>


<?php   
    $this->load->view($view); 

?>