DROP PROCEDURE IF EXISTS cambiarClave;
DELIMITER $$
CREATE PROCEDURE cambiarClave(
	/* PARAMETROS DE LA TABLA USUARIO */
    IN correo VARCHAR(50),
    IN clave varchar(250))
BEGIN
    DECLARE documento varchar(20);
    
    SET documento = (SELECT documento_usuario FROM usuario WHERE correo_usuario = correo);
    UPDATE usuario SET clave_usuario = clave WHERE documento_usuario = documento;
END
$$