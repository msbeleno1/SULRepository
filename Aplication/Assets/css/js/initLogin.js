$(document).ready(function(){
    let rol = localStorage.getItem("rol");
    let error = localStorage.getItem("error");
    if(rol != null){
        let correo = "correo="+localStorage.getItem("correo");
        $.ajax({
            type: "GET",
            url: "Controllers/usuarioController.php",
            data: correo,
            datatype: "text",
            success: function( response ){
                if(response === "Eliminado"){
                    localStorage.removeItem("rol");
                    localStorage.removeItem("nombre");
                    localStorage.removeItem("correo");
                    let cambioPass = localStorage.getItem("changePassword");
                    if(cambioPass != null){
                        localStorage.removeItem("changePassword");
                    }
                }
            }
        });
    }

    if(error != null){
        $("#msg-error-login").html(error);
        if($("#msg-error-login").hasClass("d-none")){
            $("#msg-error-login").removeClass("d-none");
        }
        localStorage.removeItem("error");
    }
});