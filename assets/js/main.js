function Tab() {

}

Tab.newTab = function(name_tab, url_tab)
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
        onChange: "Tab.change();"
      }).appendTo('#carousel-tabs');

      $('<div/>', {
        id: 'div'+name_tab,
        class: 'show'
      }).appendTo('#content');

      $('<iframe/>', {
        src: url_tab
      }).appendTo('#div'+name_tab);

  }

  if (this.arrowsShow() > 609){
     left = 590 - this.arrowsShow();
     $("#carousel-tabs").css("left",left);
  }
  //alert(this.arrowsShow()+'--'+$("#carousel-tabs").css("left"));

  this.change();

}

Tab.change = function()
{ 
  this.allHide();
  name_tab = $("input[name=tab-group]:checked").val();
  $('#content').children('#div'+name_tab).removeClass( "hide" ).addClass( "show" );
  $('#carousel-tabs').children('#label'+name_tab).removeClass( "tabUnChecked" ).addClass( "tabChecked" );
}

Tab.destroyTab = function(destroy_name_tab)
{ 

  $("#label"+destroy_name_tab).remove();
  $("#input"+destroy_name_tab).remove();
  $("#div"+destroy_name_tab).remove();

  this.arrowsShow();

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

Tab.moveRight = function()
{
  var left = $("#carousel-tabs").css("left");
  left = parseInt(left);
  if(left < 0){
    left = left+25;
    $("#carousel-tabs").css("left",left);
  }
  
}

Tab.moveLeft = function()
{
  var left = $("#carousel-tabs").css("left");
  left = parseInt(left)-25;
  $("#carousel-tabs").css("left",left);
}