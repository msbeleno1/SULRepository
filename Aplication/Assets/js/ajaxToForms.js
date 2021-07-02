function ajaxForm(form){
    let dataForm;
    dataForm = $(form).serialize();

    // FORMULARIO DE LOGIN
    if($(form).attr("id") === "formLogin"){

        // SERIALIZAMOS LA INFORMACION DEL FORMULARIO Y LE AGREGAMOS EL VALOR DEL PARAMETRO OPCION
        dataForm = dataForm+"&opcion=login";
        let correo = $("#txtCorreo").val();
        interaccionControles(form, true);

        $.ajax({
            type: "POST",
            url: "Controllers/usuarioController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                console.log(response);
                let data = JSON.parse(response);
                console.log(data);
                if(data.informacion === "error"){
                    interaccionControles(form, false);
                    $(form).find("#msg-error-login").removeClass("d-none"); // MOSTRAMOS EL MENSAJE DE ERROR
                    $(form).find("#msg-error-login").html(data.datos);
                    $(form).find(".btn-submit").html('Ingresar'); // CAMBIAMOS EL CONTENIDO DEL BOTON SUBMIT
                }
                else{
                    localStorage.setItem("nombre",data["datos"].nombre);
                    localStorage.setItem("rol",data["datos"].rol);
                    localStorage.setItem("correo",correo);

                    if(data["datos"].clave === "reject"){
                        window.location.replace("Views/changePassword.html");
                        localStorage.setItem("changePassword", "cambio");
                    }
                    else if(data["datos"].rol === "ESTUDIANTE"){
                        window.location.replace("Views/verNotas.html");
                    }
                    else if(data["datos"].rol === "PROFESOR"){
                        window.location.replace("Views/asignarNotas.html");
                    }
                    else{
                        window.location.replace("Views/usuarios.html");
                    }
                }
            },
        });
    }

    // FORMULARIO DE RESTABLECER CONTRASEÑA
    else if($(form).attr("id") === "frmRefresh"){

        // SERIALIZAMOS LA INFORMACION DEL FORMULARIO Y LE AGREGAMOS EL VALOR DEL PARAMETRO OPCION
        dataForm = "txtDocumentoRefresh="+$("#txtDocumentoRefresh").val()+"&txtEstadoRefresh="+$("#txtEstadoRefresh").val()+"&opcion=refresh";
        interaccionControles(form, true);

        $.ajax({
            type: "POST",
            url: "../Controllers/usuarioController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                interaccionControles(form, false);
                $(form).find(".btn-submit").html('Ingresar');
                $(form).parents('.modal').modal('hide');
                notificar(response);
                cargarTableUsuarios(response);
            },
        });
    }

    // FORMULARIO PARA DAR DE BAJA UN USUARIO
    else if($(form).attr("id") === "frmDelete"){

        // SERIALIZAMOS LA INFORMACION DEL FORMULARIO Y LE AGREGAMOS EL VALOR DEL PARAMETRO OPCION
        dataForm = "txtDocumentoDelete="+$("#txtDocumentoDelete").val()+"&txtEstadoDelete="+$("#txtEstadoDelete").val()+"&opcion=delete";
        interaccionControles(form, true);

        $.ajax({
            type: "POST",
            url: "../Controllers/usuarioController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                interaccionControles(form, false);
                $(form).find(".btn-submit").html('Eliminar');
                $(form).parents('.modal').modal('hide');
                notificar(response);
                cargarTableUsuarios(response);
            },
        });
    }

    // FORMULARIO PARA EDITAR UN USUARIO
    else if($(form).attr("id") === "formUsuario"){
        interaccionControles(form, true);
        console.log(dataForm);

        $.ajax({
            type: "POST",
            url: "../Controllers/usuarioController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                interaccionControles(form, false);
                $(form).find(".btn-submit").html('Crear');
                $(form).parents('.modal').modal('hide');
                notificar(response);
                cargarTableUsuarios(response);
            },
        });
    }

    // FORMULARIO PARA CAMBIAR LA CONTRASEÑA AL INGRESAR
    else if($(form).attr("id") === "formChangePassword"){
        interaccionControles(form, true);
        dataForm = dataForm + "&correo=" +localStorage.getItem("correo");
        $.ajax({
            type: "POST",
            url: "../Controllers/usuarioController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                interaccionControles(form, false);
                let data = JSON.parse(response);
                if(data.informacion === "exito"){
                    localStorage.removeItem("changePassword");
                    redirection();
                }
                else{
                    window.location.reload();
                }
            },
        });
    }

    // FORMULARIO PARA EDITAR LAS NOTAS
    else if($(form).attr("id") === "formEstudiante"){
        interaccionControles(form, true);
        $.ajax({
            type: "POST",
            url: "../Controllers/estudianteController.php",
            data: dataForm,
            datatype: "text",
            success: function( response ) {
                interaccionControles(form, false);
                $(form).find(".btn-submit").html('Guardar');
                $(form).parents('.modal').modal('hide');
                notificar(response);
                cargarTableEstudiantes(response);
            },
        });
    }
}

function notificar(response){
    console.log(response);
    let data = JSON.parse(response);
    console.log(data);
    if(data.informacion === "error"){
        showToastError(data.datos); // Mostramos la notificación del error
    }
    else{
        showToastSuccess(data.datos);
    }
}

function showToastError(mensaje){
    $("#lblToastError").html(mensaje);
    $('#toastError').toast('show')
}

function showToastSuccess(mensaje){
    $("#lblToastSuccess").html(mensaje);
    $('#toastSuccess').toast('show')
}

function interaccionControles(form, opcion){
    // VALIDAMOS SI EL FORMULARIO ESTA DENTRO DE UN MODAL
    if($(form).parents('.modal').attr("id") != undefined){

        // DESHABILITANOS LOS CONTROLES DE TODO EL MODAL
        $(form).parents(".modal").find("*").attr('disabled', opcion);
    }
    else{
        // EN CASO CONTRARIO SOLO DESHABILITAMOS CONTROLES QUE ESTÁN DENTRO DEL FORMULARIO
        $(form).find("*").attr('disabled', opcion);
    }
}