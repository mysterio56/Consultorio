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
           

        $citas = new Reunion();

        $citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
                            'estatus'        => 1));
        $citas->order_by('ABS(TIMESTAMPDIFF(MINUTE,fecha_hora,now())) ASC');   
        $citas->Limit('5');
        $citas->get();
        foreach($citas->all as $cita){
            $cita->paciente->get();
            $cita->empleado->get();
       }

         ?>   

    <section class="cita-stilo">

            <div id="datetime">
        
                <p id="time"><?php echo $hour = $citas->fecha_hora;?></p> 
                <br>
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
            <div id="detail-cita-small" class="hide">
                <div id="detail">
                    <p>Doctor <strong><?php echo $doctor    = $cita->empleado->nombre; ?></strong></p>
                    <p>Paciente <strong><?php echo $patient   = $cita->paciente->nombre; ?></strong></p>
                </div>
            </div>
        </div>
        <div id="doctors">
        </div>
    </div>
</section>
          

      
    
            


















     </article>
    </div>

<!--.<div>
        <input id="ac-3" name="accordion-1" type="radio" />
        <label for="ac-3"> <img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Caja</label>
        <article>
            <p>Lorem ipsum dolor sit amet, usu quando dicant eu, admodum instructior an per. Te sed dolor fabulas, mel adipisci temporibus ad, eligendi scriptorem referrentur ne sea. Ei nam aliquip reformidans. Option vivendo patrioque te mel, nulla percipit elaboraret vel eu, augue aeterno qualisque an per. Mel ex agam phaedrum, ei nonumy equidem cum.

Quo ex mediocrem theophrastus, id his placerat rationibus. Habeo porro animal sea cu, sed eius legere invidunt ea. Everti melius et nec, eum ullamcorper signiferumque et, vim in simul pertinax. Nec fugit ridens similique at, pro ea affert mnesarchum, ex enim deleniti vix. Patrioque definitionem has te.

No nam clita iudico recusabo, omittam noluisse ei qui. Usu novum exerci at. Ei autem vituperata mea, ex prima integre deterruisset sit. Eu vel omittam noluisse, eu his atqui numquam consulatu, porro affert decore cum et. Sit ea vocibus perpetua, ea eos fabellas electram.

Eam no noster noluisse periculis, audire delicata mea in. Expetenda evertitur ut cum, pro in facilisis salutatus, cu sed duis quando audire. Officiis complectitur at sea. Mea luptatum adolescens ei, eu mea lobortis aliquando. Ex vis cibo consul.

Eum lorem quidam legendos cu, ei usu scaevola reformidans. No deserunt conceptam per, an simul dissentiet vituperatoribus eum. Sanctus mediocrem ne duo, nam sonet dicunt splendide ei. Aliquam veritus usu ad, principes intellegat in est, mei nominavi sapientem gubergren no.</p>
        </article>
    </div>
    <div>
        <input id="ac-4" name="accordion-1" type="radio" />
        <label for="ac-4"> <img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Notas</label>
        <article>
            <p>Lorem ipsum dolor sit amet, usu quando dicant eu, admodum instructior an per. Te sed dolor fabulas, mel adipisci temporibus ad, eligendi scriptorem referrentur ne sea. Ei nam aliquip reformidans. Option vivendo patrioque te mel, nulla percipit elaboraret vel eu, augue aeterno qualisque an per. Mel ex agam phaedrum, ei nonumy equidem cum.

Quo ex mediocrem theophrastus, id his placerat rationibus. Habeo porro animal sea cu, sed eius legere invidunt ea. Everti melius et nec, eum ullamcorper signiferumque et, vim in simul pertinax. Nec fugit ridens similique at, pro ea affert mnesarchum, ex enim deleniti vix. Patrioque definitionem has te.

No nam clita iudico recusabo, omittam noluisse ei qui. Usu novum exerci at. Ei autem vituperata mea, ex prima integre deterruisset sit. Eu vel omittam noluisse, eu his atqui numquam consulatu, porro affert decore cum et. Sit ea vocibus perpetua, ea eos fabellas electram.

Eam no noster noluisse periculis, audire delicata mea in. Expetenda evertitur ut cum, pro in facilisis salutatus, cu sed duis quando audire. Officiis complectitur at sea. Mea luptatum adolescens ei, eu mea lobortis aliquando. Ex vis cibo consul.

Eum lorem quidam legendos cu, ei usu scaevola reformidans. No deserunt conceptam per, an simul dissentiet vituperatoribus eum. Sanctus mediocrem ne duo, nam sonet dicunt splendide ei. Aliquam veritus usu ad, principes intellegat in est, mei nominavi sapientem gubergren no.</p>
        </article>
    </div>
    <div></div>.-->
</section>