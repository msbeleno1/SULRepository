$(document).ready(function(){

    $(".groupPassword a").click(function(event) { // AGREGAMOS UN EVENTO CLICK AL BOTON DE MOSTRAR CONTRASEÑA (ICONO DEL OJO)
        event.preventDefault(); // SE CANCELARA EL EVENTO, SIN DETENER EL FUNCIONAMIENTO DEL EVENTO YA EN EJECUCION
        if($('.groupPassword input').attr("type") == "text"){ // SI EL ATRIBUTO TYPE DEL BOTON ES "text":
            $('.groupPassword input').attr('type', 'password'); // SE CAMBIO EL TYPE A "password"
            $('.groupPassword em').addClass( "fa-eye-slash" ); // SE AGREGA LA CLASE "fa-eye-slash"(OJO CERRADO) PARA QUE EL ICONO CAMBIE
            $('.groupPassword em').removeClass( "fa-eye" ); // SE ELIMINA LA CLASE "fa-eye"(OJO ABIERTO) PARA QUE QUEDE SOLO EL ICONO DEL OJO CERRADO
        }else if($('.groupPassword input').attr("type") == "password"){ // SI EL ATRIBUTO TYPE DEL BOTON ES "password":
            $('.groupPassword input').attr('type', 'text'); // SE CAMBIO EL TYPE A "text"
            $('.groupPassword em').removeClass( "fa-eye-slash" ); // SE ELIMINA LA CLASE "fa-eye-slash"(OJO CERRADO) PARA QUE QUEDE SOLO EL ICONO DEL OJO ABIERTO
            $('.groupPassword em').addClass( "fa-eye" ); // SE AGREGA LA CLASE "fa-eye"(OJO ABIERTO) PARA QUE EL ICONO CAMBIE
        }
    });

    $('form').submit(function(event){
        // EVITAMOS EL ENVÍO DE DATOS AL FORMULARIO
        event.preventDefault();
        event.stopPropagation();

        // QUITAMOS EL MENSAJE DE ERROR EN CASO DE QUE EXISTA
        if($(this).find("#msg-error-login").hasClass('d-none') === false){
            $(this).find("#msg-error-login").addClass("d-none");
        }

        // VALIDAMOS SI LOS CAMPOS DEL FORMULARIO CUMPLEN CON LAS ENTRADAS SOLICITADAS (TIPO DATO, ETC)
        if (this.checkValidity() === true) {
            $(".was-validated").each(function(){
                $(this).removeClass('was-validated');
            });

            // MOSTRAMOS EL MENSAJE DE CARGANDO GRACIAS A LA CLASE SPINNER DE BOOSTRAP 4.6
            $(this).find(".btn-submit").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...');
            ajaxForm(this);
        }
        this.classList.add('was-validated');
    })

    $("button[type='reset']").click(function(){
        $(".was-validated").each(function(){
            $(this).removeClass('was-validated');
        });

        // QUITAMOS EL MENSAJE DE ERROR EN CASO DE QUE EXISTA
        if($("#msg-error-login").hasClass('d-none') === false){
            $("#msg-error-login").addClass("d-none");
        }

        // DEJAMOS LA CONTRASEÑA COMO NO VISIBLE EN CASO DE QUE ESTÉ VISIBLE
        if($('.groupPassword input').attr("type") == "text"){
            $('.groupPassword input').attr('type', 'password');
            $('.groupPassword em').addClass( "fa-eye-slash" );
            $('.groupPassword em').removeClass( "fa-eye" );
        }
    });

    $("#btnCreate").click(function(){
        $("#usuarioModalTitle").html("Creación de usuarios");
        if($("#group-edit").hasClass('d-none') === false){
            $("#group-edit").addClass("d-none");
        }
        $("#opcion").val("create");
        $("#txtDocumento").attr('readonly',false);
        $("#txtClave1").attr('disabled',false);
        $("#txtClave2").attr('disabled',false);
        $("#txtEstado").attr('disabled',true);
        $("#formUsuario").trigger('reset');
        $('#txtEstado option[selected]').attr("selected",false);
        $('#txtEstado option[value='+ 1 +']').attr("selected",true);
        $('#txtRol option[value=""]').attr("selected",true);
        $("#formUsuario").find(".btn-submit").html("Registrar");
    });

    $(".btn-close").click(function(){
        $(".was-validated").each(function(){
            $(this).removeClass('was-validated');
        });

        // DEJAMOS LA CONTRASEÑA COMO NO VISIBLE EN CASO DE QUE ESTÉ VISIBLE
        if($('.groupPassword input').attr("type") == "text"){
            $('.groupPassword input').attr('type', 'password');
            $('.groupPassword em').addClass( "fa-eye-slash" );
            $('.groupPassword em').removeClass( "fa-eye" );
        }
    });
});

