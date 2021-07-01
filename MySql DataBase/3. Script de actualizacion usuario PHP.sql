DROP PROCEDURE IF EXISTS actualizarUsuario;
DELIMITER $$
CREATE PROCEDURE actualizarUsuario(
	/* PARAMETROS DE LA TABLA CLIENTE */
    IN documento VARCHAR(20),
    IN nombre VARCHAR(150),
    IN correo VARCHAR(50),
    IN estado int,
    IN rol int)
BEGIN
    DECLARE toReturn varchar(50);
    DECLARE result int;
    SET result = 0;
    
    /* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE NUMERO DE DOCUMENTO */
    SET result = (SELECT COUNT(*) FROM usuario WHERE documento = documento_usuario);
    IF(result < 1) THEN
		SET toReturn = "No existe un usuario con ese documento";
    ELSE
		
        /* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE NOMBRE Y APELLIDO */
		SET result = (SELECT COUNT(*) FROM usuario WHERE nombre = nombre_usuario AND documento != documento_usuario);
		IF(result > 0) THEN
			SET toReturn = "Ya existe un usuario con ese nombre";
		ELSE
        
			/* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE CORREO */
			SET result = (SELECT COUNT(*) FROM usuario WHERE correo = correo_usuario AND documento != documento_usuario);
			IF(result > 0) THEN
				SET toReturn = "Ya existe un usuario con ese correo";
			ELSE
            
				/* SI LOS DATOS DEL USUARIO NO SE REPITEN CON ALGUN CAMPO EN LA BD ENTONCES SE CREA EL NUEVO USUARIO */
				UPDATE usuario  SET nombre_usuario = nombre, correo_usuario=correo, id_estado=estado, id_rol=rol WHERE documento = documento_usuario;
				
                /* EN CASO DE SER UN ESTUDIANTE SE CREARÁ DE UNA MISMA VEZ*/
                IF(rol = 3) THEN
					UPDATE estudiante  SET nombre_estudiante = nombre, correo_estudiante=correo WHERE documento = documento_estudiante;					
                END IF;
                
                SET toReturn = "Usuario actualizado";
			END IF;
		END IF;
	END IF;
    
    /* LA VARIBALE toReturn ME INDICA EL ESTADO DE LA OPERACION*/
    SELECT toReturn;
END
$$