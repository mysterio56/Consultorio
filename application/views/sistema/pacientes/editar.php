<script>
	$(function(){ Valid.paciente(); });
</script>
<?php
	$aPermisos  = unserialize(PERMISOS);
	$attributes = array('id' => 'pacienteForm');

	 	echo form_open(null,$attributes);
echo '<table class="table_form">';
	echo '<tr>';
		echo form_label('*Campos Requeridos','campo');
		echo '<td>';
	 		echo form_label('*Código:');
	 	echo '</td>';

		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo',$paciente->codigo),
		 		//'style' => 'width:100px'
		 	);

		 	echo '<td>';
		 		echo form_input($data);
		 	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Nombre:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre',$paciente->nombre),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Apellido Paterno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p',$paciente->apellido_p),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Apellido Materno:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m',$paciente->apellido_m),
		 		//'style' => 'width:100px'
		 	);

	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Email:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email',$paciente->email),
		 		//'style' => 'width:200px'
		 	);
	echo '<td colspan="2">';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '<tr>';
	echo '<td>';
		 	echo form_label('*Teléfono:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono',$paciente->telefono),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
	echo '<td>';
		 	echo form_label('*Celular:');
	echo '</td>';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular',$paciente->celular),
		 		//'style' => 'width:100px'
		 	);
	echo '<td>';
		 	echo form_input($data);
	echo '</td>';
echo '</tr>';
echo '</tr>';

echo'<tr>';
		 		echo'<td colspan ="100%" class="standOut">';
		 			echo form_label('Dirección:');
		 		echo'</td>';
		 	echo'</tr>';
		 	
?>

<tr>
	<td>
		<?= form_label('*Estado:'); ?>
	</td>
	    <td colspan="2">
	  	   <select name="estado" id="estado" onChange="getMunicipalities();"> </select>
	  	   <div id="wait_estados" class="wait">
				<p>Cargando Estados, por favor espere</p>
	 		</div>
	    </td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Municipio:'); ?>
	</td>
	<td colspan="2">
		<select  name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
		<div id="wait_mun" class="wait">
		<p>Cargando Municipio, por favor espere</p>
	 	</div>
	</td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Codigo Postal:'); ?>
	</td>
    <td colspan="2">
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    	<div id="wait_cp" class="wait">
			<p>Cargando Codigo Postal, por favor espere</p>
	 	</div>
    </td>
</tr>

<tr>
	<td>
		 	<?= form_label('*Colonia:'); ?>
	</td>
	<td colspan="2">
		<select name="colonia" id="colonia" class="hide" onchange=""/></select>
		<div id="wait_col" class="wait">
		<p>Cargando Colonia, por favor espere</p>
	 	</div>
	</td>
</tr>

<?php

echo '<tr>';
   echo '<td>';
        echo form_label('*Calle:');
   echo '</td>';

          $data = array(
          'name'  => 'calle',
          'id'    => 'calle',
          'value' => set_value('calle',$paciente->direccion->calle),
          //'style' => 'width:210px'
        );
   echo '<td>';
        echo form_input($data);
   echo '</td>';
 echo '</tr>';
 echo '<tr>';
   echo '<td>';
        echo form_label('Número Exterior:');
   echo '</td>';
        $data = array(
          'name'  => 'numero_ext',
          'id'    => 'numero_ext',
          'value' => set_value('numero_ext',$paciente->direccion->numero_ext),
          //'style' => 'width:210px'
        );
   echo '<td>';
        echo form_input($data);
  echo '</td>';
   echo '<td>';
        echo form_label('Número interior:');
   echo '</td>';
        $data = array(
          'name'  => 'numero_int',
          'id'    => 'numero_int',
          'value' => set_value('numero_int',$paciente->direccion->numero_int),
          //'style' => 'width:210px'
        );
     echo '<td>';
        echo form_input($data);
  echo '</td>';

echo '</tr>';
echo '</table>';
		 	$data = array(
		 		'name'  => 'editar',
		 		'id'    => 'editar',
		 		'class' => 'abutton',
		 		'value' => 'Actualizar'
		 	);

	 		echo form_submit($data);
	 		echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
	 		echo form_close(); 
	?>
	
