<section class="tabs-container">				
  <div id="container">
  <img src="<?php echo base_url("assets/images/logos/".$logo."_bg_logo.png");?>" />
  	  <input type="button" id="moveTabLeft"  class="hide" onClick="Tab.moveRight()" />
	  <div id="tabs">
	  	<div id="carousel-tabs">
		  <!--<input id="tab-1" type="radio" name="tab-group" checked="checked" />
		  <label id="label-1" for="tab-1">Pestaña 1 <input type="butoon" onclick="Tab.destroyTab('content-1','label-1');"/></label>-->
		</div>
	  </div>
	  <input type="button" id="moveTabRight" class="hide" onClick="Tab.moveLeft()" />
	 
	  <div id="content">
		   
		   <!--<div id="content-1" class="visible">
		    	<iframe src="<?= base_url('sistema')?>"></iframe>
		   </div>-->
		   		 
	  </div>
 </div>
</section>