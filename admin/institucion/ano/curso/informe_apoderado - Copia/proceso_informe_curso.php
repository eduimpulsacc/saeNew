<?
	require('../../../../../util/header.inc');	

	$ano		 =$_ANO;
	$curso 		= $_CURSO;

	$fecha = date("d-m-Y");
	
	$sqlTraeAreaItem="SELECT * FROM informe_area_item WHERE id_plantilla=".$plantilla." AND con_concepto=1 ORDER BY id_padre,id";
	$resultTraeAreaItem=@pg_Exec($conn, $sqlTraeAreaItem);

	$concepto = 1;  /* pk se evaluan todo solo los que tienen conceptos evaluativos*/
?>	



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
	<div ID="waitDiv" style="position:absolute;left:300;top:300;visibility:hidden">
		<table cellpadding="6" cellspacing="0" border="1" bgcolor="#000000" bordercolor="#FFFFFF">
			<tr>
				<td align=center>
					<font color="#ffffff" face="Verdana" size="4">Guardando el Informe...</font>
					<img src="cargando.gif" border="1">
				</td>
			</tr>
		</table>
	</div>


	<SCRIPT language="JavaScript">
	<!--
		var DHTML = (document.getElementById || document.all || document.layers);
		function ap_getObj(name) {
			if (document.getElementById){
				return document.getElementById(name).style; 
			}
			else if (document.all){
				return document.all[name].style; 
			}
			else if (document.layers){
				return document.layers[name]; 
			}
		}
		function ap_showWaitMessage(div,flag) {
			if (!DHTML) 
				return;
			var x = ap_getObj(div); x.visibility = (flag) ? 'visible':'hidden'
			if(! document.getElementById) 
				if(document.layers) x.left=280/2; return true; 
		} ap_showWaitMessage('waitDiv', 3);
	//-->
	</SCRIPT>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td height="589" align="left" valign="top">
	     <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  		    <tr>
			   <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
			   <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
				  <? include("../../../../../cabecera/menu_superior.php"); ?>
			   </td>
		    </tr>
		    <tr align="left" valign="top"> 
			   <td height="83" colspan="3">
			      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                     <tr> 
                        <td width="27%" height="363" align="left" valign="top"> 
                           <? $menu_lateral="3_1"; ?><? include("../../../../../menus/menu_lateral.php"); ?></td>
                        <td width="73%" align="left" valign="top">
						   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr> 
                                 <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr> 
                                 <td height="395" align="left" valign="top"> 
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                       <tr> 
                                          <td height="390">
										  <!-- inicio codigo nuevo -->


<?
		for($j=0;$j<$cont_alum;$j++){
			$rut_alum = ${"rut_alum_".$j};
	
			$sql_busca = "SELECT count(*) as cant FROM informe_evaluacion2 WHERE id_ano=".$ano." AND id_periodo=".$cmb_periodo." ";
			$sql_busca = $sql_busca ." AND id_plantilla=".$plantilla." AND rut_alumno=".$rut_alum."";
			$result_busca=@pg_Exec($conn, $sql_busca);
			$filaBusca=@pg_fetch_array($result_busca,0);
			$total = $filaBusca['cant'];				
				
			for($k=0;$k<$cont_item;$k++){
				$filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $k);	
				$id_sigla = ${"cmb_".$j."_".$k};
				$item = $filaTraeAreaItem['id'];
	
				if(trim($total)>0){
					$sql_update = "UPDATE informe_evaluacion2 SET respuesta=".$id_sigla.",concepto=".$concepto.", ";
					$sql_update = $sql_update ." fecha=to_date('".$fecha."','DD MM YYYY') ";
					$sql_update = $sql_update ." WHERE id_ano=".$ano." AND id_periodo=".$cmb_periodo." AND id_plantilla=".$plantilla." ";
					$sql_update = $sql_update ." AND id_informe_area_item=".$item." and rut_alumno=".$rut_alum;
					$result_update=@pg_Exec($conn, $sql_update);
				}
				else{
					$sql_insert = "INSERT INTO informe_evaluacion2 (id_ano,id_periodo,id_curso,id_plantilla,id_informe_area_item, ";
					$sql_insert = $sql_insert ." respuesta,concepto,fecha,rut_alumno) ";
					$sql_insert = $sql_insert ." VALUES(".$ano.",".$cmb_periodo.",".$curso.",".$plantilla.",".$item.",".$id_sigla.", "; 
					$sql_insert = $sql_insert ." ".$concepto.",to_date('".$fecha."','DD MM YYYY'),".$rut_alum.")";
					$result_insert=@pg_Exec($conn, $sql_insert);
				}	
			}
		}
?>
  
		<br />
		<center><font size="1" face="Arial, Helvetica, sans-serif">EL INFORME SE HA GUARDADO EXITOSAMENTE</font></center>
		<br /><br />
	   <center><input class="botonXX"  type="button" name="aceptar" value="Visualizar Informe" onClick="window.location='muestraPlantilla_curso.php?creada=1&modificar=1&grado=<? echo $grado;?>&curso=<? echo $curso;?>&periodo=<? echo $cmb_periodo;?>&plantilla=<? echo $plantilla?>'"></center>

										  
										  <!-- fin codigo nuevo -->
									      </td>
                                       </tr>
                                    </table>
								 </td>
                              </tr>
                           </table>
                         </td>
                       </tr>
                       <tr align="center" valign="middle"> 
                          <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                       </tr>
                    </table>
				 </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	</td>
  </tr>
</table>
</body>

<SCRIPT language="JavaScript">
	<!-- 
	ap_showWaitMessage('waitDiv', 0); 
	//-->
</SCRIPT>
</html>