<script>

$(function () {

	$("input[type=submit]").attr("disabled", "disabled");
	base_url = "<?= base_url(); ?>";

	getFederalEntities(1);

	//$("#estado").combobox();

});

function getFederalEntities(nStart){

	$("input[type=submit]").attr("disabled", "disabled");

	$.getJSON( base_url + "address/getFederalEntities/", function( data ) {

	//	$('#estado').append('<option value="0">Seleccione un Estado</option>');

  		$.each( data, function( key, val ) {

  			$('#estado').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

 	 	if(nStart){
 	 		$('#estado').val("<?= $paciente->direccion->estado_id; ?>");
 	 		getMunicipalities(1);
 	 	}

 	 	//$('#estado').show();
 	 	autocom("estado");
 	 	 $( "#estado" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#estado" ).toggle();
		    });
 	 	
     	$('#wait_estados').hide();

	});
}

function getMunicipalities(nStart){

$("#municipio option").remove();
$('.municipio_input').addClass('hide');
$("#codigo_postal option").remove();
$('.codigo_postal_input').addClass('hide');
$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_mun').show();

if($("#estado").val() != null){
   var url = base_url + "address/getMunicipalities/"+$("#estado").val();

	$.getJSON( url, function( data ) {

	//$('#municipio').append('<option value="0">Seleccione un Municipio</option>');

    $.each( data, function( key, val ) {

  	$('#municipio').append('<option value="' + val.id + '">' + val.name + '</option>');

 	 	});

		 if(nStart){

 	 		$('#municipio').val("<?= $paciente->direccion->municipio_id; ?>");
 	 		getPostalCodes(1);
 	 	}

     	//$('#municipio').show();
     	$('.municipio_input').removeClass('hide');
     	$('.municipio_input').val('');
     	autocom("municipio");
 	 	 $( "#municipio" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#municipio" ).toggle();
		    });
     	$('#wait_mun').hide();
		
	});
} else {
	$('#wait_mun').hide();
	$('#municipio').hide();
}
	
}

function getPostalCodes(nStart){

$("#codigo_postal option").remove();
$('.codigo_postal_input').addClass('hide');
$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_cp').show();

var url = base_url + "address/getPostalCodes/"+$("#municipio").val();

$.getJSON( url, function( data ) {
		
//$('#codigo_postal').append('<option value="0">Seleccione un Código Postal</option>');
		
 $.each( data, function( key, val ) {
  			
  $('#codigo_postal').append('<option value="' + val.id + '">' + val.name + '</option>');

 	 	});

	   if(nStart){
 	 		$('#codigo_postal').val("<?= $paciente->direccion->codigo_postal_id; ?>");
 	 		getColonies(1);
 	 	}

		//$('#codigo_postal').show();
		$('.codigo_postal_input').removeClass('hide');
     	$('.codigo_postal_input').val('');
		autocom("codigo_postal");
 	 	 $( "#codigo_postal" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#codigo_postal" ).toggle();
		    });
		$('#wait_cp').hide();
     		
	});
	
}

function getColonies(nStart){

$("#colonia option").remove();
$('.colonia_input').addClass('hide');
$('#wait_col').show();

var url = base_url + "address/getColonies/"+$("#codigo_postal").val();

$.getJSON( url, function( data ) {

//$('#colonia').append('<option value="0">Seleccione una Colonia</option>');
		 
$.each( data, function( key, val ) {
  			
$('#colonia').append('<option value="' + val.id + '">' + val.name + '</option>');
 	 	});

		if(nStart){

 	 		$('#colonia').val("<?= $paciente->direccion->colonia_id; ?>");
 	 		$('#wait_col').hide();
			$('#address').show();
			$("input[type=submit]").removeAttr("disabled");

 	 	}
		
		//$('#colonia').show();
		$('.colonia_input').removeClass('hide');
     	$('.colonia_input').val('');
		autocom("colonia");
 	 	 $( "#colonia" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#colonia" ).toggle();
		    });
		$('#wait_col').hide();
		
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
 
  $(function() {
   
  });
  
</script>
