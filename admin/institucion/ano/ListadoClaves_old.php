<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	if ($tipo==1)	
		$texto = "ALUMNOS";
	if ($tipo==2)	
		$texto = "PADRES Y APODERADOS";		
?>
 	<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<FORM method=post name="frm">
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="periodo/listarPeriodo.php3?botonera=1"><img src="../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="feriado/listaFeriado.php3?botonera=1"><img src="../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../planEstudio/listarPlanesEstudio.php3?botonera=1"><img src="../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../atributos/listarTiposEnsenanza.php3?botonera=1"><img src="../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="curso/listarCursos.php3?botonera=1"><img src="../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="matricula/listarMatricula.php3?botonera=1"><img src="../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="ActasMatricula/Menu_Actas.php?botonera=1"><img src="../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="periodo/listarPeriodo.php3?botonera=1"><img src="../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<center>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height="50" >
		<TD width="87" align=left>
			<FONT face="arial, geneva, helvetica" size=2>
				<strong>INSTITUCION</strong>
			</FONT>
		</TD>
		<TD width="8">
			<FONT face="arial, geneva, helvetica" size=2>
				<strong>:</strong>
			</FONT>
		</TD>
		<TD width="533">
			<FONT face="arial, geneva, helvetica" size=2>
				<strong>
					<?php
						$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
						}else{
							if (pg_numrows($result)!=0){
								$fila1 = @pg_fetch_array($result,0);	
								if (!$fila1){
									error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
									exit();
								}
								echo trim($fila1['nombre_instit']);
							}
						}
					?>
				</strong>
			</FONT>
		</TD>
	</TR>

</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right"><INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button" TYPE="button" onClick=document.location="Claves.php" value="VOLVER"></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20 bgcolor=#003b85>
		<TD align=center colspan=2>
			<FONT face="arial, geneva, helvetica" size=2 color=White>
				<strong>ADMINISTRADOR DE CLAVES - <? echo $texto ?></strong>
			</FONT>
		</TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif"><a href="MainClavesCurso.php?tipo_clave=<? echo $tipo ?>">1. LISTAR CLAVES POR CURSO </a></font></td>
  </tr>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif"><a href="DetalleClaves.php?tipo_clave=<? echo $tipo ?>">2. BUSQUEDA POR RUT </a></font></td>
  </tr>
</table>

</center>
</form>
</body>
</html>
