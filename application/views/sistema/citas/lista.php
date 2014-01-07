<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Paciente</th>
				<th>Doctor</th>
				<th style="width:80px;">Servicio</th>
				<th style="width:80px;">Fecha/hora</th>
				<th style="width:55px;">Estatus</th>
				<th id="thAcciones" style="display:none; width:100px;">Acciones</th>
			</tr>
		</thead>
		<tbody id="tbodyCitas">

		</tbody>
		<tfoot id="tfootCitas">

		</tfoot>
	</table>

	<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>

		<a class="abutton" onclick = "jQuery('.screenLoad').show();"  href="<?= base_url('appointment/agregar') ?>">Agregar</a>

	<?php endif; ?>

	<a class="abutton_cancel" onclick = "jQuery('.screenLoad').show();"  href="<?= base_url('appointment'); ?>" >Cancelar</a>

<script>

base_url = "<?= base_url(); ?>";
date_now = "<?= date('D M d Y H:i:s O'); ?>";
date_now = new Date(date_now);
page     = 1;

setInterval(function(){
	changeAutoEstatus();
},180000);

jQuery(function(){

	grid();
	
});

function grid(){

	if(jQuery( "input[name=estatus_citas]:checked" ).val()){
		jQuery("#date_end").datepicker().val("");
		jQuery("#date_start").datepicker().val("");
		jQuery( "#l_date_start" ).html( "" );
		jQuery( "#l_date_end" ).html( "" );
	}

	Tips.hideAll();
	jQuery('#tbodyCitas').html("");
	jQuery('#wait_grid').show();


	if(!jQuery('#pacienteId').val()){
		jQuery('#paciente').val("");
	}

	if(!jQuery('#doctorId').val()){
		jQuery('#doctor').val("");
	}

	if(!jQuery('#servicioId').val()){
		jQuery('#servicio').val("");
	}

	var form_data = jQuery('#citasForm').serialize();

	jQuery.post( base_url+"appointment/grid/"+page, form_data , 

		function( data ) {

			if(!data.empty){
		
		  		jQuery.each(data.data,function(key,cita){

	                classRow = (key % 2 == 0)?'odd':'even';
		  			rowCita  = '<tr class="'+classRow+'">';
		  			rowCita	+= '<td class ="tdtooltip" tooltip="'+cita.paciente+'">'+cita.paciente+'</td>';
		  			rowCita	+= '<td class ="tdtooltip" tooltip="'+cita.doctor+'">'+cita.doctor+'</td>';
		  			rowCita	+= '<td class ="tdtooltip" tooltip="'+cita.servicio+'">'+cita.servicio+'</td>';
		  			rowCita	+= '<td id="fecha_'+cita.id+'">'+cita.fecha_format+'</td>';

		  			if(cita.editar){

		  				rowCita += '<td><img class    = "ico"';
	                    rowCita +=           'src     = "'+base_url+'assets/images/'+cita.estatus+'_point.png"';
		  				rowCita +=			 'id      = "estatus_'+cita.id+'"';
		  			    rowCita +=	         'onclick = "createTooltip('+cita.id+' , '+cita.nEstatus+', \''+cita.fecha_format2+'\')"';
		  			    rowCita += 			 'title   = "'+getTitle(cita.nEstatus)+'" />';	
		  			    rowCita += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+cita.id+'" class="ico" style="display:none">';
		  				rowCita += '</td>';

		  			}else{

						rowCita += '<td>';
						rowCita += '<img style="width:25px;height:25px;" src="'+base_url+'assets/images/'+cita.estatus+'_point.png" title   = "'+getTitle(cita.nEstatus)+'"/>';
						rowCita += '<img src="'+base_url+'assets/images/wait.gif" id="wait_'+cita.id+'"  style="width:25px;height:25px;display:none">';
						rowCita += '</td>';

		  			}

		  			if(cita.editar || cita.historia || cita.costo || cita.adicionales){
		  				jQuery('#thAcciones').show();

		  				rowCita +=  '<td>'; 

		  				if(cita.editar){
		  					rowCita += '<a href="'+base_url+'appointment/editar/'+cita.id+'">'; 		
		  					rowCita += '<img src="'+base_url+'assets/images/edit.png" class="ico" title="Editar" />';
		  					rowCita += '</a>'; 
	 	  				}

	 	  				if(cita.historia){ 		
		  					rowCita += '<img src="'+base_url+'assets/images/history.jpg" id="historia_'+cita.id+'" onclick="createTooltipHistoria('+cita.id+')" class="ico" title="Historial" />'; 
	 	  				}

	 	  				if(cita.adicionales){
		  					rowCita += '<a href="'+base_url+'appointment/adicional/'+cita.id+'">'; 		
		  					rowCita += '<img src="'+base_url+'assets/images/add.png"  class="ico"  title="Adicionales"/>';
		  					rowCita += '</a>'; 
	 	  				}

	 	  				if(cita.costo){ 		
		  					rowCita += '<img src="'+base_url+'assets/images/money.png" id="costo_'+cita.id+'" onclick="createTooltipCosto('+cita.id+')" class="ico" title="Costo" />'; 
	 	  				}

		  				rowCita += '</td>';
		  			}

		  			rowCita += '</tr>';

		  			if(cita.nEstatus == 1){
		  				rowCita += '<input type="hidden" class="input_cita" value="'+cita.id+'" />';
		  			}

		  			jQuery('#tbodyCitas').append(rowCita);
		  			jQuery('#tfootCitas').html("");

		  		});
				

				if(data.page_total > 1){

					rowFoot = '<tr><td colspan="100%"><div id="paging"><ul>';

					if(data.has_previous){
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage(1);">';
						rowFoot += '<span>Inicio</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.previous_page+');">';
						rowFoot += '<span>Anterior</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
					}

					for (var i=1;i<=data.page_total;i++)
					{ 

						if(data.page_actual == i){
							pagActiva = 'active';
						} else {
							pagActiva = '';
						}

						rowFoot += '<li>';
						rowFoot += '<a class="'+pagActiva+'" onClick="setPage('+i+')" >';
						rowFoot += '<span>'+i+'</span>';
						rowFoot += '</a>';
					}

					if(data.has_next){
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.next_page+');">';
						rowFoot += '<span>Siguiente</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
						rowFoot += '<li>';
						rowFoot += '<a onClick="setPage('+data.page_total+');">';
						rowFoot += '<span>Fin</span>';
						rowFoot += '</a>';
						rowFoot += '</li>';
					}

					rowFoot += '</ul></div></td></tr>';

					jQuery('#tfootCitas').append(rowFoot);
				}

				changeAutoEstatus();

	 		} else {

	 			rowCita = '<tr><td colspan="100%">No hay citas para mostrar </td></tr>';
	 			jQuery('#tbodyCitas').append(rowCita);
	 			jQuery('#tfootCitas').html("");

	 		}

	 		jQuery('#wait_grid').hide();

		}, "json");

}

