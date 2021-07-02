$(document).ready(function(){
    let rol = localStorage.getItem('rol');

    if(rol === "ESTUDIANTE"){
        if($(".nav-prof").hasClass("d-none") === false){
            $(".nav-prof").addClass("d-none");
        }
        if($(".nav-coor").hasClass("d-none") === false){
            $(".nav-coor").addClass("d-none");
        }
        if($(".nav-estu").hasClass("d-none")){
            $(".nav-estu").removeClass("d-none");
        }
        logNombre();
    }
    else if(rol === "COORDINADOR"){
        if($(".nav-estu").hasClass("d-none") === false){
            $(".nav-estu").addClass("d-none");
        }
        if($(".nav-prof").hasClass("d-none")){
            $(".nav-prof").removeClass("d-none");
        }
        if($(".nav-coor").hasClass("d-none")){
            $(".nav-coor").removeClass("d-none");
        }
        logNombre();
    }
    else if(rol === "PROFESOR"){
        if($(".nav-estu").hasClass("d-none") === false){
            $(".nav-estu").addClass("d-none");
        }
        if($(".nav-coor").hasClass("d-none") === false){
            $(".nav-coor").addClass("d-none");
        }
        if($(".nav-prof").hasClass("d-none")){
            $(".nav-prof").removeClass("d-none");
        }
        logNombre();
    }
    else{
        localStorage.setItem("error","Debe iniciar sesión para usar la plataforma");
        window.location.replace("../index.html");
    }

    $(".btn-log").click(function(event){
        event.preventDefault();
        let correo = "correo="+localStorage.getItem("correo");
        if(rol != null){
            $.ajax({
                type: "GET",
                url: "../Controllers/usuarioController.php",
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
                        window.location.replace("../index.html");
                    }
                }
            });
        }
    });
});
function logNombre(){
    let nombre = localStorage.getItem("nombre");
    $("#lblUsuarioLog").html(nombre);
}