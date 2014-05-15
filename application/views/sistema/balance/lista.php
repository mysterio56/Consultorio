<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
<?php

    $attributes = array('id' => 'ingresosForm', 'target' => '_blank');
    echo form_open(null,$attributes);

?>
   
    <div id="divProducto" style="margin-bottom:-15px">        
    <label>Producto: </label>
   <div id="wait_tp" class="wait">
                <p>Cargando productos</p>
            </div>
            <div class="select_reload" style="display:inline-block">
                <select name="producto" id="producto"></select>
                
            </div>
          </div>

    <div id="divServicio" class="hide" style="margin-bottom:-15px">        
      <label>Servicio: </label>
            <div id="wait_serv" class="wait">
            <p>Cargando servicios</p>
        </div>
                <div class="select_reload" style="display:inline-block">
                <select name="servicio" id="servicio"></select>
            </div>
    </div>

<br />

 <input type="hidden" name="imprimir" id="imprimir" value="0" />
 <input type="hidden" name="inputTotalProducto" id="inputTotalProducto" value="0" />
 <input type="hidden" name="inputTotalServicio" id="inputTotalServicio" value="0" />

 <label>Ver por: </label>

    <select name="type" id="type" onChange="typeShow(); grid();" >
        <option value="1">Producto</option>
        <option value="2">Servicio</option>
    </select>

    <label> Mes Inicio </label> <label id="l_date_start"> </label> <input type="hidden" id="date_start" name="date_start"/>
    <input type="hidden" name="date_start_alt" id="date_start_alt"/>
    <label> Mes Fin    </label> <label id="l_date_end"> </label> <input type="hidden" id="date_end" name="date_end"/>
    <input type="hidden" name="date_end_alt" id="date_end_alt"/>

    <label class ="abutton" onClick="getTotalProducto(); getTotalServicio(); grid();" >Buscar</label>

    <br />

    <label>Total Producto</label> <strong id="totalProducto"></strong>
    <label>Total Servicio</label>             <strong id="totalServicio"></strong>
    <label>Total</label>                   <strong id="total"></strong>

</div>

<?php

    echo form_close();

?> 

<section class="datagrid" >
  <table>
    <thead>
      <tr>
        <th style="width:130px">Producto/Servicio</th>
        <th>Egreso</th>
        <th>Ingreso</th>
        <th>Balance</th>
        <th>Detalle</th>
      </tr>
    </thead>
    <tbody id="tbodyBalance">

    </tbody>
    <tfoot id="tfootBalance">

    </tfoot>
  </table>

  <div id="wait_grid" class= "wait_grid" style="display:none">
    <img src="<?= base_url('assets/images/wait.gif'); ?>" style="width:25px;height:25px;"/>
    Cargando datos ...
  </div>

</section>

 <label class ="abutton" id="imprimir" onClick="imprimir();">Imprimir</label>
 <a href="<?= base_url('balance_sheet') ?>" class ="abutton_cancel" >Cancelar</a>
 
 
<script>

base_url  = "<?= base_url(); ?>";
page      = 1;
costoServicio = 0;
costoProducto = 0;
base_url  = "<?= base_url(); ?>";

jQuery(function() {

  
    getProducto();
    getServicio();
    grid();
    getTotalProducto();
    getTotalServicio();

});

