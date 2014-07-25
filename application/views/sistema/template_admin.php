<?php

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

<?php 
      
  echo form_close();

  }

  ?>

<div class="screenLoad">
  <div>  
    <img src="<?= base_url('assets/images/Loading.gif'); ?>" width="50" /><label>Procesando...</label>
  </div>  
</div>


<?php   
    $this->load->view($view);   
?>