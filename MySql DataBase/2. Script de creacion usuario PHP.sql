DROP PROCEDURE IF EXISTS crearUsuario;
DELIMITER $$
CREATE PROCEDURE crearUsuario(
	/* PARAMETROS DE LA TABLA CLIENTE */
    IN documento VARCHAR(20),
    IN nombre VARCHAR(150),
    IN correo VARCHAR(50),
    IN clave VARCHAR(250),
    IN estado int,
    IN rol int)
BEGIN
    DECLARE toReturn varchar(50);
    DECLARE hoy VARCHAR(19);
    DECLARE result int;
    SET result = 1;
    SET hoy = (SELECT now());
    
    /* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE NUMERO DE DOCUMENTO */
    SET result = (SELECT COUNT(*) FROM usuario WHERE documento = documento_usuario);
    IF(result > 0) THEN
		SET toReturn = "Ya existe un usuario con esa identificación";
    ELSE
		
        /* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE NOMBRE Y APELLIDO */
		SET result = (SELECT COUNT(*) FROM usuario WHERE nombre = nombre_usuario);
		IF(result > 0) THEN
			SET toReturn = "Ya existe un usuario con ese nombre";
		ELSE
        
			/* VALIDAMOS QUE NO EXISTA UN USUARIO CON ESE CORREO */
			SET result = (SELECT COUNT(*) FROM usuario WHERE correo = correo_usuario);
			IF(result > 0) THEN
				SET toReturn = "Ya existe un usuario con ese correo";
			ELSE
            
				/* SI LOS DATOS DEL USUARIO NO SE REPITEN CON ALGUN CAMPO EN LA BD ENTONCES SE CREA EL NUEVO USUARIO */
				INSERT INTO usuario  VALUES (documento, nombre, correo, hoy, clave, estado, rol);
                
                /* EN CASO DE SER UN ESTUDIANTE SE CREARÁ DE UNA MISMA VEZ*/
                IF(rol = 3) THEN
					INSERT INTO estudiante  VALUES (documento, nombre, correo, 0, 0, 0, 0, 0, documento);					
                END IF;
                
                SET toReturn = "Usuario creado";
			END IF;
		END IF;
	END IF;
    
    /* LA VARIBALE toReturn ME INDICA EL ESTADO DE LA OPERACION*/
    SELECT toReturn;
END
$$