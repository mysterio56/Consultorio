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

               $isParent = '';

              foreach($modulo->modulo->all as $submodulo){
                if(in_array($submodulo->nombre,$aSubmodulo)){
                    $isParent = 'parent';                  
                }
              }

               echo '<li class="'.$isParent.'"><a href="javascript:void(0)" 
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

               echo '</li>';
            }
         ?>
         <!--<li class="parent"><a href="javascript:void(0)">Menu 1</a>
            <ul>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 1','http://www.mercadolibre.com.mx/');">Submenu 1</a></li>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 2','http://www.ibazar.com.mx/');">Submenu 2</a></li>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 3','http://www.sanborns.com.mx/Paginas/Inicio.aspx');">Submenu 3</a></li>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 4','http://www.marke.com.mx');">Submenu 4</a></li>
            </ul>
         </li>
         <li><a href="javascript:void(0)" onClick = "Tab.newTab('Menu 2',base_url+'sistema');">Menu 2</a></li>
         <li><a href="javascript:void(0)" onClick = "Tab.newTab('Menu 3',base_url+'sistema/usuarios');">Menu 3</a></li>
         <li class="parent"><a href="javascript:void(0)">Menu 4</a>
            <ul>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 5','http://masqweb.com');">Submenu 5</a></li>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 6','http://horeb.org.mx/web/');">Submenu 6</a></li>
               <li><a href="javascript:void(0)" onClick = "Tab.newTab('Submenu 7','http://www.desarrolloweb.com/');">Submenu 7</a></li>
            </ul>
         </li>-->
   </nav>
</div>