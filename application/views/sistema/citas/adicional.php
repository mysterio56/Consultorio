<?php

  $attributes = array('id' => 'addForm');

$datetime1 = new DateTime();
$datetime2 = new DateTime($fecha);

$interval = $datetime1->diff($datetime2);

  echo form_open(null,$attributes);
	
  echo '<input type="hidden" name="cita_id" value="'.$cita_id.'" />';
  echo '<input type="hidden" name="estatus" value="'.$estatus.'" />';

	echo '<table class="table_form">';

  if ( $interval->format('%R%a') >= 0 && $estatus == 2){

	echo '<tr>';

		echo '<tr>';
		echo '<td width="25%">';
	 		echo form_label('Producto:');
	 	
	 	?>
		<td style="width: 35%;">
			 <div id="wait_tp" class="wait">
	  	  		<p>Cargando productos</p>
	  	 	</div>
			<div class="select_reload">
        
			 	<select name="producto" id="producto"></select>
        
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getProducto();"/>
			</div>

      <label>Cantidad:</label>

      <input name="cantidad_prod" id="cantidad_prod" value="1" style="width:45px"/>
		    
		 </td>
</tr>
<?php
		echo '</td>';
				
		echo  '<td>';
			echo form_label('Servicio: ');
		?>
		<td width="25%">
      <div id="wait_serv" class="wait">
            <p>Cargando servicios</p>
        </div>
			    <div class="select_reload">
			 	<select name="servicio" id="servicio"></select>
			 	<td>
			    <img src     = "<?= base_url('assets/images/reload.png'); ?>" 
			         style   = "width:16px; height:16px;cursor:pointer;"
			         onClick = "getServicio();"/>
			</div>
		    
      <label>Cantidad:</label>

      <input name="cantidad_serv" id="cantidad_serv" value="1" style="width:45px"/>

		 </td>
</tr>
<?php 
}
?>
<tr>
  <td width="25%">
    <?= form_label('Total: '); ?>
  </td>
  <td id="total" style="color:#000">
    
  </td>  
</tr>
<?php
		 	echo '</td>';
	echo '</tr>';
	echo'</table>';

   if ( $interval->format('%R%a') >= 0 && $estatus == 2){

		 	echo '<a href="javascript:void(0)" onclick="addGrid();" class="abutton_add">Agregar Adicionales</a>';
      
    }

echo form_close();

?>		 	

<section class="datagrid" >
	<table>
		<thead>
			<tr>
				<th align="center">Código</th>
				<th align="center" style="width:200px">Producto/Servicio</th>
        <th align="center">Cantidad</th>
				<th align="center">Costo</th>

       <?php if ( $interval->format('%R%a') >= 0 && $estatus == 2): ?>

        <th align="center">Borrar</th>

      <?php endif; ?>

			</tr>
		</thead>
    <tbody id="tbodyAdd" >

      <?php

          echo  '<tr>';
          echo  '<td>'.$servicio->codigo.'</td>';
          echo  '<td>'.$servicio->nombre.'</td>';
          echo  '<td>1</td>';
          echo  '<td class="costo" align="right">$ '.$costo.'</td>';
          echo  '</tr>';

          foreach($ingresos as $key => $ingreso){

            $ingreso->producto->get();
            $ingreso->servicio->get();

            echo '<tr id="add_'.$ingreso->id.'">';
              echo '<td>';
              echo $ingreso->producto_id?$ingreso->producto->codigo:$ingreso->servicio->codigo;
              echo '</td>';
              echo '<td>';
              echo $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre;
              echo '</td>';
              echo '<td>';
              echo $ingreso->sumCantidad;
              echo '</td>';
              echo '<td class="costo" align="right">$ ';
              echo $ingreso->sumCosto;
              echo '</td>';
              echo '<td>';
              echo '<img id="imgDelete_'.$ingreso->id.'" src="'.base_url('assets/images/delete.png').'" onClick="deleteAdd('.$ingreso->id.');"/>';
              echo '<img id="imgWait_'.$ingreso->id.'" src="'.base_url('assets/images/wait.gif').'" class="ico hide"/>';
              echo '</td>';
            echo '</tr>';
          }
      ?>
    </tbody> 
		</table>   
</section>
 <a href="<?= base_url($return); ?>" class="abutton_cancel">Cancelar</a>
<script>
$(function () {
  
  base_url = "<?= base_url(); ?>";
  getProducto();
  getServicio();
  getTotal();
  oddEven();

  $('.screenLoad').hide();
  
}); 

function getTotal(){

  total = 0;

  $.each($('.costo'),function(key, costo){
          costo = costo.innerHTML.replace("$ ","");
          total = total + parseFloat(costo);

        }); 

  $("#total").html('$ '+number_format(total,2,".",","));

}

function number_format (number, decimals, dec_point, thousands_sep) {

  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
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

    $.getJSON( base_url + "service/lista_buy", function( data ) {

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

function addGrid(){

  if($('#servicio').val() != 0 || $('#producto').val() != 0){

    var form_data = jQuery('#addForm').serialize();

    jQuery.post( base_url+"appointment/insert_adicional/", form_data , 

      function( data ) {

        $.each(data, function(key,ingreso){
            rowAdd  = "<tr id='add_"+ingreso.id+"'>";
            rowAdd += "<td>"+ingreso.codigo+"</td>";
            rowAdd += "<td>"+ingreso.nombre+"</td>";
            rowAdd += "<td>"+ingreso.cantidad+"</td>";
            rowAdd += "<td class='costo' align='right'>$ "+ingreso.costo+"</td>";  
            rowAdd += "<td><img id='imgDelete_"+ingreso.id+"' src='"+base_url+"/assets/images/delete.png' onclick='deleteAdd("+ingreso.id+")'/><img id='imgWait_"+ingreso.id+"' src='"+base_url+"/assets/images/wait.gif' class='ico hide'/></td>";      
            rowAdd += "</tr>";

            $('#tbodyAdd').append(rowAdd);
            $('#servicio').val(0);
            $('#servicio_id').val("");
            $('#producto').val(0);
            $('#producto_id').val("");
        });

        oddEven();
        getTotal();

      }, "json");
  }
}

function oddEven(){
  $.each($('#tbodyAdd').children(),function(key, tr){

          classRow = (key % 2 == 0)?'odd':'even';
          $(tr).addClass(classRow);
        });  
}

function deleteAdd(id_ingreso){

  $('#imgDelete_'+id_ingreso).hide();
  $('#imgWait_'+id_ingreso).show();

  jQuery.post( base_url+"appointment/delete_adicional/", {idIngreso:id_ingreso} , 

      function( data ) {
       if(data.addDelete){
        $('#add_'+id_ingreso).remove();
        oddEven();
       }else{
        $('#imgDelete_'+id_ingreso).show();
        $('#imgWait_'+id_ingreso).hide();
        alert("Error en la base de datos");
       }

       oddEven();
       getTotal();

      }, "json");

}

</script>
