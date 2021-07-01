DROP PROCEDURE IF EXISTS buscarUsuario;
DELIMITER $$
CREATE PROCEDURE buscarUsuario(
	/* PARAMETROS DE LA TABLA CLIENTE */
    IN correo VARCHAR(50))
BEGIN
    DECLARE documento VARCHAR(20);
    DECLARE result int;
    SET result = 0;
    
    /* VALIDAMOS QUE EXISTA UN USUARIO CON ESE CORREO Y SE ENCUENTRE ACTIVO */
    SET result = (SELECT COUNT(*) FROM usuario WHERE correo_usuario = correo AND id_estado = 1);
    IF(result < 1) THEN
		SELECT NULL, NULL, NULL;
    ELSE
		/* SI EXISTE UN USUARIO CON ESE CORREO, ENTONCES DEVOLVER LA CLAVE, ROL Y NOMBRE */
        SET documento = (SELECT documento_usuario FROM usuario WHERE correo_usuario = correo);
		UPDATE usuario  SET fecha_ult_login = (SELECT NOW()) WHERE documento = documento_usuario;
		SELECT nombre_usuario, clave_usuario, nombre_rol FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE correo_usuario = correo;
	END IF;   
END
$$
