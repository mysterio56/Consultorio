
<?php

    $attributes = array('id' => 'ingresosForm', 'target' => '_blank');
    echo form_open(null,$attributes);

?>
   
    <label>Producto: </label>
   <div id="wait_tp" class="wait">
                <p>Cargando productos</p>
            </div>
            <div class="select_reload" style="display:inline-block">
                <select name="producto" id="producto"></select>
                
            </div>
    <label>Servicio: </label>
            <div id="wait_serv" class="wait">
            <p>Cargando servicios</p>
        </div>
                <div class="select_reload" style="display:inline-block">
                <select name="servicio" id="servicio"></select>
                <td>
            </div>

<br />

 <input type="hidden" name="imprimir" id="imprimir" value="0" />

 <label>Ver por: </label>

    <select name="type" id="type" onChange="grid();" >
        <option value="1">Producto/Servicio</option>
        <option value="2">Citas</option>
    </select>

    <label> Inicio </label> <label id="l_date_start"> </label> <input type="hidden" id="date_start" name="date_start"/>
    <label> Fin    </label> <label id="l_date_end"> </label> <input type="hidden" id="date_end" name="date_end"/>

    <label class ="abutton" onClick="getTotalPS(); getTotalCitas(); grid();" >Buscar</label>

    <br />

    <label>Total Producto/Servicio</label> <strong id="totalPS">222</strong>
    <label>Total Citas</label>             <strong id="totalCitas">222</strong>
    <label>Total</label>                   <strong id="total">222</strong>

</div>

<?php

    echo form_close();

?> 

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th>Producto/Servicio</th>
				<th>Fecha</th>
				<th>Total</th>
				<th>Detalle</th>
			</tr>
		</thead>
		<tbody id="tbodyIngresos">

		</tbody>
		<tfoot id="tfootIngresos">

		</tfoot>
	</table>

	<div id="wait_grid" class= "wait_grid" style="display:none">
		<img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
		Cargando datos ...
	</div>

</section>

 <label class ="abutton" id="imprimir">Imprimir</label>
 <a href="<?= base_url('income') ?>" class ="abutton_cancel" >Cancelar</a>
 
 
<script>

base_url  = "<?= base_url(); ?>";
page      = 1;
costoCita = 0;
costoPS   = 0;
base_url  = "<?= base_url(); ?>";

jQuery(function() {

	getTotalPS();
    getProducto();
    getServicio();
    getTotalCitas();
    grid();

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

    $('#imprimir').click( function () {

      // $('#imprimir').val('imprimir');
       $('#ingresosForm').get(0).setAttribute('action', "<?= base_url('income/gridPS'); ?>" );
       $('#ingresosForm').submit();

    }); 


});

  function grid(){

    getTotalPS();
    getTotalCitas();

    jQuery('#tbodyIngresos').html("");
    jQuery('#wait_grid').show();

    var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start').val(),
                      date_end : $('#date_end').val()
                    };

    if($('#type').val()==1){
      url = "income/gridPS/"+page;
    } else {
      url = "income/gridCitas/"+page;
    }

    jQuery.post( base_url+url, form_data , 

        function( data ) {

          if(!data.empty){

            rowIngresos  = '';

            $.each(data.data, function(key, ingreso){

              classRow = (key % 2 == 0)?'odd':'even';
              rowIngresos += '<tr class="'+classRow+'">';
              rowIngresos += '<td>';
              rowIngresos += ingreso.nombre;
              rowIngresos += '</td>';
              rowIngresos += '<td>';
              rowIngresos += ingreso.fecha_format;
              rowIngresos += '</td>';
              rowIngresos += '<td>';
              rowIngresos += ingreso.total;
              rowIngresos += '</td>';
              rowIngresos += '<td>';
              rowIngresos += '<img onclick="detail('+ingreso.id+',\''+ingreso.tipo+'\')" src="'+base_url+'/assets/images/detail.png" class="ico" title="detalle"/>'
              rowIngresos += '</td>';
              rowIngresos += '</tr>';

            });

            $('#tbodyIngresos').append(rowIngresos);
            $('#tfootIngresos').html("");

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

              jQuery('#tfootIngresos').append(rowFoot);

            }

          }else{

            rowCita = '<tr><td colspan="100%">No hay Ingresos para mostrar </td></tr>';
            jQuery('#tbodyIngresos').append(rowCita);
            jQuery('#tfootIngresos').html("");
          }

            jQuery('#wait_grid').hide();

    },'json');

  }

  function imprimir(){

    var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start').val(),
                      date_end : $('#date_end').val()
                    };

    if($('#type').val()==1){
      url = "income/generar/";
    } else {
      url = "income/gridCitas/"+page;
    }

    jQuery.post( base_url+url, form_data , 

        function( data ) {



    });

  }

function setPage(nPage){
  page = nPage;
  grid();
}

function detail(id,tipo){

  if($('#date_start').val()!=""){

    date_start = $('#date_start').val().split("/"); 
    date_start = new Date(date_start[2],date_start[1]-1,date_start[0],'00','00','00').getTime();

  }else{

    date_start = false;

  }

  if($('#date_end').val()!=""){
    
    date_end = $('#date_end').val().split("/");
    date_end = new Date(date_end[2],date_end[1]-1,date_end[0],'00','00','00').getTime();

  }else{
    date_end = false;
  }

  if(tipo=="cita"){

    window.location = base_url+"income/detailCita/"+id;

  }else{

    window.location = base_url+"income/detail/"+id+"/"+tipo+"/"+date_start+"/"+date_end;

  }

} 

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

function getTotalCitas(){

    var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start').val(),
                      date_end : $('#date_end').val()
                    };
    jQuery.post( base_url+"income/getTotalCitas", form_data , 

        function( data ) {
          if(data!=""){
            $("#totalCitas").html("$ "+data);
            costoCita = data;
          }else{
             $("#totalCitas").html("$ 0.00");
            costoCita = 0;
          }
            getTotal();
    });
}


function getTotalPS(){

	var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start').val(),
                      date_end : $('#date_end').val()
                    };

	jQuery.post( base_url+"income/getTotal", form_data , 

		function( data ) {
      if(data!=""){
			$("#totalPS").html("$ "+data);
      costoPS = data;
    }else{
      $("#totalPS").html("$ 0.00");
      costoPS = 0;
    }
      getTotal();
	});
}

function getTotal(){

  total = parseFloat(costoPS) + parseFloat(costoCita);
    $("#total").html("$ "+total.toFixed(2));

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