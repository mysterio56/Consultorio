<script>
	$(function(){ Valid.paciente(); });
</script>
<?php

	$attributes = array('id' => 'pacienteForm');

	 	echo form_open(null,$attributes);
	 	echo '<table class="table_form">';
	    echo'<tr>'; 
	    echo form_label('* Campos Requeridos','campo');
	    echo'<td>'; 
	 		echo form_label('* Código:');
	 		 echo'</td>';
	   		 echo'<td>';
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo', $nCodigo),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';

        echo'</tr>';
        echo'<tr>';

 	    	echo'<td>'; 
		 	echo form_label('*Nombre:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
            echo'</td>';
        echo'</tr>';

            echo'<tr>';
            echo'<td>';
		 	echo form_label('*Apellido paterno:');
		 	echo'</td>';

		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';

		 	echo'</tr>';
        	echo'<tr>';

            echo'<td>';
  		 	echo form_label('*Apellido materno:');
		 	echo'</td>';

		 	echo'<td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

            echo '<tr>';

	        echo '<td>';
		 	echo form_label('*Sexo:');
	        echo '</td>';

	        echo'<td>';
		 	$data = array(
		 		'name'    => 'sexo',
		 		'id'      => 'sex1',
		 		'radio'   => true,
		 		'value'   => 1,
		 		'checked' => true,		 		
		 		'style'   => 'width:20px;'
		 	);
		 	echo form_label('Masculino', 'sex1');
		 	echo form_radio($data);

		 	$data = array(
		 		'name'    => 'sexo',
		 		'id'      => 'sex2',
		 		'radio'   => true,
		 		'value'   => 0,
		 		'checked' => false,
		 		'style'   => 'width:20px;'
		 	);
		 	echo form_label('Femenino', 'sex2');
		 	echo form_radio($data);

	echo '</td>';
	echo '<tr/>';

		 echo'<tr>'; 
 	     echo'<td> ';
		 	echo form_label('Email:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
          
        echo'</tr>';
        echo'<tr>';

 	     echo'<td>';
		 	echo form_label('Teléfono:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
		 	echo'</tr>';
           
           echo'</tr>';
		 	echo'<td>';
		 	
		    echo form_label('Celular:');
		 	echo'</td>';
            echo'<td>';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular'),
		 		//'style' => 'width:60%'
		 	);

		 	echo form_input($data);
		 	echo'</td>';
            echo '</tr>';

            echo'<tr>';
		 		echo'<td  colspan ="100%" class="standOut">';
		 			echo form_label('Dirección:');
		 		echo'</td>';
		 	echo'</tr>';

		 	
            ?>
 <tr>
	<td>
	<?= form_label('*Estado:'); ?>
	</td>
	<td>
	  	 <select  width="50%" name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	  	  <div id="wait_estados" class="wait">
	  	  	<p>Cargando Estados</p>
	  	  	</div>
	</td>
	
	</tr>
	<tr>

	<td>
		 	<?= form_label('*Municipio:'); ?>
	</td>
	<td>
		<select  width="50%" name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
		 <div id="wait_mun" class="wait hide">
	  	  	<p>Cargando Municipios</p>
	  	  	</div>
	</td>
</tr>


<tr>
    <td>
    <?= form_label('*Codigo Postal:');?>
    </td>
    <td>
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    	 <div id="wait_cp" class="wait hide" width="25%">
	  	  	<p>Cargando Codigos Postales</p>
	  	  	</div>
    </td>

</tr>
<tr>

    <td>
    	<?= form_label('*Colonia:'); ?>
	</td>
	<td>
		<select name="colonia" id="colonia" class="hide"/></select>
		 <div id="wait_col" class="wait hide" width="25%">
	  	  	<p>Cargando Colonias</p>
	  	  	</div>
	</td>
</tr>

    <?php
    echo '<tr>';
	echo '<td>';
		 	echo form_label('*Calle:');
	echo '</td>';
	echo '<td>';

			 	$data = array(
		 		'name'  => 'calle',
		 		'id'    => 'calle',
		 		'value' => set_value('calle'),
		 		//'style' => 'width:60%'
		 	);
	
		 	echo form_input($data);
	echo '</td>';

echo'</tr>';
echo'<tr>';
	
	echo '<td>';
		 	echo form_label('Número Exterior:');
	echo '</td>';
	        echo '<td>';
		 	$data = array(
		 		'name'  => 'numero_ext',
		 		'id'    => 'numero_ext',
		 		'value' => set_value('numero_ext'),
		 		//'style' => 'width:60%'
		 	);
	
		 	echo form_input($data);
	echo '</td>';
	echo '</tr>';

echo '<tr>';
	echo '<td>';
		 	echo form_label('Número interior:');
	echo '</td>';
	        echo '<td>';
		 	$data = array(
		 		'name'  => 'numero_int',
		 		'id'    => 'numero_int',
		 		'value' => set_value('numero_int'),
		 		//'style' => 'width:60%'
		 	);
		 	
		 	echo form_input($data);
	echo '</td>';
	echo '</tr>';
 	echo '</table>';
            
		 	$data = array(
		 		'name'  => 'agregar',
		 		'id'    => 'agregar',
		 		'class' => 'abutton',
		 		'value' => 'Agregar'
		 	);

		 	echo form_submit($data);	
		 	echo '<a href="'.base_url($return).'"  onclick = "$(\'.screenLoad\').show();"  class="abutton_cancel">Cancelar</a>';
			echo form_close(); 
	 	
?>
<script>
$(function () {

	base_url = "<?= base_url(); ?>";
	getFederalEntities();

	$( "#pacienteForm" ).submit(function( event ) {
		if($('#pacienteForm').valid()){
  			$('.screenLoad').show();
  		}
	});
	
	});

function getFederalEntities(){

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

		//$('#estado').append('<option value="0">Seleccione un Estado</option>');

  		$.each( data, function( key, val ) {
  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});


 	 	autocom("estado");
 	 	 $( "#estado" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#estado" ).toggle();
		    });
 	 	$('#wait_estados').hide();
 	 	$('.estado_input').val('');
 	 	$('.screenLoad').hide();
     	
	});
}

