<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contacto</title>
</head>
    <body>
    	<form name="formulario" action="envia_contacto.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr>
                    <td align="center" colspan="2"><strong>Formulario de Contacto</strong></td>
                </tr>
                <tr>
                    <td>Nombre</td><td><input name="nombre" type="text" /></td>
                </tr>
                <tr>
                    <td>Apellidos</td><td><input name="apellidos" type="text" /></td>
                </tr>
                <tr>
                    <td>Direccion</td><td><input name="direccion" type="text" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td><td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Archivo</td><td><input name="archivo" type="file" /></td>
                </tr>
                <tr>
                	<td colspan="2" align="center"><input type="submit" name="enviar" value="Enviar" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>
