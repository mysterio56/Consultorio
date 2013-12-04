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
						echo '<td><div id="fecha_'.$cita->id.'" >'
									.date("d", strtotime($cita->fecha_hora)) .' '. 
									$aMeses[date("n", strtotime($cita->fecha_hora))-1]. 
									//.'/'. date("Y", strtotime($cita->fecha_hora)) 
									' '. date("H:i", strtotime($cita->fecha_hora)).
							 '</div></td>';
						echo '<td>';

						if(in_array($permisos,$aPermisos['Editar'])){ 
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" id="estatus_'.$cita->id.'" style="cursor:pointer" width="25" height="25" onclick="createTooltip('.$cita->id.' , '.$cita->estatus.', \''.date("d/m/Y H:i", strtotime($cita->fecha_hora)).'\')">';
							echo '<img src="'.base_url('assets/images/wait.gif').'" id="wait_'.$cita->id.'" width="25" height="25" style="display:none">';
						} else {
							echo '<img src="'.base_url('assets/images/'.estatus($cita->estatus).'_point.png').'" width="25" height="25" >';
							echo '<img src="'.base_url('assets/images/wait.gif').'" id="wait_'.$cita->id.'" width="25" height="25" style="display:none">';
						}

						if($cita->estatus==1){
							echo '<input type="hidden" class="input_cita" value="'.$cita->id.'" />';
						}

						echo '</td>';


						if ($permisosSub){

							echo '<td>';
								if(in_array($permisos,$aPermisos['Editar'])){ 
									echo '<a href="'.base_url('appointment/editar/'.$cita->id).'">';
									echo '<img src="'.base_url('assets/images/edit.png').'" width="25" height="25" >';
									echo '</a>';
								}

								if (isset($permisosSub['Histórico'])){
									echo '<img src="'.base_url('assets/images/history.jpg').'" id="historia_'.$cita->id.'"  width="25" height="25" onclick="createTooltipHistoria('.$cita->id.')">';
								}
								if (isset($permisosSub['Adicionales'])){
									echo '<a href="'.base_url('appointment/adicional/'.$cita->id).'"/>';
									echo '<img src="'.base_url('assets/images/add.png').'" width="25" height="25" >';
									echo '</a>';
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

setInterval(function(){
	changeAutoEstatus();
},300000);

jQuery(function(){

	changeAutoEstatus();
	
});

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

		if($('estatus_'+id_cita).prototip){
			$('estatus_'+id_cita).prototip.remove();
		}

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
 		element += '<input type="text" id="dateChange_'+id_cita+'" value="'+fecha+'" style="display:none;width:120px;">';
 		element += '<input type="hidden" id="fecha_alt_'+id_cita+'" style="display:none;width:120px;">';
 	}

	return element;

} 

function showDate(id_cita, estatus){

	jQuery('#dateChange_'+id_cita).show();

	jQuery('#dateChange_'+id_cita).datetimepicker({
			//controlType: myControl,
			altField: "#fecha_alt_"+id_cita,
			altFieldTimeOnly: false,
			altFormat: "yy-mm-dd",
			altTimeFormat: "HH:mm",
			onClose: function(selectedDate,objDate,objTime) {

				var dateMS = new Date(objDate.selectedYear,objDate.selectedMonth,objDate.selectedDay,objTime.hour,objTime.minute).getTime();

				changeEstatus(id_cita, estatus, dateMS);

      		},
			timeText:    '',
			hourText:    'Hora',
			minuteText:  'Minuto',
			currentText: 'Fecha actual',
			closeText:   'Aceptar',
			minDate:     date_now
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

function changeEstatus(id_cita, estatus, fecha){

	Tips.hideAll();
	jQuery('#wait_'+id_cita).show();
	jQuery('#estatus_'+id_cita).hide();

	var url = base_url + "appointment/estatus/"+id_cita+"/"+estatus+"/"+fecha ;

	jQuery.getJSON( url, function( data ) {

		jQuery('#wait_'+id_cita).hide();
		jQuery('#estatus_'+id_cita).show();
		jQuery('#estatus_'+id_cita).attr('src',base_url+"assets/images/"+data.estatus+"_point.png");

		var d = new Date(data.fecha);

		var month=new Array();
			month[0]  = "Ene";
			month[1]  = "Feb";
			month[2]  = "Mar";
			month[3]  = "Abr";
			month[4]  = "May";
			month[5]  = "Jun";
			month[6]  = "Jul";
			month[7]  = "Ago";
			month[8]  = "Sep";
			month[9]  = "Oct";
			month[10] = "Nov";
			month[11] = "Dic";

		var date   = ("0" + d.getDate()).slice(-2)+"/"+d.getMonth()+"/"+d.getFullYear()+" "+d.getHours()+":"+("0" + d.getMinutes()).slice(-2);
		var date_g = ("0" + d.getDate()).slice(-2)+" "+month[d.getMonth()]+" "+d.getHours()+":"+("0" + d.getMinutes()).slice(-2);
		    
		jQuery('#estatus_'+id_cita).attr('onClick', 'createTooltip('+id_cita+','+data.nEstatus+', "'+date+'")');


		if(data.nEstatus == 1){

			jQuery('#fecha_'+id_cita).html(date_g);

		}

		if(data.error){

			alert(data.error);

		}

	});
	

}

function changeAutoEstatus(){

	jQuery.each(jQuery('.input_cita') , function(key, input){

		var url = base_url + "appointment/estatusAuto/"+jQuery(input).val();

		jQuery('#wait_'+jQuery(input).val()).show();
		jQuery('#estatus_'+jQuery(input).val()).hide();

		jQuery.getJSON( url, function( data ) {

 			jQuery('#wait_'+jQuery(input).val()).hide();
			jQuery('#estatus_'+jQuery(input).val()).show();
			jQuery('#estatus_'+jQuery(input).val()).attr('src',base_url+"assets/images/"+data.estatus+"_point.png");

			var d = new Date(data.fecha);

			var date   = ("0" + d.getDate()).slice(-2)+"/"+d.getMonth()+"/"+d.getFullYear()+" "+d.getHours()+":"+("0" + d.getMinutes()).slice(-2);

			jQuery('#estatus_'+jQuery(input).val()).attr('onClick', 'createTooltip('+jQuery(input).val()+','+data.nEstatus+', "'+date+'")');

			if(data.error){

				alert(data.error);

			}

 		});
	});
	

}

</script>