function setPage(nPage){
	page = nPage;
	grid();
}

function createTooltip(id_cita, estatus, fecha){ 

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

function getTitle(estatus){

	switch(parseInt(estatus))
	{
	case 1:
	  return "Pendiente";
	  break;
	case 2:
	  return "Asistencia";
	  break;
	case 3:
	  return "Inasistencia";
	  break;
	case 4:
	  return "Cancelada";
	  break;
	}

	return estatus;

}	

function elementEstatus(id_cita, estatus, fecha){

	element = "";

 	if (estatus != 1){
 		element += '<img src="'+base_url+'/assets/images/yellow_point.png" onclick="showDate('+id_cita+',1);" class="ico" title="Pendiente" />'
 	}
 	if (estatus != 2){
 		element += '<img src="'+base_url+'/assets/images/green_point.png" onclick="changeEstatus('+id_cita+',2)" class="ico" title="Asistencia" />'
 	}
 	if (estatus != 3){
 		element += '<img src="'+base_url+'/assets/images/red_point.png" onclick="changeEstatus('+id_cita+',3)" class="ico" title="Inasistencia"/>'
 	}
 	if (estatus != 4){
 		element += '<img src="'+base_url+'/assets/images/orange_point.png" onclick="changeEstatus('+id_cita+',4)" class="ico" title="Cancelada"/>'
 	}

 	if(estatus != 1){
 		element += '<input type="text" id="dateChange_'+id_cita+'" value="'+fecha+'" style="display:none;width:120px;">';
 		element += '<input type="hidden" id="fecha_alt_'+id_cita+'" style="display:none;width:120px;">';
 	}

	return element;

} 

function createTooltipHistoria(id_cita){ 

	Tips.hideAll();

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

function createTooltipCosto(id_cita){ 

	Tips.hideAll();

	new Tip('costo_'+id_cita, {
			    title : 'Costo total de la cita',
				ajax: {
					url: base_url+'appointment/costo/'+id_cita,
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

	$('costo_'+id_cita).prototip.show();

}

function showDate(id_cita, estatus){

	var myControl=  {
	create: function(tp_inst, obj, unit, val, min, max, step){
		jQuery('<input class="ui-timepicker-input" value="'+val+'" style="width:50%">')
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


	jQuery('#dateChange_'+id_cita).show();

	jQuery('#dateChange_'+id_cita).datetimepicker({
			controlType: myControl,
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

function changeEstatus(id_cita, estatus, fecha){

	Tips.hideAll();
	jQuery('#wait_'+id_cita).show();
	jQuery('#estatus_'+id_cita).hide();

	var url = base_url + "appointment/estatus/"+id_cita+"/"+estatus+"/"+fecha ;

	jQuery.getJSON( url, function( data ) {

		jQuery('#wait_'+id_cita).hide();
		jQuery('#estatus_'+id_cita).show();
		jQuery('#estatus_'+id_cita).attr('src',base_url+"assets/images/"+data.estatus+"_point.png");
		jQuery('#estatus_'+id_cita).attr('title',getTitle(data.nEstatus));

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

		parent.getProxCitas();
		parent.getProxCitasBanner();

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

			parent.getProxCitas();
			parent.getProxCitasBanner();

 		});
	});
	

}
</script>