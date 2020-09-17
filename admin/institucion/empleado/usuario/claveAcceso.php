<?php require('../../../..//util/header.inc');?>

<style type="text/css">
<!--
.Estilo1 {font-size: 10px}
.Estilo2 {font-size: 9px}
.Estilo3 {font-size: 9}
.Estilo4 {font-weight: bold}
-->
</style>
<body oncontextmenu="return false" > 
<?php 



if ($modoseguro!=1){ echo "<script>window.location = '../../../../../../../../../../../'</script>"; exit();
 } 


	$institucion	=$_INSTIT;
	$usuario		=$_USUARIO;
	if($_PERFIL==0 || $_PERFIL==14){
		$empleado		=$empleados;	
	}
	else{
		$empleado		=$_EMPLEADO;
	}
	$nombreusuario=$_NOMBREUSUARIO;
	$_POSP          =4;
	if ($empleado==""){
		$empleado=$_EMPLEADO;
	};
	

	
		
?>
<? if($_INSTIT==1590) {  ?>
<script language="javascript">
			 alert ("Opción Desactivada");
			 window.location="../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<title>Cambio De Clave</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

		
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">

			function valida(form){
			
			 
				if(form.txtPW2.value.length<5){
					alert('La Nueva Clave de acceso debe ser entre 6 y 8 caracteres.');
					return false;
				};
				if(form.txtPW3.value.length<5){
					alert('La Nueva Clave de acceso debe ser entre 6 y 8 caracteres.');
					return false;
				};
				
				if(!chkVacio(form.txtPW1,'Ingresar CLAVE ACTUAL.')){
					return false;
				};
				if(!chkVacio(form.txtPW2,'Ingresar NUEVA CLAVE.')){
					return false;
				};
				if(!chkVacio(form.txtPW3,'Repetir NUEVA CLAVE.')){
					return false;
				};
				if (!igual(form.txtPW2,form.txtPW3,'Error al repetir la nueva clave de acceso.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
		<style type="text/css">
<!--
.Estilo1 {font-size: 12px}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo3 {font-size: 10px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
        </style>
</head>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/a_menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                      </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inocio codigo antiguo -->
								  
								  
								  
	<?php //echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD width="131" align=left><strong><font size="2" face="arial, geneva, helvetica">ESTIMADO USUARIO</font></strong></TD>
							<TD width="10"><strong><font size="2" face="arial, geneva, helvetica">:</font></strong></TD>
							<TD width="21">&nbsp;</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				
      <td colspan=2 align=right><div align="left">
        <p class="Estilo2"><span class="Estilo2">POR SU SEGURIDAD, UD DEBE INGRESAR UNA NUEVA CLAVE DISTINTA DE LA ASIGNADA POR LA PLATAFORMA</span>. </p>
        </div></td>
			</tr>
			<tr height="20">
				<td colspan="2" align="middle" class="tableindex Estilo1">
					<div align="center" class="Estilo3">
					  <p>Atenci&oacute;n: El Largo Maximo de la clave no puede ser mayor a 8 entre caract&eacute;res o n&uacute;meros.
					  </p>
					  <p align="left" class="Estilo1"><br>
					    <span class="Estilo3">-No usar los primeros 5 o 6 digitos del rut.<br>
					    -No usar Combinaciones L&oacute;gicas tales como: 12345, 121212, Etc.<br>
					    -No usar la misma clave inicial. </span></p>
					  <p align="left" class="Estilo1"><span class="Estilo3">De lo contrario el sistema le pedira nuevamente el cambio de la clave al detectar una combinaci&oacute;n insegura. </span><br>  
					      <br>  
					    <br>
					    </p>
					</div></td>
			</tr>
			<TR>
				<TD width=0></TD>
				<TD width="585">
					<FORM method=post name="frm" action="procesoClave.php">
						<input type="hidden" name="empleados" value="<? echo $empleado;?>">
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR<BR>CLAVE ACTUAL</STRONG>									</FONT>								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR<BR>NUEVA CLAVE ACCESO</STRONG>									</FONT>								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>REPETIR<BR>NUEVA CLAVE ACCESO</STRONG>									</FONT>								</TD>
							</TR>
							<TR>
								<TD>
									<input type=password name="txtPW1" size=15 maxlength=20>								</TD>
								<TD>
									<input type=password name="txtPW2" size=15 maxlength=8>								</TD>
								<TD>
									<input type=password name="txtPW3" size=15 maxlength=8>								</TD>
							</TR>
							<TR align=center HEIGHT=50 VALIGN=BOTTOM>
								<TD colspan=3><p><span class="Estilo4"><br>
								            <br>
								            <input name="submit"  type=submit class="botonXX" onClick="return valida(this.form);" value=GUARDAR>
								            </span><br>
								      </p>
								  </TD>
							</TR>
						</TABLE>
					</FORM>
				</TD>
			</TR>
			<tr>
				
			</tr>
		</table>
	</center>

								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