jQuery("#date_start").datepicker({
            buttonImage: base_url+'assets/images/calendar.png',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showOn: 'both',
            dateFormat: 'M yy',
            showButtonPanel: true,
            altField: "#date_start_alt",
            altFormat: "yy-mm",
            onClose: function(selectedDate,objDate) {

               var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

                $("#date_start").datepicker('setDate', new Date(year, month, 1));
                
                jQuery( "#l_date_start" ).html( jQuery("#date_start").datepicker().val() );
                var val_end = jQuery( "#date_end_alt" ).val();
                jQuery( "#date_end" ).datepicker( "option", "minDate", new Date(year, month, 1) );
                jQuery( "#date_end_alt" ).val(val_end);
            }

    });

      jQuery("#date_end").datepicker({
            buttonImage: base_url+'assets/images/calendar.png',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showOn: 'both',
            dateFormat: 'M yy',
            showButtonPanel: true,
            altField: "#date_end_alt",
            altFormat: "yy-mm",
            onClose: function(selectedDate,objDate,s) {

                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

                $("#date_end").datepicker('setDate', new Date(year, month, 1));
                
                jQuery( "#l_date_end" ).html( jQuery("#date_end").datepicker().val() );
                var val_start = jQuery( "#date_start_alt" ).val();
                jQuery( "#date_start" ).datepicker( "option", "maxDate", new Date(year, month, 1) );
                jQuery( "#date_start_alt" ).val(val_start);
            }
    });

  function typeShow(){
    type = $('#type option:selected').val();

    if(type == 1){

      $('#divServicio').hide();
      $('#divProducto').show();

    } else {

      $('#divProducto').hide();
      $('#divServicio').show();

    }

  }

  function grid(){

    getTotalProducto();
    getTotalServicio();

    jQuery('#tbodyBalance').html("");
    jQuery('#wait_grid').show();

    var form_data = { type       : $('#type').val(),
                      producto   : $('#producto').val(),
                      servicio   : $('#servicio').val(),
                      date_start : $('#date_start_alt').val(),
                      date_end   : $('#date_end_alt').val()
                    };

    if($('#type').val()==1){
      url = "balance_sheet/gridProducto/"+page;
    } else {
      url = "balance_sheet/gridServicio/"+page;
    }

    jQuery.post( base_url+url, form_data , 

        function( data ) {

          if(!data.empty){

            rowBalance  = '';

            $.each(data.data, function(key, balance){

              classRow = (key % 2 == 0)?'odd':'even';
              rowBalance += '<tr class="'+classRow+'">';
              rowBalance += '<td>';
              rowBalance += balance.nombre;
              rowBalance += '</td>';
              rowBalance += '<td>';
              rowBalance += balance.egreso;
              rowBalance += '</td>';
              rowBalance += '<td>';
              rowBalance += balance.ingreso;
              rowBalance += '</td>';
              rowBalance += '<td>';
              rowBalance += balance.total;
              rowBalance += '</td>';
              rowBalance += '<td>';

              egreso  = false;
              ingreso = false;

              if(balance.egreso > 0){
                rowBalance += '<label class="abutton_balance" title="Detalle Egreso" onClick="detail('+balance.id+', \'egreso\');" >E</label>';
                egreso = true;
              }

              if(balance.ingreso > 0){
                rowBalance += '<label class="abutton_balance" title="Detalle Ingresos" onClick="detail('+balance.id+', \'ingreso\'); ">I</label>';
                ingreso = true;
              }

              if(ingreso == true || egreso == true){

                rowBalance += '<img onclick="detail('+balance.id+',\'\', \''+egreso+'\',\''+ingreso+'\',\'true\');" src="'+base_url+'/assets/images/pdf.png" class="ico" title="Imprimir detalle"/>'

              }

              rowBalance += '</td>';
              rowBalance += '</tr>';

            });

            $('#tbodyBalance').append(rowBalance);
            $('#tfootBalance').html("");

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

              jQuery('#tfootBalance').append(rowFoot);

            }

          }else{

            rowBalance = '<tr><td colspan="100%">No hay Ingresos para mostrar </td></tr>';
            jQuery('#tbodyBalance').append(rowBalance);
            jQuery('#tfootBalance').html("");
          }

            jQuery('#wait_grid').hide();
            $('.screenLoad').hide();

    },'json');

  }

  function imprimir(){

      if($('#type').val()==1){
        url = "balance_sheet/gridProducto/";
      } else {
        url = "balance_sheet/gridServicio";
      }

      $('#imprimir').val('imprimir');
      $('#ingresosForm').get(0).setAttribute('action', "<?= base_url(); ?>"+url );
      $('#ingresosForm').submit();
  }

function setPage(nPage){
  page = nPage;
  grid();
}

function detail(id,tipo,egreso,ingreso,imprimir){

  if($('#date_start_alt').val()!=""){

    date_start = $('#date_start_alt').val().split("-"); 
    date_start = new Date(date_start[0],date_start[1]-1,'01','00','00','00').getTime();

  }else{

    date_start = false;

  }

  if($('#date_end').val()!=""){
    
    date_end = $('#date_end_alt').val().split("-");
    date_end = new Date(date_end[0],date_end[1]-1,'01','00','00','00').getTime();

  } else {

    date_end = false;

  }

    if($('#type').val()==1){

      if(!imprimir){

        window.location = base_url+"balance_sheet/detailProducto/"+id+"/"+tipo+"/"+date_start+"/"+date_end;

      } else {

          window.open(base_url+"balance_sheet/detailImprimir/"+id+"/producto/"+date_start+"/"+date_end+"/1/imprimir",'_blank'); 

      } 

    } else {

      if(!imprimir){  

        window.location = base_url+"balance_sheet/detailServicio/"+id+"/"+tipo+"/"+date_start+"/"+date_end;

      } else {

        window.open(base_url+"balance_sheet/detailImprimir/"+id+"/servicio/"+date_start+"/"+date_end+"/1/imprimir",'_blank'); 

      }

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

function getTotalProducto(){

  var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start_alt').val(),
                      date_end : $('#date_end_alt').val()
                    };

  jQuery.post( base_url+"balance_sheet/getTotalProducto", form_data , 

    function( data ) {

      if(data!=""){
      $("#totalProducto").html("$ "+data);
      $("#inputTotalProducto").val(data);
      costoProducto = data;
    }else{
      $("#totalPS").html("$ 0.00");
      costoProducto = 0;
    }
      getTotal();
  });
}

function getTotalServicio(){

  var form_data = { type     : $('#type').val(),
                      producto : $('#producto').val(),
                      servicio : $('#servicio').val(),
                      date_start : $('#date_start_alt').val(),
                      date_end : $('#date_end_alt').val()
                    };

  jQuery.post( base_url+"balance_sheet/getTotalServicio", form_data , 

    function( data ) {

      if(data!=""){
      $("#totalServicio").html("$ "+data);
      $("#inputTotalServicio").val(data);
      costoServicio = data;
    }else{
      $("#totalServicio").html("$ 0.00");
      costoServicio = 0;
    }
      getTotal();
  });
}

function getTotal(){

  total = parseFloat(costoProducto) + parseFloat(costoServicio);
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