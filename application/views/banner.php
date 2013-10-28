<section class="banner-container" onClick="Banner.showHide();">
	<div id="div-banner">
		<div id="prox-cita">
			<div id="head-cita">
				<p>PRÓXIMA CITA</p>
			</div>
			<div id="datetime">
				<p id="date"><?php echo $date = "18 de Septiembre del 2013"; ?></p>
				<p id="time"><?php echo $hour = "13:24"; ?></p>	
			</div>
			<div id="detail-cita">
				<div id="detail-1">
					<p>Doctor</p>
					<p>Paciente</p>
				</div>
				<div id="detail-2">
					<p><?php echo $doctor  = "Francisco Javier Sánchez Rosales"; ?></p>
					<p><?php echo $patient = "Stefania Arroyo Luna"; ?></p>
				</div>
			</div>
			<div id="detail-cita-small" class="hide">
				<div id="detail">
					<p>Doctor <strong><?php echo $doctor    = "Francisco Javier Sánchez Rosales"; ?></strong></p>
					<p>Paciente <strong><?php echo $patient   = "Stefania Arroyo Luna"; ?></strong></p>
				</div>
			</div>
		</div>
		<div id="doctors">
		</div>
	</div>
</section>