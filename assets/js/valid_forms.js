function Valid() {

}

Valid.login = function()
{

    $('#loginForm').validate({
        rules:{
            usuario:{
                required:true,
                email: true,
                minlength: 5
            },
            password:{
                required:true,
                 minlength: 5
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
    
}

Valid.empleados = function()
{

    this.onlyNum('telefono'); 
    this.onlyNum('celular');

    $('#empleadosForm').validate({
        rules:{
            codigo:{
                required:true,
                 minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                 minlength: 3
            },
            apellido_p:{
                required:true,
                 minlength: 4
            },
            apellido_m:{
                required:true,
                 minlength: 4
            },
            email:{
                required:true,
                email:true,
                minlength: 5
            },
            password:{
                required:true,
                 minlength: 5
            },
            passwordcheck:{
                required:true,
                 minlength: 5,
                 equalTo: "#password"
            },
            telefono:{
                required:true,
                number:true,
                minlength: 8,
                maxlength: 10
            },
            celular:{
                required:true,
                number:true,
                minlength: 10,
                maxlength: 13
            },
            estado: {
                selectcheck: true
            },
            municipio: {
                selectcheck: true
            },
            codigo_postal: {
                selectcheck: true
            },
            colonia: {
                selectcheck: true
            },
            tipo_empleado: {
                selectcheck: true
            },
            calle:{
                required:true
            },
            estado_name:{
                required:true
            },
            municipio_name:{
                required:true
            },
            codigo_postal_name:{
                required:true
            },
            colonia_name:{
                required:true
            },
            tipo_empleado_name:{
                required:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
    
}
Valid.cita = function()
{

    $('#citaForm').validate({
        rules:{
            paciente:{
                required:true,
            },
            doctor:{
                required:true,
            },
            fecha:{
                required:true,
            },
            servicio:{
                required:true,
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.password = function()
{

    $('#passwordForm').validate({
        rules:{
            passwordOld:{
                required:true,
                 minlength: 5
            },
            password:{
                required:true,
                 minlength: 5
            },
            passwordcheck:{
                required:true,
                 minlength: 5,
                 equalTo: "#password"
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
    
}

Valid.paciente = function()
{

    this.onlyNum('telefono'); 
    this.onlyNum('celular');

    $('#pacienteForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 3,
            },
            apellido_p:{
                required:true,
                minlength: 4,
            },
            apellido_m:{
                required:true,
                minlength: 4,
            },
            email:{
                required:true,
                email:true,
                minlength: 5,
            },
            telefono:{
                required:true,
                number:true,
                minlength: 8,
                maxlength: 10
            },
            celular:{
                required:true,
                number:true,
                minlength: 10,
                maxlength: 13
            },
            estado: {
                selectcheck: true
            },
            municipio: {
                selectcheck: true
            },
            codigo_postal: {
                selectcheck: true
            },
            colonia: {
                selectcheck: true
            },
            tipo_empleado: {
                selectcheck: true
            },
            calle:{
                required:true
            },
            estado_name:{
                required:true
            },
            municipio_name:{
                required:true
            },
            codigo_postal_name:{
                required:true
            },
            colonia_name:{
                required:true
            }

        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.consultorio = function()
{

    this.onlyNum('telefono'); 
    this.onlyNum('celular');

    $('#consultorioForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 3
            },
            apellido_p:{
                required:true,
                minlength: 4
            },
            apellido_m:{
                required:true,
                minlength: 4
            },
            email:{
                required:true,
                email:true,
                minlength: 5
            },
            telefono:{
                required:true,
                number:true,
                minlength: 8,
                maxlength: 10
            },
            celular:{
                required:true,
                number:true,
                minlength: 10,
                maxlength: 13
            },
            estado: {
                selectcheck: true
            },
            municipio: {
                selectcheck: true
            },
            codigo_postal: {
                selectcheck: true
            },
            colonia: {
                selectcheck: true
            },
            calle:{
                required:true
            },
            estado_name:{
                required:true
            },
            municipio_name:{
                required:true
            },
            codigo_postal_name:{
                required:true
            },
            colonia_name:{
                required:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}
Valid.busqueda =function()
{
    $('#busquedaForm').validate({
        rules:{
            buscar:{
                required:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
}

Valid.especialidad = function()
{

    $('#especialidadesForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 2
            },
             descripcion:{
                maxlength: 100
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.eliminaregistro = function(url,type, id)
{
   var valid_confirm = confirm("¿Desea eliminar el registro?"); 
        
    if (valid_confirm == true){

      $('#wait_delete_'+id).show();
      $('#'+type+'_delete_'+id).hide();

      $.getJSON( url, function( data ) {
 
            if(!data.error){   

                $('#tr_'+type+'_'+data.id).hide();

            } else {

                alert('Ocurrio un error intente mas tarde');

            }

        });

    } 
}

Valid.changeStatus = function (url,image_url,type, id)
{

    var valid_confirm = confirm("¿Desea cambiar el estatus del registro?"); 
        
    if (valid_confirm == true){

      $('#wait_'+id).show();
      $('#'+type+'_'+id).hide();

      $.getJSON( url, function( data ) {

            if(!data.error){
            
                active = data.estatus?'active':'inactive';    

                $('#'+type+'_'+data.id).attr('src',image_url+'assets/images/'+active+'.png');

            } else {

                alert('Ocurrio un error intente mas tarde');
                console.log(data);
            }

            $('#wait_'+data.id).hide();
            $('#'+type+'_'+data.id).show();

        });

    } 

}

Valid.tipoEmpleado = function()
{

    $('#tipoEmpleadoForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 2
            },
             descripcion:{
                maxlength: 100
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.formato = function()
{

    $('#formatoForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 2
            },
             descripcion:{
                maxlength: 100
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.servicio = function()
{

    $('#servicioForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 2
            },
            costo_c:{
                required:true
            },
            costo_v:{
                required:true
            },
             descripcion:{
                maxlength: 100
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}


Valid.auto_complete = function()
{
    
}

Valid.producto = function()
{

    $('#productoForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 1,
                 maxlength: 10
            },
            nombre:{
                required:true,
                minlength: 2
            },
            costo_c:{
                required:true
            },
            costo_v:{
                required:true
            },
             descripcion:{
                maxlength: 100
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        }
    });
    
}

Valid.onlyNum = function(inputId)
{

    $("#"+inputId).keydown(function(event) {

        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
            (event.keyCode == 65 && event.ctrlKey === true) || 
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
        }
        else {
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }

    });

}

Valid.carga = function(){
    location.reload();
}

Valid.return = function(id_iframe){
    parent.document.getElementById(id_iframe).contentWindow.history.go(-1);
}

function Find() {

}

Find.producto = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
}
    

Find.empleados = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
}
Find.especialidades = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
}
Find.tipoempleados = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
}

Find.pacientes = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
}

Find.fecha_alta_value = function()
{

    $('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});


/*jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "Requerido.");*/
}