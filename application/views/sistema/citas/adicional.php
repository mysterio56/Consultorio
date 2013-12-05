<?php
echo form_open(null); 
	
	echo '<table class="table_form">';
	echo '<tr>';
		echo '<tr>';
		echo '<td>';
	 		echo form_label('Producto:');
	 	
	 	?>
		<td width="25%">
			 <div id="wait_tp" class="wait">
	  	  		<p>Cargando productos, por favor espere</p>
	  	 	</div>
			<div class="select_reload">
			 	<select name="producto" id="producto"></select>
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getProducto();"/>
			</div>
		    
		 </td>
</tr>
<?php
		echo '</td>';
				
		echo  '<td>';
			echo form_label('Servicio: ');
		?>
		<td width="25%">
			    <div class="select_reload">
			 	<select name="servicio" id="servicio"></select>
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getServicio();"/>
			</div>
		    
		 </td>
</tr>
<?php
		 	echo '</td>';
	echo '</tr>';
	echo'</table>'; 

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
	
	base_url = "<?= base_url(); ?>";
	getProducto();
	getServicio();

});	

function getProducto(){

	$('#wait_tp').show();

	$("#producto option").remove();

  	$.getJSON( base_url + "product/lista_add", function( data ) {

	$('#producto').append('<option value="0"></option>');

		$.each(data,function (key, val) {
			
  			$('#producto').append('<option value="' + val.id + '">' + val.value + '</option>');  

  		});

  		autocom("producto");
 	 	 $( "#producto" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#producto" ).toggle();
		    });

		$('#wait_tp').hide();
 	 	$('.producto_input').val('');
 	 	     	
	});

}
function getServicio(){

	$("#servicio option").remove();

  	$.getJSON( base_url + "service/lista_add", function( data ) {

		$.each(data,function (key, val) {
			
  			$('#servicio').append('<option value="' + val.id + '">' + val.codigo +' '+val.nombre + '</option>');  

  		});

  		autocom("servicio");
 	 	 $( "#servicio" ).combobox();
		    $( "#toggle" ).click(function() {
		      $( "#servicio" ).toggle();
		    });

		$('#wait_tp').hide();
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

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th align="center">Código</th>
				<th align="center">Producto/Servicio</th>
				<th align="center">Costo</th>
			</tr>
		</thead>
		</table>
</section>
