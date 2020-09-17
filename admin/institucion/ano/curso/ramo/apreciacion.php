<? 	require('../../../../../util/header.inc');

	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $_CURSO;	
	$ramo 			= $_RAMO;
	$caso			= $_CASO;
	$frmModo		= $_FRMMODO;
	
	if($_PERIODO==""){
		$periodo	= $cmbPERIODO;
	}
	if($_PERIODO!=""){
		$periodo 	= $_PERIODO;
	}
	if($cmbPERIODO!="0" && $cmbPERIODO!=""){
		$periodo	= $cmbPERIODO;
	}
	session_unregister($_CASO);
	$_CASO="";
	
	$_POSP = 4;
	$_bot = 8;
	
	$sql= "SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$rs_ano = @pg_exec($conn,$sql);	
	$nro_ano = @pg_result($rs_ano,0);
	
	$sql ="SELECT nombre,apreciacion FROM subsector a INNER JOIN ramo b ON a.cod_subsector=b.cod_subsector WHERE id_ramo=".$ramo;
	$rs_ramo = @pg_exec($conn,$sql);
	$nombre_ramo =@pg_result($rs_ramo,0);
	$apreciacion=@pg_result($rs_ramo,1);
	
	$sql = "SELECT a.rut_alumno,a.ape_pat || cast(' ' as varchar) || a.ape_mat || CAST(', ' as varchar) || a.nombre_alu as nombre,promedio, notaap FROM alumno a INNER JOIN matricula b ON a.rut_alumno=b.rut_alumno INNER JOIN tiene$nro_ano c ON a.rut_alumno=c.rut_alumno AND b.rut_alumno=c.rut_alumno INNER JOIN notas$nro_ano d ON a.rut_alumno=d.rut_alumno AND b.rut_alumno=d.rut_alumno AND c.rut_alumno=d.rut_alumno AND d.id_ramo=c.id_ramo  WHERE b.id_ano=".$ano." AND b.id_curso=".$curso." AND  c.id_ramo=".$ramo." AND d.id_periodo=".$periodo." ORDER BY nro_lista ASC";
	$rs_alumno = @pg_exec($conn,$sql);

