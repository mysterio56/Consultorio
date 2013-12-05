<section class="ac-container">
<?php

    $warning = false;
    $days    = 123;

    if($days <= 10 ){
        $warning = true;
    }
    
?>

        <div id="renew">
            <!--<input id="submit-renew" type="button" value="RENOVAR AHORA" />-->
            <p class="<?= $warning?'error':''; ?>" >Quedan <strong><?= $days ?></strong> días para renovar su licencia</p>
            <a class="abutton" href="http://masqweb.com/" target="_blank">Renovar ahora</a>
        </div>

    <div>
        <p class="ac-title">Servicios varios</p>
    </div>
    <div>
        <input id="ac-1" name="accordion-1" type="radio" checked/>
        <label for="ac-1"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Lo nuevo</label>
        <article>
         <a class="twitter-timeline" 
         href="https://twitter.com/Masqweb" 
         data-widget-id="408349543822934017">Tweets por @Masqweb
        </a>
      <script>!function(d,s,id)
      {
        var js,fjs=d.getElementsByTagName(s)[0],
        p=/^http:/.test(d.location)?'http':'https';
        if(!d.getElementById(id)){js=d.createElement(s);
            js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js,fjs);
        }
    }
    (document,"script","twitter-wjs");
    </script>
   </article>
   </div>


    <div>
        <input id="ac-2" name="accordion-1" type="radio" />
        <label for="ac-2"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Citas</label>
        <article>
             <?php
           $aMeses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

        $citas = new Reunion();

        $citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
                            'estatus'        => 1));
        
        $citas->order_by('ABS(TIMESTAMPDIFF(MINUTE,fecha_hora,now())) ASC');   
        $citas->Limit('5');
        $citas->get();

        foreach($citas->all  as  $cita){
            $cita->paciente->get();
            $cita->empleado->get();

            $cita->paciente->nombre." ".$cita->paciente->apellido_p." ".$cita->paciente->apellido_m;
            $cita->empleado->nombre." ".$cita->empleado->apellido_p." ".$cita->empleado->apellido_m;
            $cita->fecha_hora;
                              date("d", strtotime($cita->fecha_hora)) ." ". 
                              $aMeses[date("m", strtotime($cita->fecha_hora)) - 1] ." ".
                              date("H", strtotime($cita->fecha_hora)) .":".
                              date("i", strtotime($cita->fecha_hora));
                              date("d/m/Y H:i", strtotime($cita->fecha_hora));
                                        

         ?>  
         

    <section class="cita-stilo">
    <div id="div-banner">
        <div id="prox-cita">
            <div id="datetime">
                <p id="date"><?php echo $date =  $cita->fecha_hora; ?></p>
                <p id="time"><?php echo $hour = $cita->fecha_hora;  ?></p> 
            </div>
            <div id="detail-cita">
                <div id="detail-1">
                    <p>Doctor</p>
                    <p>Paciente</p>
                </div>
                <div id="detail-2">
                    <p><?php echo $doctor  = $cita->empleado->nombre; ?></p>
                    <p><?php echo $patient = $cita->paciente->nombre; ?></p>
                </div>
            </div>
            <div id="detail-cita-small">
                <div id="detail">
                    <p>Doctor <strong><?php echo $doctor    = $cita->empleado->nombre; ?></strong></p>
                    <p>Paciente <strong><?php echo $patient  = $cita->paciente->nombre; ?></strong></p>
                    <div id="doctors">
        </div>
    
                </div>
            </div>
      
        
</div>
</article>
</section>

</div>
<?php
}
?>
</section>