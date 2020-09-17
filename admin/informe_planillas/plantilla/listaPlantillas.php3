<?php require('../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
if(session_is_registered('_PLANTILLA')){
			session_unregister('_PLANTILLA');
		};
if(session_is_registered('_AREA')){
			session_unregister('_AREA');
		};
if(session_is_registered('_SUBAREA')){
			session_unregister('_SUBAREA');
		};		

	//$sqlTraePlantillas="SELECT * FROM informe_plantilla where tipo_ensenanza=".$tipoEns;
	$sqlTraePlantillas="SELECT * FROM informe_plantilla where activa=1 and rdb=".$institucion." order by fecha_creacion asc";
	$resultTraePlantillas=pg_Exec($conn, $sqlTraePlantillas);
	if (!$resultTraePlantillas) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlTraePlantillas);
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
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
		
</head>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
								<?php if($_PERFIL!=17){?>
<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../ano/periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6"onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe_roll.gif" name="Image0" width="81" height="30" border="0" id="Image0" ></a></td>
		  <td width="81" height="30"><a href="../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <div align="right"><font color="#000099" size="1" face="Arial, Helvetica, sans-serif">*para 
        volver presione Informe de Personalidad</font></div></td>
  </tr>
</table>

<table width="" border="0" align="center">
  <tr>
    <td><table width="100%" border="0">
        <tr> 
          <td width="19%"><FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
            </FONT>&nbsp;</td>
          <td width="2%"><strong>:</strong></td>
          <td width="79%"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
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
            &nbsp;</font></strong></td>
        </tr>
      </table>

      <table width="100%" border="0">
        <tr> 
          <td width="69%">&nbsp;</td>
          <td width="15%"><input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit2" value="AGREGAR" onClick="window.location='plantilla.php'"></td>
          <td width="16%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td colspan="3" align="center" class="tableindex">PLANTILLAS 
            PARA EVALUACION</td>
        </tr>
        <tr align="center"> 
          <td class="tablatit2-1">NOMBRE</td>
          <td class="tablatit2-1">TIPO DE ENSE&Ntilde;ANZA</td>
          <td class="tablatit2-1">FECHA DE CREACI&Oacute;N</td>
        </tr>
		<?php for ($countP=0 ; $countP<pg_numrows($resultTraePlantillas) ; $countP++){
				$filaP=pg_fetch_array($resultTraePlantillas);
				$fecha=$filaP['fecha_creacion'];
				
				$qryEnse="select nombre_tipo from tipo_ensenanza where cod_tipo=".$filaP['tipo_ensenanza'];
				$resultEnse=pg_exec($conn, $qryEnse);
					if (!$resultEnse) {
						error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qryEnse);
					}
				
				$filaE=pg_fetch_array($resultEnse,0);
		?>
        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='ffffff' onClick=window.location='modPlantilla.php?plantilla=<?php echo $filaP["id_plantilla"];?>&creada=1'> 
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaP['nombre']?>&nbsp;</font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaE['nombre_tipo']?>&nbsp;</font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php impF ($fecha)?>&nbsp;</font></td>
        </tr>
		<?php } ?>
      </table></td>
  </tr>
</table>

   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