?>
<script type="text/javascript">
function enviapag(form){
	if(document.form.cmbPERIODO.value!=0){
		form.action='apreciacion.php?id_ramo=<?=$ramo;?>';
		form.submit(true);
	}
}
function valida(form,nombre,promedio){
	var maximo='<?=$apreciacion;?>';
	var suma=0;
	
	if(promedio!=0){
		suma = parseInt(document.form1.elements[nombre].value) - parseInt(promedio); 
		if(parseInt(suma) > parseInt(maximo)){
			alert("Apreciacion supera lo permitido en la configuración del subsector, maximo " + maximo + " decimas");
			document.form1.elements[nombre].value="";
			document.form1.elements[nombre].focus();
		}else if(parseInt(promedio) > parseInt(document.form1.elements[nombre].value)){
			alert("No esta permitido bajar la nota al alumno");
			document.form1.elements[nombre].value="";
			document.form1.elements[nombre].focus();

		}
	}
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr align="left" valign="top">
              <td height="75" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle"><?   include("../../../../../cabecera/menu_superior.php");?>                    </td>
                  </tr>
              </table></td>
            </tr>
            <!-- FIN DE COPIA DE CABECERA -->
        </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><table>
                <tr>
                  <td><? 
				  $menu_lateral="3_1";
				  include("../../../../../menus/menu_lateral.php"); ?></td>
              </table></td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="cajaborde">
					  <tr>
						<td>
						
						<form name="form" method="post" action="<?=$PHP_SELF;?>">
						<input name="id_ramo" type="hidden" value="<?=$ramo;?>" />
						<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
						  <tr>
							<td width="%" class="textonegrita">A&Ntilde;O</td>
							<td width="%" class="textonegrita">:</td>
							<td width="%" class="Estilo12"><?=$nro_ano;?></td>
						  </tr>
						  <tr>
							<td class="textonegrita">CURSO</td>
							<td class="textonegrita">:</td>
							<td class="Estilo12"><? echo CursoPalabra($curso,1,$conn);?></td>
						  </tr>
						  <tr>
							<td class="textonegrita">ASIGNATURA</td>
							<td class="textonegrita">:</td>
							<td class="Estilo12"><?=$nombre_ramo;?></td>
						  </tr>
						  <tr>
						    <td class="textonegrita">PERIODO</td>
						    <td class="textonegrita">:</td>
						    <td class="Estilo12">
							<select name="cmbPERIODO" class="ddlb_x" onChange="enviapag(this.form)">
								<option value="0">seleccione</option>
								<? 	$sql = "SELECT nombre_periodo,id_periodo FROM periodo WHERE id_ano=".$ano;
									$rs_periodo = @pg_exec($conn,$sql);
									for($i=0;$i<@pg_numrows($rs_periodo);$i++){
										$fila_per = @pg_fetch_array($rs_periodo,$i); 
										if($fila_per['id_periodo']==$periodo){?>
										<option value="<?=$fila_per['id_periodo'];?>" selected="selected"><?=$fila_per['nombre_periodo'];?></option>
									<? }else{?>
										<option value="<?=$fila_per['id_periodo'];?>"><?=$fila_per['nombre_periodo'];?></option>
									<? 	}	
									} ?>								
							</select>
							</td>
						    </tr>
						</table>
						</form>
						<BR />
						<form name="form1" method="post" action="procesoApreciacion.php">
						  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td align="right">
							  <? if($frmModo=="modificar"){?>
							  <input name="guardar" type="submit" value="GUARDAR" class="botonXX" />
							  <input name="cancelar" type="button" id="cancelar" value="CANCELAR" class="botonXX" onClick="window.location='seteaApreciacion.php?caso=1&id_ramo=<?=$ramo;?>&curso=<?=$curso;?>'"  />
							  <? } ?>
							  <? if($frmModo=="mostrar" or $frmModo=="eliminar"){ ?>
							  <input name="LIMPIAR" type="button" id="LIMPIAR" value="LIMPIAR" class="botonXX"  onclick="window.location='seteaApreciacion.php?caso=9&id_ramo=<?=$ramo;?>&cmbPERIODO=<?=$periodo;?>'"/>
							  <input name="volver" type="button" id="volver" value="VOLVER" class="botonXX" onClick="window.location='listarRamos.php3'"/>
							  <input name="modificar" type="button" id="modificar" value="MODIFICAR" class="botonXX"  onclick="window.location='seteaApreciacion.php?caso=3&periodo=<?=$periodo;?>'"/>
							  <? } ?>							  </td>
                            </tr>
                          </table>
						  <br />
						<table width="80%" border="0" cellspacing="3" cellpadding="0" align="center">
						  <tr>
							<td class="tablatit2-1"><div align="center">NOTAS DE APRECIACION</div></td>
						  </tr>
						</table>
						<br />
						<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center">
						  <tr class="tablatit2-1">
							<td><div align="center">N&ordm;</div></td>
							<td><div align="center">NOMBRE</div></td>
							<td><div align="center">PROMEDIO</div></td>
							<td><div align="center">NOTA <br />APRECIACI&Oacute;N </div></td>
						  </tr>
						  <? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
						  		$fila_alu = @pg_fetch_array($rs_alumno,$i);
						  ?>	
						  	<input name="txtRUT<?=$i;?>" type="hidden" value="<?=$fila_alu['rut_alumno'];?>" />
						  <tr>
							<td class="Estilo17"><?=$i+1;?></td>
							<td class="Estilo17"><?=strtoupper($fila_alu['nombre']);?></td>
							<td class="Estilo17"><div align="center">
							  <? if($fila_alu['promedio']==0) echo "--"; else echo $fila_alu['promedio'];?>
							  <input name="txtPROMEDIO<?=$i;?>" type="hidden" value="<?=$fila_alu['promedio'];?>" />
							</div></td>
							<td class="Estilo17"><div align="center">
							<? if($frmModo=="mostrar" or $frmModo=="eliminar"){
									echo "&nbsp;".$fila_alu['notaap'];
								}
								if($frmModo=="modificar"){?>
							  <input name="txtNOTA<?=$i;?>" type="text" size="5" maxlength="2" id="txtNOTA<?=$i;?>" onBlur="valida(this.form,this.id,<?=$fila_alu['promedio'];?>)" value="<? if (trim($fila_alu['notaap'])==0) { echo "";}else{ echo trim($fila_alu['notaap']);}?>"/>
							<? } ?>
							  </div></td>
						  </tr>
						  <? } ?>
						  <input name="contador" type="hidden" value="<?=$i;?>" />
						</table>
						</form>
						</td>
					  </tr>
					</table>
					</td>
                  </tr>
                 
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
 <? pg_close($conn)?>