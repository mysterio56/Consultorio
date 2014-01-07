<?php

define ("PERMISOS", serialize (array("Agregar"  => array(4,5,6,7),
                                         "Editar"   => array(2,3,6,7),
                                         "Eliminar" => array(1,3,5,7)
                                         )
                                  )
        );

 define ("MESES", serialize (array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic")));

	if(isset($cssFiles) && is_array($cssFiles)){
		foreach($cssFiles as $cssFile) {
        	echo '<link href="'.base_url('assets/css/'.$cssFile).'" rel="stylesheet" type="text/css" />';
        } 
    }

    if(isset($jsFiles) && is_array($jsFiles)){
		foreach($jsFiles as $jsFile) {
			echo '<script src="'.base_url('assets/js/'.$jsFile).'" type="text/javascript"></script>';
        }
    }
?>

<div class="screenLoad">
  <div>  
    <img src="<?= base_url('assets/images/Loading.gif'); ?>" width="50" /><label>Procesando...</label>
  </div>  
</div>

<div class="subir">

<?php

    $attributes = array('id' => 'citasForm');
    echo form_open(null,$attributes);

?>

<div class="citas">

    <input id="chk_pas" type="radio" name="estatus_citas" onchange = "page = 1;grid()" class="vis-hidden" value="3" />
    <label class ="radio_citas"  for="chk_pas">Pasadas</label>
    
    <input id="chk_act" checked="true" type="radio" name="estatus_citas" onchange="page = 1;grid();" class="vis-hidden" value="1" />
    <label class ="radio_citas" for="chk_act">Actuales</label>

    <input id="chk_prox" type="radio" name="estatus_citas" onchange = "page = 1;grid();" class="vis-hidden" value="2" />
    <label class ="radio_citas" for="chk_prox">Proximas</label>

    <label> Inicio </label> <label id="l_date_start"> </label> <input type="hidden" id="date_start" name="date_start"/>
    <label> Fin    </label> <label id="l_date_end"> </label> <input type="hidden" id="date_end" name="date_end"/>
    <br />
<?php 
    echo form_label('Paciente: '); 
    $data = array(
                'name'  => 'paciente',
                'id'    => 'paciente',
                'class' => 'color_form',
                'style' => 'width:130px'
            );

    echo form_input($data);

    echo form_label('Doctor: '); 
    $data = array(
                'name'  => 'doctor',
                'id'    => 'doctor',
                'class' => 'color_form',
                'style' => 'width:130px'
            );

    echo form_input($data);

    echo form_label('Servicio: '); 
    $data = array(
                'name'  => 'servicio',
                'id'    => 'servicio',
                'class' => 'color_form',
                'style' => 'width:130px'
            );

    echo form_input($data);
?> 
    <input type="hidden" name="pacienteId" id="pacienteId"/>
    <input type="hidden" name="servicioId" id="servicioId"/>
    <input type="hidden" name="doctorId" id="doctorId"/>
    <label class ="radio_citas" onClick="grid();" >Buscar</label>


</div>

<?php

    echo form_close();

?> 

</div>

<script>

$.noConflict();

base_url = "<?= base_url(); ?>";

jQuery(function() {

    parent.getProxCitas();
    parent.getProxCitasBanner();

    jQuery("#date_start").datepicker({
            buttonImage: base_url+'assets/images/calendar.png',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showOn: 'both',
            onClose: function(selectedDate,objDate) {

                var date2 = jQuery("#date_start").datepicker('getDate', '+1d'); 
                date2.setDate(date2.getDate()+1);

                jQuery( "#date_end" ).datepicker( "option", "minDate", date2 );

                jQuery( "#l_date_start" ).html( selectedDate );
                jQuery('input[name=estatus_citas]').prop('checked', false);
            }

    });

    jQuery("#date_end").datepicker({
            buttonImage: base_url+'assets/images/calendar.png',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showOn: 'both',
            onClose: function(selectedDate,objDate) {

                var date2 = jQuery("#date_end").datepicker('getDate', '-1d'); 
                date2.setDate(date2.getDate()-1);

                jQuery( "#date_start" ).datepicker( "option", "maxDate", date2 );

                jQuery( "#l_date_end" ).html( selectedDate );
                jQuery('input[name=estatus_citas]').prop('checked', false);
            }
    });

        jQuery( "#paciente" ).autocomplete({
            source: base_url + "patient/lista",
            minLength: 1,
                select: function( event, item ) {
                },
                change: function(event, ui) {
                    jQuery("#pacienteId").val(ui.item ? ui.item.Id : "");
                }
        });

        jQuery( "#doctor" ).autocomplete({
            source: base_url + "employees/lista",
            minLength: 1,
                select: function( event, item ) {
                },
                change: function(event, ui) {
                    jQuery("#doctorId").val(ui.item ? ui.item.Id : "");
                }
        });

        jQuery( "#servicio" ).autocomplete({
            source: base_url + "service/lista",
            minLength: 1,
                select: function( event, item ) {
                },
                change: function(event, ui) {
                    jQuery("#servicioId").val(ui.item ? ui.item.Id : "");
                }
        });

});


</script>

<?php   
    $this->load->view($view);   
?>