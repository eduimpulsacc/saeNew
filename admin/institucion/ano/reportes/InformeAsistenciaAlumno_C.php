<?php 
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;
	$curso			= $cmb_curso;	
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
   $ob_motor = new MotorBusqueda();
   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="589" align="left" valign="top">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;
					</td>
					<td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
					<!-- DESDE AC� DEBE IR CON INCLUDE -->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr align="left" valign="top">
								<td height="75" valign="middle"><? include("../../../../cabecera/menu_superior.php");?>				 
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr align="left" valign="top"> 
					<td height="83">
						<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td width="27%" height="363" align="left" valign="top"><? $menu_lateral=3;
include("../../../../menus/menu_lateral.php"); ?>
								</td>
								<td width="73%" align="left" valign="top">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td align="left" valign="top">&nbsp;</td>
										</tr>
										<tr> 
											<td height="395" align="left" valign="top"> 
												<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
													<tr> 
														<td><br>
															<!-- INCLUYO CODIGO DE LOS BOTONES -->
															<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
																<tr> 
																	<td width="" height="30" align="center" valign="top">
																	</td>
																</tr> 
															</table>

<form action="printInformeAsistenciaAlumno_C.php" method="post" target="_blank" name="form">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$ob_motor ->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$resultado_query_cue = $ob_motor ->curso2($conn);

?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="662" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="658" class="tableindex"><div align="center"><? echo $numero.".- Buscador ".$nombre;?></div></td>
  </tr>
  <tr>
    <td height="27">
	<table width="658" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="67"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Buscar por </strong></font></td>
    <td colspan="2">
	  <div align="left">
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
        </select>
	    </font></div></td>
    <td width="64">&nbsp;</td>
    <td width="106"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Alumno SEP </strong></font></div></td>
    <td width="95"><div align="left"><input type="checkbox" name="SEP" value="1"></div></td></tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Mes</strong></font></td>
    <td colspan="2">
		<select name="cmb_meses" class="ddlb_9_x">
		  <option value="01">Enero</option>
		  <option value="02">Febrero</option>
		  <option value="03">Marzo</option>
		  <option value="04">Abril</option>
		  <option value="05">Mayo</option>
		  <option value="06">Junio</option>
		  <option value="07">Julio</option>
		  <option value="08">Agosto</option>
		  <option value="09">Septiembre</option>
		  <option value="10">Octubre</option>
		  <option value="11">Noviembre</option>
		  <option value="12">Diciembre</option>
		</select>	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="148"><input name="cb_ok" type="submit" class="botonXX"  value="Buscar"></td>
	<? if($_PERFIL == 0){?>
	<td width="137"><input name="cb_exp" type="submit" class="botonXX"  value="Exportar"></td>
	<? }?>
	<td><input name="cb_ok2" type="button" class="botonXX"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="1">&nbsp;</td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
				 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
<? pg_close($conn);?>