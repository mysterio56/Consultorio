<?php $aPermisos = unserialize (PERMISOS); ?>
<?php $aMeses    = unserialize (MESES); ?>

<section class="datagrid" >
	<table>

	</table>
</section>

	<?php if(in_array($permisos,$aPermisos['Agregar']) ): ?>

		<a class="abutton" href="<?= base_url('appointment/agregar') ?>">Agregar</a>

	<?php endif; ?>

<script>

$.noConflict();

base_url = "<?= base_url(); ?>";

jQuery(function(){

});

function grid(){

	jQuery.post( base_url+"appointment/grid", 
		{ 
			tipo: jQuery('input[name=estatus_citas]:checked').val()
		}, 

		function( data ) {
	  		console.log(data);
		}, "json");

}

</script>