function getMunicipalities(){

$("#municipio option").remove();
$('.municipio_input').addClass('hide');
$("#codigo_postal option").remove();
$('.codigo_postal_input').addClass('hide');
$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_mun').show();


var url = base_url + "address/getMunicipalities/"+$("#estado").val();
	$.getJSON( url, function( data ) {
		//$('#municipio').append('<option value="0">Seleccione un Municipio</option>');
		 $.each( data, function( key, val ) {
  			$('#municipio').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

     	$('.municipio_input').removeClass('hide');
 
     	autocom("municipio");
 	 	 $( "#municipio" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#municipio" ).toggle();
		    });
     	$('#wait_mun').hide();
     	$('.municipio_input').val('');
		
	});
	
}

function getPostalCodes(){

$("#codigo_postal option").remove();
$('.codigo_postal_input').addClass('hide');
$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_cp').show();

var url = base_url + "address/getPostalCodes/"+$("#municipio").val();
	$.getJSON( url, function( data ) {
	//	$('#codigo_postal').append('<option value="0">Seleccione un Código Postal</option>');
		 $.each( data, function( key, val ) {
  			$('#codigo_postal').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

		$('.codigo_postal_input').removeClass('hide');
     	
		autocom("codigo_postal");
 	 	 $( "#codigo_postal" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#codigo_postal" ).toggle();
		    });
		$('#wait_cp').hide();
		$('.codigo_postal_input').val('');
     		
	});
	
}

function getColonies(){

$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_col').show();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();
	$.getJSON( url, function( data ) {
		//$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 $.each( data, function( key, val ) {
  			$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});
		
		$('.colonia_input').removeClass('hide');
     	
		autocom("colonia");
 	 	 $( "#colonia" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#colonia" ).toggle();
		    });
		$('#wait_col').hide();
		$('.colonia_input').val('');

	});
	
}

function showEspecialidades(){
	var tipo_empleado = $("#tipo_empleado").val();
		if(tipo_empleado == 1){
			$("#tdEspecialidadesLabel").show();
			$("#tdEspecialidades").show();
		} else {
			$("#tdEspecialidadesLabel").hide();
			$("#tdEspecialidades").hide();
		}
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
 
  $(function() {
   
  });

</script>
