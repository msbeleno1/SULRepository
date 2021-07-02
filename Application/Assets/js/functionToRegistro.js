$(document).ready(function(){
    
    // CADA VEZ QUE PRESIONE UNA TECLA EN EL INPUT DE CONFIRMAR CONTRASEÑA, HARA LO SIGUIENTE:
    $("#txtClave2").keyup(function (){
        let claveUnicode = "";

        // OBTENEMOS EL TEXTO INGRESADO EN LA PRIMERA CONTRASEÑA
        let clave = $("#txtClave1").val();

        // CONVERTIMOS CADA CARACTER DE LA PRIMERA CONTRASEÑA A UNICODE Y LOS ALMACEMOS UNA NUEVA CADENA
        for(let i = 0; i < clave.length; i++){
            claveUnicode += ascii_to_hexa(clave.charAt(i));
        }

        // CAMBIAMOS EL PATTERN DEL INPUT DE LA SEGUNDA CONTRASEÑA PARA QUE POR OBLIGACIÓN DEBAN SER IGUALES
        $("#txtClave2").attr("pattern","^("+claveUnicode+")$");

        // POR SEGURIDAD TAMBIEN CAMBIAMOS EL NUMERO DE CARACTERES MINIMOS EN EL INPUT DE LA SEGUNDA CONTRASEÑA
        $("#txtClave2").attr("minlength",clave.length);
    });

    // EN CASO DE QUE EL VALOR DE LA PRIMERA CONTRASEÑA CAMBIE, SE REPETIRÁ EL MISMO PROCESO QUE CUANDO PRESIONA UNA TECLA EN EL INPUT "CONFIRMAR CONTRASEÑA"
    $("#txtClave1").keyup(function(){
        $("#txtClave2").keyup();
    });

    // FUNCION PARA CONVERTIR UNA CADENA EN CARACTERES UNICODE
    function ascii_to_hexa(str){
        var arr1 = [];
        for (var n = 0, l = str.length; n < l; n ++) 
        {
            let hex = Number(str.charCodeAt(n)).toString(16);
            let unicode = "\\u00"+hex.toString();
            arr1.push(unicode);
        }
        return arr1.join('');
    }
});