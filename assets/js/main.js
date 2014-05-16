function Tab() {

}

Tab.newTab = function(name_tab, url_tab, name_iframe)
{

  name_tab_title = name_tab;
  name_tab       = name_tab.replace(/ /g,"_");

  var valid_tab = $( "#label"+name_tab ).length;

  if(!valid_tab){

      this.allHide();

      var count_radios = $(':radio[name="tab-group"]').length;

      if(count_radios == 0){

        $('#carousel-tabs')
            .append('<label class="tabChecked" id="label'+name_tab+'" for="input'+name_tab+'">'+name_tab_title+'  '+'<img src="'+base_url+'assets/images/x.png" onclick="Tab.destroyTab(\''+name_tab+'\');"/></label>');

      } else {

        $('#carousel-tabs label:eq('+(count_radios-1)+')')
            .after ('<label class="tabChecked" id="label'+name_tab+'" for="input'+name_tab+'">'+name_tab_title+'  '+'<img src="'+base_url+'assets/images/x.png" onclick="Tab.destroyTab(\''+name_tab+'\');"/></label>');

     }
     
      $('<input/>', {
        id: 'input'+name_tab,
        type:'radio',
        name:'tab-group',
        checked: 'checked',
        value: name_tab,
        onChange: "Tab.change('"+name_iframe+"');"
      }).appendTo('#carousel-tabs');

      $('<div/>', {
        id: 'div'+name_tab,
        class: 'show'
      }).appendTo('#content');

      iframe = $('<iframe/>', {
        name: name_iframe, 
        src : url_tab,
        id  : name_iframe,
        onLoad: 'Tab.iframe("'+name_iframe+'")',
      }).appendTo('#div'+name_tab);



  } else {

     $.each($('#input'+name_tab), function(key,input){
        input.checked = true;
     });

     if (this.arrowsShow() > 609){
       $("#carousel-tabs").animate({"left":this.tabChange('label'+name_tab)});
      }

  }

  if (this.arrowsShow() > 609){
     left = 590 - this.arrowsShow();
     $("#carousel-tabs").css("left",left);
  }
 
  this.change(name_iframe);

}

Tab.iframe = function(obj)
{

  heightDiv = 0;

  $.each($('.ac-container').children(),function(key,div){
    heightDiv = heightDiv + $(div).height();
  });

height = $('#'+obj).contents().find("html").height();

$('#'+obj).animate({"height":height});

//if(heightDiv < height){
 // $('#'+obj).css("height",1);

    if(height<400){
      height = 400;
    }

    $('#'+obj).animate({"height":height});

   // if(heightDiv < height){
      $('.ac-container').animate({"min-height":height+30});
    //}
    
    //$("#wrapper").animate({"height":height+50});
    //$(".main-container").animate({"height":height+46});
    //$(".main-container").animate({"height":height+46});
//  }


/*$("iframe#"+obj).load(function() {
    height = $('#'+obj).contents().find("html").height();
    if(height<400){
      height = 400;
    }
    $('#'+obj).animate({"height":height});
    $("#wrapper").animate({"height":height+80});
    $(".main-container").animate({"height":height+40});
});*/

    

 /* $("#"+name_iframe).load(function() {

        height = $("#"+name_iframe).contents().find("html").height();
        if(height < 400){
          height = 400;
        }
          $("#"+name_iframe).animate({"height":height});
          //$("#div-container").animate({"height":height+50});
         // $(".main-container").animate({"height":height+98});
         // $("#wrapper").animate({"height":height+100});
      
    });

  if($("#"+name_iframe).contents().find("html").height() >= 400){
            if(height < 400){
              height = 400;
            }
              $("#"+name_iframe).animate({"height":height});
            //  $("#div-container").animate({"height":height+50});
              //$(".main-container").animate({"height":height+98});
            //  $("#wrapper").animate({"height":height+100});
  }*/
}

Tab.change = function(iframe)
{
  Tab.iframe(iframe); 
  this.allHide();
  name_tab = $("input[name=tab-group]:checked").val();
  $('#content').children('#div'+name_tab).removeClass( "hide" ).addClass( "show" );
  $('#carousel-tabs').children('#label'+name_tab).removeClass( "tabUnChecked" ).addClass( "tabChecked" );

}

