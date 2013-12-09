<section class="banner-container" onClick="Banner.showHide();">
	<div id="div-banner">
		<div id="prox-cita">
			<div id="head-cita">
				<p>PRÓXIMA CITA</p>
			</div>
			<div id="datetime">
				<p id="date_prox"></p>
				<p id="time_prox"></p>	
			</div>
			<div id="detail-cita">
				<div id="detail-1">
					<p>Doctor</p>
					<p>Paciente</p>
				</div>
				<div id="detail-2">
					<p id="doctor_prox"></p>
					<p id="paciente_prox"></p>
				</div>
			</div>
			<div id="detail-cita-small" class="hide">
				<div id="detail">
					<p>Doctor <strong id="doctor_prox_s"></strong></p>
					<p>Paciente <strong id="paciente_prox_s"></strong></p>
				</div>
			</div>

			<div id="proxCitaEmpty" style="padding:7px;display:none">
				<p> No hay citas para mostrar </p>
			</div>

		</div>
		
	</div>
</section>

<script>
    $(function(){

        base_url = "<?= base_url(); ?>";
        getProxCitasBanner();

        setInterval(function(){
            getProxCitasBanner();
        },60000);

    });

    function getProxCitasBanner(){

        $.getJSON( base_url+"appointment/prox_citas", function( data ) {
    
            if(!data.empty){

            	$('#proxCitaEmpty').hide();
            	$('#datetime').show();

            	$('#date_prox').html(data[0].fecha);
            	$('#time_prox').html(data[0].hora);
            	$('#doctor_prox').html(data[0].doctor);
            	$('#paciente_prox').html(data[0].paciente);
            	$('#doctor_prox_s').html(data[0].doctor);
            	$('#paciente_prox_s').html(data[0].paciente);
            	
            } else {

            	$('#proxCitaEmpty').show();
            	$('#datetime').hide();
            	$('#detail-cita').hide();
            	$('#detail-cita-small').hide();
       
            }
               
        });

    }

</script>
