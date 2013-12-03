<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Paciente</th>
				<th>Doctor</th>
				<th>Servicio</th>
				<th>Fecha y hora</th>
				<th>Estatus</th>
				<?php if ($permisosSub): ?>
					<th>Acciones</th>
				<?php elseif(in_array($permisos,$aPermisos['Editar'])): ?>
					<th>Acciones</th>
				<?php endif; ?>


			</tr>
		</thead>
		<tbody>
			<?php 
				$nRow = 1;
				foreach($citas as $cita){

					$cita->paciente->get();
					$cita->empleado->get();
					$cita->servicio->get();

					if (($nRow % 2) == 0) {
						$rowClass = "even";
					} else {
						$rowClass = "odd";
					}

					echo '<tr class='.$rowClass.'>';
						echo '<td>'.$cita->paciente->nombre.' '.$cita->paciente->apellido_p .' '.$cita->paciente->apellido_m.'</td>';
						echo '<td>'.$cita->empleado->nombre.' '.$cita->empleado->apellido_p .' '.$cita->empleado->apellido_m.'</td>';
					    echo '<td>'.$cita->servicio->nombre.'</td>';
						echo '<td>'.date("d", strtotime($cita->fecha_hora)) .' '. 
									$aMeses[date("n", strtotime($cita->fecha_hora))-1]. 
									//.'/'. date("Y", strtotime($cita->fecha_hora)) 
									' '. date("H:i", strtotime($cita->fecha_hora)).
							 '</td>';
						echo '<td>';

						if(in_array($permisos,$aPermisos['Editar'])){ 
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" id="estatus_'.$cita->id.'" style="cursor:pointer" width="25" height="25" onclick="createTooltip('.$cita->id.' , '.$cita->estatus.', \''.date("d/m/Y H:i", strtotime($cita->fecha_hora)).'\')">';
							echo '<img src="'.base_url('assets/images/wait.gif').'" id="wait_'.$cita->id.'" width="25" height="25" style="display:none">';
						} else {
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" width="25" height="25" >';
						}

						echo '</td>';


						if ($permisosSub){

							echo '<td>';
								if(in_array($permisos,$aPermisos['Editar'])){ 
									echo '<img src="'.base_url('assets/images/edit.png').'" width="25" height="25" >';
								}
								if (isset($permisosSub['Histórico'])){
									echo '<img src="'.base_url('assets/images/history.jpg').'" id="historia_'.$cita->id.'"  width="25" height="25" onclick="createTooltipHistoria('.$cita->id.')">';
								}
								if (isset($permisosSub['Adicionales'])){
									echo '<img src="'.base_url('assets/images/add.png').'" width="25" height="25" >';
								}
								if (isset($permisosSub['Costo'])){
									echo '<img src="'.base_url('assets/images/money.png').'" width="25" height="25" >';
								}
							echo '</td>';

						} else {

								if(in_array($permisos,$aPermisos['Editar'])){ 
									echo '<td>';
									echo '<img src="'.base_url('assets/images/edit.png').'" width="25" height="25" >';
									echo '</td>';
								}

						}	

					echo '</tr>';
					$nRow++;
				}
			?>
		</tbody>
		<?php if($citas->paged->total_pages > 1): ?>
			<tfoot>
				<tr>
					<td colspan="100%">
						<div id="paging">
							<ul>
								<?php if($citas->paged->has_previous): ?>
									<li>
										<a href="<?= base_url('appointment/index/1/'.$estatusActual); ?>">
											<span>Inicio</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->previous_page.'/'.$estatusActual); ?>">
											<span>Anterior</span>
										</a>
									</li>
								<?php endif; ?>

								<?php 
									for($x = 1; $x <= $citas->paged->total_pages; $x++): 
										if($paginaActual == $x){
											$pagActiva = 'active';
										} else {
											$pagActiva = '';
										}
								?>
											<li>
												<a href="<?= base_url('appointment/index/'.$x.'/'.$estatusActual); ?>" class="<?= $pagActiva ?>">
													<span><?= $x; ?></span>
												</a>
											</li>
								<?php endfor; ?>

								<?php if($citas->paged->has_next): ?>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->next_page.'/'.$estatusActual); ?>">
											<span>Siguiente</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('appointment/index/'.$cita->paged->total_pages.'/'.$estatusActual); ?>">
											<span>Fin</span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</tr>
				</tfoot>
		<?php endif; ?>
	</table>
</section>


	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>
		<a class="abutton" href="<?= base_url('appointment/agregar') ?>">Agregar</a>
	<?php endif; ?>

<script>

$.noConflict();

	var myControl=  {
		create: function(tp_inst, obj, unit, val, min, max, step){
			$('<input class="ui-timepicker-input" value="'+val+'" style="width:50%">')
				.appendTo(obj)
				.spinner({
					min: min,
					max: max,
					step: step,
					change: function(e,ui){ // key events
							// don't call if api was used and not key press
							if(e.originalEvent !== undefined)
								tp_inst._onTimeChange();
							tp_inst._onSelectHandler();
						},
					spin: function(e,ui){ // spin events
							tp_inst.control.value(tp_inst, obj, unit, ui.value);
							tp_inst._onTimeChange();
							tp_inst._onSelectHandler();
						}
				});
			return obj;
		},
		options: function(tp_inst, obj, unit, opts, val){
			if(typeof(opts) == 'string' && val !== undefined)
				return obj.find('.ui-timepicker-input').spinner(opts, val);
			return obj.find('.ui-timepicker-input').spinner(opts);
		},
		value: function(tp_inst, obj, unit, val){
			if(val !== undefined)
				return obj.find('.ui-timepicker-input').spinner('value', val);
			return obj.find('.ui-timepicker-input').spinner('value');
		}
	};

	base_url = "<?= base_url(); ?>";
	date_now = "<?= date('D M d Y H:i:s O'); ?>";
	date_now = new Date(date_now);

