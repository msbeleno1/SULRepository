$(document).ready(function(){
    let localData = localStorage.getItem("changePassword");

    if(localData != "cambio"){
        localStorage.removeItem("changePassword");
        redirection();
    }

    $("#omitir").click(function(){
        redirection();
    });
});
function redirection(){
    let rol = localStorage.getItem("rol");
    if(rol === "ESTUDIANTE"){
        window.location.replace("verNotas.html");
    }
    else if(rol === "PROFESOR"){
        window.location.replace("asignarNotas.html");
    }
    else if(rol === "COORDINADOR"){
        window.location.replace("usuarios.html");
    }
    else{
        window.location.replace("../index.html");
    }
}