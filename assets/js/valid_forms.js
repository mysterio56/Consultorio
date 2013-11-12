function Valid() {

}

Valid.login = function()
{

    $('#loginForm').validate({
        rules:{
            usuario:{
                required:true,
                email: true
            },
            password:{
                required:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
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
                required:true
            },
            nombre:{
                required:true
            },
            apellido_p:{
                required:true
            },
            apellido_m:{
                required:true
            },
            email:{
                required:true,
                email:true
            },
            telefono:{
                required:true,
                number:true
            },
            celular:{
                required:true,
                number:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
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
                required:true
            },
            nombre:{
                required:true
            },
            apellido_p:{
                required:true
            },
            apellido_m:{
                required:true
            },
            email:{
                required:true,
                email:true
            },
            telefono:{
                required:true,
                number:true
            },
            celular:{
                required:true,
                number:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
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
                required:true
            },
            nombre:{
                required:true
            },
            apellido_p:{
                required:true
            },
            apellido_m:{
                required:true
            },
            email:{
                required:true,
                email:true
            },
            telefono:{
                required:true,
                number:true
            },
            celular:{
                required:true,
                number:true
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
        }
    });
    
}

Valid.especialidad = function()
{

    $('#especialidadesForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 4
            },
            nombre:{
                required:true,
                minlength: 2
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
        }
    });
    
}

Valid.tipoEmpleado = function()
{

    $('#tipoEmpleadoForm').validate({
        rules:{
            codigo:{
                required:true,
                minlength: 4
            },
            nombre:{
                required:true,
                minlength: 2
            }
        },
        errorElement: 'div',
        wrapper: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element); // default function
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

Valid.return = function(){
    history.back();
}

function Find() {

}
    

Find.empleados = function()
{

    $('#empleadosForm')
        .children('#fecha_alta_value')
            .datepicker({
                altField:   "#fecha_alta",
                altFormat:  "yy-mm-dd",
                dateFormat: "dd M yy"});
    
}