function createTooltip(id_cita, estatus, fecha){ 

	/*new Tip('estatus_'+id_cita, {
			    title : 'Actualizar estatus',
				//target: $('estatus').up('li'),
				ajax: {
					url: base_url+'appointment/estatus/'+id_cita,
					options: {
						onComplete: function(transport) {
							
						}
					}
				},
				closeButton: true,
				hideOn: { element: '.close', event: 'click' },
				showOn: 'click',
				width: '120', 
				hook: { target: 'bottomMiddle', tip: 'topRight' },
				stem: 'topRight',
				offset: { x: 6, y: 3 }
			});*/ 
Tips.hideAll();
new Tip('estatus_'+id_cita, new Element('div').update(elementEstatus(id_cita,estatus,fecha)), {
			    title : 'Actualizar estatus',
				closeButton: true,
				hideOn: { element: '.close', event: 'click' },
				showOn: 'click',
				width: '130', 
				hook: { target: 'bottomMiddle', tip: 'topRight' },
				stem: 'topRight',
				offset: { x: 6, y: 3 }
			});

	$('estatus_'+id_cita).prototip.show();


}

function elementEstatus(id_cita, estatus, fecha){

	element = "";

 	if (estatus != 1){
 		element += '<img src="'+base_url+'/assets/images/yellow_point.png" onclick="showDate('+id_cita+',1);" width="25" height="25" style="cursor:pointer"/>'
 	}
 	if (estatus != 2){
 		element += '<img src="'+base_url+'/assets/images/green_point.png" onclick="changeEstatus('+id_cita+',2)" width="25" height="25" style="cursor:pointer"/>'
 	}
 	if (estatus != 3){
 		element += '<img src="'+base_url+'/assets/images/red_point.png" onclick="changeEstatus('+id_cita+',3)" width="25" height="25" style="cursor:pointer"/>'
 	}
 	if (estatus != 4){
 		element += '<img src="'+base_url+'/assets/images/orange_point.png" onclick="changeEstatus('+id_cita+',4)" width="25" height="25" style="cursor:pointer"/>'
 	}

 	if(estatus != 1){
 		element += '<input type="text" id="dateChange" value="'+fecha+'" style="display:none;width:120px;">';
 		element += '<input type="hidden" id="fecha_alt" style="display:none;width:120px;">';
 	}

	return element;

} 

function showDate(id_cita, estatus){

	jQuery('#dateChange').show();

	jQuery('#dateChange').datetimepicker({
			//controlType: myControl,
			altField: "#fecha_alt",
			altFieldTimeOnly: false,
			altFormat: "yy-mm-dd",
			altTimeFormat: "HH:mm",
			onClose: function(selectedDate,objDate,objTime) {

				var dateMS = new Date(objDate.selectedYear,objDate.selectedMonth,objDate.selectedDay,objTime.hour,objTime.minute).getTime();

				changeEstatus(id_cita, estatus, dateMS);

      		},
			timeText: '',
			hourText: 'Hora',
			minuteText: 'Minuto',
			currentText: 'Fecha actual',
			closeText: 'Aceptar',
			minDate: date_now
		});
}


function createTooltipHistoria(id_cita){ 

	new Tip('historia_'+id_cita, {
			    title : 'Historia de la cita',
				//target: $('estatus').up('li'),
				ajax: {
					url: base_url+'appointment/historia/'+id_cita,
					options: {
						onComplete: function(transport) {
							
						}
					}
				},
				closeButton: true,
				hideOn: { element: '.close', event: 'click' },
				showOn: 'click',
				width: '200', 
				hook: { target: 'bottomMiddle', tip: 'topRight' },
				stem: 'topRight',
				offset: { x: 6, y: 3 }
			});

	$('historia_'+id_cita).prototip.show();

}

	//});

function changeEstatus(id_cita, estatus, fecha){

	Tips.hideAll();
	jQuery('#wait_'+id_cita).show();
	jQuery('#estatus_'+id_cita).hide();

	var url = base_url + "appointment/estatus/"+id_cita+"/"+estatus+"/"+fecha ;

	jQuery.getJSON( url, function( data ) {
		console.log(data);
		jQuery('#wait_'+id_cita).hide();
		jQuery('#estatus_'+id_cita).show();
		jQuery('#estatus_'+id_cita).attr('src',base_url+"assets/images/"+data.estatus+"_point.png");

		if(data.estatus == 'yellow'){

		 var d = new Date(data.fecha);
		 console.log(d.toString());
        var curr_date = d.getDate();

	    var curr_month = d.getMonth() + 1; //Months are zero based
	    var curr_year = d.getFullYear();
	    console.log(curr_date);
	    console.log(curr_month);
	    console.log(curr_year);
}

		if(data.error){
			alert(data.error);
		}

	});
	

}


</script>