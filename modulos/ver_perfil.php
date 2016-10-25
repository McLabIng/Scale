<?php
require_once 'vista/vw_ver_perfil.php';

if (isset($_SESSION['cod_usuario'])) {
    $cod_usuario = $_SESSION['cod_usuario'];
}
else {
    echo '<script>alert("Error, no se ha podido rescatar el codigo del usuario");</script>';
}

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>Perfil </h2>
    </div>
</div>
<div class="row">

    <div class="col-lg-10">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Mis datos </h5><br>
                </div>
                <div class="ibox-content">
                    <?php
                    // Vista de edicion de usuarios
                    vw_ver_perfil::formulario_edit_usuario($cod_usuario);
                    ?>
                </div><!-- ibox Content -->
            </div><!-- ibox -->
        </div><!-- wraper -->
    </div><!-- Col-lg-6 -->

</div><!-- Row -->

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Chosen -->
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<!-- JSKnob -->
<script src="js/plugins/jsKnob/jquery.knob.js"></script>

<!-- Input Mask-->
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- NouSlider -->
<script src="js/plugins/nouslider/jquery.nouislider.min.js"></script>

<!-- Switchery -->
<script src="js/plugins/switchery/switchery.js"></script>

<!-- IonRangeSlider -->
<script src="js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>

<!-- MENU -->
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- Color picker -->
<script src="js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- Image cropper -->
<script src="js/plugins/cropper/cropper.min.js"></script>

<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>

<script>
    $(document).ready(function(){

        $('#loading-example-btn').click(function () {
            btn = $(this);
            simpleLoad(btn, true)

            // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

            simpleLoad(btn, false)
        });
    });

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "yyyy-mm-dd"
    });

    (function ($) {
        $('.spinner .btn:first-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
        });
    })(jQuery);

    function validaCantidad(form)
    {
        if(form.cantidad.value <= 1)
        {
            alert("No puede indicar menos de 1 componente");
            form.cantidad.value = 1;
        }
    }

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            setTimeout(function () {
                btn.children().removeClass('fa-spin');
                btn.contents().last().replaceWith(" Refresh");
            }, 2000);
        }
    }

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }


    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html, { color: '#1AB394', size: 'small' });
    });

    function cerrar_ventana()
    {
        window.close();
    }

    function pregunta_campos(){
        if(document.form_crear_usuario.nombre.value.length==0){
            alert("Por favor ingrese el nombre")
            document.form_crear_usuario.nombre.focus()
            return 0;
        }
        else if(document.form_crear_usuario.apellido.value.length==0){
            alert("Por favor ingrese el apellido")
            document.form_crear_usuario.apellido.focus()
            return 0;
        }
        else if(document.form_crear_usuario.username.value.length==0){
            alert("Por favor ingrese el username")
            document.form_crear_usuario.username.focus()
            return 0;
        }
        else if(document.form_crear_usuario.password.value.length==0){
            alert("Por favor ingrese el password")
            document.form_crear_usuario.password.focus()
            return 0;
        }
        else if(document.form_crear_usuario.password.value != document.form_crear_usuario.password_bis.value){
            alert("El password debe coincidir en ambos cuadros de texto")
            document.form_crear_usuario.password.focus()
            return; 0;
        }
        else if(document.form_crear_usuario.email.value.length==0){
            alert("Por favor ingrese el correo")
            document.form_crear_usuario.email.focus()
            return 0;
        }
        else if (confirm('Esta seguro de guardar los cambios?')){
            document.form_crear_usuario.submit()
        }
    }

</script>