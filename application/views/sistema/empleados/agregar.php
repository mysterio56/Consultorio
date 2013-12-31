<script>
	$(function(){ Valid.empleados(); });
</script>
<?php
	$attributes = array('id' => 'empleadosForm');

	 	echo form_open(null,$attributes);
    echo '<table class="table_form" CELLSPACING="10">';
	echo '<tr>';
			echo form_label('*Campos Requeridos','campo');
		echo '<td width="8%">';
	 		echo form_label('*Código:');
	 	echo'</td>';
	   		 echo'<td width="25%">';
		 	$data = array(
		 		'name'  => 'codigo',
		 		'id'    => 'codigo',
		 		'value' => set_value('codigo', $nCodigo),
		 		'style' => 'width:90%'
		 	);

		 
		 		echo form_input($data);
		 		echo'</td>';
          
 	    echo'<td width="25%">'; 
		 	echo form_label('*Nombre:');
	echo'</td>';
            echo'<td width="25%">';
		 	$data = array(
		 		'name'  => 'nombre',
		 		'id'    => 'nombre',
		 		'class' => 'capitalize',
		 		'value' => set_value('nombre'),
		 		'style' => 'width:100%'
		 	);
	
		 	echo form_input($data);
	echo'</td>';
            echo'</tr>';

            echo'<tr>';
            echo'<td width="25%">';
		 	echo form_label('*Apellido Paterno:');
	echo'</td>';

		 	echo'<td  width="25%">';
		 	$data = array(
		 		'name'  => 'apellido_p',
		 		'id'    => 'apellido_p',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_p'),
		 		'style' => 'width:90%'
		 	);
	
		 	echo form_input($data);
	echo'</td>';

            echo'<td width="25%">';
		 	echo form_label('*Apellido Materno:');
	echo'</td>';

		 	echo'<td colspan="25%">';
		 	$data = array(
		 		'name'  => 'apellido_m',
		 		'id'    => 'apellido_m',
		 		'class' => 'capitalize',
		 		'value' => set_value('apellido_m'),
		 		'style' => 'width:80%'
		 	);

	
		 	echo form_input($data);
	echo'</td>';
            echo '</tr>';

		 echo'<tr>'; 
 	     echo'<td width="8%"> ';
		 	echo form_label('*Email:');
	echo'</td>';
            echo'<td width="8%">';
		 	$data = array(
		 		'name'  => 'email',
		 		'id'    => 'email',
		 		'value' => set_value('email'),
		 		'style' => 'width:90%'
		 	);
	
		 	echo form_input($data);
	echo '</td>';


	echo'<td width="25%">';
		 	echo form_label('*Password:');
	echo '</td>';
	        echo'<td colspan="25%">';
		 	$data = array(
		 		'name'  => 'password',
		 		'id'    => 'password',
		 		'style' => 'width:80%'
		 	);
	
		 	echo form_password($data);
	echo '</td>';
	echo '</tr>';
	echo'<tr>';
	        echo'<td width="8%">';
		 	echo form_label('*Confirme Password:');
	echo '</td>';
            echo'<td width="8%">';
		 	$data = array(
		 		'name'  => 'passwordcheck',
		 		'id'    => 'passwordcheck',
		 		'style' => 'width:90%'
		 	);
	
		 	echo form_password($data);
	echo '</td>';

	   echo'<td width="15%">';
		 	echo form_label('*Teléfono:');
	echo '</td>';
	        echo'<td width="8%">';
		 	$data = array(
		 		'name'  => 'telefono',
		 		'id'    => 'telefono',
		 		'value' => set_value('telefono'),
		 		'style' => 'width:100%'
		 	);
	
		 	echo form_input($data);
	echo '</td>';
	echo'</tr>';

	echo'<tr>';
	echo'<td width="25%">';
		 	echo form_label('*Celular:');
	echo '</td>';
	        echo'<td width="25%">';
		 	$data = array(
		 		'name'  => 'celular',
		 		'id'    => 'celular',
		 		'value' => set_value('celular'),
		 		'style' => 'width:90%'
		 	);
	
		 	echo form_input($data);
	echo '</td>';

	echo '<td>';
		echo form_label('*Tipo de empleado:');
	echo '</td>';
	?>
		<td width="25%">
			 <div id="wait_tp" class="wait">
	  	  		<p>Cargando tipo de empleados</p>
	  	 	</div>
			<div class="select_reload">
			 	<select name="tipo_empleado" id="tipo_empleado"></select>
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getTipoEmpleado();"/>
			</div>
		    
		 </td>
</tr>
<?php

echo '<tr>';
	echo '<td colspan="100%" class="hide standOut" id="tdEspecialidadesLabel">';
			echo form_label('*Especialidades:');
	echo '</td>';
echo '</tr>';

