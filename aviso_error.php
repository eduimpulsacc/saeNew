<?
$cf  = $_REQUEST['cf'];
$cc  = $_REQUEST['cc'];
$rf  = $_REQUEST['rf'];
$pf  = $_REQUEST['pf'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>www.colegiointeractivo.com</title>
</head>

<body topmargin="0" leftmargin="0">
<table width="700" height="400" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td valign="top">
		<table width="100%" height="300" border="1"  cellpadding="0" cellspacing="0">
			  <tr>
			  <td bgcolor="#FFFFFF">
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="10%"><div align="center"><img src="../../../../icono_atencion.gif" width="33" height="28"></div></td>
					  <td><font color="#FF0000" size="4" face="Verdana, Arial, Helvetica, sans-serif" >Atenci&oacute;n</font><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif" >&nbsp;</font><font face="Verdana, Arial, Helvetica, sans-serif" size="2" >, parte de la informaci&oacute;n de su colegio est&aacute; incompleta o err&oacute;nea, por favor corrija lo antes posible lo que se indica a continuaci&oacute;n: </font></td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>
					   <br />
					   <? if ($cf>0){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta informaci&oacute;n </font><font size="1"> en la configuración de los cursos. Vaya a <strong>Configuración - Cursos</strong> e ingrese la información faltante.</font><font size="2"> </font></font><br>
					   <? } ?>
					
<br />
 <? if ($cc>0){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Información incorrecta, </font><font size="1"> En la configuración de los cursos existe un valor incorrecto. Vaya a <strong>Configuración - Cursos</strong> y corrija la información ingresada.</font></font><br>
 <? } ?>
 
 <? if ($rf>0){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta información, </font><font size="1"> En la configuración de los subsectores falta asignar a Docentes. Vaya a <strong>Libro de Clases - Cursos - Subsectores</strong> e ingrese la información faltante.</font></font> <br />
<br />
 <? } ?>
 
 <? if ($pf>0){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta información, </font><font size="1"> En la configuración de los períodos falta fecha de inicio y cantidad de días hábiles. Vaya a <strong>Configuración - Períodos</strong> e ingrese la información faltante.</font></font><br>
 <? } ?>
					   
					   <br>											   											  
					 </td>
					</tr>
				  </table>
			  </td>
			  </tr>
	  </table>
	
	</td>
  </tr>
</table>
</body>
</html>
