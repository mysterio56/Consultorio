<section class="ac-container">

    <div>
        <p class="ac-title">Servicios varios</p>
    </div>

   <div>
        <input id="ac-2" name="accordion-1" type="radio" checked/>
        <label for="ac-2"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Citas</label>
        <article>
            <p id="wait_prox_citas" class="hide" ><img src="<?= base_url('assets/images/wait.gif'); ?>" class="ico"> Cargando citas</p>
            <div id="prox_citas">
            </div>
        </article>
   </div>

   <div>
        <input id="ac-1" name="accordion-1" type="radio"/>
        <label for="ac-1"><img src="<?= base_url('assets/images/black-dot.png'); ?>" /> Lo nuevo</label>
        <article>
         <a class="twitter-timeline" 
         href="https://twitter.com/Masqweb" 
         data-widget-id="408349543822934017"
         style="height:auto;width:95%"
         width="305">Tweets por @Masqweb
        </a>
      <script>!function(d,s,id)
      {
        var js,fjs=d.getElementsByTagName(s)[0],
        p=/^http:/.test(d.location)?'http':'https';
        if(!d.getElementById(id)){js=d.createElement(s);
            js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js,fjs);
        }
    }
    (document,"script","twitter-wjs");
    </script>
   </article>
   </div>

</section>

<script>
    $(function(){

        base_url = "<?= base_url(); ?>";
        getProxCitas();

        setInterval(function(){
            getProxCitas();
        },60000);

    });

    function getProxCitas(){

        $('#wait_prox_citas').show();

        $.getJSON( base_url+"appointment/prox_citas/5", function( data ) {

            $('#prox_citas').html("");
    
            if(!data.empty){
                
                $.each(data,function(key,cita){
                    
                        prox_cita  = '<section class="cita-stilo">';
                        prox_cita +=    '<div id="prox-cita">';
                        prox_cita +=        '<div id="datetime">';
                        prox_cita +=            '<p id="date">'+cita.fecha+'</p>'
                        prox_cita +=            '<p id="time">'+cita.hora+' hrs.</p>'
                        prox_cita +=        '</div>';
                        prox_cita +=        '<div>';
                        prox_cita +=            '<div id="detail">';
                        prox_cita +=                '<p>Doctor   <em style="color:#000"> '+cita.doctor+'</em></p>'
                        prox_cita +=                '<p>Paciente <em style="color:#000"> '+cita.paciente+'</em></p>'
                        prox_cita +=            '</div>';
                        prox_cita +=        '</div>';
                        prox_cita +=    '</div>';
                        prox_cita += '</section>';

                        $('#prox_citas').append(prox_cita);   
               });

            } else {

                $('#prox_citas').html("<p>No hay citas para mostrar</p>");

            }

            $('#wait_prox_citas').hide();
               
        });

    }

</script>