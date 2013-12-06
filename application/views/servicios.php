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
<?php
        $aMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julil","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $citas = new Reunion();

        $citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
                            'estatus'        => 1));
        
        $citas->order_by('TIMESTAMPDIFF(MINUTE,fecha_hora,now()) DESC');   
        $citas->limit('5');
        $citas->get();

?>  

   <div>
        <input id="ac-2" name="accordion-1" type="radio"/>
        <label for="ac-2"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Citas</label>
        <article>
         <?php

             foreach($citas->all  as  $cita){

                $cita->paciente->get();
                $cita->empleado->get();

                $patient = $cita->paciente->nombre." ".$cita->paciente->apellido_p." ".$cita->paciente->apellido_m;
                $doctor  = $cita->empleado->nombre." ".$cita->empleado->apellido_p." ".$cita->empleado->apellido_m;
                $date    = date("d", strtotime($cita->fecha_hora)) ." de ". 
                           $aMeses[date("m", strtotime($cita->fecha_hora)) - 1] ." del ".
                           date("Y", strtotime($cita->fecha_hora));
                $hour    = date("H:i", strtotime($cita->fecha_hora));        
        ?>

    <section class="cita-stilo">
    <div id="div-banner">
        <div id="prox-cita">
            <div id="datetime">
                <p id="date"><?= $date; ?></p>
                <p id="time"><?= $hour; ?></p> 
            </div>
            <div id="">
                <div id="detail">
                    <p>Doctor   <strong><?= $doctor; ?></strong></p>
                    <p>Paciente <strong><?= $patient; ?></strong></p>
                </div>
            </div>
        </div>
        <div id="doctors">
        </div>
    </div>
</section>
<?php
}
?>
   </article>
   </div>


    
</section>