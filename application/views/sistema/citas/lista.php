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
				<th id="thAcciones" style="display:none">Acciones</th>
			</tr>
		</thead>
		<tbody id="tbodyCitas">

		</tbody>
	</table>
</section>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>

		<a class="abutton" href="<?= base_url('appointment/agregar') ?>">Agregar</a>

	<?php endif; ?>

<script>

$.noConflict();

base_url = "<?= base_url(); ?>";

jQuery(function(){
 	grid();
});

function grid(){

	jQuery.post( base_url+"appointment/grid", 
		{ 
			estatus_citas: jQuery('input[name=estatus_citas]:checked').val()
		}, 

		function( data ) {

	  		jQuery.each(data,function(key,cita){

                classRow = (key % 2 == 0)?'odd':'even';
	  			rowCita  = '<tr class="'+classRow+'">';
	  			rowCita	+= '<td>'+cita.paciente+'</td>';
	  			rowCita	+= '<td>'+cita.doctor+'</td>';
	  			rowCita	+= '<td>'+cita.servicio+'</td>';
	  			rowCita	+= '<td>'+cita.fecha_format+'</td>';

	  			if(cita.editar){

	  				rowCita += '<td><img style   = "width:25px;height:25px;cursor:pointer;"';
                    rowCita +=           'src     = "'+base_url+'assets/images/'+cita.estatus+'_point.png"';
	  				rowCita +=			 'id      = "estatus_'+cita.id+'"';
	  			    rowCita +=	         'onclick = "createTooltip('+cita.id+' , '+cita.nEstatus+', \''+cita.fecha_format2+'\')" />';
	  				rowCita += '</td>';

	  			}else{

					rowCita += '<td><img style="width:25px;height:25px;" src="'+base_url+'assets/images/'+cita.estatus+'_point.png"/></td>';

	  			}

	  			if(cita.editar || cita.historia || cita.costo || cita.adicionales){
	  				jQuery('#thAcciones').show();

	  				rowCita +=  '<td>'; 

	  				if(cita.editar){
	  					rowCita += '<a href="'+base_url+'appointment/editar/'+cita.id+'">'; 		
	  					rowCita += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
	  					rowCita += '</a>'; 
 	  				}

 	  				if(cita.historia){
	  					//rowCita += '<a href="'+base_url+'appointment/editar/'+cita.id+'">'; 		
	  					//rowCita += '<img src="'+base_url+'assets/images/edit.png" style="width:25px;height:25px;" />';
	  					//rowCita += '</a>'; 
 	  				}

 	  				if(cita.adicionales){
	  					rowCita += '<a href="'+base_url+'appointment/adicional/'+cita.id+'">'; 		
	  					rowCita += '<img src="'+base_url+'assets/images/add.png" style="width:25px;height:25px;" />';
	  					rowCita += '</a>'; 
 	  				}

	  				rowCita +=  '</td>';
	  			}

	  			rowCita +=  '</tr>';

	  			jQuery('#tbodyCitas').append(rowCita);

	  		});

		}, "json");

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

</script>