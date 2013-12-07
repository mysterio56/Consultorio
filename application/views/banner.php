<section class="banner-container" onClick="Banner.showHide();">
	<div id="div-banner">
		<div id="prox-cita">
			<div id="head-cita">
				<p>PRÓXIMA CITA</p>
			</div>
			<?php  if(!empty($prox_cita->all)): ?>
			<div id="datetime">
				<?php 

					$prox_cita->paciente->get();
					$prox_cita->empleado->get();

					$prox_patient = $prox_cita->paciente->nombre.' '.$prox_cita->paciente->apellido_p.' '.$prox_cita->paciente->apellido_m;
					$prox_doctor  = $prox_cita->empleado->nombre.' '.$prox_cita->empleado->apellido_p.' '.$prox_cita->empleado->apellido_m;
					$prox_fecha   = date("d", strtotime($prox_cita->fecha_hora)) .' de '.
									month((date("m", strtotime($prox_cita->fecha_hora))-1), true).' del '.
									date("Y", strtotime($prox_cita->fecha_hora));
					$prox_hora    = date("H:i", strtotime($prox_cita->fecha_hora));

				?>
				<p id="date"><?= $prox_fecha; ?></p>
				<p id="time"><?= $prox_hora; ?></p>	
			</div>
			<div id="detail-cita">
				<div id="detail-1">
					<p>Doctor</p>
					<p>Paciente</p>
				</div>
				<div id="detail-2">
					<p><?=  $prox_doctor; ?></p>
					<p><?= $prox_patient; ?></p>
				</div>
			</div>
			<div id="detail-cita-small" class="hide">
				<div id="detail">
					<p>Doctor <strong><?= $prox_doctor; ?></strong></p>
					<p>Paciente <strong><?= $prox_patient; ?></strong></p>
				</div>
			</div>

		<?php else: ?>
			<div id="proxCitaEmpty" style="padding:7px">
				<p> No hay citas para mostrar </p>
			</div>
		<?php endif; ?>

		</div>
		<div id="doctors">
		</div>
	</div>
</section>