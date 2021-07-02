$(document).ready(function(){
    let dataForm = "opcion=actualizar";

	// PARA LA VISTA DE USUARIOS
    if($('table').attr('id') == "table-usuarios"){

        // PETICION AJAX PARA ACTUALIZAR LA TABLA DE USUARIOS
		$.ajax({
			type: "POST",
	        url: "../Controllers/usuarioController.php",
			data:dataForm,
			success: function(response){
				cargarTableUsuarios(response);
			},
		});

        // EVENTO CLICK DEL BOTON EDITAR DE LA TABLA DE USUARIOS
		$("#table-usuarios tbody").on("click",".edit",function(){
			
			// OBTENEMOS LA INFORMACIÓN DE LA FILA
			let dataRow = dataTable.row($(this).parents()).data();
            console.log(dataRow);
			
			// CARGAMOS LA INFORMACIÓN AL FORMULARIO DE EDICIÓN
            $("#usuarioModalTitle").html("Edición de usuarios");
            if($("#group-edit").hasClass('d-none')){
                $("#group-edit").removeClass("d-none");
            }

			$("#opcion").val("edit");
			$("#txtDocumento").val(dataRow.documento);
            $("#txtDocumento").attr('readonly',true);
            $("#txtClave1").attr('disabled',true);
            $("#txtClave2").attr('disabled',true);
			$("#txtEstado").attr('disabled',false);

			$("#txtNombres").val(dataRow.nombres);
			$("#txtClave1").val("******************");
            $("#txtClave2").val("******************");
            $("#txtCorreo").val(dataRow.correo);
			$("#txtFecha").val(dataRow.fecha);
            $('#txtEstado option[value='+ dataRow.estado +']').attr("selected",true);
			$('#txtRol option[value='+ dataRow.rol +']').attr("selected",true);
			$("#formUsuario").find(".btn-submit").html("Editar");
			
		});

        // EVENTO CLICK DEL BOTON ELIMINAR DE LA TABLA DE USUARIOS
		$("#table-usuarios tbody").on("click",".delet",function(){
			
			// OBTENEMOS LA INFORMACIÓN DE LA FILA
			let dataRow = dataTable.row($(this).parents()).data();
            console.log(dataRow);

			$("#txtDocumentoDelete").val(dataRow.documento);
            $("#txtEstadoDelete").val(dataRow.estado);
			$("#lblDelete").html(dataRow.nombres);
		});

        // EVENTO CLICK DEL BOTON ELIMINAR DE LA TABLA DE USUARIOS
		$("#table-usuarios tbody").on("click",".refresh",function(){
			
			// OBTENEMOS LA INFORMACIÓN DE LA FILA
			let dataRow = dataTable.row($(this).parents()).data();
            console.log(dataRow);

			$("#txtDocumentoRefresh").val(dataRow.documento);
            $("#txtEstadoRefresh").val(dataRow.estado);
			$("#lblRefresh").html(dataRow.nombres);
		});
    }


	// PARA LA VISTA DE ASIGNAR NOTAS
	if($('table').attr('id') == "table-estudiantes"){

        // PETICION AJAX PARA ACTUALIZAR LA TABLA DE USUARIOS
		$.ajax({
			type: "POST",
	        url: "../Controllers/estudianteController.php",
			data:dataForm,
			success: function(response){
				cargarTableEstudiantes(response);
			},
		});

        // EVENTO CLICK DEL BOTON EDITAR DE LA TABLA DE USUARIOS
		$("#table-estudiantes tbody").on("click",".edit",function(){
			
			// OBTENEMOS LA INFORMACIÓN DE LA FILA
			let dataRow = dataTable.row($(this).parents()).data();
            console.log(dataRow);

			$("#txtDocumento").val(dataRow.documento);
			$("#txtNombres").val(dataRow.nombres);
			$("#txtxCorreo").val(dataRow.correo);
			$("#txtNota1").val(dataRow.nota1);
			$("#txtNota2").val(dataRow.nota2);
			$("#txtNota3").val(dataRow.nota3);
			$("#txtNota4").val(dataRow.nota4);
			$("#txtNotaFinal").val(dataRow.nota_final);
		});

		// EVENTOS PARA CALCULAR LA NOTA FINAL
		$("#txtNota1").keyup(function(){
			let nota1 = 0;
			let nota2 = 0;
			let nota3 = 0;
			let nota4 = 0;

			if($("#txtNota1").val()){ nota1 = parseFloat($("#txtNota1").val()); }
			if($("#txtNota2").val()){ nota2 = parseFloat($("#txtNota2").val());	}
			if($("#txtNota3").val()){ nota3 = parseFloat($("#txtNota3").val()); }
			if($("#txtNota4").val()){ nota4 = parseFloat($("#txtNota4").val()); }

			let promedio = ((nota1+nota2+nota3+nota4)/4).toFixed(2);
			$("#txtNotaFinal").val(promedio);
		});

		$("#txtNota2").keyup(function(){
			$("#txtNota1").keyup();
		});

		$("#txtNota3").keyup(function(){
			$("#txtNota1").keyup();
		});

		$("#txtNota4").keyup(function(){
			$("#txtNota1").keyup();
		});
    }
});

let dataTable, data;

function cargarTableUsuarios( response ){
	console.log(response);
	data = JSON.parse(response);
	console.log(data);
	// CARGAMOS LOS DATOS DEL SELECT DE CARGO
	$("#txtEstado").empty();
	$("#txtEstado").append('<option value="" selected>Seleccione...</option>');
	data.selectEstados.forEach(element => $("#txtEstado").append('<option value='+element.id+'>'+element.nombre+'</option>'));

	$("#txtRol").empty();
	$("#txtRol").append('<option value="" selected>Seleccione...</option>');
	data.selectRol.forEach(element => $("#txtRol").append('<option value='+element.id+'>'+element.nombre+'</option>'));
	
	dataTable = $("#table-usuarios").DataTable( {
		language: {
			url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
		},
		responsive: true,
		"destroy": true,
		// CARGAMOS LOS DATOS POR MEDIO DE LA RESPUESTA DE AJAX
		"data": data.dataTable,
		"columns":[
			{"data":"nombres"},
			{"data":"correo"},
			{"data":"rol_name"},
			{"data":"estado_name"},
			{"defaultContent":	`<button class="edit btn btn-submit m-1" data-toggle="modal" data-target="#usuarioModal"><em class="fas fa-pen"></em></button>
								<button class="delet btn btn-secondary m-1" data-toggle="modal" data-target="#deleteModal"><em class="fas fa-trash-alt text-light"></em></button>
								<button class="refresh btn btn-dark m-1" data-toggle="modal" data-target="#refreshModal"><em class="fas fa-sync-alt text-light"></em></button>`
			},
		]        
	} );
}

function cargarTableEstudiantes( response ){
	console.log(response);
	data = JSON.parse(response);
	console.log(data);

	dataTable = $("#table-estudiantes").DataTable( {
		language: {
			url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
		},
		responsive: true,
		"destroy": true,
		// CARGAMOS LOS DATOS POR MEDIO DE LA RESPUESTA DE AJAX
		"data": data.dataTable,
		"columns":[
			{"data":"documento"},
			{"data":"nombres"},
			{"data":"nota_final"},
			{"defaultContent":	`<button class="edit btn btn-submit m-1" data-toggle="modal" data-target="#estudianteModal"><em class="fas fa-pen"></em></button>`},
		]        
	} );
}