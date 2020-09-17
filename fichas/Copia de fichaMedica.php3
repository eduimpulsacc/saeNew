<? echo "#hashjsahj2";?>
asdasdsa
<?php require('../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
//	$frmModo		=$_FRMMODO;
	$frmModo		="mostrar";
	$curso			=$_CURSO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$POSP           =1;


?>
<?php 

	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ficha_medica.fecha_atencion, ficha_medica.id_ficha FROM ficha_medica INNER JOIN alumno ON ficha_medica.rut_alumno = alumno.rut_alumno WHERE alumno.rut_alumno='".$alumno."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (@pg_numrows($result)!=0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){x
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
			}
		}
	}

	if($fila['id_ficha']!=""){
		$qry="SELECT * FROM FICHA_MEDICA WHERE ID_FICHA=".$fila['id_ficha']." ORDER BY FECHA_ATENCION DESC";
		$result =@pg_Exec($conn,$qry);
		if (!$result){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
					exit();
				}
			}
		}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../Sea/estilos.css" rel="stylesheet" type="text/css">
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
		<LINK REL="STYLESHEET" HREF="../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
/*				if(!chkVacio(form.txtFECHAATE,'Ingresar FECHA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAATE,'FECHA ATENCION invalida.')){
					return false;
				};
*/
				if(!chkVacio(form.txtFECHAPROXATE,'Ingresar FECHA PROXIMA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAPROXATE,'FECHA PROXIMA ATENCION invalida.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
		<SCRIPT language="JavaScript">
			function jmpFicha(form){
				document.location = "seteaFichaMed.php3?caso=1&ficha=" + form.txtFECHAATE.value;
//				return false;
			}
		</SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../Sea/cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                <td width="156" height="75" valign="middle"><img src="../Sea/cortes/logo_colegio.jpg" width="155px" height="75"></td>
                <td width="174">&nbsp;</td>
                <td width="392" valign="bottom"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="34" height="26" rowspan="2" align="left"><img src="../Sea/cortes/icono_perfil.jpg" width="26" height="26px"></td>
                      <td width="362" height="19"><span class="textosesion">Mis 
                        Datos</span> - <span class="textosesion">Cambio de Clave</span> 
                        - <span class="textosesion">Cerrar Sesi&oacute;n</span></td>
                    </tr>
                    <tr> 
                      <td height="22" class="textosesion">Iniciado por:</td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="28" colspan="3"> 
                  <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="19" align="left" valign="top">
<table height="28" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="367" rowspan="2" align="left" valign="top"><img src="../Sea/cortes/linea01.jpg" width="367" height="28"></td>
                            <td width="315" align="left" valign="top"> 
                              <table width="221" border="0" cellspacing="0" cellpadding="0">
                                <tr align="left" valign="top"> 
                                  <td width="60"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image15','','../Sea/cortes/b_ayuda_r.jpg',1)"><img src="../Sea/cortes/b_ayuda_n.jpg" name="Image15" width="60" height="20" border="0"></a></td>
                                  <td width="86"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','../Sea/cortes/b_info_r.jpg',1)"><img src="../Sea/cortes/b_info_n.jpg" name="Image16" width="101" height="20" border="0"></a></td>
                                  <td width="75"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','../Sea/cortes/b_mapa_r.jpg',1)"><img src="../Sea/cortes/b_mapa_n.jpg" name="Image17" width="60" height="20" border="0"></a></td>
                                  <td width="75"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','../Sea/cortes/b_home_r.jpg',1)"><img src="../Sea/cortes/b_home_n.jpg" name="Image7" width="60" height="20" border="0"></a></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td height="8" align="left" valign="top" bgcolor="ff6600"><img src="../Sea/cortes/linea02.jpg" height="8"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <table width="84%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Libro 
                                    de Clases</td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Listados 
                                    A&ntilde;os Acad&eacute;micos</td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Datos 
                                    Instituci&oacute;n</td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Administraci&oacute;n</td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Personal</td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top" class="cajamenu">Salir</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td height="181" align="left" valign="middle"><img src="../Sea/cortes/banner_01.jpg" width="162" height="166"></td>
                          </tr>
                        </table></td>
                      <td width="73%" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../Sea/cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