echo '<tr>';
	echo '<td colspan="100%" class="hide" id="tdEspecialidades">';
		foreach($especialidades as $especialidad){
				 		echo form_label($especialidad->nombre.':');
				 		$data = array(
				 			'name'  => 'especialidades[]',
				 			'id'    => 'especialidad_'.$especialidad->id,
				 			'value' => $especialidad->id
		 		 			);

				 		echo form_checkbox($data);
				 	}
	echo '</td>';
echo '</tr>';

echo'<tr>';
		 		echo'<td colspan ="100%" class="standOut">';
		 			echo form_label('Dirección:');
		 		echo'</td>';
		 	echo'</tr>';

?>
<tr>
	<td width="25%">
		 	<?= form_label('*Estado:'); ?>
	</td>
	<td width="25%">
	  	 <select name="estado" id="estado" class="hide" onChange="getMunicipalities();"> </select>
	  	  <div id="wait_estados" class="wait">
	  	  	<p>Cargando Estados</p>
	  	  	</div>
	</td>

	<td width="25%">
		 	<?= form_label('*Municipio:'); ?>
	</td>
	<td width="25%">
		<select  name="municipio" id="municipio" class="hide" onchange="getPostalCodes();"/></select>
		 <div id="wait_mun" class="wait hide">
	  	  	<p>Cargando Municipios</p>
	  	  	</div>
	</td>
</tr>
<tr>
    <td width="25%">
    <?= form_label('*Codigo Postal:');?>
    </td>
    <td width="25%">
    	<select name="codigo_postal" id="codigo_postal" class="hide" onchange="getColonies();"/></select>
    	 <div id="wait_cp" class="wait hide">
	  	  	<p>Cargando Codigos Postales</p>
	  	 </div>
    </td>

    <td width="25%">
    	<?= form_label('*Colonia:'); ?>
	</td>
	<td width="25%">
		<select name="colonia" id="colonia" class="hide"/></select>
		 <div id="wait_col" class="wait hide">
	  	  	<p>Cargando Colonias</p>
	  	  	</div>
	</td>
</tr>

    <?php
    echo '<tr>';
	echo '<td width="25%">';
		 	echo form_label('*Calle:');
	echo '</td>';
                echo '<td width="25%">';
			 	$data = array(
		 		'name'  => 'calle',
		 		'id'    => 'calle',
		 		'value' => set_value('calle'),
		 		//'style' => 'width:210px'
		 	);
	
		 	echo form_input($data);
	echo '</td>';
	
	echo '<td width="25%">';
		 	echo form_label('Número Exterior:');
	echo '</td>';
	        echo'<td width="25%">';
		 	$data = array(
		 		'name'  => 'numero_ext',
		 		'id'    => 'numero_ext',
		 		'value' => set_value('numero_ext'),
		 		//'style' => **'width:210px'
		 	);
	
		 	echo form_input($data);
	echo '</td>';
	echo'</tr>';

	echo'<tr>';
	echo '<td>';
		 	echo form_label('Número interior:');
	echo '</td>';
	        echo '<td width="25%">';
		 	$data = array(
		 		'name'  => 'numero_int',
		 		'id'    => 'numero_int',
		 		'value' => set_value('numero_int'),
		 		//'style' => 'width:210px'
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
		 	echo '<a href="'.base_url($return).'" class="abutton_cancel">Cancelar</a>';
			echo form_close(); 
	 	
?>
<script>
$(function () {

	 $("#tipo_empleado").change(function(){
       showEspecialidades();
   	});

	base_url = "<?= base_url(); ?>";

	getTipoEmpleado();
	getFederalEntities();
});


function getTipoEmpleado(){

	$('#wait_tp').show();

	$("#tipo_empleado option").remove();

  	$.getJSON( base_url + "type_employee/lista", function( data ) {

	$('#tipo_empleado').append('<option value="0"></option>');

		$.each(data,function (key, val) {
			
  			$('#tipo_empleado').append('<option value="' + val.id + '">' + val.nombre + '</option>');  

  		});

  		autocom("tipo_empleado");
 	 	 $( "#tipo_empleado" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#tipo_empleado" ).toggle();
		    });

		$('#wait_tp').hide();
 	 	$('.tipo_empleado_input').val('');
 	 	showEspecialidades();
     	
	});

}

function trim (myString){
	return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

function showEspecialidades(){

   var tipo_empleado = $("#tipo_empleado option:selected").text();
   tipo_empleado     = trim(tipo_empleado);

	var n = tipo_empleado.indexOf("doctor");

     if(n){
       $("#tdEspecialidadesLabel").show();
       $("#tdEspecialidades").show();
     } else {
       $("#tdEspecialidadesLabel").hide();
       $("#tdEspecialidades").hide();
     }
 }

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

</script>