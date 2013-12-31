<script>
    base_url = '<?php echo base_url(); ?>';
</script>
<div id="divnav">
   <nav>

         <?php

            $aSubmodulo = array();

            foreach($submodulos as $submodulo){
              $aSubmodulo[$submodulo->id] = $submodulo->nombre; 
            }

            foreach($modulos as $modulo){
              $aModulos[$modulo->id] = $modulo->nombre; 
            }
  
            foreach($allModulos as $modulo){
              
              $modulo->modulo->get();

              $asub = array();
              $val = false;

              foreach($modulo->modulo->all as $submoduloAll){
                $asub[$submoduloAll->id]['nombre'] = $submoduloAll->nombre;
                $asub[$submoduloAll->id]['url'] = $submoduloAll->url;
                $asub[$submoduloAll->id]['permiso'] = in_array($submoduloAll->nombre,$aSubmodulo)?true:false;
                if(in_array($submoduloAll->nombre,$aSubmodulo)){
                   $val = true;
                }
              }
               
               $aModulosAll[$modulo->id]['submodulo'] = $asub;
               $aModulosAll[$modulo->id]['nombre']    = $modulo->nombre;
               $aModulosAll[$modulo->id]['url']   = $modulo->url;
               $aModulosAll[$modulo->id]['print']   = (in_array($modulo->nombre,$aModulos)||$val)?true:false;
               $aModulosAll[$modulo->id]['permiso']   = in_array($modulo->nombre,$aModulos)?true:false;
              
            }

            foreach ($aModulosAll as $key => $modulo) {

              if($modulo['print']){

                if(!empty($modulo['submodulo'])){
                    $isParent = 'parent';
                } else {
                    $isParent = '';
                }

                echo '<li class="'.$isParent.'">';
                echo    '<a href="javascript:void(0)"'; 

                  if($modulo['permiso'] && $modulo['url'] != ""){
                    echo 'onClick="Tab.newTab(\''.$modulo['nombre'].'\',\''.base_url($modulo['url']).'\',\''.$modulo['url'].'\');"';
                  }

                echo     '>';
                echo     $modulo['nombre'];
                echo    '</a>';
        

                if(!empty($modulo['submodulo'])){
                    echo '<ul>';

                    foreach($modulo['submodulo'] as $submodulo){
                      if($submodulo['permiso']){
                        echo '<li>';
                        echo  '<a href="javascript:void(0)"';
                        echo 'onClick="Tab.newTab(\''.$submodulo['nombre'].'\',\''.base_url($submodulo['url']).'\',\''.$submodulo['url'].'\');"';
                        echo  '>';
                        echo $submodulo['nombre'];
                        echo '</a>';
                        echo '</li>';
                      }

                    }
                    echo '</ul>';
                }
                echo '</li>';
              }

            }

         ?>
   </nav>
</div>