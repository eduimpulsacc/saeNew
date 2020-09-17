<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 3;
	$_bot = 0;

  if ($ano == NULL){
     $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
     $result = @pg_Exec($conn,$qry);
     $filaaux = @pg_fetch_array($result,0);	
     $_ANO=$filaaux["id_ano"];
     $ano = $_ANO;
  }  
  	if ($ano==NULL){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la institucion \r\n');
	window.location= 'listarAno.php3';
</script>	
	
	<? exit;
		
	}


$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		 $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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

<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};
				
				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
.a {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/b_ayuda_r.jpg','botones/b_info_r.jpg','botones/b_mapa_r.jpg','botones/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								   <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									
							  
							       <table border="0" cellpadding="0" cellspacing="0">
									  <tr> 
										<td align="center" valign="top"> </td>
									  </tr>
									</table>
	<FORM method=post name="frm">
	  <TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
	  <TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>
				</TD>
		</TR>
			<TR height=15>
				<TD>
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableindex">
                      <tr>             
                       <td>Respaldar Informaci&oacute;n</td>
                      </tr>
                     </table>
				</TD>
			</TR>
	  </TABLE>
	  
	  
  <table width="599" border="0" align="center">
    <TD width="589"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
      <tr align="center" valign="middle" class="titulos-respaldo">
        <td><a href="Respaldo/MenuRespaldoCursos.php"><img src="botones/icono_notas2.png" width="46" height="46" border="0"></a><br>
          Respaldo de Notas</td>
        <td><a href="Respaldo/RespaldoMatricula.php"><img src="botones/icono_matricula2.png" width="46" height="46" border="0"></a><br>
          Respaldo de Matr&iacute;cula</td>
        <td><a href="Respaldo/MenuRespaldoPromocion.php"><img src="botones/icono_cursos2.png" width="46" height="46" border="0"></a><br>
          Respaldo de Promoci&oacute;n</td>
        <td><a href="Respaldo/RespaldoApoderados.php"><img src="botones/icono_apoderados2.png" width="46" height="46" border="0"></a><br>
          Respaldo de Apoderados</td>
        <td><a href="Respaldo/MenuRespaldoAsistencia.php"><img src="botones/icono_matricula2.png" width="46" height="46" border="0"></a>
          Respaldo de <br>
          Asistencia</td>
      </tr>
    </table>
   </TD>
  </table>
	</FORM>
							  
							  		
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
															
								  </td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