Tab.destroyTab = function(destroy_name_tab)
{ 

  labelClass = $("#label"+destroy_name_tab).attr("class");
  $("#label"+destroy_name_tab).remove();
  $("#input"+destroy_name_tab).remove();
  $("#div"+destroy_name_tab).remove();

  this.arrowsShow();

  numInputs = $("#carousel-tabs").children('input');

  if(numInputs.length > 0 && labelClass == "tabChecked"){

    iframe   = $(numInputs[numInputs.length-1]).attr("onChange");
    name_tab = $(numInputs[numInputs.length-1]).val();

    iframe = iframe.split("'");
    Tab.iframe(iframe[1]);

    $('#content').children('#div'+name_tab).removeClass( "hide" ).addClass( "show" );
    $('#carousel-tabs').children('#label'+name_tab).removeClass( "tabUnChecked" ).addClass( "tabChecked" );

  }

}

Tab.allHide = function()
{
  $('#content').children('div').removeClass( "show" ).addClass( "hide" );
  $('#carousel-tabs').children('label').removeClass( "tabChecked" ).addClass( "tabUnChecked" );
}

Tab.arrowsShow = function()
{
var width_lables = 0;
  $( "#carousel-tabs" ).children("label").each(function( index ) {
     width_lables += parseInt($( this ).css('width'));
  });

  if(width_lables > 609){
     $( "#container" ).children(".hide").removeClass( "hide" ).addClass( "show" );
  } else {
    if(parseInt($('#carousel-tabs').css('left'))>=0 ){
      $( "#container" ).children(".show").removeClass( "show" ).addClass( "hide" );
    }
  }

  return width_lables;
}

Tab.tabChange = function(input)
{
var width_lables = 0;
  $( "#carousel-tabs" ).children("label").each(function( index ) {
     width_lables += parseInt($( this ).css('width'));
     
     if(input == this.id){
        nReturn = (width_lables-parseInt($( this ).css('width'))) * -1 ;
      }

  });

  return nReturn;
}

Tab.moveRight = function()
{
  var left = $("#carousel-tabs").css("left");
  left = parseInt(left);
  if(left < 0){
    left = left+100;
    $("#carousel-tabs").animate({"left":left},200);
  } else {
    $("#carousel-tabs").animate({"left":0},200);
  }
  
}

Tab.moveLeft = function()
{
  var left = $("#carousel-tabs").css("left");
  left = parseInt(left)-100;

  limit1 = (Tab.arrowsShow()/2)*-1;
  limit2 = $("#carousel-tabs").css("left");

  if(parseInt(limit2) > limit1){
     $("#carousel-tabs").animate({"left":left},200);
  }
}

/*** Funciones para la animacion del banner ***/ 
function Banner() {

  var innerHeight = $( window ).height(); 

  if(innerHeight<=656){

    setTimeout("Banner.hide();",3000);

  }else{

    //setTimeout("$('#ac-1').attr('checked', true)",100);

  }

}

Banner.hide = function()
{
  $('.banner-container').animate({"height": "30px"});
  $('.banner-container').attr({"title": "Da click para expander"});
  $('#prox-cita').animate({width: "100%"});

  if($("#proxCitaEmpty").css("display") == "none"){
    $('#detail-cita').hide();
    $('#detail-cita-small').show();
    $('#detail-cita-small').css({display: 'inline-block'});
  }
  $('#doctors').hide();
  $('#head-cita').css({'width':'150px',
                       'padding-left': '50px',
                       'padding-top': '4px',
                       'background-position': '25px 3px',
                       'background-size': '18px'});
  $('#date, #time').css('padding','7px');

  $(".tabs-container").animate({"height":435});
  
}

Banner.show = function()
{
  $('.banner-container').animate({"height": "130px"});
  $('.banner-container').attr({"title": "Da click para ocultar"});
  $('#prox-cita').animate({width: "31%"});
  $('#doctors').show();
  if($("#proxCitaEmpty").css("display") == "none"){
    $('#detail-cita').show();
    $('#detail-cita-small').css({display: 'none'});
  }

  $('#head-cita').css({'width':'100%',
                       'padding-left': '0px',
                       'padding-top': '7px',
                       'background-position': '77px 5px',
                       'background-size': '21px'});
  $('#date, #time').css('padding','10px');
}

Banner.showHide = function()
{
  if($('.banner-container').css("height") == "30px"){
    this.show();
  } else {
    this.hide();
  }
}

var banner = new Banner();