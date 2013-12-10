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
              
              $modulo->modulo->get();

              $asub = array();
              foreach($modulo->modulo->all as $submodulo){
                $asub[$submodulo->id] = $submodulo->nombre;
              }

               
               $aModulos[$modulo->id]['submodulo'] = $asub;
               $aModulos[$modulo->id]['nombre'] = $modulo->nombre;

              

              /* echo '<li class="'.$isParent.'"><a href="javascript:void(0)" 
                           onClick = "Tab.newTab(\''.$modulo->nombre.'\',base_url+\''.$modulo->url.'\', \''.$modulo->url.'\' );">'.$modulo->nombre.'
                         </a>';
                         if($isParent == 'parent'){
                           echo '<ul>';
                            foreach($modulo->modulo->all as $submodulo){
                                if(in_array($submodulo->nombre,$aSubmodulo)){
                                  
                                      echo '<li>
                                               <a href="javascript:void(0)"
                                                   onClick = "Tab.newTab(\''.$submodulo->nombre.'\',base_url+\''.$submodulo->url.'\', \''.$submodulo->url.'\' );">'.$submodulo->nombre.'
                                                </a>
                                            </li>'; 
                                }
                            }
                            echo '</ul>';
                         }

               echo '</li>';*/
            }
            print_r($aModulos);
         ?>
   </nav>
</div>