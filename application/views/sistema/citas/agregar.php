<script>
	$(function(){ Valid.cita(); });
</script>

<?php 

  $attributes = array('id' => 'citaForm');
  	echo form_open(null,$attributes); 
	
	echo '<table class="table_form">';
	echo '<tr>';
		echo'<td>';

			echo form_label('*Campos Requeridos','campo');
		echo'</td>';
	echo '</tr>';
	
	echo '<tr>';
		echo '<td>';
	 		echo form_label('*Paciente:');
	 	
	 	echo '<td>';

		 	$data = array(
		 		'name'  => 'paciente',
		 		'id'    => 'paciente',
		 		'value' => set_value('paciente'),
		 		'style' => 'width:150px'
		 	);

		 	echo form_input($data);
		 		echo '<input type="hidden" name="pacienteId" id="pacienteId"/>';
		echo '</td>';
		echo '</td>';
				
		echo  '<td>';
			echo form_label('*Doctor: ');
		
		echo '<td>';
		$data = array(
		 		'name'  => 'doctor',
		 		'id'    => 'doctor',
		 		'value' => set_value('doctor'),
		 		'style' => 'width:150px'
		 	);
			echo form_input($data);
		 	echo '<input type="hidden" name="doctorId" id="doctorId"/>';
		 	echo '</td>';
		 	echo '</td>';
	echo '</tr>';

	echo '<tr>';
		echo '<td>';
			echo form_label('*Fecha y Hora:');
		
		echo '<td>';

		$data=array(
					'name' =>'fecha' ,
					'id'   =>'fecha' ,
					'value'=>set_value('fecha'),
					'style'=>'width:150px'
					);
		
			echo form_input($data);

		echo '<input type="hidden" name="fecha_alt" id="fecha_alt"/>';

		echo '</td>';
		echo '</td>'; 
	

		echo '<td>';
			echo form_label('*Servicio:');
		echo '<td>';
?>
		<div id="wait_serv" class="wait">
            <p>Cargando servicios</p>
        </div>
			    <div class="select_reload">
			 	<select name="servicioId" id="servicio"></select>
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getServicio();"/>
<?php
		echo '</td>'; 
		echo'</td>';
	echo '</tr>';

	echo'</table>'; 

		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);	

		 	echo '<a href="'.base_url($return).'" onclick = "$(\'.screenLoad\').show();" class="abutton_cancel">Cancelar</a>';
		
		echo form_close();

?>

<script>

base_url = "<?= base_url(); ?>";

$(function () {
	
	getServicio();
	
        $( "#paciente" ).autocomplete({
      	source: base_url + "patient/lista",
      	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#pacienteId").val(ui.item ? ui.item.Id : "");
        	}
    	});

        $( "#doctor" ).autocomplete({
	    source: base_url + "employees/lista",
    	minLength: 2,
      		select: function( event, item ) {
      		},
       		change: function(event, ui) {
            $("#doctorId").val(ui.item ? ui.item.Id : "");
        	}
    	});

    	fecha_ahora = "<?= date('D M d Y H:i:s O'); ?>";
		fecha_ahora = new Date(fecha_ahora);

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

$('#fecha').datetimepicker({
	controlType: myControl,
	altField: "#fecha_alt",
	altFieldTimeOnly: false,
	altFormat: "yy-mm-dd",
	altTimeFormat: "HH:mm",
	minDate: fecha_ahora,
	timeText:    '',
	hourText:    'Hora',
	minuteText:  'Minuto',
	currentText: 'Fecha actual',
	closeText:   'Aceptar',
});

$( "#citaForm" ).submit(function( event ) {
    if($('#citaForm').valid()){
        $('.screenLoad').show();
      }
  });

});	

function getServicio(){

  $('#wait_serv').show();

  $("#servicio option").remove();

    $.getJSON( base_url + "service/lista_add", function( data ) {

    $('#servicio').append('<option value="0"></option>');

    $.each(data,function (key, val) {
      
        $('#servicio').append('<option value="' + val.id + '">' + val.codigo +' '+val.nombre + '</option>');  

      });

      autocom("servicio");
     $( "#servicio" ).combobox();
        $( "#toggle" ).click(function() {
          $( "#servicio" ).toggle();
        });

    $('#wait_serv').hide();
    $('.servicio_input').val('');
          
  });

}

function autocom(select){

  var accentMap = {
    "á": "a",
      "é": "e",
      "í": "i",
      "ó": "o",
      "ú": "u"
    };

  var normalize = function( term ) {
      var ret = "";
      for ( var i = 0; i < term.length; i++ ) {
        ret += accentMap[ term.charAt(i) ] || term.charAt(i);
      }
      return ret;
    };

    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
       this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton(select);
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .attr( "id", select+"_id" )
          .attr( "name", select+"_name" )
          .attr( "value", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left auto-input "+select+"_input" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
            $( "#"+select ).change();
          },
 
          autocompletechange: function (event, ui) { 
            this._removeIfInvalid(event, ui); 
            //$( "#estado" ).change();
          }
        });
      },
 
      _createShowAllButton: function(select) {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )

          .attr( "tabIndex", -1 )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right auto-button "+select+"_input" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(normalize( text )) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {

        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " no coincide con ninguna opción" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  }

</script>