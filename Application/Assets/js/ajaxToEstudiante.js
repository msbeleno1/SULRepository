$(document).ready(function(){
    let nombre = localStorage.getItem("nombre");
    let dataForm = "opcion=verNotas&nombre="+nombre;
    console.log(dataForm);

    $.ajax({
        type: "POST",
        url: "../Controllers/estudianteController.php",
        data: dataForm,
        datatype: "text",
        success: function( response ) {
            console.log(response);
            let data = JSON.parse(response);
            console.log(data);

            if(data.informacion == "exito"){
                console.log(data.datos);
                
                $("#txtNota1").val(data["datos"].nota1);
                $("#txtNota2").val(data["datos"].nota2);
                $("#txtNota3").val(data["datos"].nota3);
                $("#txtNota4").val(data["datos"].nota4);
                $("#txtNotaFinal").val(data["datos"].nota_final);

                if(parseFloat($("#txtNotaFinal").val())<3.5){
                    if($("#msg-lost").hasClass('d-none')){
                        $("#msg-lost").removeClass('d-none')
                    }
                    if($("#msg-win").hasClass('d-none') === false){
                        $("#msg-win").addClass('d-none')
                    }
                }
                else{
                    if($("#msg-win").hasClass('d-none')){
                        $("#msg-win").removeClass('d-none')
                    }
                    if($("#msg-lost").hasClass('d-none') === false){
                        $("#msg-lost").addClass('d-none')
                    }
                }
            }
        },
    });
});