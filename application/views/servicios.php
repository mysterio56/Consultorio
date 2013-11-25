<section class="ac-container">
<?php

    $warning = false;
    $days    = 10;

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
            <p>Lorem ipsum dolor sit amet, usu quando dicant eu, admodum instructior an per. Te sed dolor fabulas, mel adipisci temporibus ad, eligendi scriptorem referrentur ne sea. Ei nam aliquip reformidans. Option vivendo patrioque te mel, nulla percipit elaboraret vel eu, augue aeterno qualisque an per. Mel ex agam phaedrum, ei nonumy equidem cum.

Quo ex mediocrem theophrastus, id his placerat rationibus. Habeo porro animal sea cu, sed eius legere invidunt ea. Everti melius et nec, eum ullamcorper signiferumque et, vim in simul pertinax. Nec fugit ridens similique at, pro ea affert mnesarchum, ex enim deleniti vix. Patrioque definitionem has te.

No nam clita iudico recusabo, omittam noluisse ei qui. Usu novum exerci at. Ei autem vituperata mea, ex prima integre deterruisset sit. Eu vel omittam noluisse, eu his atqui numquam consulatu, porro affert decore cum et. Sit ea vocibus perpetua, ea eos fabellas electram.

Eam no noster noluisse periculis, audire delicata mea in. Expetenda evertitur ut cum, pro in facilisis salutatus, cu sed duis quando audire. Officiis complectitur at sea. Mea luptatum adolescens ei, eu mea lobortis aliquando. Ex vis cibo consul.

Eum lorem quidam legendos cu, ei usu scaevola reformidans. No deserunt conceptam per, an simul dissentiet vituperatoribus eum. Sanctus mediocrem ne duo, nam sonet dicunt splendide ei. Aliquam veritus usu ad, principes intellegat in est, mei nominavi sapientem gubergren no.</p>
        </article>
    </div>
    <div>
        <input id="ac-2" name="accordion-1" type="radio" />
        <label for="ac-2"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Citas</label>
        <article>
            <p>Lorem ipsum dolor sit amet, usu quando dicant eu, admodum instructior an per. Te sed dolor fabulas, mel adipisci temporibus ad, eligendi scriptorem referrentur ne sea. Ei nam aliquip reformidans. Option vivendo patrioque te mel, nulla percipit elaboraret vel eu, augue aeterno qualisque an per. Mel ex agam phaedrum, ei nonumy equidem cum.

Quo ex mediocrem theophrastus, id his placerat rationibus. Habeo porro animal sea cu, sed eius legere invidunt ea. Everti melius et nec, eum ullamcorper signiferumque et, vim in simul pertinax. Nec fugit ridens similique at, pro ea affert mnesarchum, ex enim deleniti vix. Patrioque definitionem has te.

No nam clita iudico recusabo, omittam noluisse ei qui. Usu novum exerci at. Ei autem vituperata mea, ex prima integre deterruisset sit. Eu vel omittam noluisse, eu his atqui numquam consulatu, porro affert decore cum et. Sit ea vocibus perpetua, ea eos fabellas electram.

Eam no noster noluisse periculis, audire delicata mea in. Expetenda evertitur ut cum, pro in facilisis salutatus, cu sed duis quando audire. Officiis complectitur at sea. Mea luptatum adolescens ei, eu mea lobortis aliquando. Ex vis cibo consul.

Eum lorem quidam legendos cu, ei usu scaevola reformidans. No deserunt conceptam per, an simul dissentiet vituperatoribus eum. Sanctus mediocrem ne duo, nam sonet dicunt splendide ei. Aliquam veritus usu ad, principes intellegat in est, mei nominavi sapientem gubergren no.</p>
        </article>
    </div>
    <div>
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
    <div><!--...--></div>
</section>