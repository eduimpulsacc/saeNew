<?
require('../../../../util/header.inc');
include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$id_feriado		=$_IDFERIADO;
	$bool_fer		=$_BOOLFER;
	

?>

<html>
<head>

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

	<title>Utilizaci&oacute;n del calendario</title>
	<!--script language="JavaScript" src="../calendario-seleccion-fecha/calendario/javascripts.js"></script-->

	<script language="JavaScript" src="../feriado/calendario/javascripts.js"></script>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/feriados_roll.gif" name="Image3" width="81" height="30" border="0" id="Image3"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>



<?php //echo tope("../../../../util/");?>

<br>
<br>
<br>
<form method=post name="fcalen" action="procesoFeriado.php3">
<table width="64%" border="0" align="center">
    <tr>
      <td><table width="61%" border="0">
          <tr> 
            <td width="34%"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
            <td width="2%"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td width="64%"><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												//if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												//}
 											}
										?>
              </strong></FONT></td>
          </tr>
          <tr>
            <td> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong> 
              </FONT> </td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
													$nroAno=trim($fila1['nro_ano']);
												}
											}
										?>
              </strong></FONT></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td align="right"><input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="Submit" value="GUARDAR">
			<?php if (($frmModo=="modificar") and ($bool_fer!=0)){?>
            <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit4" value="ELIMINAR" onClick=document.location="seteaFeriado.php3?caso=9&id_feriado=<?php echo $id_feriado;?>">
			<?php } ?>
            <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit3" value="CANCELAR" onClick=document.location="seteaFeriado.php3?caso=4"></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="17%" height="20" align="left" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;INGRESO 
              DE FERIADOS</strong></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td height="30" align="left" valign="middle"><font color="#000033" size="1" face="Arial, Helvetica, sans-serif">NOTA: 
              En caso de ingresar s&oacute;lo un d&iacute;a, h&aacute;galo en 
              el campo &quot;Fecha inicio&quot;</font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="left">
        <tr align="left" valign="top"> 
            <td width="17%" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              inicio</strong></font></td>
            <td width="2%" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td width="81%"> &nbsp; 
              <?php //$sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion from feriado where id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer." UNION select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where feriado.id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer;
			  /*$sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion, feriado.id_periodo from feriado where id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer." UNION select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion, feriados_nac.periodo from feriados_nac where id_feriado=".$id_feriado." and bool_fer=".$bool_fer;
					$result =@pg_Exec($conn,$sql);
							if (@pg_numrows($result)!=0){
								$fila=@pg_fetch_array($result,0);
								echo $fila["fecha_inicio"];
								exit;
								
									$fecIni=substr($fila["fecha_inicio"],8,2); //dia
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],5,2); //mes
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],0,4);  //año

									$fecFin=substr($fecFin=$fila["fecha_fin"],8,2); //dia
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],5,2); //mes
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],0,4);  //año
						}*/
						
						if ($bool_fer==0){
							$fecSis=getdate();
							$anoActual=$fecSis["year"];
							$sql="select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where id_feriado=".$id_feriado;
							$result =@pg_Exec($conn,$sql);
								if (@pg_numrows($result)!=0){
									$fila=@pg_fetch_array($result,0);
								}
							//$fecIni=$fila["fecha_inicio"]."-".$anoActual;
							$fecIni=$fila["fecha_inicio"]."-".$nroAno;
							if ($fila["fecha_fin"]!=0){
								//$fecFin=$fila["fecha_fin"]."-".$anoActual;
								$fecFin=$fila["fecha_fin"]."-".$nroAno;
							}
						}else{//fin if ($bool_fer==0)
						$sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion, feriado.id_periodo from feriado where id_ano=".$ano." and id_feriado=".$id_feriado;
						$result =@pg_Exec($conn,$sql);
								if (@pg_numrows($result)!=0){
									$fila=@pg_fetch_array($result,0);
								}
									$fecIni=substr($fila["fecha_inicio"],8,2); //dia
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],5,2); //mes
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],0,4);  //año

									$fecFin=substr($fecFin=$fila["fecha_fin"],8,2); //dia
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],5,2); //mes
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],0,4); 
						}//fin else
						?>
						
						
						
              <?php
					escribe_formulario_fecha_vacio("fecha1","fcalen","$fecIni");
?>
            </td>
          </tr>
          <tr align="left" valign="top"> 
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              final </strong> </font></td>
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td> &nbsp;
              <?
				escribe_formulario_fecha_vacio("fecha2","fcalen","$fecFin");
?>
            </td>
          </tr>
		  <tr align="left" valign="top"> 
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Periodo</strong> 
              </font></td>
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td> &nbsp; 
			<?php $sqlPeriodo="select * from periodo where id_ano=".$ano."order by nombre_periodo";
					$resultPeriodo=pg_Exec($conn,$sqlPeriodo);
					if(!$resultPeriodo){
						error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>'.$sqlPeriodo);
					}else{
					echo "<select name=cmbPeriodo>";
					echo "<option value=0>Seleccione Periodo</option>";
						for($x=0 ; $x<pg_numrows($resultPeriodo) ; $x++){
							$filaPeriodo=pg_fetch_array($resultPeriodo);
								if($filaPeriodo["id_periodo"]==$fila["id_periodo"]){
									echo "<option value=".$filaPeriodo["id_periodo"]." selected>".$filaPeriodo["nombre_periodo"]."</option>";
								}else{
									echo "<option value=".$filaPeriodo["id_periodo"].">".$filaPeriodo["nombre_periodo"]."</option>";
								}
						}
					echo "</select>";
					}
			?>
			</td>
          </tr>
		  
          <tr align="left" valign="top"> 
            <td valign="middle"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descripci&oacute;n</font></strong></td>
            <td valign="middle"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></td>
          <td> &nbsp; 
            <?php if($frmModo=="ingresar"){ ?>
            <input name="descripcion" type="text" size="50" maxlength="60">
			<?php } ?>
			<?php if($frmModo=="modificar"){
					$descripcion= $desc;
					//$descripcion= $fila["descripcion"];?>
            <input type="text" name="descripcion" size="50" maxlength="60" value="<?php imp ($fila["descripcion"]);?>">
			</td>
			<?php } ?>
          </tr>
        </table>

	</table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;<hr width="64%" color=#003b85></td>
    </tr>
  </table>
  <table width="58%" border="0" align="center">
    <tr bgcolor="#48d1cc"> 
      <td align="center"> 
        <table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
          <tr> 
            <td align="left"> <font face="arial, geneva, helvetica" size="1" color=black> 
              <ul>
                <li>Debe ingresar los feriados a ser considerados en el m&oacute;dulo 
                  de Asistencia</li>
                <li>&quot;GUARDAR&quot;: Guarda las modificaciones hechas al feriado.</li>
                <?php if ($frmModo=="modificar"){?>
                <li><font face="arial, geneva, helvetica" size="1" color=black>&quot;ELIMINAR&quot; 
                  : Elimina toda la informaci&oacute;n del feriado ingresado.</font></li>
                <?php } ?>
                <li>"VOLVER" : Vuelve al listado de feriados.</li>
                <li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
              </ul>
              </font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr bgcolor="white"> 
      
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
	